<?php

namespace App\Http\Controllers\Umum\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan2Tersedia;
use App\Models\Pelatihan2Usulan;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\ref_namapelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ref_unitkerjas;


class PelatihanPendaftaranUserController extends Controller
{
    /**
     * Tampilkan daftar pendaftaran pelatihan milik user yang sedang login.
     */

     public function index(Request $request)
    {
        $search = $request->get('search');
        $start = $request->get('start_date');
        $end = $request->get('end_date');
        $pelatihan = $request->get('pelatihan');
        $kategori = $request->get('kategori');
        $verifikasi = $request->get('verifikasi');
        $peserta = $request->get('peserta');
        $userNip = Auth::user()->nip;

        // Get filter options
        $pelatihanList = Pelatihan2Tersedia::select('id', 'nama_pelatihan')
            ->union(
                Pelatihan2Usulan::select('id', 'nama_pelatihan')
                    ->where('nip_pengusul', $userNip)
            )
            ->orderBy('nama_pelatihan')
            ->get();

        // $kategoriList = ref_kategoripelatihans::select('id', 'nama_kategori')
        //     ->orderBy('nama_kategori')
        //     ->get();

        $pendaftarans = Pelatihan3Pendaftaran::with(['user', 'tersedia', 'usulan'])
            ->where('user_nip', $userNip)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('user_nip', 'like', "%$search%")
                        ->orWhereHas('tersedia', fn($q2) => $q2->where('nama_pelatihan', 'like', "%$search%"))
                        ->orWhereHas('usulan', fn($q3) => $q3->where('nama_pelatihan', 'like', "%$search%"));
                });
            })
            ->when($pelatihan, function ($query) use ($pelatihan) {
                $query->where(function($q) use ($pelatihan) {
                    $q->whereHas('tersedia', fn($q2) => $q2->where('id', $pelatihan))
                        ->orWhereHas('usulan', fn($q3) => $q3->where('id', $pelatihan));
                });
            })
            ->when($kategori, function ($query) use ($kategori) {
                $query->whereHas('tersedia', fn($q) => $q->where('kategoripelatihan_id', $kategori));
            })
            ->when($verifikasi, fn($q) => $q->where('status_verifikasi', $verifikasi))
            ->when($peserta, fn($q) => $q->where('status_peserta', $peserta))
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_pendaftaran', [$start, $end]))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        if ($request->ajax()) {
            return view('pelatihan.pendaftaran.hasil-registrasi', compact('pendaftarans', 'pelatihanList'))->render();
        }

        return view('pelatihan.pendaftaran.hasil-registrasi', compact('pendaftarans', 'pelatihanList'));
    }

    public function store(Request $request)
    {
        //dd(Auth::user());
        $user = Auth::user()->nip;
        $pelatihanId = $request->pelatihan_id;

        $pelatihan = Pelatihan2Tersedia::findOrFail($pelatihanId);

        // Cek apakah user sudah daftar
        $sudahDaftar = Pelatihan3Pendaftaran::where('user_nip', $user)
            ->where('tersedia_id', $pelatihan->id)
            ->exists();

        if ($sudahDaftar) {
            return back()->with('error', 'Anda sudah mendaftar pelatihan ini.');
        }

        // Format kode: TSP(idTersedia)(YmdHis)
        $kode = 'TSP' . $pelatihan->id . now()->format('YmdHis');

        Pelatihan3Pendaftaran::create([
            'kode_pendaftaran' => $kode,
            'user_nip' => $user,
            'tersedia_id' => $pelatihan->id,
            'usulan_id' => null,
            'keterangan' => null,
            'tanggal_pendaftaran' => now(),
            'status_verifikasi' => 'tersimpan',
            'status_peserta' => 'calon_peserta',
        ]);

        return back()
            ->with('success', 'Pendaftaran berhasil.');
    }

    /**
     * Tampilkan detail registrasi milik user.
     */
    public function show($id)
    {
        $pendaftaran = Pelatihan3Pendaftaran::findOrFail($id);
        return view('pelatihan.pendaftaran.detail', compact('pendaftaran'));
    }

    // public function show(Pelatihan3Pendaftaran $registrasi)
    // {
    //     // Pastikan user hanya bisa melihat datanya sendiri
    //     if ($registrasi->nip != Auth::user()->nip) {
    //         abort(403);
    //     }

    //     return view('pelatihan.pendaftaran.detail', compact('registrasi'));
    // }
}
