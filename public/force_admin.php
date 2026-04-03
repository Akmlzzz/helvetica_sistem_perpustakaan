<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Pengguna;

echo "<style>body{font-family:monospace;padding:20px;} table{border-collapse:collapse;width:100%;} td,th{border:1px solid #ccc;padding:6px 12px;} .ok{color:green;} .fail{color:red;}</style>";
echo "<h2>🔧 Database & Auth Rescue Tool (v2)</h2>";

try {
    // 1. Tampilkan semua tabel yang ada
    echo "<h3>📋 Tabel di Database:</h3><table><tr><th>Nama Tabel</th><th>Status</th></tr>";
    $tables = DB::select('SHOW TABLES');
    $tableNames = array_map(fn($t) => array_values((array)$t)[0], $tables);
    
    // Perbaikan typo nama tabel koleksi_pribadi (biasanya singular di model Laravel)
    $requiredTables = ['pengguna', 'anggota', 'buku', 'kategori', 'peminjaman', 
                       'denda', 'notifikasi', 'pengajuan_buku', 'hero_banners', 
                       'hak_akses', 'koleksi_pribadi', 'ulasan_buku', 'musik', 'series'];
    
    foreach ($requiredTables as $table) {
        $exists = in_array($table, $tableNames);
        echo "<tr><td>{$table}</td><td class='" . ($exists ? 'ok' : 'fail') . "'>" . ($exists ? '✅ Ada' : '❌ TIDAK ADA') . "</td></tr>";
    }
    echo "</table><br>";

    // 2. Cek/Buat Admin
    $admin = Pengguna::where('level_akses', 'admin')->first();
    if (!$admin) {
        echo "<p class='fail'>⚠️ Admin tidak ditemukan. Membuat Admin baru...</p>";
        $admin = Pengguna::create([
            'nama_pengguna' => 'admin',
            'email'         => 'admin@biblio.id',
            'kata_sandi'    => Hash::make('admin123'),
            'level_akses'   => 'admin',
            'status'        => 'active',
        ]);
        echo "<p class='ok'>✅ Admin 'admin' berhasil dibuat dengan password 'admin123'!</p>";
    } else {
        $admin->kata_sandi = Hash::make('admin123');
        $admin->status = 'active';
        $admin->save();
        echo "<p class='ok'>✅ Admin ditemukan. Password direset ke 'admin123' dan dipastikan ACTIVE.</p>";
    }

    // 3. Aktifkan semua user lainnya
    Pengguna::query()->update(['status' => 'active']);
    echo "<p class='ok'>✅ Semua user status diaktifkan.</p>";

    echo "<hr><p class='fail'><b>PENTING: Hapus file public/force_admin.php SETELAH BERHASIL LOGIN!</b></p>";

} catch (\Exception $e) {
    echo "<p class='fail'>ERROR: " . $e->getMessage() . "</p>";
}
