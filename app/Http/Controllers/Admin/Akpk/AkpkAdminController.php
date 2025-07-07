<?php
namespace App\Http\Controllers\Admin\Akpk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AkpkPertanyaanDiri;
use App\Models\AkpkPertanyaanEssayDiri;
use App\Models\AkpkKategori;
use App\Models\AkpkPertanyaanAtasan;
use App\Models\AkpkPertanyaanEssayAtasan;
use App\Models\RefJabatan;

class AkpkAdminController extends Controller
{
    // ...existing code...

    public function dashboard()
    {
        return view('Admin.Akpk.dashboardAkpk');
    }

    public function tabelSelfAssessment()
    {
        return view('Admin.Akpk.Asessment.tabelSelfAssessment');
    }
    public function tabelAssessmentAtasan()
    {
        return view('Admin.Akpk.Asessment.tabelAssessmentAtasan');
    }
    public function tabelEvaluasiAssessment()
    {
        return view('Admin.Akpk.Asessment.tabelEvaluasiAssessment');
    }
    public function tabelUsulanKebutuhanPelatihan()
    {
        return view('Admin.Akpk.Usulan.tabelUsulanKebutuhanPelatihan');
    }
    public function tabelUsulanPelatihanSolowasis()
    {
        return view('Admin.Akpk.Usulan.tabelUsulanPelatihanSolowasis');
    }


    public function manajemenPertanyaanDiri()
    {

        $jabatan = RefJabatan::all();
        $kategori = AkpkKategori::all();
        // Ambil data skala dari tabel akpk_pertanyaan_diri
        $pertanyaanSkala = AkpkPertanyaanDiri::with(['kategori', 'jabatan'])
        ->where('is_visible_admin', true)
        ->get();

        // Ambil data essay dari tabel akpk_pertanyaan_essay_diri (tidak ada relasi)
        $pertanyaanEssay = AkpkPertanyaanEssayDiri::all()
        ->where('is_visible_admin', true);

        // Gabungkan dan tandai tipe pertanyaannya
        $data = $pertanyaanSkala->map(function ($item) {
            return [
                'id' => $item->id,
                'kategori' => $item->jabatan->jabatan ?? 'Tidak Diketahui',
                'tipe' => 'Skala',
                'kompetensi' => $item->kategori->kategori ?? 'Tidak Diketahui',
                'deskripsi' => $item->deskripsi,
                'status' => $item->status,
                'standar_min' => $item->standar_min,
            ];
        })->merge(
            $pertanyaanEssay->map(function ($item) {
                return [
                    'id' => $item->id,
                    'kategori' => '-',
                    'tipe' => 'Essai',
                    'kompetensi' => '-',
                    'status' => $item->status,
                    'deskripsi' => $item->pertanyaan,
                    'standar_min' => '-',   
                ];
            })
        );
        return view('Admin.Akpk.ManajemenData.Pertanyaan.manajemenPertanyaan', 
        compact('data','jabatan','kategori'));
    }
    
    public function simpanPertanyaanDiri(Request $request)
    {
        $request->validate([
            'kategori' => 'required_if:tipe_soal,Skala|string|nullable',
            'pertanyaan' => 'required_if:tipe_soal,Essai|string|nullable',
            'tipe_soal' => 'required|in:Skala,Essai',
            'kompetensi' => 'required_if:tipe_soal,Skala|string|nullable',
            'deskripsi' => 'required_if:tipe_soal,Skala|string|nullable',
            'standar_minimum' => 'required_if:tipe_soal,Skala|integer|min:0|max:5|nullable',
        ]);
    
        if ($request->tipe_soal === 'Skala') {
            $jabatan = RefJabatan::where('jabatan', $request->kategori)->first();
            $kategori = AkpkKategori::where('kategori', $request->kompetensi)->first();
        
            if (!$jabatan || !$kategori) {
                return back()->with('error', 'Kategori jabatan atau kompetensi tidak ditemukan.');
            }
        
            AkpkPertanyaanDiri::create([
                'deskripsi' => $request->deskripsi,
                'id_kategori' => $kategori->id,
                'standar_min' => $request->standar_minimum,
                'id_jabatan' => $jabatan->id,
                'status' => 'aktif',
            ]);
        } elseif ($request->tipe_soal === 'Essai') {
            AkpkPertanyaanEssayDiri::create([
                'pertanyaan' => $request->pertanyaan,
                'status' => 'aktif',
            ]);
        }
    
        return back()->with('success', 'Pertanyaan berhasil disimpan.');
    }

