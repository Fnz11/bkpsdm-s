<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AkpkEvaluasiDiri;
use App\Models\AkpkEvaluasiEssayDiri;
use App\Models\AkpkPertanyaanDiri;
use App\Models\AkpkJawaban;
use App\Models\AkpkPertanyaanEssayDiri;

class AkpkHasilEvaluasiDiriController extends Controller
{
    public function index()
    {
        $nip = Auth::user()->nip;

        // Ambil data evaluasi diri
        $evaluasiDiri = AkpkEvaluasiDiri::with(['jawaban', 'pertanyaan'])
            ->where('nip', $nip)
            ->get();

        // Ambil data evaluasi essay diri
        $evaluasiEssay = AkpkEvaluasiEssayDiri::with(['pertanyaanEssay'])
            ->where('nip', $nip)
            ->get();

            return view('MenuUmum.Akpk.Assessment.hasilSelfAssessment', compact('evaluasiDiri', 'evaluasiEssay'));
    }
}
