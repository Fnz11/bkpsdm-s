<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\ref_pegawais;

class UserEvaluasiController extends Controller
{
    public function index()
    {
        return view(view: 'menuumum.evaluasipasca.homepage');
    }
    public function login(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'role' => 'required'
        ]);
    
        // Ambil data pegawai berdasarkan NIP
        $pegawai = ref_pegawais::where('nip', $request->nip)->first();
    
        if (!$pegawai) {
            return response()->json(['success' => false, 'message' => 'NIP tidak ditemukan.']);
        }
    
        // Cek apakah role sesuai dengan yang dipilih user
        if ($pegawai->role !== $request->role) {
            return response()->json(['success' => false, 'message' => 'Role tidak sesuai.']);
        }
    
        // Simpan user ke session
        session([
            'user_id' => $pegawai->id,
            'user_nip' => $pegawai->nip,
            'user_role' => $pegawai->role,
            'user_name' => $pegawai->nama // Simpan nama di session
        ]);
    
        // Redirect sesuai role
        $redirectUrl = match ($pegawai->role) {
            'alumni' => route('dashboard.alumni'),
            'atasan' => route('dashboard.atasan'),
            'rekan' => route('dashboard.rekan'),
            default => route('home'),
        };
    
        return response()->json(['success' => true, 'redirect' => $redirectUrl]);
    }
    
    public function logout()
    {
        session()->flush(); // Menghapus semua session
        return redirect('/');
    }


    public function alumni()
    {
        // Pastikan user sudah login dengan sesi yang valid
        if (!session()->has('user_nip')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data pegawai berdasarkan NIP dari session
        $nip = session('user_nip');
        $ref_pegawai = ref_pegawais::where('nip', $nip)->first();

        if (!$ref_pegawai) {
            return redirect()->route('home')->with('error', 'Data alumni tidak ditemukan.');
        }

        // Kirim ke view dengan nama variabel yang sama
        return view('menuumum.evaluasipasca.dashboard.alumni', compact('ref_pegawai'));
    }


    public function atasan()
    {
        return view('menuumum.evaluasipasca.dashboard.atasan', ['role' => 'atasan']);
    }

    public function rekan()
    {
        return view('menuumum.evaluasipasca.dashboard.rekan', ['role' => 'rekan']);
    }

}
