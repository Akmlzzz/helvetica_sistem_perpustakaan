<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
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

    // =========================================================
    // ADMIN ONLY — hanya bisa diakses oleh admin
    // =========================================================
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', function () {
            $totalBuku = \App\Models\Buku::count();
            $totalAnggota = \App\Models\Pengguna::where('level_akses', 'anggota')->count();
            $totalPeminjaman = \App\Models\Peminjaman::where('status_transaksi', 'dipinjam')->count();

            $latestPeminjaman = \App\Models\Peminjaman::with(['pengguna', 'buku', 'detail.buku'])
                ->latest('tgl_pinjam')
                ->take(5)
                ->get();

            return view('dashboard', compact('totalBuku', 'totalAnggota', 'totalPeminjaman', 'latestPeminjaman'));
        })->name('dashboard');

        // Pengguna Management (admin only)
        Route::get('/pengguna', [\App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('admin.pengguna.index');
        Route::post('/pengguna', [\App\Http\Controllers\Admin\PenggunaController::class, 'store'])->name('admin.pengguna.store');
        Route::put('/pengguna/{id}', [\App\Http\Controllers\Admin\PenggunaController::class, 'update'])->name('admin.pengguna.update');
        Route::delete('/pengguna/{id}', [\App\Http\Controllers\Admin\PenggunaController::class, 'destroy'])->name('admin.pengguna.destroy');

        // Hak Akses Management (admin only)
        Route::get('/hak-akses', [\App\Http\Controllers\Admin\HakAksesController::class, 'index'])->name('admin.hak-akses.index');
        Route::post('/hak-akses/{id_pengguna}', [\App\Http\Controllers\Admin\HakAksesController::class, 'update'])->name('admin.hak-akses.update');
        Route::post('/hak-akses/{id_pengguna}/toggle', [\App\Http\Controllers\Admin\HakAksesController::class, 'toggle'])->name('admin.hak-akses.toggle');

        // Pengajuan Buku Management (admin only)
        Route::get('/pengajuan-buku', [\App\Http\Controllers\Admin\PengajuanBukuController::class, 'index'])->name('admin.pengajuan-buku.index');
        Route::get('/pengajuan-buku/{id}', [\App\Http\Controllers\Admin\PengajuanBukuController::class, 'show'])->name('admin.pengajuan-buku.show');
        Route::patch('/pengajuan-buku/{id}/status', [\App\Http\Controllers\Admin\PengajuanBukuController::class, 'updateStatus'])->name('admin.pengajuan-buku.status');
        Route::delete('/pengajuan-buku/{id}', [\App\Http\Controllers\Admin\PengajuanBukuController::class, 'destroy'])->name('admin.pengajuan-buku.destroy');

        // Verifikasi Anggota Management (admin only)
        Route::get('/verifikasi-anggota', [\App\Http\Controllers\Admin\VerifikasiAnggotaController::class, 'index'])->name('admin.verifikasi-anggota.index');
        Route::get('/verifikasi-anggota/{id}', [\App\Http\Controllers\Admin\VerifikasiAnggotaController::class, 'show'])->name('admin.verifikasi-anggota.show');
        Route::post('/verifikasi-anggota/{id}/approve', [\App\Http\Controllers\Admin\VerifikasiAnggotaController::class, 'approve'])->name('admin.verifikasi-anggota.approve');
        Route::post('/verifikasi-anggota/{id}/reject', [\App\Http\Controllers\Admin\VerifikasiAnggotaController::class, 'reject'])->name('admin.verifikasi-anggota.reject');
        Route::get('/verifikasi-anggota/all', [\App\Http\Controllers\Admin\VerifikasiAnggotaController::class, 'allMembers'])->name('admin.verifikasi-anggota.all');
        Route::post('/verifikasi-anggota/{id}/toggle', [\App\Http\Controllers\Admin\VerifikasiAnggotaController::class, 'toggleStatus'])->name('admin.verifikasi-anggota.toggle');
    });

    // =========================================================
    // SHARED — Admin ATAU Petugas dengan izin yang sesuai
    // =========================================================

    // Kategori — admin atau petugas yang punya izin 'kategori'
    Route::middleware('akses:kategori')->group(function () {
        Route::get('/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'index'])->name('admin.kategori.index');
        Route::post('/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'store'])->name('admin.kategori.store');
        Route::put('/kategori/{id}', [\App\Http\Controllers\Admin\KategoriController::class, 'update'])->name('admin.kategori.update');
        Route::delete('/kategori/{id}', [\App\Http\Controllers\Admin\KategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    });

    // Buku — admin atau petugas yang punya izin 'buku'
    Route::middleware('akses:buku')->group(function () {
        Route::get('/buku', [\App\Http\Controllers\Admin\BukuController::class, 'index'])->name('admin.buku.index');
        Route::get('/buku/{id}', [\App\Http\Controllers\Admin\BukuController::class, 'show'])->name('admin.buku.show');
        Route::post('/buku', [\App\Http\Controllers\Admin\BukuController::class, 'store'])->name('admin.buku.store');
        Route::put('/buku/{id}', [\App\Http\Controllers\Admin\BukuController::class, 'update'])->name('admin.buku.update');
        Route::delete('/buku/{id}', [\App\Http\Controllers\Admin\BukuController::class, 'destroy'])->name('admin.buku.destroy');
    });

    // Peminjaman — admin atau petugas yang punya izin 'peminjaman'
    Route::middleware('akses:peminjaman')->group(function () {
        Route::get('/peminjaman', [\App\Http\Controllers\Admin\PeminjamanController::class, 'index'])->name('admin.peminjaman.index');
        Route::get('/peminjaman/create', [\App\Http\Controllers\Admin\PeminjamanController::class, 'create'])->name('admin.peminjaman.create');
        Route::post('/peminjaman', [\App\Http\Controllers\Admin\PeminjamanController::class, 'store'])->name('admin.peminjaman.store');
        Route::get('/peminjaman/{id}', [\App\Http\Controllers\Admin\PeminjamanController::class, 'show'])->name('admin.peminjaman.show');
    });

    // Denda — admin atau petugas yang punya izin 'denda'
    Route::middleware('akses:denda')->group(function () {
        Route::get('/denda', [\App\Http\Controllers\Admin\DendaController::class, 'index'])->name('admin.denda.index');
        Route::get('/denda/{id}', [\App\Http\Controllers\Admin\DendaController::class, 'show'])->name('admin.denda.show');
    });

    // Laporan — admin atau petugas yang punya izin 'laporan'
    Route::middleware('akses:laporan')->group(function () {
        Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/laporan/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'exportPdf'])->name('admin.laporan.pdf');
        Route::get('/laporan/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'exportExcel'])->name('admin.laporan.excel');
    });

    // =========================================================
    // PETUGAS Routes (dashboard & fitur petugas)
    // =========================================================
    Route::middleware([\App\Http\Middleware\PetugasMiddleware::class])->group(function () {
        Route::get('/petugas/dashboard', [\App\Http\Controllers\Petugas\PetugasController::class, 'index'])->name('petugas.dashboard');
        Route::get('/petugas/booking', [\App\Http\Controllers\Petugas\PetugasController::class, 'booking'])->name('petugas.booking');
        Route::get('/petugas/katalog', [\App\Http\Controllers\Petugas\PetugasController::class, 'katalog'])->name('petugas.katalog');
        Route::post('/petugas/peminjaman', [\App\Http\Controllers\Petugas\PetugasController::class, 'storePeminjaman'])->name('petugas.peminjaman.store');
        Route::post('/petugas/pengembalian', [\App\Http\Controllers\Petugas\PetugasController::class, 'returnBuku'])->name('petugas.pengembalian.store');
    });

    // =========================================================
    // ANGGOTA Routes
    // =========================================================
    Route::middleware([\App\Http\Middleware\AnggotaMiddleware::class])->group(function () {
        Route::get('/anggota/dashboard', [\App\Http\Controllers\Anggota\AnggotaController::class, 'index'])->name('anggota.dashboard');
        Route::get('/anggota/buku/{id}', [\App\Http\Controllers\Anggota\AnggotaController::class, 'detailBuku'])->name('anggota.buku.detail');
        Route::get('/anggota/pinjaman', [\App\Http\Controllers\Anggota\AnggotaController::class, 'pinjaman'])->name('anggota.pinjaman');
        Route::get('/anggota/riwayat', [\App\Http\Controllers\Anggota\AnggotaController::class, 'riwayat'])->name('anggota.riwayat');
        Route::post('/anggota/pinjam', [\App\Http\Controllers\Anggota\AnggotaController::class, 'storeBooking'])->name('anggota.booking.store');
        Route::post('/anggota/pinjaman/{id}/perpanjang', [\App\Http\Controllers\Anggota\AnggotaController::class, 'perpanjang'])->name('anggota.pinjaman.perpanjang');

        // Profile Routes
        Route::get('/anggota/profile', [\App\Http\Controllers\Anggota\AnggotaController::class, 'profile'])->name('anggota.profile');
        Route::put('/anggota/profile', [\App\Http\Controllers\Anggota\AnggotaController::class, 'updateProfile'])->name('anggota.profile.update');

        // Pengajuan Buku Saya
        Route::get('/anggota/pengajuan-saya', [\App\Http\Controllers\Anggota\AnggotaController::class, 'pengajuanBuku'])->name('anggota.pengajuan-buku.index');
        Route::get('/anggota/pengajuan-saya/{id}', [\App\Http\Controllers\Anggota\AnggotaController::class, 'showPengajuan'])->name('anggota.pengajuan-buku.show');

        // Kartu Anggota
        Route::get('/anggota/kartu-anggota', [\App\Http\Controllers\Anggota\AnggotaController::class, 'kartuAnggota'])->name('anggota.kartu-anggota');
    });
});

// API Routes for AJAX calls
Route::get('/api/buku/search', [\App\Http\Controllers\Api\BukuApiController::class, 'search'])->name('api.buku.search');

// Pengajuan Buku - Form Publik (bisa diakses anggota yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/ajukan-buku', [\App\Http\Controllers\PengajuanBukuPublikController::class, 'create'])->name('pengajuan-buku.create');
    Route::post('/ajukan-buku', [\App\Http\Controllers\PengajuanBukuPublikController::class, 'store'])->name('pengajuan-buku.store');

    // Notifikasi Routes
    Route::get('/notifikasi/{id}/buka', [\App\Http\Controllers\NotifikasiController::class, 'buka'])->name('notifikasi.buka');
    Route::patch('/notifikasi/{id}/baca', [\App\Http\Controllers\NotifikasiController::class, 'markAsRead'])->name('notifikasi.baca');
    Route::patch('/notifikasi/baca-semua', [\App\Http\Controllers\NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.baca-semua');
    Route::delete('/notifikasi/{id}', [\App\Http\Controllers\NotifikasiController::class, 'destroy'])->name('notifikasi.hapus');
});
