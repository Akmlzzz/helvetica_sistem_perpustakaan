<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    protected $table = 'hak_akses';

    protected $fillable = [
        'id_pengguna',
        'fitur',
    ];

    /**
     * Daftar fitur yang tersedia beserta label dan ikonnya.
     */
    public static function daftarFitur(): array
    {
        return [
            'kategori' => [
                'label' => 'Kelola Kategori',
                'deskripsi' => 'Menambah, mengubah, dan menghapus kategori buku',
                'icon' => 'tag',
                'warna' => 'blue',
            ],
            'buku' => [
                'label' => 'Data Buku',
                'deskripsi' => 'Mengelola data buku perpustakaan',
                'icon' => 'book',
                'warna' => 'green',
            ],
            'peminjaman' => [
                'label' => 'Peminjaman',
                'deskripsi' => 'Mengelola transaksi peminjaman buku',
                'icon' => 'swap',
                'warna' => 'purple',
            ],
            'denda' => [
                'label' => 'Denda',
                'deskripsi' => 'Mengelola data denda keterlambatan',
                'icon' => 'money',
                'warna' => 'red',
            ],
            'laporan' => [
                'label' => 'Laporan',
                'deskripsi' => 'Melihat dan mengekspor laporan perpustakaan',
                'icon' => 'report',
                'warna' => 'orange',
            ],
        ];
    }

    // ----------- RELATIONSHIP -----------

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
