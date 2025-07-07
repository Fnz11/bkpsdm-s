<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AkpkPertanyaanAtasan;
use App\Models\AkpkPertanyaanEssayAtasan;
use App\Models\UserPivot;
use App\Models\AkpkKategori;
use App\Models\AkpkEvaluasiAtasan; // Model evaluasi_Atasan
use App\Models\AkpkJawaban;
use App\Models\AkpkTahunEvaluasi;
use App\Models\AkpkEvaluasiEssayAtasan;
use App\Models\User;
use App\Models\RefPegawai;
use App\Models\RefJabatan;
use App\Models\RefUnitKerja;
use Carbon\Carbon;

class AkpkPertanyaanAtasanController extends Controller
{

    
    public function index(Request $request)
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
            return back()->with('error', 'Penilaian hanya tersedia pada periode yang ditentukan.');
        }
    
        $nipLogin = Auth::user()->nip;
    
        // Data atasan (yang login)
        $atasan = User::with(['userPivot.jabatan', 'userPivot.unitKerja'])
            ->where('nip', $nipLogin)->first();
    
        // Ambil semua NIP bawahan
        $allBawahanNip = RefPegawai::where('nip_atasan', $nipLogin)->pluck('nip');
    
        // Ambil daftar NIP bawahan yang SUDAH dinilai
        $bawahanSudahDinilai = AkpkEvaluasiAtasan::where('nip_atasan', $nipLogin)
            ->where('id_tahun_evaluasi', $tahunEvaluasi->id)
            ->pluck('nip_bawahan');
    
        // Filter hanya bawahan yang BELUM dinilai
        $bawahanBelumDinilai = $allBawahanNip->diff($bawahanSudahDinilai);
    
        // Jika tidak ada bawahan yang tersisa
        if ($bawahanBelumDinilai->isEmpty()) {
            return redirect('/homepage-akpk')->with('error', 'Semua bawahan sudah dinilai.');
        }
    
        // Ambil data user untuk bawahan yang belum dinilai
        $bawahanList = User::whereIn('nip', $bawahanBelumDinilai)->get();
    
        // Ambil NIP bawahan dari request (misalnya dari dropdown atau query param)
        $nipBawahan = $request->input('nip_bawahan');
    
        $idJabatan = null;
        $pertanyaan = [];
        $pertanyaanEssay = [];
    
        if ($nipBawahan) {
            $bawahan = User::with('userPivot.jabatan')->where('nip', $nipBawahan)->first();
            $idJabatan = $bawahan->userPivot->id_jabatan ?? null;
    
            // Ambil pertanyaan untuk jabatan tersebut
            $pertanyaan = AkpkPertanyaanAtasan::with('kategori')
                ->where('id_jabatan', $idJabatan)
                ->where('status', 'aktif')
                ->get();
    
            $pertanyaanEssay = AkpkPertanyaanEssayAtasan::where('status', 'aktif')->get();
        }
    
        return view('MenuUmum.Akpk.Assessment.assessmentBawahan', compact(
            'atasan',
            'bawahanList',
            'pertanyaan',
            'pertanyaanEssay'
        ));
    }
    

    public function store(Request $request)
    {
        {
            $user = Auth::user();
    
            $nip_atasan = $user->nip;
            $nip_bawahan = $request->input('nip_bawahan'); // pastikan form mengirimkan ini
            $id_tahun_evaluasi = AkpkTahunEvaluasi::latest()->first()->id ?? 1;
    
            $tanggal = now();
    
            // 🔵 Simpan data pilihan (nilai)
            $pertanyaan = AkpkPertanyaanAtasan::all();
            foreach ($pertanyaan as $item) {
                $nilai = $request->input('nilai_' . $item->id);
    
                if ($nilai) {
                    AkpkEvaluasiAtasan::create([
                        'nip_atasan' => $nip_atasan,
                        'nip_bawahan' => $nip_bawahan,
                        'id_jawaban' => $nilai, // langsung pakai angka 1–5
                        'id_pertanyaan' => $item->id,
                        'id_tahun_evaluasi' => $id_tahun_evaluasi,
                        'tanggal_pengisian' => $tanggal
                    ]);
                }
            }
    
            // 🟠 Simpan data essay
            $jawabanEssay = $request->input('jawaban_essay', []);
            foreach ($jawabanEssay as $id_pertanyaan_essay => $jawaban) {
                if ($jawaban != null && trim($jawaban) !== '') {
                    AkpkEvaluasiEssayAtasan::create([
                        'nip_atasan' => $nip_atasan,
                        'nip_bawahan' => $nip_bawahan,
                        'id_tahun_evaluasi' => $id_tahun_evaluasi,
                        'id_pertanyaan_essay_atasan' => $id_pertanyaan_essay,
                        'jawaban' => $jawaban,
                    ]);
                }
            }
    
            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        }
    }
}

