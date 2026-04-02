<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

try {
    $admin = Pengguna::where('level_akses', 'admin')->first();
    
    if (!$admin) {
        echo "TIdak ada User Admin di database!\n";
    } else {
        echo "Admin Ditemukan: " . $admin->nama_pengguna . " (Email: " . $admin->email . ")\n";
        echo "Level Akses: " . $admin->level_akses . "\n";
        echo "Status: " . $admin->status . "\n";
        
        // Test password 'admin123' (atau ganti sesuai password admin Anda)
        $testPass = 'admin123'; 
        if (Hash::check($testPass, $admin->kata_sandi)) {
            echo "Password '" . $testPass . "' COCOK!\n";
        } else {
            echo "Password '" . $testPass . "' SALAH (Hash tidak cocok)!\n";
        }
    }
} catch (\Exception $e) {
    echo "ERROR DATABASE: " . $e->getMessage() . "\n";
}
