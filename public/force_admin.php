<?php

use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

// Bootstrapping Laravel (karena di folder public)
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // 1. Aktifkan semua user (Menyelesaikan "Akses Ditolak" Anggota)
    Pengguna::query()->update(['status' => 'active']);
    echo "- Semua USER status diatur ke ACTIVE.<br>";

    // 2. Reset password Admin ke admin123
    $admin = Pengguna::where('nama_pengguna', 'admin')->first();
    if ($admin) {
        $admin->kata_sandi = Hash::make('admin123');
        $admin->save();
        echo "- Password ADMIN berhasil direset ke: <b>admin123</b><br>";
    } else {
        echo "- Akun admin tidak ditemukan di database.<br>";
    }

    echo "<br><b>Selesai!</b> Silakan coba login lagi.";
    echo "<br><br><span style='color:red'>PENTING: Hapus file public/force_admin.php setelah berhasil login!</span>";

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