    public function updatePertanyaanDiri(Request $request)
    {
        $request->validate([
            'kategori' => 'required_if:tipe_soal,Skala|string|nullable',
            'pertanyaan' => 'required_if:tipe_soal,Essai|string|nullable',
            'tipe_soal' => 'required|in:Skala,Essai',
            'kompetensi' => 'required_if:tipe_soal,Skala|string|nullable',
            'deskripsi' => 'required_if:tipe_soal,Skala|string|nullable',
            'standar_minimum' => 'required_if:tipe_soal,Skala|integer|min:0|max:5|nullable',
        ]);
    

    
        if ($request->tipe_soal === 'Skala') {
            $pertanyaan = AkpkPertanyaanDiri::findOrFail($request->id);
            $jabatan = RefJabatan::where('jabatan', $request->kategori)->first();
            $kategori = AkpkKategori::where('kategori', $request->kompetensi)->first();
        
            if (!$jabatan || !$kategori) {
                return back()->with('error', 'Kategori jabatan atau kompetensi tidak ditemukan.');
            }
        
            $pertanyaan->update([
                'deskripsi' => $request->deskripsi,
                'id_kategori' => $kategori->id,
                'standar_min' => $request->standar_minimum,
                'id_jabatan' => $jabatan->id,
                'status' => 'aktif',
            ]);
        } elseif ($request->tipe_soal === 'Essai') {
            $pertanyaan = AkpkPertanyaanEssayDiri::findOrFail($request->id);
            $pertanyaan->update([
                'pertanyaan' => $request->pertanyaan,
                'status' => 'aktif',
            ]);
        }
    
        return back()->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function hapusPertanyaanDiri(Request $request)
    {
        $id = $request->input('id');
        $tipe = $request->input('tipe');
    
        if ($tipe === 'Skala') {
            $pertanyaan = AkpkPertanyaanDiri::find($id);
        } elseif ($tipe === 'Essai') {
            $pertanyaan = AkpkPertanyaanEssayDiri::find($id);
        } else {
            return response()->json(['success' => false, 'message' => 'Tipe tidak valid']);
        }
    
        if ($pertanyaan) {
            $pertanyaan->is_visible_admin = false;
            $pertanyaan->save();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
    }
    

    public function manajemenPertanyaanAtasan()
    { 
        $jabatan = RefJabatan::all();
        $kategori = AkpkKategori::all();
        // Ambil data skala dari tabel akpk_pertanyaan_diri
        $pertanyaanSkala = AkpkPertanyaanAtasan::with(['kategori', 'jabatan'])
        ->where('is_visible_admin', true)
        ->get();

        // Ambil data essay dari tabel akpk_pertanyaan_essay_diri (tidak ada relasi)
        $pertanyaanEssay = AkpkPertanyaanEssayAtasan::all()
        ->where('is_visible_admin', true);

        // Gabungkan dan tandai tipe pertanyaannya
        $data = $pertanyaanSkala->map(function ($item) {
            return [
                'id' => $item->id,
                'kategori' => $item->jabatan->jabatan ?? 'Tidak Diketahui',
                'tipe' => 'Skala',
                'kompetensi' => $item->kategori->kategori ?? 'Tidak Diketahui',
                'deskripsi' => $item->deskripsi,
                'status' => $item->status,
                'standar_min' => $item->standar_min,
            ];
        })->merge(
            $pertanyaanEssay->map(function ($item) {
                return [
                    'id' => $item->id,
                    'kategori' => '-',
                    'tipe' => 'Essai',
                    'kompetensi' => '-',
                    'status' => $item->status,
                    'deskripsi' => $item->pertanyaan,
                    'standar_min' => '-',
                ];
            })
        );

        return view('Admin.Akpk.ManajemenData.Pertanyaan.Atasan.manajemenPertanyaanAtasan', 
        compact('data','jabatan','kategori'));
    }

    public function simpanPertanyaanAtasan(Request $request)
    {
        $request->validate([
            'kategori' => 'required_if:tipe_soal,Skala|string|nullable',
            'pertanyaan' => 'required_if:tipe_soal,Essai|string|nullable',
            'tipe_soal' => 'required|in:Skala,Essai',
            'kompetensi' => 'required_if:tipe_soal,Skala|string|nullable',
            'deskripsi' => 'required_if:tipe_soal,Skala|string|nullable',
            'standar_minimum' => 'required_if:tipe_soal,Skala|integer|min:0|max:5|nullable',
        ]);
    
        if ($request->tipe_soal === 'Skala') {
            $jabatan = RefJabatan::where('jabatan', $request->kategori)->first();
            $kategori = AkpkKategori::where('kategori', $request->kompetensi)->first();
        
            if (!$jabatan || !$kategori) {
                return back()->with('error', 'Kategori jabatan atau kompetensi tidak ditemukan.');
            }
        
            AkpkPertanyaanAtasan::create([
                'deskripsi' => $request->deskripsi,
                'id_kategori' => $kategori->id,
                'standar_min' => $request->standar_minimum,
                'id_jabatan' => $jabatan->id,
                'status' => 'aktif',
            ]);
        } elseif ($request->tipe_soal === 'Essai') {
            AkpkPertanyaanEssayAtasan::create([
                'pertanyaan' => $request->pertanyaan,
                'status' => 'aktif',
            ]);
        }
    
        return back()->with('success', 'Pertanyaan berhasil disimpan.');
    }

    public function updatePertanyaanAtasan(Request $request)
    {
        $request->validate([
            'kategori' => 'required_if:tipe_soal,Skala|string|nullable',
            'pertanyaan' => 'required_if:tipe_soal,Essai|string|nullable',
            'tipe_soal' => 'required|in:Skala,Essai',
            'kompetensi' => 'required_if:tipe_soal,Skala|string|nullable',
            'deskripsi' => 'required_if:tipe_soal,Skala|string|nullable',
            'standar_minimum' => 'required_if:tipe_soal,Skala|integer|min:0|max:5|nullable',
        ]);
    

    
        if ($request->tipe_soal === 'Skala') {
            $pertanyaan = AkpkPertanyaanAtasan::findOrFail($request->id);
            $jabatan = RefJabatan::where('jabatan', $request->kategori)->first();
            $kategori = AkpkKategori::where('kategori', $request->kompetensi)->first();
        
            if (!$jabatan || !$kategori) {
                return back()->with('error', 'Kategori jabatan atau kompetensi tidak ditemukan.');
            }
        
            $pertanyaan->update([
                'deskripsi' => $request->deskripsi,
                'id_kategori' => $kategori->id,
                'standar_min' => $request->standar_minimum,
                'id_jabatan' => $jabatan->id,
                'status' => 'aktif',
            ]);
        } elseif ($request->tipe_soal === 'Essai') {
            $pertanyaan = AkpkPertanyaanEssayAtasan::findOrFail($request->id);
            $pertanyaan->update([
                'pertanyaan' => $request->pertanyaan,
                'status' => 'aktif',
            ]);
        }
    
        return back()->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function hapusPertanyaanAtasan(Request $request)
    {
        $id = $request->input('id');
        $tipe = $request->input('tipe');
    
        if ($tipe === 'Skala') {
            $pertanyaan = AkpkPertanyaanAtasan::find($id);
        } elseif ($tipe === 'Essai') {
            $pertanyaan = AkpkPertanyaanEssayAtasan::find($id);
        } else {
            return response()->json(['success' => false, 'message' => 'Tipe tidak valid']);
        }
    
        if ($pertanyaan) {
            $pertanyaan->is_visible_admin = false;
            $pertanyaan->save();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
    }
    

    public function manajemenKomentar()
    {
        return view('Admin.Akpk.ManajemenData.Komentar.manajemenKomentar');
    }
    public function manajemenGaleri()
    {
        return view('Admin.Akpk.ManajemenData.Galeri.manajemenGaleri');
    }
    public function manajemenSolowasis()
    {
        return view('Admin.Akpk.ManajemenData.manajemenSolowasis');
    }
    public function manajemenRUmpun()
    {
        return view('Admin.Akpk.ManajemenData.manajemenRumpun');
    }
    public function dataNomenklatur(){
    
        return view('Admin.Akpk.Usulan.Admin.dataNomenklatur');
    }
    public function tabelUsulanAdmin()
    {
        return view('Admin.Akpk.Usulan.Admin.tabelUsulanAdmin');
    }


    public function toggleStatusDiri(Request $request)
    {
        $id = $request->id;
        $status = $request->status; // 'aktif' atau 'nonaktif'
        $tipe = $request->tipe;
    
        if ($tipe === 'Skala') {
            $pertanyaan = AkpkPertanyaanDiri::find($id);
        } else {
            $pertanyaan = AkpkPertanyaanEssayDiri::find($id);
        }
    
        if ($pertanyaan) {
            $pertanyaan->status = $status;
            $pertanyaan->save();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404);
    }

    public function toggleStatusAtasan(Request $request)
    {
        $id = $request->id;
        $status = $request->status; // 'aktif' atau 'nonaktif'
        $tipe = $request->tipe;
    
        if ($tipe === 'Skala') {
            $pertanyaan = AkpkPertanyaanAtasan::find($id);
        } else {
            $pertanyaan = AkpkPertanyaanEssayAtasan::find($id);
        }
    
        if ($pertanyaan) {
            $pertanyaan->status = $status;
            $pertanyaan->save();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404);
    }
}
