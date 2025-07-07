<?php

namespace App\Http\Controllers\Umum\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan2Tersedia;
use App\Models\ref_jenispelatihans;
use App\Models\ref_metodepelatihans;
use App\Models\ref_namapelatihan;
use App\Models\ref_pelaksanaanpelatihans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelatihanTersediaUserController extends Controller
{

    // public function index()
    // {
    //     $pelatihan = Pelatihan2Tersedia::where('status_pelatihan', 'buka')->latest()->get();

    //     return view('pelatihan.tersedia.daftar-pelatihan', compact('pelatihan'));
    // }

    public function index(Request $request)
    {
        $query = Pelatihan2Tersedia::query()->with(['jenispelatihan', 'metodepelatihan', 'pelaksanaanpelatihan']);

        // // Default filter hanya yang statusnya buka
        // $query->where('status_pelatihan', 'buka');

        // Filter status (buka atau tutup) - override default jika diminta
        if ($request->filled('status')) {
            $query->where('status_pelatihan', $request->status);
        }

        // Filter jenis pelatihan
        if ($request->filled('jenis')) {
            $query->where('jenispelatihan_id', $request->jenis);
        }

        // Filter metode pelatihan
        if ($request->filled('metode')) {
            $query->where('metodepelatihan_id', $request->metode);
        }

        // Filter nama/kategori/tempat (search)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_pelatihan', 'like', '%' . $request->search . '%')
                ->orWhere('penyelenggara_pelatihan', 'like', '%' . $request->search . '%')
                ->orWhere('tempat_pelatihan', 'like', '%' . $request->search . '%')
                ->orWhereHas('jenispelatihan', function($q) use ($request) {
                    $q->where('jenis_pelatihan', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('metodepelatihan', function($q) use ($request) {
                    $q->where('metode_pelatihan', 'like', '%' . $request->search . '%');
                });
            });
        }

        // Filter berdasarkan tanggal mulai
        if ($request->filled('start')) {
            $query->whereDate('tanggal_mulai', '>=', $request->start);
        }
        if ($request->filled('end')) {
            $query->whereDate('tanggal_selesai', '<=', $request->end);
        }

        // Pagination dengan query yang sudah difilter
        $pelatihan = $query->latest()->paginate(9)->appends(request()->all());
        
        $jenisPelatihan = ref_jenispelatihans::all();
        $metodePelatihan = ref_metodepelatihans::all();
        $pelaksanaanPelatihan = ref_pelaksanaanpelatihans::all();

        return view('pelatihan.tersedia.index', compact('pelatihan', 'jenisPelatihan', 'metodePelatihan', 'pelaksanaanPelatihan'));
    }

        public function show($id)
    {
        $pelatihan = Pelatihan2Tersedia::findOrFail($id);

        return view('pelatihan.tersedia.detail', compact('pelatihan'));
    }
}

    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $search = $request->input('search');
    //     $jenisId = $request->input('jenis');
    //     $metodeId = $request->input('metode');
    //     $pelaksanaanId = $request->input('pelaksanaan');
    //     $start = $request->input('start_date');
    //     $end = $request->input('end_date');

    //     $jenispelatihans = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get();
    //     $metodes = ref_metodepelatihans::select('id', 'metode_pelatihan')->get();
    //     $pelaksanaans = ref_pelaksanaanpelatihans::select('id', 'pelaksanaan_pelatihan')->get();

    //     $pelatihans = Pelatihan2Tersedia::when($search, function ($query, $search) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('nama_pelatihan', 'like', "%{$search}%")
    //                 ->orWhere('penyelenggara_pelatihan', 'like', "%{$search}%")
    //                 ->orWhere('tempat_pelatihan', 'like', "%{$search}%")
    //                 ->orWhere('kuota', 'like', "%{$search}%")
    //                 ->orWhere('biaya', 'like', "%{$search}%")
    //                 ->orWhere('status_pelatihan', 'like', "%{$search}%")
    //                 ->orWhereHas('jenispelatihan', fn($q2) => $q2->where('jenis_pelatihan', 'like', "%{$search}%"))
    //                 ->orWhereHas('metodepelatihan', fn($q2) => $q2->where('metode_pelatihan', 'like', "%{$search}%"))
    //                 ->orWhereHas('pelaksanaanpelatihan', fn($q2) => $q2->where('pelaksanaan_pelatihan', 'like', "%{$search}%"));
    //         });
    //     })
    //         ->when($jenisId, fn($q) => $q->where('jenispelatihan_id', $jenisId))
    //         ->when($metodeId, fn($q) => $q->where('metodepelatihan_id', $metodeId))
    //         ->when($pelaksanaanId, fn($q) => $q->where('pelaksanaanpelatihan_id', $pelaksanaanId))
    //         ->when($start && $end, fn($q) => $q->whereBetween('tanggal_mulai', [$start, $end]))
    //         ->orderByDesc('created_at')
    //         ->paginate(25)
    //         ->withQueryString();

    //     if ($request->ajax()) {
    //         return view('dashboard.pelatihan.tersedia.index', compact('pelatihans', 'jenispelatihans', 'metodes', 'pelaksanaans'))->render();
    //     }

    //     return view('dashboard.pelatihan.tersedia.index', compact('pelatihans', 'jenispelatihans', 'metodes', 'pelaksanaans'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'nama_pelatihan' => 'required|string|exists:ref_namapelatihans,nama_pelatihan',
//             'jenispelatihan_id' => 'required|exists:ref_jenispelatihans,id',
//             'metodepelatihan_id' => 'required|exists:ref_metodepelatihans,id',
//             'pelaksanaanpelatihan_id' => 'required|exists:ref_pelaksanaanpelatihans,id',
//             'penyelenggara_pelatihan' => 'required|string|max:255',
//             'tempat_pelatihan' => 'nullable|string|max:255',
//             'tanggal_mulai' => 'required|date',
//             'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
//             'tutup_pendaftaran' => 'required|date|before_or_equal:tanggal_mulai',
//             'kuota' => 'nullable|integer|min:1',
//             'biaya' => 'nullable|numeric|min:0',
//             'deskripsi' => 'nullable|string|max:1000',
//             'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
//             'status_pelatihan' => 'required|in:buka,tutup,draft,selesai',
//         ]);

//         // Upload gambar jika ada
//         if ($request->hasFile('gambar')) {
//             $path = $request->file('gambar')->store('uploads/pelatihan', 'public');
//             $validated['gambar'] = $path; // Simpan path ke array validated
//         }

//         Pelatihan2Tersedia::create($validated);

//         return redirect()->route('pelatihan.tersedia.daftar-pelatihan')
//             ->with('success', 'Pelatihan berhasil ditambahkan.');
//     }

