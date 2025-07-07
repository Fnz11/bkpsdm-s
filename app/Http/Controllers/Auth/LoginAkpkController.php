<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAkpkController extends Controller
{
    public function showLoginForm()
    {
        return view('MenuUmum.Akpk.Auth.loginAkpk');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return redirect()->route('akpk.index');
        }

        return back()->withErrors(['nip' => 'NIP atau password salah'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('akpk.index');
    }
}
