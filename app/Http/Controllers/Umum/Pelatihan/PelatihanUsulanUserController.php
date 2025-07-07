<?php

namespace App\Http\Controllers\Umum\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan2Usulan;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\ref_jenispelatihans;
use App\Models\ref_metodepelatihans;
use App\Models\ref_namapelatihans;
use App\Models\ref_pelaksanaanpelatihans;
use App\Models\ref_unitkerjas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PelatihanUsulanUserController extends Controller
{
    
    public function indexUsulan(Request $request)
    {
        $userNip = Auth::user()->nip;
        
        // Filter parameters
        $search = $request->input('search');
        $status = $request->input('status');
        $periode = $request->input('periode');
        $start_date = $request->input('start');
        $end_date = $request->input('end');
        
        // Base query
        $query = Pelatihan3Pendaftaran::with(['user', 'usulan.jenispelatihan', 'usulan.metodepelatihan', 'usulan.pelaksanaanpelatihan'])
            ->where('user_nip', $userNip)
            ->whereHas('usulan')
            ->latest();

        // Apply filters
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('usulan', function($q) use ($search) {
                    $q->where('nama_pelatihan', 'like', "%{$search}%");
                });
            });
        }

        if ($status) {
            $query->where('status_verifikasi', $status);
        }

        if ($periode === 'current') {
            $query->whereYear('created_at', date('Y'));
        } elseif ($periode === 'next') {
            $query->whereYear('created_at', date('Y') + 1);
        }

        if ($start_date && $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        // Paginate results
        $pendaftarans = $query->paginate(10)->appends(request()->query());

        if ($request->ajax()) {
            return view('pelatihan.usulan.index', compact('pendaftarans'))->render();
        }

        return view('pelatihan.usulan.index', compact('pendaftarans'));
    }


    public function createUsulan()
        {
            // Fetch all jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
            $pegawai = User::select('nip')->get();
            $namaPelatihan = ref_namapelatihans::select('nama_pelatihan')->where('status', 'diterima')->get();
            $jenisPelatihan = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get();
            $pelaksanaanPelatihan = ref_pelaksanaanpelatihans::select('id', 'pelaksanaan_pelatihan')->get();
            $metodePelatihan = ref_metodepelatihans::select('id', 'metode_pelatihan')->get();

            // Return the view with jenis pelatihan, pelaksanaan pelatihan, and metode pelatihan data
            return view('pelatihan.usulan.create', compact('pegawai', 'namaPelatihan', 'jenisPelatihan', 'pelaksanaanPelatihan', 'metodePelatihan'));
        }

    public function storeUsulan(Request $request)
    {
        //dd(Auth::user());
        $user = Auth::user()-> nip;

        // Validasi request
        $request->validate([
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

        // Cek apakah usulan pelatihan yang sama oleh nip_pengusul sudah pernah ada
        $isDuplicate = Pelatihan2Usulan::where('nip_pengusul', $user)
            ->where('nama_pelatihan', $request->nama_pelatihan)
            ->where('tanggal_mulai', $request->tanggal_mulai)
            ->where('tanggal_selesai', $request->tanggal_selesai)
            ->exists();

        if ($isDuplicate) {
            return redirect()->back()->withInput()->with('error', 'Usulan pelatihan dengan nama dan tanggal yang sama sudah pernah diajukan.');
        }

        // Ambil data selain nip_pengusul
        $data = $request->except('nip_pengusul');
        $data['nip_pengusul'] = $user;

        // Upload file
        if ($request->hasFile('file_penawaran')) {
            $data['file_penawaran'] = $request->file('file_penawaran')->store('uploads/penawaran', 'public');
        }

        // Simpan ke tabel pelatihan_2_usulans
        $usulan = Pelatihan2Usulan::create($data);

        // Buat kode pendaftaran
        $kode = 'USP' . $usulan->id . now()->format('YmdHis');

        // Simpan ke tabel pelatihan_3_pendaftarans
        Pelatihan3Pendaftaran::create([
            'kode_pendaftaran' => $kode,
            'user_nip' => $user,
            'tersedia_id' => null,
            'usulan_id' => $usulan->id,
            'keterangan' => null,
            'tanggal_pendaftaran' => now(),
            'status_verifikasi' => 'tersimpan',
            'status_peserta' => 'calon_peserta',
        ]);

        return redirect()->back()->with('success', 'Selamat! Usulan pelatihan Anda berhasil dikirim.');

        //return view('pelatihan.usulan.indexUsulan')-> with('success', 'Usulan pelatihan berhasil dikirim.');
    }


    public function editUsulan($idPendaftaran)
    {
        // 1. Cari data pendaftaran beserta relasi usulan
        $pendaftaran = Pelatihan3Pendaftaran::with([
            'usulan.jenispelatihan',
            'usulan.metodepelatihan',
            'usulan.pelaksanaanpelatihan'
        ])->findOrFail($idPendaftaran);

        \Log::info('Mencoba edit usulan via pendaftaran ID: '.$idPendaftaran);
        
        // 2. Ambil data usulan dari relasi
        $usulan = $pendaftaran->usulan;
        
        if (!$usulan) {
            \Log::error('Usulan tidak ditemukan untuk pendaftaran ID: '.$idPendaftaran);
            abort(404, 'Data usulan tidak ditemukan');
        }

        // 3. Validasi kepemilikan dan status
        if ($usulan->nip_pengusul !== auth()->user()->nip) {
            abort(403, 'Anda tidak memiliki akses ke usulan ini');
        }

        if ($pendaftaran->status_verifikasi !== 'tersimpan') {
            abort(403, 'Hanya usulan dengan status tersimpan yang dapat diedit');
        }

        // 4. Data referensi untuk form
        $namaPelatihan = ref_namapelatihans::where('status', 'diterima')->get();
        $jenisPelatihan = ref_jenispelatihans::all();
        $pelaksanaanPelatihan = ref_pelaksanaanpelatihans::all();
        $metodePelatihan = ref_metodepelatihans::all();

        return view('pelatihan.usulan.edit', compact(
            'usulan',
            'pendaftaran', // kirim juga data pendaftaran ke view jika diperlukan
            'namaPelatihan',
            'jenisPelatihan',
            'pelaksanaanPelatihan',
            'metodePelatihan'
        ));
    }

    public function updateUsulan(Request $request, $id)
    {
        $user = Auth::user()->nip;
        $usulan = Pelatihan2Usulan::with('pendaftaran')->findOrFail($id);

        // Validasi kepemilikan dan status
        if ($usulan->nip_pengusul !== $user) {
            abort(403, 'Anda tidak memiliki akses ke usulan ini');
        }

        if ($usulan->pendaftaran->status_verifikasi !== 'tersimpan') {
            abort(403, 'Hanya usulan dengan status tersimpan yang dapat diedit');
        }

        // Validasi request (sesuai dengan store)
        $request->validate([
            'nama_pelatihan' => 'required|exists:ref_namapelatihans,nama_pelatihan',
            'jenispelatihan_id' => 'required|exists:ref_jenispelatihans,id',
            'metodepelatihan_id' => 'required|exists:ref_metodepelatihans,id',
            'pelaksanaanpelatihan_id' => 'required|exists:ref_pelaksanaanpelatihans,id',
            'penyelenggara_pelatihan' => 'required|string|max:255',
            'tempat_pelatihan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'estimasi_biaya' => 'required|numeric',
            'file_penawaran' => 'nullable|file|mimes:pdf|max:8192', // nullable untuk update
            'keterangan' => 'required|string|max:255',
        ]);

        // Cek duplikasi (kecuali data saat ini)
        $isDuplicate = Pelatihan2Usulan::where('nip_pengusul', $user)
            ->where('nama_pelatihan', $request->nama_pelatihan)
            ->where('tanggal_mulai', $request->tanggal_mulai)
            ->where('tanggal_selesai', $request->tanggal_selesai)
            ->where('id', '!=', $id)
            ->exists();

        if ($isDuplicate) {
            return redirect()->back()->withInput()->with('error', 'Usulan pelatihan dengan nama dan tanggal yang sama sudah pernah diajukan.');
        }

        // Persiapkan data update
        $data = $request->except(['_token', '_method', 'file_penawaran']);

        // Handle file upload
        if ($request->hasFile('file_penawaran')) {
            // Hapus file lama jika ada
            if ($usulan->file_penawaran) {
                Storage::disk('public')->delete($usulan->file_penawaran);
            }
            $data['file_penawaran'] = $request->file('file_penawaran')->store('uploads/penawaran', 'public');
        }

        // Update data usulan
        $usulan->update($data);

        // Update kode pendaftaran jika nama/tanggal berubah di tabel pelat3dftr
        if ($usulan->wasChanged(['nama_pelatihan', 'tanggal_mulai', 'tanggal_selesai'])) {
            $usulan->pendaftaran->update([
                'kode_pendaftaran' => 'USP' . $usulan->id . now()->format('YmdHis')
            ]);
        }

        return redirect()->route('pelatihan.usulan.create')
            ->with('success', 'Usulan pelatihan berhasil diperbarui.');
    }

    /**
     * Tampilkan detail dari usulan pelatihan tertentu.
     */
    public function show($id)
    {
        $pendaftaran = Pelatihan3Pendaftaran::findOrFail($id);
        return view('pelatihan.usulan.detail', compact('pendaftaran'));
    }


    // hapus usulan pelatihan
    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $pendaftaran = Pelatihan3Pendaftaran::findOrFail($id);

        // Hapus
        $pendaftaran->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('pelatihan.usulan.index')
            ->with('success', 'Data pendaftaran berhasil dihapus.');
    }



    //Usulan Nomenklatur
   public function index(Request $request)
    {
        $user = Auth::user()->nip;
        
        $search = $request->input('search');
        $jenisId = $request->input('jenis');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $jenispelatihans = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get();

        $query = ref_namapelatihans::with(['jenispelatihan:id,jenis_pelatihan'])
            ->where('nip', $user)
            ->orderByDesc('created_at');

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_pelatihan', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%")
                ->orWhereHas('jenispelatihan', function($q) use ($search) {
                    $q->where('jenis_pelatihan', 'like', "%{$search}%");
                });
            });
        }

        // Apply jenis filter
        if ($jenisId) {
            $query->where('jenispelatihan_id', $jenisId);
        }

        // Apply status filter
        if ($status) {
            $query->where('status', $status);
        }


        $namapelatihans = $query->paginate(25)->withQueryString();

        if ($request->ajax()) {
            return view('pelatihan.nomenklatur.index', compact('namapelatihans'))->render();
        }

        return view('pelatihan.nomenklatur.index', compact('namapelatihans', 'jenispelatihans'));
    }
    public function create()
    {
        // Fetch all jenis pelatihan data
            $jenisPelatihan = ref_jenispelatihans::select('id', 'jenis_pelatihan')->get();
           
        // Return the view with jenis pelatihan
        return view('pelatihan.nomenklatur.create', compact('jenisPelatihan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|exists:users,nip',
            'nama_pelatihan' => 'required|string|max:255|unique:ref_namapelatihans,nama_pelatihan',
            'jenispelatihan_id' => 'required|exists:ref_jenispelatihans,id',
            'status' => 'in:proses,',
        ]);

        // Tambahan pengecekan jika user ini sudah pernah usulkan nama yang sama
        $exists = ref_namapelatihans::where('nip', auth()->user()->nip)
            ->where('nama_pelatihan', $request->nama_pelatihan)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['nama_pelatihan' => 'Anda sudah pernah mengusulkan nama pelatihan ini.'])
                ->withInput();
        }

        ref_namapelatihans::create([
            'nip' => auth()->user()->nip,
            'kode_namapelatihan' => null,
            'nama_pelatihan' => $request->nama_pelatihan,
            'jenispelatihan_id' => $request->jenispelatihan_id,
            'keterangan' => null,
            'status' => 'proses',
        ]);

        return redirect()->route('pelatihan.nomenklatur')->with('success', 'Usulan Nomenklatur berhasil dikirim.');
    }
        // public function index()
    // {
    //     $nip = auth()->user()->nip;
    //     $namapelatihans = ref_namapelatihan::where('nip', $nip)
    //         ->orderBy('created_at', 'desc') // urut dari terbaru
    //         ->get();

    //     return view('Pelatihan.Nomenklatur.index', compact('namapelatihans'));
    // }

}
