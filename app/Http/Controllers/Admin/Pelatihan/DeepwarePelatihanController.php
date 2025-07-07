<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan2Tersedia;
use App\Models\Pelatihan2Usulan;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\PelatihanList;
use App\Models\ref_jenispelatihans;
use App\Models\ref_metodepelatihans;
use App\Models\ref_namapelatihan;
use App\Models\ref_pelaksanaanpelatihans;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DeepwarePelatihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all pelatihan data
        $pelatihan = Pelatihan2Usulan::with([
            'user',
        ])->get();

        // Return the view with pelatihan data
        return view('dashboard.pelatihan.daftar-pelatihan', compact('pelatihan'));
    }

    public function dashboard()
    {
        // Hitung statistik
        $countPelatihanTersedia = Pelatihan2Tersedia::count();
        $countUsulanPelatihan = Pelatihan2Usulan::count();
        $countTotalPeserta = Pelatihan3Pendaftaran::count();
        $countPelatihanBerjalan = Pelatihan2Tersedia::where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->count();

        // Hitung persentase perubahan
        $lastMonthPelatihan = Pelatihan2Tersedia::whereMonth('created_at', now()->subMonth()->month)->count();
        $percentagePelatihanTersedia = $lastMonthPelatihan > 0 ?
            round(($countPelatihanTersedia - $lastMonthPelatihan) / $lastMonthPelatihan * 100, 1) : 100;

        $lastMonthUsulan = Pelatihan2Usulan::whereMonth('created_at', now()->subMonth()->month)->count();
        $percentageUsulanPelatihan = $lastMonthUsulan > 0 ?
            round(($countUsulanPelatihan - $lastMonthUsulan) / $lastMonthUsulan * 100, 1) : 100;
        $usulanTrendDirection = $countUsulanPelatihan >= $lastMonthUsulan ? 'up' : 'down';
        $usulanTrendColor = $countUsulanPelatihan >= $lastMonthUsulan ? 'success' : 'danger';

        // Status pendaftaran
        $countPendaftaranTerverifikasi = Pelatihan3Pendaftaran::where('status_verifikasi', 'terverifikasi')->count();
        $countPendaftaranMenunggu = Pelatihan3Pendaftaran::where('status_verifikasi', 'menunggu')->count();
        $countPendaftaranDitolak = Pelatihan3Pendaftaran::where('status_verifikasi', 'ditolak')->count();
        $countTotalPendaftaran = $countPendaftaranTerverifikasi + $countPendaftaranMenunggu + $countPendaftaranDitolak;
        $pendaftaranProgress = $countTotalPendaftaran > 0 ?
            round(($countPendaftaranTerverifikasi / $countTotalPendaftaran) * 100) : 0;

        // Data chart
        $chartData = [
            'months' => [],
            'pelatihan_tersedia' => [],
            'pendaftar' => [],
            'usulan' => []
        ];

        for ($i = 0; $i < 12; $i++) {
            $month = now()->subMonths(11 - $i);
            $chartData['months'][] = $month->format('M');

            $chartData['pelatihan_tersedia'][] = Pelatihan2Tersedia::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $chartData['pendaftar'][] = Pelatihan3Pendaftaran::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $chartData['usulan'][] = Pelatihan2Usulan::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Aktivitas terbaru
        $recentActivities = [
            [
                'icon' => 'mortarboard',
                'color' => 'primary',
                'title' => 'Pelatihan Baru Ditambahkan',
                'time' => '10 menit yang lalu',
                'description' => 'Pelatihan "Manajemen ASN Modern" telah ditambahkan ke sistem'
            ],
            [
                'icon' => 'file-earmark-text',
                'color' => 'success',
                'title' => 'Usulan Pelatihan Baru',
                'time' => '1 jam yang lalu',
                'description' => 'Usulan pelatihan "Kepemimpinan Digital" diajukan oleh Budi Santoso'
            ],
            [
                'icon' => 'check-circle',
                'color' => 'info',
                'title' => 'Pendaftaran Diverifikasi',
                'time' => '2 jam yang lalu',
                'description' => 'Pendaftaran pelatihan "Public Speaking" oleh Ani Wijaya telah diverifikasi'
            ],
            [
                'icon' => 'people',
                'color' => 'warning',
                'title' => 'Pelatihan Dimulai',
                'time' => '1 hari yang lalu',
                'description' => 'Pelatihan "Manajemen Waktu" telah dimulai dengan 25 peserta'
            ]
        ];

        // Pelatihan mendatang
        $upcomingTrainings = Pelatihan2Tersedia::withCount(['pendaftaran as peserta_count' => function ($query) {
            $query->where('status_verifikasi', 'terverifikasi');
        }])
            ->with('jenispelatihan')
            ->where('tanggal_mulai', '>=', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'nama_pelatihan' => $item->nama_pelatihan,
                    'jenis_pelatihan' => $item->jenispelatihan->jenis_pelatihan ?? '-',
                    'peserta_count' => $item->peserta_count,
                    'tanggal_mulai' => Carbon::parse($item->tanggal_mulai)->format('d M Y'),
                    'tempat_pelatihan' => $item->tempat_pelatihan
                ];
            });

        return view('dashboard.pelatihan.dashboard', compact(
            'countPelatihanTersedia',
            'percentagePelatihanTersedia',
            'countUsulanPelatihan',
            'percentageUsulanPelatihan',
            'usulanTrendDirection',
            'usulanTrendColor',
            'countTotalPeserta',
            'countPelatihanBerjalan',
            'countPendaftaranTerverifikasi',
            'countPendaftaranMenunggu',
            'countPendaftaranDitolak',
            'countTotalPendaftaran',
            'pendaftaranProgress',
            'chartData',
            'recentActivities',
            'upcomingTrainings'
        ));
    }

    public function referensi()
    {
        return view('dashboard.pelatihan.reverensi-pelatihan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
        $jenisPelatihan = ref_jenispelatihans::all();
        $pelaksanaanPelatihan = ref_pelaksanaanpelatihans::all();
        $metodePelatihan = ref_metodepelatihans::all();

        // Return the view with jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
        return view('dashboard.pelatihan.create', compact('jenisPelatihan', 'pelaksanaanPelatihan', 'metodePelatihan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi manual
        $validator = Validator::make($request->all(), [
            'nip' => 'required|exists:users,nip',
            'nama_pelatihan' => 'required|string|max:255',
            'jenis_pelatihan_id' => 'required|exists:ref_jenispelatihans,id',
            'pelaksanaan_pelatihan_id' => 'required|exists:ref_pelaksanaanpelatihans,id',
            'metode_pelatihan_id' => 'required|exists:ref_metodepelatihans,id',
            'tempat_pelatihan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'penyelenggara' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'status' => 'required|in:open,closed',
        ]);

        if ($validator->fails()) {
            // Debug: tampilkan semua pesan error validasi
            dd($validator->errors()->all());
        }

        // Jika lolos validasi, ambil data terverifikasi
        $validatedData = $validator->validated();

        // Lanjutkan proses upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $namaGambar = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
            $gambarPath = $gambar->storeAs('uploads/pelatihan', $namaGambar, 'public');
            $validatedData['gambar'] = $gambarPath;
        }

        // Simpan ke database
        PelatihanList::create($validatedData);

        return redirect()->route('dashboard.pelatihan.index')
            ->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the pelatihan data by ID
        $pelatihan = PelatihanList::findOrFail($id);

        // Return the view with pelatihan data
        return view('admin.pelatihan.show', compact('pelatihan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the pelatihan data by ID
        $pelatihan = PelatihanList::findOrFail($id);

        // Fetch all jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
        $jenisPelatihan = ref_jenispelatihans::all();
        $pelaksanaanPelatihan = ref_pelaksanaanpelatihans::all();
        $metodePelatihan = ref_metodepelatihans::all();

        // Return the view with pelatihan data and other related data
        return view('dashboard.pelatihan.edit', compact('pelatihan', 'jenisPelatihan', 'pelaksanaanPelatihan', 'metodePelatihan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->all());

        // Validate the request data
        $request->validate([
            //'nip' => 'required|exists:users,nip',
            'nama_pelatihan' => 'required|string|max:255',
            'jenis_pelatihan_id' => 'required|exists:ref_jenispelatihans,id',
            'pelaksanaan_pelatihan_id' => 'required|exists:ref_pelaksanaanpelatihans,id',
            'metode_pelatihan_id' => 'required|exists:ref_metodepelatihans,id',
            'tempat_pelatihan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'penyelenggara' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            // 'nip' => 'required|exists:ref_pegawais,nip',
            // 'nama_pelatihan' => 'required|string|max:255',
            // 'jenis_pelatihan_id' => 'required|exists:ref_jenispelatihans,id',
            // 'pelaksanaan_pelatihan_id' => 'required|exists:ref_pelaksanaanpelatihans,id',
            // 'metode_pelatihan_id' => 'required|exists:ref_metodepelatihans,id',
            // 'tempat_pelatihan' => 'required|string|max:255',
            // 'tanggal_mulai' => 'required|date',
            // 'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            // 'penyelenggara' => 'required|string|max:255',
            // 'deskripsi' => 'nullable|string',
            // 'link_pelatihan' => 'nullable|url',
            // 'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Temukan pelatihan berdasarkan ID
        $pelatihan = PelatihanList::findOrFail($id);

        // Update data pelatihan
        $pelatihan->update($request->except('gambar')); // Update semua kecuali gambar

        // Jika ada file gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($pelatihan->image && file_exists(public_path($pelatihan->image))) {
                unlink(public_path($pelatihan->image)); // Menghapus gambar lama
            }

            // Simpan gambar baru
            $imagePath = $request->file('gambar')->store('pelatihan-images', 'public');
            $pelatihan->image = 'storage/' . $imagePath;
        }

        // Simpan perubahan
        $pelatihan->save();

        // Redirect to the pelatihan index with success message
        return redirect()->route('dashboard.pelatihan.index')->with('success', 'Pelatihan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the pelatihan record by ID
        $pelatihan = PelatihanList::findOrFail($id);
        $namaPelatihan = $pelatihan->nama_pelatihan; // sesuaikan field nama pelatihan

        // Delete the pelatihan record
        $pelatihan->delete();

        // Redirect to the pelatihan index with success message
        return redirect()->route('dashboard.pelatihan.index')->with('success', "Pelatihan \"$namaPelatihan\" berhasil dihapus.");
    }

    /**
     * Search for pelatihan by ID.
     */
    public function searchById(Request $request)
    {
        // Validate the search request
        $request->validate([
            'id' => 'required|exists:pelatihan_1_lists,id',
        ]);

        // Fetch pelatihan data by ID
        $pelatihan = PelatihanList::findOrFail($request->id);

        // Return the view with pelatihan data
        return view('dashboard.pelatihan.daftar-pelatihan', compact('pelatihan'));
    }

    /**
     * Search for pelatihan by NIP.
     */
    public function search(Request $request)
    {
        // Validate the search request
        $request->validate([
            'nip' => 'required|exists:ref_pegawais,nip',
        ]);

        // Fetch pelatihan data by NIP
        $pelatihan = PelatihanList::where('nip', $request->nip)->get();

        // Return the view with pelatihan data
        return view('dashboard.pelatihan.daftar-pelatihan', compact('pelatihan'));
    }

    /**
     * Search for pelatihan by name.
     */
    public function searchByName(Request $request)
    {
        // Validate the search request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Fetch pelatihan data by name
        $pelatihan = PelatihanList::where('nama_pelatihan', 'like', '%' . $request->name . '%')->get();

        // Return the view with pelatihan data
        return view('dashboard.pelatihan.daftar-pelatihan', compact('pelatihan'));
    }

    /**
     * Search for pelatihan by date.
     */
    public function searchByDate(Request $request)
    {
        // Validate the search request
        $request->validate([
            'date' => 'required|date',
        ]);

        // Fetch pelatihan data by date
        $pelatihan = PelatihanList::whereDate('tanggal_mulai', $request->date)->get();

        // Return the view with pelatihan data
        return view('dashboard.pelatihan.daftar-pelatihan', compact('pelatihan'));
    }
}
