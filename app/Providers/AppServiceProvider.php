<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\RateLimiter::for('login', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->email . $request->ip());
        });

        // Daftarkan Observer
        \App\Models\Peminjaman::observe(\App\Observers\PeminjamanObserver::class);
        \App\Models\Buku::observe(\App\Observers\BukuObserver::class);
    }
}
