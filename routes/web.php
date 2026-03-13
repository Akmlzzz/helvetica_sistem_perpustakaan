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
            $now = \Carbon\Carbon::now();
            $lastWeek = \Carbon\Carbon::now()->subWeek();

            // === STAT CARDS ===
            $totalBuku = \App\Models\Buku::count();
            $totalBukuLastWeek = \App\Models\Buku::where('dibuat_pada', '<', $lastWeek)->count();
            $bukuTrend = $totalBukuLastWeek > 0 ? round((($totalBuku - $totalBukuLastWeek) / $totalBukuLastWeek) * 100) : 0;

            $totalAnggota = \App\Models\Pengguna::where('level_akses', 'anggota')->count();
            $anggotaLastWeek = \App\Models\Pengguna::where('level_akses', 'anggota')->where('dibuat_pada', '<', $lastWeek)->count();
            $anggotaTrend = $anggotaLastWeek > 0 ? round((($totalAnggota - $anggotaLastWeek) / $anggotaLastWeek) * 100) : 0;

            $totalPeminjaman = \App\Models\Peminjaman::whereIn('status_transaksi', ['dipinjam', 'booking'])->count();
            $peminjamanLastWeek = \App\Models\Peminjaman::whereIn('status_transaksi', ['dipinjam', 'booking'])->where('dibuat_pada', '<', $lastWeek)->count();
            $peminjamanTrend = $peminjamanLastWeek > 0 ? round((($totalPeminjaman - $peminjamanLastWeek) / $peminjamanLastWeek) * 100) : 0;

            $totalTerlambat = \App\Models\Peminjaman::whereIn('status_transaksi', ['dipinjam', 'terlambat'])
                ->where(function($q) use ($now) {
                    $q->whereNotNull('tgl_jatuh_tempo')->where('tgl_jatuh_tempo', '<', $now->toDateString());
                })->count();
            $terlambatLastWeek = \App\Models\Peminjaman::whereIn('status_transaksi', ['dipinjam', 'terlambat'])
                ->where(function($q) use ($lastWeek) {
                    $q->whereNotNull('tgl_jatuh_tempo')->where('tgl_jatuh_tempo', '<', $lastWeek->toDateString());
                })->count();
            $terlambatTrend = $terlambatLastWeek > 0 ? round((($totalTerlambat - $terlambatLastWeek) / $terlambatLastWeek) * 100) : 0;

            // === DONUT CHART: Top 6 Kategori ===
            $kategoriData = \App\Models\Kategori::withCount('buku')->orderByDesc('buku_count')->take(6)->get();

            // === BAR CHART: Peminjaman 7 hari terakhir ===
            $weeklyData = collect();
            for ($i = 6; $i >= 0; $i--) {
                $day = \Carbon\Carbon::now()->subDays($i);
                $count = \App\Models\Peminjaman::whereDate('tgl_pinjam', $day->toDateString())->count();
                $weeklyData->push(['label' => $day->translatedFormat('D'), 'count' => $count, 'date' => $day->format('d/m')]);
            }

            // === RECENT PEMINJAMAN ===
            $latestPeminjaman = \App\Models\Peminjaman::with(['pengguna.anggota', 'buku'])
                ->whereNotNull('tgl_pinjam')
                ->latest('tgl_pinjam')
                ->take(6)
                ->get();

            return view('dashboard', compact(
                'totalBuku', 'bukuTrend',
                'totalAnggota', 'anggotaTrend',
                'totalPeminjaman', 'peminjamanTrend',
                'totalTerlambat', 'terlambatTrend',
                'kategoriData', 'weeklyData',
                'latestPeminjaman'
            ));
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

        // Hero Banner Management
        Route::resource('hero-banners', \App\Http\Controllers\Admin\HeroBannerController::class)->names('admin.hero-banners');
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

        // Series Buku
        Route::get('/series', [\App\Http\Controllers\Admin\SeriesController::class, 'index'])->name('admin.series.index');
        Route::get('/series/{id}', [\App\Http\Controllers\Admin\SeriesController::class, 'show'])->name('admin.series.show');
        Route::post('/series', [\App\Http\Controllers\Admin\SeriesController::class, 'store'])->name('admin.series.store');
        Route::put('/series/{id}', [\App\Http\Controllers\Admin\SeriesController::class, 'update'])->name('admin.series.update');
        Route::delete('/series/{id}', [\App\Http\Controllers\Admin\SeriesController::class, 'destroy'])->name('admin.series.destroy');
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
        Route::get('/petugas/katalog', [\App\Http\Controllers\Petugas\PetugasController::class, 'katalog'])->name('petugas.katalog');
        Route::post('/petugas/proses-booking', [\App\Http\Controllers\Petugas\PetugasController::class, 'prosesBooking'])->name('petugas.booking.proses');
        Route::post('/petugas/pengembalian', [\App\Http\Controllers\Petugas\PetugasController::class, 'returnBuku'])->name('petugas.pengembalian.store');
        // Halaman terpisah untuk Proses Booking & Pengembalian
        Route::get('/petugas/booking', [\App\Http\Controllers\Petugas\PetugasController::class, 'bookingPage'])->name('petugas.booking.index');
        Route::get('/petugas/pengembalian', [\App\Http\Controllers\Petugas\PetugasController::class, 'pengembalianPage'])->name('petugas.pengembalian.index');
    });

    // =========================================================
    // ANGGOTA Routes
    // =========================================================
    Route::middleware([\App\Http\Middleware\AnggotaMiddleware::class])->group(function () {
        Route::get('/anggota/dashboard', [\App\Http\Controllers\Anggota\AnggotaController::class, 'index'])->name('anggota.dashboard');
        Route::get('/anggota/buku/{id}', [\App\Http\Controllers\Anggota\AnggotaController::class, 'detailBuku'])->name('anggota.buku.detail');
        Route::get('/anggota/series/{id}', [\App\Http\Controllers\Anggota\AnggotaController::class, 'detailSeries'])->name('anggota.series.detail');
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

        // Koleksi Pribadi (Wishlist)
        Route::get('/anggota/koleksi', [\App\Http\Controllers\Anggota\KoleksiPribadiController::class, 'index'])->name('anggota.koleksi.index');
        Route::post('/anggota/koleksi/{id_buku}', [\App\Http\Controllers\Anggota\KoleksiPribadiController::class, 'store'])->name('anggota.koleksi.store');
        Route::post('/anggota/koleksi/series/{id_series}', [\App\Http\Controllers\Anggota\KoleksiPribadiController::class, 'storeFromSeries'])->name('anggota.koleksi.store-series');
        Route::delete('/anggota/koleksi/{id_buku}', [\App\Http\Controllers\Anggota\KoleksiPribadiController::class, 'destroy'])->name('anggota.koleksi.destroy');

        // Ulasan Buku
        Route::post('/anggota/ulasan', [\App\Http\Controllers\Anggota\UlasanController::class, 'store'])->name('anggota.ulasan.store');
    });
});

