<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Admin\Exports\PelatihanUsulanExport;
use App\Http\Controllers\Controller;
use App\Models\Pelatihan2Usulan;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\Pelatihan4Laporan;
use App\Models\ref_jenispelatihans;
use App\Models\ref_metodepelatihans;
use App\Models\ref_namapelatihan;
use App\Models\ref_namapelatihans;
use App\Models\ref_pelaksanaanpelatihans;
use App\Models\ref_unitkerjas;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PelatihanUsulanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenisId = $request->input('jenis');
        $metodeId = $request->input('metode');
        $pelaksanaanId = $request->input('pelaksanaan');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $minCost = $request->input('min_cost');
        $maxCost = $request->input('max_cost');

        $user = Auth::user();
        if ($user->role === 'admin') {
            $unit = $user->latestUserPivot->unitKerja->unitkerja_id;
        } else {
            $unit = $request->get('unit');
        }

        $nipAtasan = $user->refPegawai?->nip_atasan;
        $user = User::where('nip', $nipAtasan)->first();

        $unitkerjas = ref_unitkerjas::select('id', 'unitkerja')
            ->orderBy('unitkerja')
            ->get();

        // Fetch all jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
        $jenispelatihans = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get();
        $metodes = ref_metodepelatihans::select('id', 'metode_pelatihan')->get();
        $pelaksanaans = ref_pelaksanaanpelatihans::select('id', 'pelaksanaan_pelatihan')->get();

        $pelatihans = Pelatihan2Usulan::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelatihan', 'like', '%' . $search . '%')
                    ->orWhere('nip_pengusul', 'like', '%' . $search . '%')
                    ->orWhere('penyelenggara_pelatihan', 'like', '%' . $search . '%')
                    ->orWhere('tempat_pelatihan', 'like', '%' . $search . '%')
                    ->orWhere('estimasi_biaya', 'like', '%' . $search . '%')
                    ->orWhere('keterangan', 'like', '%' . $search . '%')
                    ->orWhere('realisasi_biaya', 'like', '%' . $search . '%')
                    ->orWhereHas('jenispelatihan', fn($q2) => $q2->where('jenis_pelatihan', 'like', "%{$search}%"))
                    ->orWhereHas('metodepelatihan', fn($q2) => $q2->where('metode_pelatihan', 'like', "%{$search}%"))
                    ->orWhereHas('pelaksanaanpelatihan', fn($q2) => $q2->where('pelaksanaan_pelatihan', 'like', "%{$search}%"));
            });
        })
            ->when(
                $unit,
                fn($query) =>
                $query->whereHas('user.latestUserPivot.unitKerja', fn($q) => $q->where('unitkerja_id', $unit))
            )
            ->when($jenisId, fn($q) => $q->where('jenispelatihan_id', $jenisId))
            ->when($metodeId, fn($q) => $q->where('metodepelatihan_id', $metodeId))
            ->when($pelaksanaanId, fn($q) => $q->where('pelaksanaanpelatihan_id', $pelaksanaanId))
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_mulai', [$start, $end]))
            ->when($minCost && $maxCost, fn($q) => $q->whereBetween('estimasi_biaya', [$minCost, $maxCost]))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pelatihan.usulan.index', compact('pelatihans', 'unitkerjas', 'jenispelatihans', 'metodes', 'pelaksanaans'))->render();
        }

        // Return the view with pelatihan data
        return view('dashboard.pelatihan.usulan.index', compact('pelatihans', 'unitkerjas', 'jenispelatihans', 'metodes', 'pelaksanaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
        $pegawai = User::select('nip')->get();
        $namaPelatihan = ref_namapelatihans::select('nama_pelatihan')->where('status', 'diterima')->get();
        $jenisPelatihan = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get();
        $pelaksanaanPelatihan = ref_pelaksanaanpelatihans::select('id', 'pelaksanaan_pelatihan')->get();
        $metodePelatihan = ref_metodepelatihans::select('id', 'metode_pelatihan')->get();

        // Return the view with jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
        return view('dashboard.pelatihan.usulan.create', compact('pegawai', 'namaPelatihan', 'jenisPelatihan', 'pelaksanaanPelatihan', 'metodePelatihan'));
    }

    /**
     * Get Pegawai by NIP
     */
    public function getPegawaiByNip(Request $request)
    {
        $request->validate([
            'nip' => 'required|string'
        ]);

        $user = User::where('nip', $request->nip)->first();

        if (!$user || $user->userPivot->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Pegawai tidak ditemukan'
            ]);
        }

        $pivot = $user->latestUserPivot;

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $user->refPegawai->name,
                'pangkat_golongan' => $pivot->golongan->pangkat_golongan ?? null,
                'jabatan' => $pivot->jabatan->jabatan ?? null,
                'unitkerja' => $pivot->unitKerja->unitkerja->unitkerja ?? null,
                'sub_unitkerja' => $pivot->unitKerja->sub_unitkerja ?? null,
                'no_hp' => $user->refPegawai->no_hp ?? null
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nip_pengusul' => 'required|exists:users,nip',
            'nama_pelatihan' => 'required|exists:ref_namapelatihans,nama_pelatihan',
            'jenispelatihan_id' => 'required|exists:ref_jenispelatihans,id',
            'metodepelatihan_id' => 'required|exists:ref_metodepelatihans,id',
            'pelaksanaanpelatihan_id' => 'required|exists:ref_pelaksanaanpelatihans,id',
            'penyelenggara_pelatihan' => 'required|string|max:255',
            'tempat_pelatihan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'estimasi_biaya' => 'required|numeric',
            'file_penawaran' => 'required|file|mimes:pdf|max:8192',
            'keterangan' => 'required|string|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_penawaran')) {
            $data['file_penawaran'] = $request->file('file_penawaran')->store('uploads/penawaran', 'public');
        }

        $usulan = Pelatihan2Usulan::create($data);

        Pelatihan3Pendaftaran::create([
            'kode_pendaftaran' => 'USP' . $usulan->id . now()->timezone('Asia/Jakarta')->format('YmdHis'),
            'usulan_id' => $usulan->id,
            'user_nip' => $usulan->nip_pengusul,
            'status_verifikasi' => 'tersimpan',
            'status_peserta' => 'calon_peserta',
            'tanggal_pendaftaran' => now()->timezone('Asia/Jakarta'),
        ]);

        // Redirect to the pelatihan index with success message
        return redirect()->route('dashboard.pelatihan.usulan')->with([
            'message' => 'Usulan pelatihan berhasil dikirim.',
            'title' => 'Success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the pelatihan data by ID
        $pelatihan = Pelatihan2Usulan::findOrFail($id);

        // Return the view with pelatihan data
        return view('dashboard.pelatihan.usulan.detail', compact('pelatihan'));
    }

    public function edit($id)
    {
        // Fetch the pelatihan data by ID
        $pelatihan = Pelatihan2Usulan::with('pendaftaran:id,usulan_id,status_verifikasi,status_peserta')->findOrFail($id);

        // Fetch all jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
        $pegawai = User::select('nip')->get();
        $namaPelatihan = ref_namapelatihans::select('nama_pelatihan')->where('status', 'diterima')->get();
        $jenisPelatihan = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get();
        $pelaksanaanPelatihan = ref_pelaksanaanpelatihans::select('id', 'pelaksanaan_pelatihan')->get();
        $metodePelatihan = ref_metodepelatihans::select('id', 'metode_pelatihan')->get();

        // Return the view with pelatihan data and jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
        return view('dashboard.pelatihan.usulan.edit', compact('pelatihan', 'pegawai', 'namaPelatihan', 'jenisPelatihan', 'pelaksanaanPelatihan', 'metodePelatihan'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'realisasi_biya' => 'nullable|numeric',
            'status_verifikasi' => 'required|in:tersimpan,terkirim,tercetak,diterima,ditolak',
        ]);

        $pendaftaran = Pelatihan3Pendaftaran::where('usulan_id', $id)->first();

        if ($request->status_verifikasi === 'diterima') {
            // Update the pelatihan usulan with the realisasi biaya
            Pelatihan2Usulan::where('id', $id)->update([
                'realisasi_biaya' => $request->realisasi_biaya,
            ]);

            $pendaftaran->update([
                'status_verifikasi' => $request->status_verifikasi,
                'status_peserta' => 'peserta',
            ]);

            // Cek apakah sudah ada laporan untuk pendaftaran ini
            $existingLaporan = Pelatihan4Laporan::where('pendaftaran_id', $pendaftaran->id)->first();

            if (!$existingLaporan) {
                // Jika belum ada laporan, buat baru
                Pelatihan4Laporan::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'judul_laporan' => 'Ubah setelah selesai pelatihan!',
                    'latar_belakang' => 'Ubah setelah selesai pelatihan!',
                    'sertifikat' => null,
                    'total_biaya' => 0,
                    'laporan' => null,
                    'hasil_pelatihan' => 'draft',
                ]);
            }

            return redirect()->route('dashboard.pelatihan.usulan')->with([
                'message' => 'Usulan pelatihan berhasil disetujui.',
                'title' => 'Success',
            ]);
        } else {
            // If the status is 'ditolak', set status_peserta to 'ditolak'
            $pendaftaran->update([
                'status_verifikasi' => $request->status_verifikasi,
                'status_peserta' => 'calon_peserta',
            ]);

            return redirect()->route('dashboard.pelatihan.usulan')->with([
                'message' => 'Usulan pelatihan berhasil ditolak.',
                'title' => 'Success',
            ]);
        }
    }

    public function destroy($id)
    {
        // Fetch the pelatihan data by ID
        $pelatihan = Pelatihan2Usulan::findOrFail($id);

        if ($pelatihan->file_penawaran && Storage::disk('public')->exists($pelatihan->file_penawaran)) {
            // Delete the file from storage
            Storage::disk('public')->delete($pelatihan->file_penawaran);
        }
        $pelatihan->delete();

        // Redirect to the pelatihan index with success message
        return redirect()->route('dashboard.pelatihan.usulan')->with([
            'message' => 'Usulan pelatihan berhasil dihapus.',
            'title' => 'Success',
        ]);
    }

    public function exportExcel(Request $request)
    {
        $search = $request->input('search');
        $jenisId = $request->input('jenis');
        $metodeId = $request->input('metode');
        $pelaksanaanId = $request->input('pelaksanaan');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $columns = $request->input('columns', []);
        $fileFormat = $request->input('file_format', 'xlsx');
        $includeHeader = $request->has('include_header');

        $query = Pelatihan2Usulan::with(['jenispelatihan', 'metodepelatihan', 'pelaksanaanpelatihan'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_pelatihan', 'like', "%{$search}%")
                        ->orWhere('penyelenggara_pelatihan', 'like', "%{$search}%")
                        ->orWhere('tempat_pelatihan', 'like', "%{$search}%")
                        ->orWhere('kuota', 'like', "%{$search}%")
                        ->orWhere('estimasi_biaya', 'like', "%{$search}%")
                        ->orWhere('realisasi_biaya', 'like', "%{$search}%")
                        ->orWhereHas('jenispelatihan', fn($q2) => $q2->where('jenis_pelatihan', 'like', "%{$search}%"))
                        ->orWhereHas('metodepelatihan', fn($q2) => $q2->where('metode_pelatihan', 'like', "%{$search}%"))
                        ->orWhereHas('pelaksanaanpelatihan', fn($q2) => $q2->where('pelaksanaan_pelatihan', 'like', "%{$search}%"));
                });
            })
            ->when($jenisId, fn($q) => $q->where('jenispelatihan_id', $jenisId))
            ->when($metodeId, fn($q) => $q->where('metodepelatihan_id', $metodeId))
            ->when($pelaksanaanId, fn($q) => $q->where('pelaksanaanpelatihan_id', $pelaksanaanId))
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_mulai', [$start, $end]))
            ->orderByDesc('created_at');

        $pelatihans = $query->get();

        $exportType = $fileFormat === 'csv' ?
            \Maatwebsite\Excel\Excel::CSV :
            \Maatwebsite\Excel\Excel::XLSX;

        return Excel::download(
            new PelatihanUsulanExport($pelatihans, $columns, $includeHeader),
            'pelatihan_usulan_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.' . $fileFormat,
            $exportType
        );
    }

    public function exportPdf(Request $request)
    {
        $search = $request->input('search');
        $jenisId = $request->input('jenis');
        $metodeId = $request->input('metode');
        $pelaksanaanId = $request->input('pelaksanaan');
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $query = Pelatihan2Usulan::with(['jenispelatihan', 'metodepelatihan', 'pelaksanaanpelatihan'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_pelatihan', 'like', "%{$search}%")
                        ->orWhere('penyelenggara_pelatihan', 'like', "%{$search}%")
                        ->orWhere('tempat_pelatihan', 'like', "%{$search}%")
                        ->orWhere('kuota', 'like', "%{$search}%")
                        ->orWhere('estimasi_biaya', 'like', "%{$search}%")
                        ->orWhere('realisasi_biaya', 'like', "%{$search}%")
                        ->orWhereHas('jenispelatihan', fn($q2) => $q2->where('jenis_pelatihan', 'like', "%{$search}%"))
                        ->orWhereHas('metodepelatihan', fn($q2) => $q2->where('metode_pelatihan', 'like', "%{$search}%"))
                        ->orWhereHas('pelaksanaanpelatihan', fn($q2) => $q2->where('pelaksanaan_pelatihan', 'like', "%{$search}%"));
                });
            })
            ->when($jenisId, fn($q) => $q->where('jenispelatihan_id', $jenisId))
            ->when($metodeId, fn($q) => $q->where('metodepelatihan_id', $metodeId))
            ->when($pelaksanaanId, fn($q) => $q->where('pelaksanaanpelatihan_id', $pelaksanaanId))
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_mulai', [$start, $end]))
            ->orderByDesc('created_at');

        $pelatihans = $query->get();

        $pdfSettings = [
            'paper_size' => $request->input('paper_size', 'a4'),
            'orientation' => $request->input('orientation', 'portrait'),
            'margin_top' => $request->input('margin_top', 0.5),
            'margin_right' => $request->input('margin_right', 0.5),
            'margin_bottom' => $request->input('margin_bottom', 0.5),
            'margin_left' => $request->input('margin_left', 0.5),
            'show_header' => $request->has('show_header'),
            'show_footer' => $request->has('show_footer')
        ];

        $pdf = Pdf::loadView('dashboard.pelatihan.usulan.pdf', compact('pelatihans', 'pdfSettings'));

        $pdf->setPaper($pdfSettings['paper_size'], 'landscape');
        $pdf->setOption('margin-top', $pdfSettings['margin_top'] . 'in');
        $pdf->setOption('margin-right', $pdfSettings['margin_right'] . 'in');
        $pdf->setOption('margin-bottom', $pdfSettings['margin_bottom'] . 'in');
        $pdf->setOption('margin-left', $pdfSettings['margin_left'] . 'in');

        return $pdf->stream('pelatihan_usulan_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.pdf');
    }

    public function preview(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');
        $metode = $request->input('metode');
        $pelaksanaan = $request->input('pelaksanaan');
        $start = $request->input('start');
        $end = $request->input('end');

        $query = Pelatihan2Usulan::with(['jenispelatihan', 'metodepelatihan', 'pelaksanaanpelatihan'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_pelatihan', 'like', "%{$search}%")
                        ->orWhere('penyelenggara_pelatihan', 'like', "%{$search}%")
                        ->orWhere('tempat_pelatihan', 'like', "%{$search}%")
                        ->orWhere('kuota', 'like', "%{$search}%")
                        ->orWhere('biaya', 'like', "%{$search}%")
                        ->orWhere('status_pelatihan', 'like', "%{$search}%")
                        ->orWhereHas('jenispelatihan', fn($q2) => $q2->where('jenis_pelatihan', 'like', "%{$search}%"))
                        ->orWhereHas('metodepelatihan', fn($q2) => $q2->where('metode_pelatihan', 'like', "%{$search}%"))
                        ->orWhereHas('pelaksanaanpelatihan', fn($q2) => $q2->where('pelaksanaan_pelatihan', 'like', "%{$search}%"));
                });
            })
            ->when($jenis, fn($q) => $q->where('jenispelatihan_id', $jenis))
            ->when($metode, fn($q) => $q->where('metodepelatihan_id', $metode))
            ->when($pelaksanaan, fn($q) => $q->where('pelaksanaanpelatihan_id', $pelaksanaan))
            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_mulai', [$start, $end]);
            });

        $data = $query->orderBy('created_at')->get();

        return response()->json(['data' => $data]);
    }
}
