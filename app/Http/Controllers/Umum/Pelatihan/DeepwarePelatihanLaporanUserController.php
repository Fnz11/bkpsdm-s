<?php

namespace App\Http\Controllers\Umum\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\PelatihanLaporan;
use App\Models\PelatihanRegistrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeepwarePelatihanLaporanUserController extends Controller
{
    /**
     * Tampilkan semua laporan milik user yang login
     */
    public function index()
    {
        $nip = Auth::user()->nip;

        $laporan = PelatihanLaporan::with('registrasi.pelatihan')
                    ->whereHas('registrasi', function ($query) use ($nip) {
                        $query->where('nip', $nip);
                    })
                    ->get();

        return view('user.pelatihan.laporan.index', compact('laporan'));
    }

    /**
     * Tampilkan form pembuatan laporan
     */
    public function create($id_registrasi)
    {
        $registrasi = PelatihanRegistrasi::where('id', $id_registrasi)
                        ->where('nip', Auth::user()->nip)
                        ->firstOrFail();

        return view('user.pelatihan.laporan.create', compact('registrasi'));
    }

    /**
     * Simpan laporan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_registrasi' => 'required|exists:pelatihan_registrasis,id',
            'judul_laporan' => 'required|string|max:255',
            'latar_belakang' => 'required|string',
            'laporan_pelatihan' => 'required|file|mimes:pdf|max:2048',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'total_biaya' => 'nullable|numeric',
        ]);

        // Upload file
        $laporanPath = $request->file('laporan_pelatihan')->store('laporan_pelatihan');
        $sertifikatPath = $request->file('sertifikat')?->store('sertifikat');

        PelatihanLaporan::create([
            'id_registrasi' => $request->id_registrasi,
            'judul_laporan' => $request->judul_laporan,
            'latar_belakang' => $request->latar_belakang,
            'laporan_pelatihan' => $laporanPath,
            'sertifikat' => $sertifikatPath,
            'total_biaya' => $request->total_biaya,
            'status' => 'diajukan',
        ]);

        return redirect()->route('user.laporan.index')->with('success', 'Laporan berhasil dikirim.');
    }

    /**
     * Tampilkan detail laporan
     */
    public function show(PelatihanLaporan $laporan)
    {
        if ($laporan->registrasi->nip !== Auth::user()->nip) {
            abort(403);
        }

        return view('user.pelatihan.laporan.show', compact('laporan'));
    }
}
