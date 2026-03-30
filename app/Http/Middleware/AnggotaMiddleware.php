<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AnggotaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->level_akses === 'anggota') {
            if (Auth::user()->status !== 'aktif') {
                Auth::logout();
                return redirect('/login')->with('error', 'Akun Anda belum aktif atau sedang menunggu verifikasi dari Admin.');
            }
            
            return $next($request);
        }

        return redirect('/')->with('error', 'Akses ditolak.');
    }
}
