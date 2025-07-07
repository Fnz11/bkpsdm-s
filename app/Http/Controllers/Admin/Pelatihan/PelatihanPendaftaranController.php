<?php

namespace App\Http\Controllers\Admin\Pelatihan;

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

class PelatihanPendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $start = $request->get('start_date');
        $end = $request->get('end_date');
        $verif = $request->get('verif');
        $peserta = $request->get('peserta');

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

        $pendaftarans = Pelatihan3Pendaftaran::with([
            'user.latestUserPivot.unitKerja',
            'tersedia',
            'usulan'
        ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('user_nip', 'like', "%$search%")
                        ->orWhereHas('user.refPegawai', fn($q2) => $q2->where('name', 'like', "%$search%"))
                        ->orWhereHas('tersedia', fn($q3) => $q3->where('nama_pelatihan', 'like', "%$search%"))
                        ->orWhereHas('usulan', fn($q4) => $q4->where('nama_pelatihan', 'like', "%$search%"));
                });
            })
            ->when(
                $unit,
                fn($query) =>
                $query->whereHas('user.latestUserPivot.unitKerja', fn($q) => $q->where('unitkerja_id', $unit))
            )
            ->when($verif, fn($q) => $q->where('status_verifikasi', $verif))
            ->when($peserta, fn($q) => $q->where('status_peserta', $peserta))
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_pendaftaran', [$start, $end]))
            ->leftJoin('users', 'users.nip', '=', 'pelatihan_3_pendaftarans.user_nip')
            ->leftJoin('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->orderBy('ref_pegawai.name')
            ->select('pelatihan_3_pendaftarans.*')
            ->paginate(25)
            ->withQueryString();

        $pendaftarans2 = Pelatihan3Pendaftaran::with([
            'user.latestUserPivot.unitKerja',
            'tersedia',
            'usulan'
        ])
            ->leftJoin('users', 'users.nip', '=', 'pelatihan_3_pendaftarans.user_nip')
            ->leftJoin('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->orderBy('ref_pegawai.name')
            ->select('pelatihan_3_pendaftarans.*')
            ->get();


        if ($request->ajax()) {
            return view('dashboard.pelatihan.pendaftaran.index', compact('pendaftarans', 'pendaftarans2', 'unitkerjas', 'user'))->render();
        }

        return view('dashboard.pelatihan.pendaftaran.index', compact('pendaftarans', 'pendaftarans2', 'unitkerjas', 'user'));
    }

    public function cetakPdfPage()
    {
        $unitkerjas = ref_unitkerjas::select('id', 'unitkerja')
            ->orderBy('unitkerja')
            ->get();
        $user = Auth::user();
        $nipAtasan = $user->refPegawai?->nip_atasan;
        $user = User::where('nip', $nipAtasan)->first();

        return view('dashboard.pelatihan.cetakadmin.index', compact('unitkerjas', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This method can be used to show a form for creating a new registration
        return view('dashboard.pelatihan.pendaftaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // This method can be used to store a new registration
        $validatedData = $request->validate([
            'user_nip' => 'required|string|max:255',
            'tersedia_id' => 'required|exists:pelatihan3_tersedia,id',
            'tanggal_pendaftaran' => 'required|date',
            // Add other validation rules as necessary
        ]);

        Pelatihan3Pendaftaran::create($validatedData);

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pendaftaran = Pelatihan3Pendaftaran::findOrFail($id);
        return view('dashboard.pelatihan.pendaftaran.detail', compact('pendaftaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pendaftaran = Pelatihan3Pendaftaran::findOrFail($id);
        return view('dashboard.pelatihan.pendaftaran.edit', compact('pendaftaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = Pelatihan3Pendaftaran::findOrFail($id);

        $validatedData = $request->validate([
            'realisasi_biaya' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
            'status_verifikasi' => 'required|in:tersimpan,tercetak,terkirim,diterima,ditolak',
            'status_peserta' => 'required|in:calon_peserta,peserta,alumni',
        ]);

        $pendaftaran->update([
            'keterangan' => $validatedData['keterangan'],
            'status_verifikasi' => $validatedData['status_verifikasi'],
            'status_peserta' => $validatedData['status_peserta'],
        ]);

        if ($validatedData['status_verifikasi'] === 'diterima') {
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

        if (isset($validatedData['realisasi_biaya'])) {
            if ($pendaftaran->usulan) {
                $pendaftaran->usulan->update([
                    'realisasi_biaya' => $validatedData['realisasi_biaya'],
                ]);
            }
        }

        return redirect()->route('dashboard.pelatihan.pendaftaran')->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    public function updateBulk(Request $request)
    {
        $request->validate([
            'pendaftaran_ids' => 'required|array|min:1',
            'pendaftaran_ids.*' => 'exists:pelatihan_3_pendaftarans,id',
            'status_verifikasi' => 'nullable|in:tersimpan,tercetak,terkirim,diterima,ditolak',
            'status_peserta' => 'nullable|in:calon_peserta,peserta,alumni'
        ]);

        // Validasi minimal satu status yang diupdate
        if (!$request->filled('status_verifikasi') && !$request->filled('status_peserta')) {
            return redirect()->back()->with([
                'message' => 'Pilih minimal satu status untuk diperbarui.',
                'title' => 'Error'
            ]);
        }

        $updates = [];
        if ($request->filled('status_verifikasi')) {
            $updates['status_verifikasi'] = $request->status_verifikasi;
        }
        if ($request->filled('status_peserta')) {
            $updates['status_peserta'] = $request->status_peserta;
        }

        // Gunakan transaction untuk memastikan konsistensi data
        DB::beginTransaction();
        try {
            $pendaftarans = Pelatihan3Pendaftaran::whereIn('id', $request->pendaftaran_ids)->get();

            // Update status pendaftaran
            Pelatihan3Pendaftaran::whereIn('id', $request->pendaftaran_ids)
                ->update($updates);

            // Jika status verifikasi diubah menjadi 'diterima', buat laporan
            if ($request->status_verifikasi === 'diterima') {
                foreach ($pendaftarans as $pendaftaran) {
                    // Cek apakah laporan sudah ada untuk menghindari duplikasi
                    $laporanExists = Pelatihan4Laporan::where('pendaftaran_id', $pendaftaran->id)->exists();

                    if (!$laporanExists) {
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
                }
            }

            DB::commit();

            return redirect()->back()->with([
                'message' => 'Berhasil memperbarui status ' . count($request->pendaftaran_ids) . ' pendaftaran.',
                'title' => 'Success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'message' => 'Gagal memperbarui status: ' . $e->getMessage(),
                'title' => 'Error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pendaftaran = Pelatihan3Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('dashboard.pelatihan.pendaftaran')->with('success', 'Pendaftaran berhasil dihapus.');
    }

    public function cetakPdf(Request $request)
    {
        $pendaftarans = collect();
        $pj = '';
        $unitkerja = Auth::user()->latestUserPivot->unitKerja->unitkerja->unitkerja;

        if ($request->mode_penanggung === 'manual') {
            $pj = 'manual';
        } else {
            $pj = 'auto';
        }

        $user = (object)[
            'nama' => $request->penanggungjawab_nama,
            'nip' => $request->penanggungjawab_nip,
            'jabatan' => $request->penanggungjawab_jabatan,
            'pangkat' => $request->penanggungjawab_pangkat
        ];

        // Mode: Cetak semua hasil filter
        $search = $request->input('search');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $unit = $request->input('unit_id');
        $peserta = $request->input('peserta');
        $verif = $request->input('verif');

        $query = Pelatihan3Pendaftaran::with(['user.latestUserPivot.unitKerja', 'tersedia', 'usulan'])
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
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_pendaftaran', [$start, $end]))
            ->when($peserta, fn($q) => $q->where('status_peserta', $peserta))
            ->when($verif, fn($q) => $q->where('status_verifikasi', $verif));

        $pendaftarans = $query->get()->sortBy('user.refPegawai.name');

        $pdfSettings = [
            'paper_size' => $request->input('paper_size', 'a4'),
            'orientation' => $request->input('orientation', 'portrait'),
            'margin_top' => $request->input('margin_top', 10),
            'margin_right' => $request->input('margin_right', 10),
            'margin_bottom' => $request->input('margin_bottom', 10),
            'margin_left' => $request->input('margin_left', 10),
            'show_header' => $request->has('show_header'),
            'show_footer' => $request->has('show_footer'),
            'show_signature' => $request->has('show_signature')
        ];

        $pdf = PDF::loadView('dashboard.pelatihan.pendaftaran.pdf', compact('pendaftarans', 'unitkerja', 'user', 'pj', 'pdfSettings'));

        $pdf->setPaper($pdfSettings['paper_size'], $pdfSettings['orientation']);
        $pdf->setOption('margin-top', $pdfSettings['margin_top'] . 'in');
        $pdf->setOption('margin-right', $pdfSettings['margin_right'] . 'in');
        $pdf->setOption('margin-bottom', $pdfSettings['margin_bottom'] . 'in');
        $pdf->setOption('margin-left', $pdfSettings['margin_left'] . 'in');

        return $pdf->stream('pendaftaran_pelatihan_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.pdf');
    }

    public function cetakPdfAdmin(Request $request)
    {
        $pendaftarans = collect();
        $pj = '';
        $unitkerja = Auth::user()->latestUserPivot->unitKerja->unitkerja->unitkerja;

        if ($request->mode_penanggung === 'manual') {
            $pj = 'manual';
        } else {
            $pj = 'auto';
        }

        $user = (object)[
            'nama' => $request->penanggungjawab_nama,
            'nip' => $request->penanggungjawab_nip,
            'jabatan' => $request->penanggungjawab_jabatan,
            'pangkat' => $request->penanggungjawab_pangkat
        ];

        // Mode: Cetak semua hasil filter
        $search = $request->input('search');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $unit = $request->input('unit_id');
        $peserta = $request->input('peserta');

        $query = Pelatihan3Pendaftaran::with(['user.latestUserPivot.unitKerja', 'tersedia', 'usulan'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('user_nip', 'like', "%$search%")
                        ->orWhereHas('user.refPegawai', fn($q2) => $q2->where('name', 'like', "%$search%"))
                        ->orWhereHas('tersedia', fn($q3) => $q3->where('nama_pelatihan', 'like', "%$search%"))
                        ->orWhereHas('usulan', fn($q4) => $q4->where('nama_pelatihan', 'like', "%$search%"));
                });
            })
            ->when($unit, function ($query) use ($unit) {
                $query->whereHas(
                    'user.latestUserPivot.unitKerja',
                    fn($q) =>
                    $q->where('unitkerja_id', $unit)
                );
            })
            ->when(
                $start && $end,
                fn($q) =>
                $q->whereBetween('tanggal_pendaftaran', [$start, $end])
            )
            ->where('status_peserta', 'calon_peserta')
            ->where('status_verifikasi', 'tersimpan'); // Hanya ambil yang belum dicetak

        $pendaftarans = $query->get()->sortBy('user.refPegawai.name');

        // Update status menjadi tercetak untuk semua pendaftaran yang akan dicetak
        if ($pendaftarans->isNotEmpty()) {
            $ids = $pendaftarans->pluck('id')->toArray();
            Pelatihan3Pendaftaran::whereIn('id', $ids)
                ->update(['status_verifikasi' => 'tercetak']);
        }

        $pdfSettings = [
            'paper_size' => $request->input('paper_size', 'a4'),
            'orientation' => $request->input('orientation', 'portrait'),
            'margin_top' => $request->input('margin_top', 10),
            'margin_right' => $request->input('margin_right', 10),
            'margin_bottom' => $request->input('margin_bottom', 10),
            'margin_left' => $request->input('margin_left', 10),
            'show_header' => $request->has('show_header'),
            'show_footer' => $request->has('show_footer'),
            'show_signature' => $request->has('show_signature')
        ];

        $pdf = PDF::loadView('dashboard.pelatihan.pendaftaran.pdf', compact('pendaftarans', 'unitkerja', 'user', 'pj', 'pdfSettings'));

        $pdf->setPaper($pdfSettings['paper_size'], $pdfSettings['orientation']);
        $pdf->setOption('margin-top', $pdfSettings['margin_top'] . 'in');
        $pdf->setOption('margin-right', $pdfSettings['margin_right'] . 'in');
        $pdf->setOption('margin-bottom', $pdfSettings['margin_bottom'] . 'in');
        $pdf->setOption('margin-left', $pdfSettings['margin_left'] . 'in');

        return $pdf->download('pendaftaran_pelatihan_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.pdf');
    }

    public function cetakExcel(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $unit = $request->input('unit_id');
        $verif = $request->input('verif');
        $peserta = $request->input('peserta');
        $columns = $request->input('columns', []);
        $fileFormat = $request->input('file_format', 'xlsx');
        $includeHeader = $request->has('include_header');

        $query = Pelatihan3Pendaftaran::with(['user.latestUserPivot.unitKerja', 'tersedia', 'usulan'])
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
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_pendaftaran', [$start, $end]))
            ->when($verif, fn($q) => $q->where('status_verifikasi', $verif))
            ->when($peserta, fn($q) => $q->where('status_peserta', $peserta));

        $pendaftarans = $query->get()->sortBy('user.refPegawai.name');

        // Tambahkan pengecekan format
        $exportType = $fileFormat === 'csv' ?
            \Maatwebsite\Excel\Excel::CSV :
            \Maatwebsite\Excel\Excel::XLSX;

        return Excel::download(
            new PelatihanPendaftaranExport($pendaftarans, $columns, $includeHeader),
            'pendaftaran_pelatihan_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.' . $fileFormat,
            $exportType
        );
    }

    public function preview(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start');
        $end = $request->input('end');
        $unit = $request->input('unit_id');
        $verif = $request->input('verif');
        $peserta = $request->input('peserta');

        $query = Pelatihan3Pendaftaran::with(['user.latestUserPivot.unitKerja', 'tersedia', 'usulan'])
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
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_pendaftaran', [$start, $end]))
            ->when($verif, fn($q) => $q->where('status_verifikasi', $verif))
            ->when($peserta, fn($q) => $q->where('status_peserta', $peserta));

        $data = $query->join('users', 'users.nip', '=', 'pelatihan_3_pendaftarans.user_nip')
            ->join('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->orderBy('ref_pegawai.name')
            ->select('pelatihan_3_pendaftarans.*')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function previewAdmin(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start');
        $end = $request->input('end');
        $unit = $request->input('unit_id');

        $query = Pelatihan3Pendaftaran::with(['user.latestUserPivot.unitKerja', 'tersedia', 'usulan'])
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
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_pendaftaran', [$start, $end]))
            ->where('status_verifikasi', 'tersimpan');

        $data = $query->join('users', 'users.nip', '=', 'pelatihan_3_pendaftarans.user_nip')
            ->join('ref_pegawai', 'ref_pegawai.nip', '=', 'users.nip')
            ->orderBy('ref_pegawai.name')
            ->select('pelatihan_3_pendaftarans.*')
            ->get();

        return response()->json(['data' => $data]);
    }
}
