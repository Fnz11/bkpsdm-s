<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Pastikan pengguna sudah login dan memiliki peran admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Jika bukan admin, arahkan ke halaman yang sesuai
        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
