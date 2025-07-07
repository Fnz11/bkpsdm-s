<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Admin\Exports\PelatihanTersediaExport;
use App\Http\Controllers\Controller;
use App\Models\Pelatihan2Tersedia;
use App\Models\ref_jenispelatihans;
use App\Models\ref_metodepelatihans;
use App\Models\ref_namapelatihans;
use App\Models\ref_pelaksanaanpelatihans;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PelatihanTersediaController extends Controller
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

        $jenispelatihans = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get();
        $metodes = ref_metodepelatihans::select('id', 'metode_pelatihan')->get();
        $pelaksanaans = ref_pelaksanaanpelatihans::select('id', 'pelaksanaan_pelatihan')->get();

        $pelatihans = Pelatihan2Tersedia::when($search, function ($query, $search) {
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
            ->when($jenisId, fn($q) => $q->where('jenispelatihan_id', $jenisId))
            ->when($metodeId, fn($q) => $q->where('metodepelatihan_id', $metodeId))
            ->when($pelaksanaanId, fn($q) => $q->where('pelaksanaanpelatihan_id', $pelaksanaanId))
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_mulai', [$start, $end]))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('dashboard.pelatihan.tersedia.index', compact('pelatihans', 'jenispelatihans', 'metodes', 'pelaksanaans'))->render();
        }

        return view('dashboard.pelatihan.tersedia.index', compact('pelatihans', 'jenispelatihans', 'metodes', 'pelaksanaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch necessary data for the form
        $namapelatihans = ref_namapelatihans::select('id', 'nama_pelatihan')->get(); // Adjusted to select specific columns
        $jenispelatihans = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get(); // Adjusted to select specific columns
        $metodepelatihans = ref_metodepelatihans::select('id', 'metode_pelatihan')->get(); // Adjusted to select specific columns
        $pelaksanaanpelatihans = ref_pelaksanaanpelatihans::select('id', 'pelaksanaan_pelatihan')->get(); // Adjusted to select specific columns

        return view('dashboard.pelatihan.tersedia.create', compact('namapelatihans', 'jenispelatihans', 'metodepelatihans', 'pelaksanaanpelatihans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelatihan' => 'required|string|exists:ref_namapelatihans,nama_pelatihan',
            'jenispelatihan_id' => 'required|exists:ref_jenispelatihans,id',
            'metodepelatihan_id' => 'required|exists:ref_metodepelatihans,id',
            'pelaksanaanpelatihan_id' => 'required|exists:ref_pelaksanaanpelatihans,id',
            'penyelenggara_pelatihan' => 'required|string|max:255',
            'tempat_pelatihan' => 'nullable|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tutup_pendaftaran' => 'required|date|before_or_equal:tanggal_mulai',
            'kuota' => 'nullable|integer|min:1',
            'biaya' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string|max:1000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status_pelatihan' => 'required|in:buka,tutup,draft,selesai',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('uploads/pelatihan', 'public');
            $validated['gambar'] = $path; // Simpan path ke array validated
        }

        Pelatihan2Tersedia::create($validated);

        return redirect()->route('dashboard.pelatihan.tersedia')
            ->with([
                'message' => 'Pelatihan berhasil ditambahkan.',
                'title' => 'Success',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pelatihan = Pelatihan2Tersedia::findOrFail($id);

        return view('dashboard.pelatihan.tersedia.detail', compact('pelatihan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pelatihan = Pelatihan2Tersedia::findOrFail($id);
        // Fetch necessary data for the form
        $namapelatihans = ref_namapelatihans::select('id', 'nama_pelatihan')->get(); // Adjusted to select specific columns
        $jenispelatihans = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get(); // Adjusted to select specific columns
        $metodepelatihans = ref_metodepelatihans::select('id', 'metode_pelatihan')->get(); // Adjusted to select specific columns
        $pelaksanaanpelatihans = ref_pelaksanaanpelatihans::select('id', 'pelaksanaan_pelatihan')->get(); // Adjusted to select specific columns

        return view('dashboard.pelatihan.tersedia.edit', compact('pelatihan', 'namapelatihans', 'jenispelatihans', 'metodepelatihans', 'pelaksanaanpelatihans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_pelatihan' => 'required|string|exists:ref_namapelatihans,nama_pelatihan',
            'jenispelatihan_id' => 'required|exists:ref_jenispelatihans,id',
            'metodepelatihan_id' => 'required|exists:ref_metodepelatihans,id',
            'pelaksanaanpelatihan_id' => 'required|exists:ref_pelaksanaanpelatihans,id',
            'penyelenggara_pelatihan' => 'required|string|max:255',
            'tempat_pelatihan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tutup_pendaftaran' => 'required|date',
            'kuota' => 'required|integer|min:1',
            'biaya' => 'required|numeric|min:0',
            'deskripsi' => 'required|string|max:1000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status_pelatihan' => 'required|in:buka,tutup,draft,selesai',
        ]);

        $pelatihan = Pelatihan2Tersedia::findOrFail($id);

        // Handle upload gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada dan file-nya masih tersedia
            if ($pelatihan->gambar && Storage::disk('public')->exists($pelatihan->gambar)) {
                Storage::disk('public')->delete($pelatihan->gambar);
            }

            // Simpan gambar baru
            $path = $request->file('gambar')->store('uploads/pelatihan', 'public');
            $validated['gambar'] = $path;
        }

        $pelatihan->update($validated);

        return redirect()->route('dashboard.pelatihan.tersedia')
            ->with([
                'message' => 'Pelatihan berhasil diperbarui.',
                'title' => 'Success',
            ]);
    }

    /**
     * Update the status of all open trainings to closed if the registration date has passed.
     */
    public function updateStatus()
    {
        // Set timezone khusus untuk Carbon
        $today = Carbon::now('Asia/Jakarta')->startOfDay();

        $count = Pelatihan2Tersedia::where('status_pelatihan', 'buka')
            ->whereDate('tutup_pendaftaran', '<', $today)
            ->update(['status_pelatihan' => 'tutup']);

        if ($count > 0) {
            return redirect()->back()->with([
                'message' => "Berhasil memperbarui status {$count} pelatihan yang sudah tutup pendaftaran.",
                'title' => 'Success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Tidak ada pelatihan yang perlu diperbarui statusnya. Semua pelatihan sudah sesuai.',
                'title' => 'Info',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pelatihan = Pelatihan2Tersedia::findOrFail($id);
        if ($pelatihan->gambar && Storage::disk('public')->exists($pelatihan->gambar)) {
            Storage::disk('public')->delete($pelatihan->gambar);
        }
        $pelatihan->delete();

        return redirect()->route('dashboard.pelatihan.tersedia')
            ->with([
                'message' => 'Pelatihan berhasil dihapus.',
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

        $query = Pelatihan2Tersedia::with(['jenispelatihan', 'metodepelatihan', 'pelaksanaanpelatihan'])
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
        new PelatihanTersediaExport($pelatihans, $columns, $includeHeader),
            'pelatihan_tersedia_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.' . $fileFormat,
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

        $query = Pelatihan2Tersedia::with(['jenispelatihan', 'metodepelatihan', 'pelaksanaanpelatihan'])
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

        $pdf = Pdf::loadView('dashboard.pelatihan.tersedia.pdf', compact('pelatihans', 'pdfSettings'));

        $pdf->setPaper($pdfSettings['paper_size'], 'landscape');
        $pdf->setOption('margin-top', $pdfSettings['margin_top'] . 'in');
        $pdf->setOption('margin-right', $pdfSettings['margin_right'] . 'in');
        $pdf->setOption('margin-bottom', $pdfSettings['margin_bottom'] . 'in');
        $pdf->setOption('margin-left', $pdfSettings['margin_left'] . 'in');

        return $pdf->stream('pelatihan_tersedia_' . now()->timezone('Asia/Jakarta')->format('Ymd_His') . '.pdf');
    }

    public function preview(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');
        $metode = $request->input('metode');
        $pelaksanaan = $request->input('pelaksanaan');
        $start = $request->input('start');
        $end = $request->input('end');

        $query = Pelatihan2Tersedia::with(['jenispelatihan', 'metodepelatihan', 'pelaksanaanpelatihan'])
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
