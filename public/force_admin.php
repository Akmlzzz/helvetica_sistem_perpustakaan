<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Pengguna;

echo "<style>body{font-family:monospace;padding:20px;} table{border-collapse:collapse;width:100%;} td,th{border:1px solid #ccc;padding:6px 12px;} .ok{color:green;} .fail{color:red;}</style>";
echo "<h2>🔧 Database & Auth Rescue Tool</h2>";

try {
    // 1. Tampilkan semua tabel yang ada
    echo "<h3>📋 Tabel di Database:</h3><table><tr><th>Nama Tabel</th><th>Status</th></tr>";
    $tables = DB::select('SHOW TABLES');
    $tableNames = array_map(fn($t) => array_values((array)$t)[0], $tables);
    
    $requiredTables = ['pengguna', 'anggota', 'buku', 'kategori', 'peminjaman', 
                       'denda', 'notifikasi', 'pengajuan_buku', 'hero_banners', 
                       'hak_akses', 'koleksi_pribadis', 'ulasan_buku', 'musik', 'series'];
    
    foreach ($requiredTables as $table) {
        $exists = in_array($table, $tableNames);
        echo "<tr><td>{$table}</td><td class='" . ($exists ? 'ok' : 'fail') . "'>" . ($exists ? '✅ Ada' : '❌ TIDAK ADA') . "</td></tr>";
    }
    echo "</table><br>";

    // 2. Aktifkan semua user
    Pengguna::query()->update(['status' => 'active']);
    echo "<p class='ok'>✅ Semua user status diaktifkan.</p>";

    // 3. Reset password admin
    $admin = Pengguna::where('nama_pengguna', 'admin')->first();
    if ($admin) {
        $admin->kata_sandi = Hash::make('admin123');
        $admin->save();
        echo "<p class='ok'>✅ Password admin direset ke: <b>admin123</b></p>";
    } else {
        echo "<p class='fail'>❌ Akun admin tidak ditemukan!</p>";
    }

    echo "<hr><p class='fail'><b>PENTING: Hapus file public/force_admin.php setelah selesai!</b></p>";

} catch (\Exception $e) {
    echo "<p class='fail'>ERROR: " . $e->getMessage() . "</p>";
}
