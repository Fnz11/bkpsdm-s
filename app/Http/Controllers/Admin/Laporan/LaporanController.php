<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Directory_2_laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    // Menampilkan daftar laporan dengan filter dan pagination
    public function index(Request $request)
{
    $search = $request->input('search');
    $tahun = $request->input('tahun');

    // Ambil data dengan filter pencarian dan tahun
    $query = Directory_2_laporan::query();

    // Tambahkan filter berdasarkan jenis halaman
    $routeName = $request->route()->getName();
    if ($routeName === 'laporan.arsip') {
        $query->where('hasil_pelatihan', 'lulus'); // Arsip hanya menampilkan yang "lulus"
    } else {
        $query->where('hasil_pelatihan', 'tidak lulus'); // Usulan hanya menampilkan yang "tidak lulus"
    }

    $directory_2_laporans = $query->when($search, function ($query, $search) {
            return $query->where('judul_laporan', 'like', "%$search%");
        })
        ->when($tahun, function ($query, $tahun) {
            return $query->whereYear('tanggal_mulai', $tahun);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->appends($request->query());

    // Ambil daftar tahun unik untuk filter dropdown sesuai dengan tipe halaman
    $years = Directory_2_laporan::selectRaw('YEAR(tanggal_mulai) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year')
        ->toArray();

    return view('Admin.Laporan.' . ($routeName === 'laporan.arsip' ? 'arsip' : 'usulan'), compact('directory_2_laporans', 'years'));
}






    // Menampilkan form tambah laporan
    public function create()
    {
        return view('Admin.Laporan.createusulan');
    }

    // Menyimpan data laporan baru
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|integer',
            'nama' => 'required|string',
            'golongan_ruang' => 'required|string',
            'jabatan' => 'required|string',
            'unit_kerja' => 'required|string',
            'email' => 'required|email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama_pelatihan' => 'required|string',
            'pelaksanaan_pelatihan' => 'required|string',
            'penyelenggara_pelatihan' => 'required|string',
            'rumpun_pelatihan' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'hasil_pelatihan' => 'required|in:lulus,tidak lulus',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'judul_laporan' => 'required|string',
            'abstrak_laporan' => 'required|string',
            'link_laporan' => 'required|url',
            'Status_peserta' => 'required|in:Alumni,Non Alumni',
            'keterangan' => 'nullable|string',
        ]);

        $laporan = new Directory_2_laporan($request->except('foto'));

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('uploads/foto', 'public');
            $laporan->foto = $fotoPath;
        }

        $laporan->save();

        return redirect()->route('laporan.usulan')->with('success', 'Laporan berhasil ditambahkan.');
    }

    // Menampilkan form edit laporan
    public function edit($id)
    {
        $laporan = Directory_2_laporan::findOrFail($id);
        return view('Admin.Laporan.editlaporan', compact('laporan'));
    }

    // Menyimpan perubahan pada laporan
    public function update(Request $request, $id)
    {
        $laporan = Directory_2_laporan::findOrFail($id);
        $laporan->update($request->except('foto'));

        if ($request->hasFile('foto')) {
            if ($laporan->foto && Storage::disk('public')->exists($laporan->foto)) {
                Storage::disk('public')->delete($laporan->foto);
            }
            $fotoPath = $request->file('foto')->store('uploads/foto', 'public');
            $laporan->foto = $fotoPath;
            $laporan->save();
        }

        return redirect()->route('laporan.usulan')->with('success', 'Laporan berhasil diperbarui.');
    }

    // Menghapus laporan
    public function destroy($id)
    {
        $laporan = Directory_2_laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('laporan.usulan')->with('success', 'Laporan berhasil dihapus!');
    }


    public function approve($id)
    {
        $laporan = Directory_2_laporan::findOrFail($id);
        $laporan->hasil_pelatihan = 'lulus';
        $laporan->save();

        return redirect()->route('laporan.arsip')->with('success', 'Laporam berhasil disetujui.');
    }
}
