<?php

namespace App\Http\Controllers\Umum\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\PelatihanList;
use App\Models\PelatihanRegistrasi;
use App\Models\ref_namapelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeepwarePelatihanRegistrasiUserController extends Controller
{
    /**
     * Tampilkan daftar pendaftaran pelatihan milik user yang sedang login.
     */
    public function index()
    {
        $nip = Auth::user()->nip;

        $pendaftaran = PelatihanRegistrasi::with('pelatihan')
            ->where('nip', $nip)
            ->get();

        return view('pelatihan.hasil-registrasi', compact('pendaftaran'));
    }

    /**
     * Tampilkan form pendaftaran pelatihan baru.
     */
    public function create(PelatihanList $pelatihan)
    {
        return view('pelatihan.registers', compact('pelatihan'));
    }

    public function create2()
    {
        $namaPelatihan = ref_namapelatihan::where('status', 'diterima')->get();

        return view('pelatihan.registers-2', compact('namaPelatihan'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        $query = PelatihanList::query();

        if ($keyword) {
            $query->where('nama_pelatihan', 'LIKE', '%' . $keyword . '%');
        }

        return response()->json(
            $query->select('id', 'nama_pelatihan')->limit(20)->get()
        );
    }

    public function store(Request $request)
    {
        // Validasi manual agar bisa debug
        $validator = Validator::make($request->all(), [
            'id_pelatihan' => 'required|exists:pelatihan_lists,id',
            'file_usulan' => 'required|file|mimes:pdf|max:2048',
            'file_penawaran' => 'required|file|mimes:pdf|max:2048',
            'biaya_akomodasi' => 'required|numeric',
            'biaya_hotel' => 'required|numeric',
            'biaya_pelatihan' => 'required|numeric',
            'uang_harian' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            // Debug error validasi
            dd($validator->errors()->all());
        }

        $validated = $validator->validated();

        $validated['nip'] = Auth::user()->nip;
        $validated['tanggal_daftar'] = now();
        $validated['status'] = 'tersimpan';

        // Upload file usulan
        if ($request->hasFile('file_usulan')) {
            $validated['file_usulan'] = $request->file('file_usulan')->store('uploads/usulan', 'public');
        }

        // Upload file penawaran
        if ($request->hasFile('file_penawaran')) {
            $validated['file_penawaran'] = $request->file('file_penawaran')->store('uploads/penawaran', 'public');
        }

        // Simpan data
        PelatihanRegistrasi::create($validated);

        return redirect()
            ->route('pelatihan.pendaftaran')
            ->with('success', 'Pendaftaran berhasil.');
    }

    /**
     * Tampilkan detail registrasi milik user.
     */
    public function show(PelatihanRegistrasi $registrasi)
    {
        // Pastikan user hanya bisa melihat datanya sendiri
        if ($registrasi->nip != Auth::user()->nip) {
            abort(403);
        }

        return view('user.pelatihan.show', compact('registrasi'));
    }
}
