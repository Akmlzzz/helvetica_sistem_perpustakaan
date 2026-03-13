<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'akses' => \App\Http\Middleware\CekHakAkses::class,
        ]);

        $middleware->redirectUsersTo(function () {
            /** @var \App\Models\Pengguna $user */
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user->isAdmin())
                return route('dashboard');
            if ($user->isPetugas())
                return route('petugas.dashboard');
            if ($user->isAnggota())
                return route('anggota.dashboard');
            return url('/');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
