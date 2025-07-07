<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Admin\Exports\PelatihanLaporanExport;
use App\Http\Controllers\Controller;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\Pelatihan4Laporan;
use App\Models\ref_jenispelatihans;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PelatihanLaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');
        $status = $request->input('status');
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        // Untuk dropdown filter jenis pelatihan
        $jenispelatihans = ref_jenispelatihans::all();

        $laporans = Pelatihan4Laporan::with(['pendaftaran.tersedia', 'pendaftaran.usulan'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul_laporan', 'like', "%{$search}%")
                        ->orWhere('latar_belakang', 'like', "%{$search}%")
                        ->orWhere('total_biaya', 'like', "%{$search}%")
                        ->orWhereHas('pendaftaran.tersedia', function ($q2) use ($search) {
                            $q2->where('nama_pelatihan', 'like', "%{$search}%");
                        })
                        ->orWhereHas('pendaftaran.usulan', function ($q3) use ($search) {
                            $q3->where('nama_pelatihan', 'like', "%{$search}%");
                        });
                });
            })
            ->when($jenis, function ($query, $jenis) {
                $query->where(function ($q) use ($jenis) {
                    $q->whereHas('pendaftaran.tersedia', function ($sub) use ($jenis) {
                        $sub->where('jenispelatihan_id', $jenis);
                    })->orWhereHas('pendaftaran.usulan', function ($sub) use ($jenis) {
                        $sub->where('jenispelatihan_id', $jenis);
                    });
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('hasil_pelatihan', $status);
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            })
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pelatihan.laporan.index', compact('laporans', 'jenispelatihans'))->render();
        }

        return view('dashboard.pelatihan.laporan.index', compact('laporans', 'jenispelatihans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pendaftarans = Pelatihan3Pendaftaran::with('user', 'pelatihan')->get();

        return view('dashboard.pelatihan.laporan.create', compact('pendaftarans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pelatihan_3_pendaftarans,id',
            'judul_laporan' => 'required|string|max:255',
            'latar_belakang' => 'required|string|max:255',
            'total_biaya' => 'required|numeric|min:0',
            'hasil_pelatihan' => 'required|in:lulus,tidak lulus',
            'sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'laporan' => 'required|file|mimes:pdf,docx|max:4096',
        ]);

        $sertifikatPath = $request->file('sertifikat')->store('sertifikat', 'public');
        $laporanPath = $request->file('laporan')->store('laporan', 'public');

        Pelatihan4Laporan::create([
            'pendaftaran_id' => $request->pendaftaran_id,
            'judul_laporan' => $request->judul_laporan,
            'latar_belakang' => $request->latar_belakang,
            'total_biaya' => $request->total_biaya,
            'hasil_pelatihan' => $request->hasil_pelatihan,
            'sertifikat' => basename($sertifikatPath),
            'laporan' => basename($laporanPath),
        ]);

        return redirect()->route('dashboard.pelatihan.laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = Pelatihan4Laporan::findOrFail($id);
        // $pendaftaran = Pelatihan3Pendaftaran::with('user', 'pelatihan')->findOrFail($laporan->pendaftaran_id);

        return view('dashboard.pelatihan.laporan.detail', compact('laporan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $laporan = Pelatihan4Laporan::findOrFail($id);
        $pendaftarans = Pelatihan3Pendaftaran::with('user')->get();

        return view('dashboard.pelatihan.laporan.edit', compact('laporan', 'pendaftarans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $laporan = Pelatihan4Laporan::findOrFail($id);

        $request->validate([
            'pendaftaran_id'  => 'required|exists:pelatihan_3_pendaftarans,id',
            'judul_laporan'   => 'required|string|max:255',
            'latar_belakang'  => 'required|string|max:255',
            'total_biaya'     => 'required|numeric|min:0',
            'hasil_pelatihan' => 'required|in:proses,revisi,lulus,tidak_lulus',
            'sertifikat'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'laporan'         => 'nullable|file|mimes:pdf,docx|max:4096',
        ]);

        // Update file sertifikat jika ada
        if ($request->hasFile('sertifikat')) {
            if ($laporan->sertifikat && Storage::disk('public')->exists('sertifikat/' . $laporan->sertifikat)) {
                Storage::disk('public')->delete('sertifikat/' . $laporan->sertifikat);
            }
            $laporan->sertifikat = $request->file('sertifikat')->store('sertifikat', 'public');
            $laporan->sertifikat = basename($laporan->sertifikat);
        }

        // Update file laporan jika ada
        if ($request->hasFile('laporan')) {
            if ($laporan->laporan && Storage::disk('public')->exists('laporan/' . $laporan->laporan)) {
                Storage::disk('public')->delete('laporan/' . $laporan->laporan);
            }
            $laporan->laporan = $request->file('laporan')->store('laporan', 'public');
            $laporan->laporan = basename($laporan->laporan);
        }

        // Update field lainnya
        $laporan->judul_laporan   = $request->judul_laporan;
        $laporan->latar_belakang  = $request->latar_belakang;
        $laporan->total_biaya     = $request->total_biaya;
        $laporan->hasil_pelatihan = $request->hasil_pelatihan;

        $laporan->save();

        $pendaftaran = Pelatihan3Pendaftaran::findOrFail($request->pendaftaran_id);
        $pendaftaran->status_peserta = $request->hasil_pelatihan === 'lulus' ? 'alumni' : 'peserta';
        $pendaftaran->save();

        return redirect()->route('dashboard.pelatihan.laporan')->with([
            'message' => 'Laporan berhasil diperbarui.',
            'title'   => 'Berhasil',
        ]);
    }

    /**
     * Update multiple laporan status in bulk
     */
    public function updateBulk(Request $request)
    {
        $request->validate([
            'laporan_ids' => 'required|array',
            'laporan_ids.*' => 'exists:pelatihan_4_laporans,id',
            'hasil_pelatihan' => 'required|in:proses,revisi,lulus,tidak_lulus'
        ]);

        $laporans = Pelatihan4Laporan::whereIn('id', $request->laporan_ids)->get();

        foreach ($laporans as $laporan) {
            $laporan->hasil_pelatihan = $request->hasil_pelatihan;
            $laporan->save();

            // Update status peserta di pendaftaran terkait
            if ($laporan->pendaftaran_id) {
                $pendaftaran = Pelatihan3Pendaftaran::find($laporan->pendaftaran_id);
                if ($pendaftaran) {
                    $pendaftaran->status_peserta = $request->hasil_pelatihan === 'lulus' ? 'alumni' : 'peserta';
                    $pendaftaran->save();
                }
            }
        }

        return redirect()->back()->with([
            'message' => 'Berhasil memperbarui status ' . $laporans->count() . ' laporan.',
            'title'   => 'Sukses',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = Pelatihan4Laporan::findOrFail($id);

        Storage::disk('public')->delete([
            'sertifikat/' . $laporan->sertifikat,
            'laporan/' . $laporan->laporan,
        ]);

        $laporan->delete();

        return redirect()->route('dashboard.pelatihan.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    public function cetakPdf(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');
        $status = $request->input('status');
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $query = Pelatihan4Laporan::with(['pendaftaran.tersedia', 'pendaftaran.usulan'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul_laporan', 'like', "%{$search}%")
                        ->orWhere('latar_belakang', 'like', "%{$search}%")
                        ->orWhere('total_biaya', 'like', "%{$search}%")
                        ->orWhereHas('pendaftaran.tersedia', fn($q2) => $q2->where('nama_pelatihan', 'like', "%{$search}%"))
                        ->orWhereHas('pendaftaran.usulan', fn($q3) => $q3->where('nama_pelatihan', 'like', "%{$search}%"));
                });
            })
            ->when($jenis, function ($query, $jenis) {
                $query->where(function ($q) use ($jenis) {
                    $q->whereHas('pendaftaran.tersedia', function ($sub) use ($jenis) {
                        $sub->where('jenispelatihan_id', $jenis);
                    })->orWhereHas('pendaftaran.usulan', function ($sub) use ($jenis) {
                        $sub->where('jenispelatihan_id', $jenis);
                    });
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('hasil_pelatihan', $status);
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            })
            ->orderBy('created_at');

        $laporans = $query->get();

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

        $pdf = Pdf::loadView('dashboard.pelatihan.laporan.pdf', compact('laporans', 'pdfSettings'));

        $pdf->setPaper($pdfSettings['paper_size'], $pdfSettings['orientation']);
        $pdf->setOption('margin-top', $pdfSettings['margin_top'] . 'in');
        $pdf->setOption('margin-right', $pdfSettings['margin_right'] . 'in');
        $pdf->setOption('margin-bottom', $pdfSettings['margin_bottom'] . 'in');
        $pdf->setOption('margin-left', $pdfSettings['margin_left'] . 'in');

        return $pdf->stream('laporan_pelatihan_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.pdf');
    }

    public function cetakExcel(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');
        $status = $request->input('status');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $columns = $request->input('columns', []);
        $fileFormat = $request->input('file_format', 'xlsx');
        $includeHeader = $request->has('include_header');

        $query = Pelatihan4Laporan::with(['pendaftaran.tersedia', 'pendaftaran.usulan'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul_laporan', 'like', "%{$search}%")
                        ->orWhere('latar_belakang', 'like', "%{$search}%")
                        ->orWhere('total_biaya', 'like', "%{$search}%")
                        ->orWhereHas('pendaftaran.tersedia', fn($q2) => $q2->where('nama_pelatihan', 'like', "%{$search}%"))
                        ->orWhereHas('pendaftaran.usulan', fn($q3) => $q3->where('nama_pelatihan', 'like', "%{$search}%"));
                });
            })
            ->when($jenis, function ($query, $jenis) {
                $query->where(function ($q) use ($jenis) {
                    $q->whereHas('pendaftaran.tersedia', function ($sub) use ($jenis) {
                        $sub->where('jenispelatihan_id', $jenis);
                    })->orWhereHas('pendaftaran.usulan', function ($sub) use ($jenis) {
                        $sub->where('jenispelatihan_id', $jenis);
                    });
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('hasil_pelatihan', $status);
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            })
            ->orderBy('created_at');

        $laporans = $query->get();

        $exportType = $fileFormat === 'csv' ?
            \Maatwebsite\Excel\Excel::CSV :
            \Maatwebsite\Excel\Excel::XLSX;

        return Excel::download(
            new PelatihanLaporanExport($laporans, $columns, $includeHeader),
            'laporan_pelatihan_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.' . $fileFormat,
            $exportType
        );
    }

    public function preview(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');
        $status = $request->input('status');
        $start = $request->input('start');
        $end = $request->input('end');

        $query = Pelatihan4Laporan::with(['pendaftaran.tersedia', 'pendaftaran.usulan'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul_laporan', 'like', "%{$search}%")
                        ->orWhere('latar_belakang', 'like', "%{$search}%")
                        ->orWhere('total_biaya', 'like', "%{$search}%")
                        ->orWhereHas('pendaftaran.tersedia', fn($q2) => $q2->where('nama_pelatihan', 'like', "%{$search}%"))
                        ->orWhereHas('pendaftaran.usulan', fn($q3) => $q3->where('nama_pelatihan', 'like', "%{$search}%"));
                });
            })
            ->when($jenis, function ($query, $jenis) {
                $query->where(function ($q) use ($jenis) {
                    $q->whereHas('pendaftaran.tersedia', function ($sub) use ($jenis) {
                        $sub->where('jenispelatihan_id', $jenis);
                    })->orWhereHas('pendaftaran.usulan', function ($sub) use ($jenis) {
                        $sub->where('jenispelatihan_id', $jenis);
                    });
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('hasil_pelatihan', $status);
            })
            ->when($start && $end, function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            });

        $data = $query->orderBy('created_at')->get();

        return response()->json(['data' => $data]);
    }
}
