<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Admin\Exports\AlumniPelatihanExport;
use App\Http\Controllers\Admin\Exports\PelatihanPendaftaranExport;
use App\Http\Controllers\Controller;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\Pelatihan4Laporan;
use App\Models\ref_unitkerjas;
use App\Models\User;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AlumniPelatihanController extends Controller
{
    /**
     * Display a listing of alumni resources.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $start = $request->get('start_date');
        $end = $request->get('end_date');

        $user = Auth::user();
        if ($user->role === 'admin') {
            $unit = $user->latestUserPivot->unitKerja->unitkerja_id;
        } else {
            $unit = $request->get('unit_id');
        }

        $nipAtasan = $user->refPegawai?->nip_atasan;
        $user = User::where('nip', $nipAtasan)->first();

        $unitkerjas = ref_unitkerjas::select('id', 'unitkerja')
            ->orderBy('unitkerja')
            ->get();

        // Query utama untuk alumni
        $alumnis = Pelatihan3Pendaftaran::with([
                'user.latestUserPivot.unitKerja',
                'tersedia',
                'usulan',
                'laporan' // Menambahkan relasi laporan
            ])
            ->where('status_peserta', 'alumni') // Hanya ambil alumni
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('user_nip', 'like', "%$search%")
                        ->orWhereHas('user.refPegawai', fn($q2) => $q2->where('name', 'like', "%$search%"))
                        ->orWhereHas('tersedia', fn($q3) => $q3->where('nama_pelatihan', 'like', "%$search%"))
                        ->orWhereHas('usulan', fn($q4) => $q4->where('nama_pelatihan', 'like', "%$search%"))
                        ->orWhereHas('laporan', fn($q4) => $q4->where('judul_laporan', 'like', "%$search%"));
                });
            })
            ->when($unit, function ($query) use ($unit) {
                $query->whereHas('user.latestUserPivot.unitKerja', fn($q) => $q->where('unitkerja_id', $unit));
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_pendaftaran', [$start, $end]);
            })
            ->leftJoin('users', 'users.nip', '=', 'pelatihan_3_pendaftarans.user_nip')
            ->leftJoin('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->orderBy('ref_pegawai.name')
            ->select('pelatihan_3_pendaftarans.*')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pelatihan.alumni.index', compact('alumnis', 'unitkerjas', 'user'))->render();
        }

        return view('dashboard.pelatihan.alumni.index', compact('alumnis', 'unitkerjas', 'user'));
    }

    /**
     * Display the specified alumni resource.
     */
    public function show($id)
    {
        $pendaftaran = Pelatihan3Pendaftaran::with(['laporan'])
            ->where('status_peserta', 'alumni')
            ->findOrFail($id);
            
        return view('dashboard.pelatihan.alumni.detail', compact('pendaftaran'));
    }

    /**
     * Cetak PDF untuk data alumni
     */
    public function cetakPdf(Request $request)
    {
        $pendaftarans = collect();

        // Mode: Cetak semua hasil filter
        $search = $request->input('search');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $unit = $request->input('unit_id');

        $query = Pelatihan3Pendaftaran::with(['user.latestUserPivot.unitKerja', 'tersedia', 'usulan', 'laporan'])
            ->where('status_peserta', 'alumni') // Hanya ambil alumni
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('user_nip', 'like', "%$search%")
                        ->orWhereHas('user.refPegawai', fn($q2) => $q2->where('name', 'like', "%$search%"))
                        ->orWhereHas('tersedia', fn($q3) => $q3->where('nama_pelatihan', 'like', "%$search%"))
                        ->orWhereHas('usulan', fn($q4) => $q4->where('nama_pelatihan', 'like', "%$search%"));
                });
            })
            ->when($unit, function ($query) use ($unit) {
                $query->whereHas('user.latestUserPivot.unitKerja', fn($q) => $q->where('unitkerja_id', $unit));
            })
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_pendaftaran', [$start, $end]));

        $pendaftarans = $query->get()->sortBy('user.refPegawai.name');

        $pdfSettings = [
            'paper_size' => $request->input('paper_size', 'a4'),
            'orientation' => $request->input('orientation', 'portrait'),
            'margin_top' => $request->input('margin_top', 10),
            'margin_right' => $request->input('margin_right', 10),
            'margin_bottom' => $request->input('margin_bottom', 10),
            'margin_left' => $request->input('margin_left', 10),
            'show_header' => $request->has('show_header'),
            'show_footer' => $request->has('show_footer')
        ];

        $pdf = PDF::loadView('dashboard.pelatihan.alumni.pdf', compact('pendaftarans', 'pdfSettings'));

        $pdf->setPaper($pdfSettings['paper_size'], $pdfSettings['orientation']);
        $pdf->setOption('margin-top', $pdfSettings['margin_top'] . 'in');
        $pdf->setOption('margin-right', $pdfSettings['margin_right'] . 'in');
        $pdf->setOption('margin-bottom', $pdfSettings['margin_bottom'] . 'in');
        $pdf->setOption('margin-left', $pdfSettings['margin_left'] . 'in');

        return $pdf->stream('alumni_pelatihan_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.pdf');
    }

    /**
     * Cetak Excel untuk data alumni
     */
    public function cetakExcel(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $unit = $request->input('unit_id');
        $columns = $request->input('columns', []);
        $fileFormat = $request->input('file_format', 'xlsx');
        $includeHeader = $request->has('include_header');

        $query = Pelatihan3Pendaftaran::with(['user.latestUserPivot.unitKerja', 'tersedia', 'usulan', 'laporan'])
            ->where('status_peserta', 'alumni') // Hanya ambil alumni
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('user_nip', 'like', "%$search%")
                        ->orWhereHas('user.refPegawai', fn($q2) => $q2->where('name', 'like', "%$search%"))
                        ->orWhereHas('tersedia', fn($q3) => $q3->where('nama_pelatihan', 'like', "%$search%"))
                        ->orWhereHas('usulan', fn($q4) => $q4->where('nama_pelatihan', 'like', "%$search%"));
                });
            })
            ->when($unit, function ($query) use ($unit) {
                $query->whereHas('user.latestUserPivot.unitKerja', fn($q) => $q->where('unitkerja_id', $unit));
            })
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_pendaftaran', [$start, $end]));

        $pendaftarans = $query->get()->sortBy('user.refPegawai.name');

        $exportType = $fileFormat === 'csv' ? 
            \Maatwebsite\Excel\Excel::CSV : 
            \Maatwebsite\Excel\Excel::XLSX;

        return Excel::download(
            new AlumniPelatihanExport($pendaftarans, $columns, $includeHeader),
            'alumni_pelatihan_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.' . $fileFormat,
            $exportType
        );
    }

    /**
     * Preview data alumni untuk modal cetak
     */
    public function preview(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start');
        $end = $request->input('end');
        $unit = $request->input('unit_id');

        $query = Pelatihan3Pendaftaran::with(['user.latestUserPivot.unitKerja', 'tersedia', 'usulan', 'laporan'])
            ->where('status_peserta', 'alumni') // Hanya ambil alumni
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('user_nip', 'like', "%$search%")
                        ->orWhereHas('user.refPegawai', fn($q2) => $q2->where('name', 'like', "%$search%"))
                        ->orWhereHas('tersedia', fn($q3) => $q3->where('nama_pelatihan', 'like', "%$search%"))
                        ->orWhereHas('usulan', fn($q4) => $q4->where('nama_pelatihan', 'like', "%$search%"))
                        ->orWhereHas('laporan', fn($q5) => $q5->where('judul_laporan', 'like', "%$search%"));
                });
            })
            ->when($unit, function ($query) use ($unit) {
                $query->whereHas('user.latestUserPivot.unitKerja', fn($q) => $q->where('unitkerja_id', $unit));
            })
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_pendaftaran', [$start, $end]));

        $data = $query->join('users', 'users.nip', '=', 'pelatihan_3_pendaftarans.user_nip')
            ->join('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->orderBy('ref_pegawai.name')
            ->select('pelatihan_3_pendaftarans.*')
            ->get();

        return response()->json(['data' => $data]);
    }
}