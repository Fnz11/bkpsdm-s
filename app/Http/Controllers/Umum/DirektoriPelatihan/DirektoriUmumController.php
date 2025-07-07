<?php

namespace App\Http\Controllers\Umum\DirektoriPelatihan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Directory_2_laporan;
use App\Http\Controllers\Controller;

class DirektoriUmumController extends Controller
{
    public function create()
    {
        return view('MenuUmum.DirektoriPelatihan.createdirektori');
    }

    public function index(Request $request)
    {
        $search = trim($request->input('search'));
        $searchYear = trim($request->input('tahun'));

        $years = Directory_2_laporan::whereNotNull('created_at')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $directory_2_laporans = Directory_2_laporan::where('Status_peserta', 'Alumni') // Hanya Alumni
            ->where('hasil_pelatihan', 'Lulus') // Hanya yang Lulus
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%$search%");
        })
            ->when($searchYear, function ($query, $searchYear) {
                return $query->whereYear('created_at', $searchYear);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        Log::info('Pencarian Direktori Pelatihan', [
            'search' => $search,
            'tahun' => $searchYear,
            'jumlah_ditemukan' => $directory_2_laporans->total()
        ]);

        return view('MenuUmum.DirektoriPelatihan.direktori', compact('directory_2_laporans', 'search', 'searchYear', 'years'));
    }

    

    public function store(Request $request)
    {
        Log::info('Form Direktori Pelatihan Submitted', $request->all());

        // Validasi input
        $request->validate([
            'nip' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
            'golongan_ruang' => 'required|string|max:50',
            'jabatan' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'email' => 'required|email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama_pelatihan' => 'required|string|max:255',
            'pelaksanaan_pelatihan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_pelatihan' => 'required|string|max:255',
            'metode_pelatihan' => 'required|string|max:255',
            'rumpun_pelatihan' => 'required|string|max:255',
            'penyelenggara_pelatihan' => 'required|string|max:255',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'Status_peserta' => 'required|in:Alumni,Non Alumni',
            'judul_laporan' => 'required|string|max:255',
            'abstrak_laporan' => 'required|string',
            'link_laporan' => 'required|url',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Simpan data ke database
        $direktori = new Directory_2_laporan();
        $direktori->fill($request->except(['foto', 'sertifikat']));

        // Upload Foto
        if ($request->hasFile('foto')) {
            Log::info('Foto uploaded');
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/foto'), $fotoName);
            $direktori->foto = 'uploads/foto/' . $fotoName;
        } else {
            Log::info('No Foto uploaded');
        }

        // Upload Sertifikat
        if ($request->hasFile('sertifikat')) {
            Log::info('Sertifikat uploaded');
            $sertifikat = $request->file('sertifikat');
            $sertifikatName = time() . '_' . $sertifikat->getClientOriginalName();
            $sertifikat->move(public_path('uploads/sertifikat'), $sertifikatName);
            $direktori->sertifikat = 'uploads/sertifikat/' . $sertifikatName;
        } else {
            Log::info('No Sertifikat uploaded');
        }

        $direktori->save();
        Log::info('Data Direktori Pelatihan Disimpan');

        return redirect()->back()->with([
            'success' => 'Data berhasil disimpan!',
            'redirect_to_home' => true
        ]);
    }


    // Menampilkan halaman detail laporan
    public function view($id)
    {
        $laporan = Directory_2_laporan::findOrFail($id);
        return view('MenuUmum.DirektoriPelatihan.viewdirektori', compact('laporan'));
    }
}