// API Routes for AJAX calls
Route::get('/api/buku/search', [\App\Http\Controllers\Api\BukuApiController::class, 'search'])->name('api.buku.search');
Route::post('/api/booking', [\App\Http\Controllers\Api\BookingApiController::class, 'storeBooking'])->name('api.booking.store')->middleware(['auth', \App\Http\Middleware\AnggotaMiddleware::class]);

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

// AI Chatbot Routes
Route::middleware('auth')->group(function () {
    Route::post('/api/ai/chat', [\App\Http\Controllers\AiChatController::class, 'chat'])->name('api.ai.chat');
    Route::post('/api/ai/summary', [\App\Http\Controllers\AiChatController::class, 'summary'])->name('api.ai.summary');
});

// Music Player Management (Admin only)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/musik', [\App\Http\Controllers\Admin\MusikController::class, 'index'])->name('musik.index');
    Route::post('/musik', [\App\Http\Controllers\Admin\MusikController::class, 'store'])->name('musik.store');
    Route::put('/musik/{musik}', [\App\Http\Controllers\Admin\MusikController::class, 'update'])->name('musik.update');
    Route::delete('/musik/{musik}', [\App\Http\Controllers\Admin\MusikController::class, 'destroy'])->name('musik.destroy');
    Route::patch('/musik/{musik}/toggle', [\App\Http\Controllers\Admin\MusikController::class, 'toggleAktif'])->name('musik.toggle');
});

// Public API: get active tracks for music player
Route::get('/api/musik', function () {
    return response()->json(
        \App\Models\Musik::aktif()->get()->map(fn($m) => [
            'judul' => $m->judul,
            'artis' => $m->artis,
            'url' => $m->audio_url, // accessor: prioritas file upload > URL
        ])
    );
})->name('api.musik');
