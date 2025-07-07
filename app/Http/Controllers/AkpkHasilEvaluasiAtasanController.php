<?php

namespace App\Http\Controllers;

use App\Models\AkpkEvaluasiAtasan;
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
use App\Models\User;

class AkpkHasilEvaluasiAtasanController extends Controller
{
    public function index(){
        
        $nip_atasan = Auth::user()->nip;
    
        $pivot = UserPivot::where('nip', $nip_atasan)
                    ->latest()
                    ->first();
        $userInfo = [
            'nama' => Auth::user()->name,
            'nip' => Auth::user()->nip,
            'jabatan' => $pivot->jabatan->jabatan ?? '-',
            'unit_kerja' => $pivot->unitkerja->unit_kerja ?? '-',
        ];

            // Ambil semua kategori sebagai kolom
    $kategoriList = AkpkKategori::all();

    // Ambil semua bawahan yang dinilai oleh atasan ini
    $bawahanNips = AkpkEvaluasiAtasan::where('nip_atasan', $nip_atasan)
                        ->distinct()
                        ->pluck('nip_bawahan');

    $data = [];

    foreach ($bawahanNips as $index => $nip_bawahan) {
        $user = User::where('nip', $nip_bawahan)->first();
        $row = [
            'no' => $index + 1,
            'nip' => $nip_bawahan,
            'nama' => $user->name ?? '-',
        ];

        foreach ($kategoriList as $kategori) {
            $jawaban = AkpkEvaluasiAtasan::join('akpk_pertanyaan_atasan', 'akpk_evaluasi_atasan.id_pertanyaan', '=', 'akpk_pertanyaan_atasan.id')
                ->where('akpk_evaluasi_atasan.nip_atasan', $nip_atasan)
                ->where('akpk_evaluasi_atasan.nip_bawahan', $nip_bawahan)
                ->where('akpk_pertanyaan_atasan.id_kategori', $kategori->id)
                ->avg('akpk_evaluasi_atasan.id_jawaban');

            $row[$kategori->nama_kategori] = round($jawaban, 2); // Atau bisa pakai total/sum
        }

        $data[] = $row;
    }
        return view('MenuUmum.Akpk.Assessment.hasilAssessmentBawahan', compact( 'userInfo','data','kategoriList'));
    }
}
