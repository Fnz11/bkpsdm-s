<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AkpkPertanyaanDiri;
use App\Models\AkpkPertanyaanEssayDiri;
use App\Models\UserPivot;
use App\Models\AkpkKategori;
use App\Models\AkpkEvaluasiDiri; // Model evaluasi_diri
use App\Models\AkpkJawaban;
use App\Models\AkpkTahunEvaluasi;
use App\Models\AkpkEvaluasiEssayDiri;
use Carbon\Carbon;

class AkpkPertanyaanDiriController extends Controller
{
    public function index()
    {
        $today = Carbon::now();

        // Ambil tahun evaluasi terbaru
        $tahunEvaluasi = AkpkTahunEvaluasi::latest()->first();

        // Cek apakah tanggal sekarang dalam rentang buka dan tutup
        if (
            !$tahunEvaluasi ||
            $today->lt($tahunEvaluasi->tanggal_buka) ||
            $today->gt($tahunEvaluasi->tanggal_tutup)
        ) {
            return view('MenuUmum.Akpk.Assessment.alert', [
                'message' => 'Penilaian belum masuk jadwal pengerjaan.'
            ]);
        }

        $nip = Auth::user()->nip;

        // Cek apakah user sudah mengisi evaluasi untuk tahun evaluasi ini
        $sudahIsi = AkpkEvaluasiDiri::where('nip', $nip)
            ->where('id_tahun_evaluasi', $tahunEvaluasi->id)
            ->exists();

        if ($sudahIsi) {
            return view('MenuUmum.Akpk.Assessment.alert', [
                'message' => 'Anda sudah pernah mengisi evaluasi untuk tahun ini.'
            ]);
        }

        // Ambil data pivot user
        $pivot = UserPivot::where('nip', $nip)->latest()->first();

        if (!$pivot) {
            return view('MenuUmum.Akpk.Assessment.selfAssessment')->with('pertanyaan', []);
        }

        $id_jabatan = $pivot->id_jabatan;

        // Ambil semua pertanyaan beserta kategori
        $pertanyaan = AkpkPertanyaanDiri::with('kategori')
            ->where('id_jabatan', $id_jabatan)
            ->where('status', 'aktif')
            ->get();

        $pertanyaanEssay = AkpkPertanyaanEssayDiri::where('status', 'aktif')->get();

        $userInfo = [
            'nama' => Auth::user()->name,
            'nip' => Auth::user()->nip,
            'jabatan' => $pivot->jabatan->jabatan ?? '-',
            'unit_kerja' => $pivot->unitkerja->unit_kerja ?? '-',
        ];

        return view('MenuUmum.Akpk.Assessment.selfAssessment', compact('pertanyaan', 'pertanyaanEssay', 'userInfo'));
    }

    public function store(Request $request)
    {
        $nip = Auth::user()->nip;
        $tanggal = now();
        $id_tahun = AkpkTahunEvaluasi::latest()->first()->id ?? 1;

        // Simpan nilai pilihan
        $pertanyaan = AkpkPertanyaanDiri::all();
        foreach ($pertanyaan as $item) {
            $nilai = $request->input('nilai_' . $item->id);

            if ($nilai) {
                AkpkEvaluasiDiri::create([
                    'nip' => $nip,
                    'id_jawaban' => $nilai, // langsung pakai angka 1–5
                    'id_pertanyaan' => $item->id,
                    'id_tahun_evaluasi' => $id_tahun,
                    'tanggal_pengisian' => $tanggal
                ]);
            }
        }

        // Simpan essay
        foreach ($request->input('jawaban_essay', []) as $id_pertanyaan_essay => $jawaban) {
            if ($jawaban) {
                AkpkEvaluasiEssayDiri::create([
                    'nip' => $nip,
                    'jawaban' => $jawaban,
                    'id_tahun_evaluasi' => $id_tahun,
                    'id_pertanyaan_essay_diri' => $id_pertanyaan_essay,
                ]);
            }
        }

        return redirect('MenuUmum.Akpk.Assessment.selfAssessment')->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
