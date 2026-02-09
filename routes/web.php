<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', function () {
            // Count data for dashboard
            $totalBuku = \App\Models\Buku::count();
            $totalAnggota = \App\Models\Pengguna::where('level_akses', 'anggota')->count();
            $totalPeminjaman = \App\Models\Peminjaman::where('status_transaksi', 'dipinjam')->count();
            // $totalDenda would come from a Denda model if implemented

            // Get latest peminjaman
            $latestPeminjaman = \App\Models\Peminjaman::with(['pengguna', 'buku', 'detail.buku'])
                ->latest('tgl_pinjam')
                ->take(5)
                ->get();

            return view('dashboard', compact('totalBuku', 'totalAnggota', 'totalPeminjaman', 'latestPeminjaman'));
        })->name('dashboard');

        // Book Management Routes
        Route::get('/buku', [\App\Http\Controllers\Admin\BukuController::class, 'index'])->name('admin.buku.index');
        Route::post('/buku', [\App\Http\Controllers\Admin\BukuController::class, 'store'])->name('admin.buku.store');
        Route::put('/buku/{id}', [\App\Http\Controllers\Admin\BukuController::class, 'update'])->name('admin.buku.update');
        Route::delete('/buku/{id}', [\App\Http\Controllers\Admin\BukuController::class, 'destroy'])->name('admin.buku.destroy');

        // Category Management Routes
        Route::get('/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'index'])->name('admin.kategori.index');
        Route::post('/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'store'])->name('admin.kategori.store');
        Route::put('/kategori/{id}', [\App\Http\Controllers\Admin\KategoriController::class, 'update'])->name('admin.kategori.update');
        Route::delete('/kategori/{id}', [\App\Http\Controllers\Admin\KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

        // Peminjaman Management Routes
        Route::get('/peminjaman', [\App\Http\Controllers\Admin\PeminjamanController::class, 'index'])->name('admin.peminjaman.index');
        Route::get('/peminjaman/create', [\App\Http\Controllers\Admin\PeminjamanController::class, 'create'])->name('admin.peminjaman.create');
        Route::post('/peminjaman', [\App\Http\Controllers\Admin\PeminjamanController::class, 'store'])->name('admin.peminjaman.store');
        Route::get('/peminjaman/{id}', [\App\Http\Controllers\Admin\PeminjamanController::class, 'show'])->name('admin.peminjaman.show');

        // Denda Management Routes
        Route::get('/denda', [\App\Http\Controllers\Admin\DendaController::class, 'index'])->name('admin.denda.index');
        Route::get('/denda/{id}', [\App\Http\Controllers\Admin\DendaController::class, 'show'])->name('admin.denda.show');

        // User Management Routes
        Route::get('/pengguna', [\App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('admin.pengguna.index');
        Route::post('/pengguna', [\App\Http\Controllers\Admin\PenggunaController::class, 'store'])->name('admin.pengguna.store');
        Route::put('/pengguna/{id}', [\App\Http\Controllers\Admin\PenggunaController::class, 'update'])->name('admin.pengguna.update');
        Route::delete('/pengguna/{id}', [\App\Http\Controllers\Admin\PenggunaController::class, 'destroy'])->name('admin.pengguna.destroy');
        // Laporan Management Routes
        Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/laporan/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'exportPdf'])->name('admin.laporan.pdf');
        Route::get('/laporan/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'exportExcel'])->name('admin.laporan.excel');
    });

    Route::middleware(['auth', \App\Http\Middleware\PetugasMiddleware::class])->group(function () {
        Route::get('/petugas/dashboard', [\App\Http\Controllers\Petugas\PetugasController::class, 'index'])->name('petugas.dashboard');
        Route::get('/petugas/booking', [\App\Http\Controllers\Petugas\PetugasController::class, 'booking'])->name('petugas.booking');
        Route::get('/petugas/katalog', [\App\Http\Controllers\Petugas\PetugasController::class, 'katalog'])->name('petugas.katalog');
        Route::post('/petugas/peminjaman', [\App\Http\Controllers\Petugas\PetugasController::class, 'storePeminjaman'])->name('petugas.peminjaman.store');
        Route::post('/petugas/pengembalian', [\App\Http\Controllers\Petugas\PetugasController::class, 'returnBuku'])->name('petugas.pengembalian.store');
    });

    // Anggota Routes
    Route::middleware(['auth', \App\Http\Middleware\AnggotaMiddleware::class])->group(function () {
        Route::get('/anggota/dashboard', [\App\Http\Controllers\Anggota\AnggotaController::class, 'index'])->name('anggota.dashboard');
        Route::get('/anggota/pinjaman', [\App\Http\Controllers\Anggota\AnggotaController::class, 'pinjaman'])->name('anggota.pinjaman');
        Route::get('/anggota/riwayat', [\App\Http\Controllers\Anggota\AnggotaController::class, 'riwayat'])->name('anggota.riwayat');
        Route::post('/anggota/booking', [\App\Http\Controllers\Anggota\AnggotaController::class, 'storeBooking'])->name('anggota.booking.store');

        // Profile Routes
        Route::get('/anggota/profile', [\App\Http\Controllers\Anggota\AnggotaController::class, 'profile'])->name('anggota.profile');
        Route::put('/anggota/profile', [\App\Http\Controllers\Anggota\AnggotaController::class, 'updateProfile'])->name('anggota.profile.update');
    });
});

// API Routes for AJAX calls
Route::get('/api/buku/search', [\App\Http\Controllers\Api\BukuApiController::class, 'search'])->name('api.buku.search');
