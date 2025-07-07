<?php

namespace App\Http\Controllers\Admin\Evaluasi;

use App\Models\eva_2_atasan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AtasanAdminController extends Controller
{
    // Menampilkan daftar atasan dengan pencarian
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pelatihan_5_pascadiklat_atasan = eva_2_atasan::when($search, function ($query, $search) {
            return $query->where('nama', 'LIKE', "%{$search}%")
                ->orWhere('pangkat_golongan', 'LIKE', "%{$search}%")
                ->orWhere('jabatan', 'LIKE', "%{$search}%")
                ->orWhere('unit_kerja', 'LIKE', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.evaluasi.atasan', compact('pelatihan_5_pascadiklat_atasan'));
    }

    // Menampilkan form tambah atasan
    public function create()
    {
        return view('admin.evaluasi.createatasan');
    }

    // Menyimpan data atasan baru
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|integer',
            'nama' => 'required|string|max:255',
            'pangkat_golongan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15', // Sesuai dengan database
        ]);

        eva_2_atasan::create($request->all());

        return redirect()->route('evaluasi.atasan')->with('success', 'Data atasan berhasil disimpan.');
    }

    // Menampilkan form edit atasan
    public function edit($id)
    {
        $pelatihan_5_pascadiklat_atasan = eva_2_atasan::findOrFail($id);
        return view('admin.evaluasi.editatasan', compact('pelatihan_5_pascadiklat_atasan'));
    }

    // Memperbarui data atasan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|integer',
            'nama' => 'required|string|max:255',
            'pangkat_golongan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15', // Sesuai dengan database
        ]);

        $pelatihan_5_pascadiklat_atasan = eva_2_atasan::findOrFail($id);
        $pelatihan_5_pascadiklat_atasan->update($request->all());

        return redirect()->route('evaluasi.atasan')->with('success', 'Data atasan berhasil diperbarui.');
    }

    // Menghapus data atasan
    public function destroy($id)
    {
        $pelatihan_5_pascadiklat_atasan = eva_2_atasan::findOrFail($id);
        $pelatihan_5_pascadiklat_atasan->delete();

        return redirect()->route('evaluasi.atasan')->with('success', 'Data atasan berhasil dihapus.');
    }

    // Menampilkan detail atasan
    public function view($id)
    {
        $pelatihan_5_pascadiklat_atasan = eva_2_atasan::findOrFail($id);
        return view('admin.evaluasi.viewatasan', compact('pelatihan_5_pascadiklat_atasan'));
    }
}
