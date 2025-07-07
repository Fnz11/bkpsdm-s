<?php
//controller login
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('adminlogin');
    }

    public function logins(Request $request)
    {
        // Validasi form input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
        
            // Simpan session
            session([
                'nama_admin' => $user->name,
                'nama_unitkerja' => $user->unitkerja->nama ?? null
            ]);
        
            // Role dan redirect
            $user->syncRoles([]);
        
            switch ($user->role) {
                case 'superadmin':
                    $user->assignRole('superadmin');
                    return redirect()->route('dashboard');
                case 'admin':
                    $user->assignRole('admin');
                    return redirect()->route('dashboard');
                case 'asn':
                    $user->assignRole('asn');
                    return redirect()->route('dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors(['email' => 'Role pengguna tidak dikenali.']);
            }
        }
    
        // Jika kredensial salah
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }
    
public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Ambil nama unit kerja berdasarkan kode_unitkerja dari tabel ref_unitkerja (jika bukan superadmin)
        $unitKerja = null;
        if ($user->is_admin == 2) {
            $unitKerja = DB::table('ref_unitkerjas')
                ->where('kode_unitkerja', $user->kode_unitkerja)
                ->value('unitkerja');
        }

        // Jika admin biasa tetapi tidak memiliki unit kerja, tolak akses
        if ($user->is_admin == 2 && !$unitKerja) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Anda belum memiliki unit kerja. Hubungi Super Admin untuk menambahkan unit kerja Anda.'
            ]);
        }

        // Simpan nama admin di session
        session([
            'nama_admin' => $user->name, // Asumsikan ada kolom 'name' di tabel users
            'nama_unitkerja' => $user->is_admin == 1 ? null : ($unitKerja ?? 'Tidak Diketahui') // Superadmin tidak perlu unit kerja
        ]);

        // Super Admin (akses semua fitur)
        if ($user->is_admin == 1) {
            return redirect()->route('dashboard');
        }

        // Admin Biasa (akses berdasarkan unit kerja)
        return redirect()->route('dashboard', ['unit' => $user->kode_unitkerja]);
    }

    // Jika kredensial salah
    return back()->withErrors(['email' => 'Email atau password salah.']);
}




public function logout()
{
    Auth::logout();
    return redirect('/');
}

}
