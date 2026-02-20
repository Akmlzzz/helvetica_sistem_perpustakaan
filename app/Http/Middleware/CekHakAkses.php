<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: CekHakAkses
 *
 * Digunakan pada route yang bisa diakses oleh:
 *  - Admin  → selalu boleh
 *  - Petugas → hanya jika memiliki izin untuk fitur tertentu
 *
 * Cara pemakaian di route:
 *   Route::middleware('akses:buku')->group(...)
 */
class CekHakAkses
{
    public function handle(Request $request, Closure $next, string $fitur): Response
    {
        $user = auth()->user();

        // Belum login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Admin → selalu diizinkan
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Petugas → cek izin ke fitur yang diminta
        if ($user->isPetugas()) {
            // Load hakAkses jika belum di-load (eager loading cache)
            $user->loadMissing('hakAkses');

            if ($user->canAccess($fitur)) {
                return $next($request);
            }

            return redirect()->route('petugas.dashboard')
                ->with('error', 'Anda tidak memiliki hak akses ke fitur "' . ucfirst($fitur) . '".');
        }

        // Role lain (anggota dll.) → tolak
        abort(403, 'Akses ditolak.');
    }
}
