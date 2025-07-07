<?php

namespace App\Http\Controllers\Admin\Evaluasi;

use App\Models\Pelatihan;
use App\Models\eva_1_alumni;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlumniAdminController extends Controller
{
    // Menampilkan daftar pelatihan dengan pencarian
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pelatihan_5_pascadiklat_alumni = eva_1_alumni::when($search, function ($query, $search) {
            return $query->where('nama_pelatihan', 'LIKE', "%{$search}%")
                ->orWhere('jenis_pelatihan', 'LIKE', "%{$search}%")
                ->orWhere('penyelenggara_pelatihan', 'LIKE', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.evaluasi.alumni', compact('pelatihan_5_pascadiklat_alumni'));
    }

    // Menampilkan form tambah pelatihan
    public function create()
    {
        return view('admin.evaluasi.createlumni');
    }

    // Menyimpan data pelatihan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'pangkat_golongan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'unitkerja' => 'required|string|max:255',
            'pelaksanaan_pelatihan' => 'required|string|max:255',
            'jenis_pelatihan' => 'required|string|max:255',
            'nama_pelatihan' => 'required|string|max:255',
            'penyelenggara_pelatihan' => 'required|string|max:255',
            'tanggal_pelatihan' => 'required|date',
            'selesai_pelatihan' => 'required|date',
            'biaya' => 'required|string|max:255',
            'laporan' => 'required|string|max:255',
            'hasil_pelatihan' => 'required|in:lulus,tidak lulus',
            'Status_peserta' => 'required|in:Alumni,Non Alumni',
        ]);

        eva_1_alumni::create($request->all());

        return redirect()->route('evaluasi.alumni')->with('success', 'Data pelatihan berhasil disimpan.');
    }

    // Menampilkan form edit pelatihan
    public function edit($id)
    {
        $pelatihan_5_pascadiklat_alumni = eva_1_alumni::findOrFail($id);
        return view('admin.evaluasi.editalumni', compact('pelatihan_5_pascadiklat_alumni'));
    }

    // Memperbarui data pelatihan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'pangkat_golongan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'unitkerja' => 'required|string|max:255',
            'pelaksanaan_pelatihan' => 'required|string|max:255',
            'jenis_pelatihan' => 'required|string|max:255',
            'nama_pelatihan' => 'required|string|max:255',
            'penyelenggara_pelatihan' => 'required|string|max:255',
            'tanggal_pelatihan' => 'required|date',
            'selesai_pelatihan' => 'required|date',
            'biaya' => 'required|string|max:255',
            'laporan' => 'required|string|max:255',
            'hasil_pelatihan' => 'required|in:lulus,tidak lulus',
            'Status_peserta' => 'required|in:Alumni,Non Alumni',
        ]);

        $pelatihan_5_pascadiklat_alumni = eva_1_alumni::findOrFail($id);
        $pelatihan_5_pascadiklat_alumni->update($request->all());

        return redirect()->route('evaluasi.alumni')->with('success', 'Data pelatihan berhasil diperbarui.');
    }

    // Menghapus data pelatihan
    public function destroy($id)
    {
        $pelatihan_5_pascadiklat_alumni = eva_1_alumni::findOrFail($id);
        $pelatihan_5_pascadiklat_alumni->delete();

        return redirect()->route('evaluasi.alumni')->with('success', 'Data pelatihan berhasil dihapus.');
    }

    // Menampilkan detail pelatihan
    public function view($id)
    {
        $pelatihan_5_pascadiklat_alumni = eva_1_alumni::findOrFail($id);
        return view('admin.evaluasi.viewalumni', compact('pelatihan_5_pascadiklat_alumni'));
    }

    // Mengubah status pelatihan
    public function toggleStatus($id)
    {
        $pelatihan_5_pascadiklat_alumni = eva_1_alumni::findOrFail($id);
        $pelatihan_5_pascadiklat_alumni->Status_peserta = $pelatihan_5_pascadiklat_alumni->Status_peserta == 'Alumni' ? 'Non Alumni' : 'Alumni';
        $pelatihan_5_pascadiklat_alumni->save();

        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }
}
