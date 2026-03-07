<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$url = 'https://hook.eu1.make.com/c3l27bc4597a67hr3bdknqbhsw6636pw';

// KIta kirim 1 Skenario data "Super Gabungan" agar Make.com langsung menghafal SELURUH nama variabel buku & peminjaman sekaligus.
Illuminate\Support\Facades\Http::post($url, [
    'jenis_tabel' => 'tabel_buku',
    'jenis_aktivitas' => 'buku_baru',
    'waktu_update' => now()->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'),

    // Variabel Peminjaman
    'kode_booking' => 'BK-20260307-ABCD',
    'nama_anggota' => 'Budi Tester',
    'status' => 'dipinjam',

    // Variabel Buku
    'judul_buku' => 'Tutorial Laravue Full',
    'penulis' => 'Taylor Otwell',
    'penerbit' => 'IT Pustaka',
    'stok' => 15,
    'kategori' => 'Teknologi'
]);

echo "Berhasil mengirim data komplit ke Make.com!";
