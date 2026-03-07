<?php

namespace App\Observers;

use App\Models\Buku;
use Illuminate\Support\Facades\Http;

class BukuObserver
{
    /**
     * URL Webhook Make.com (Harus menggunakan fitur "Router" nanti di Make.com jika ingin dipisah sheet-nya)
     */
    private $webhookUrl = 'https://hook.eu1.make.com/c3l27bc4597a67hr3bdknqbhsw6636pw';

    /**
     * Terjadi saat baris data Buku baru ditambahkan ke database
     */
    public function created(Buku $buku)
    {
        Http::post($this->webhookUrl, [
            'jenis_tabel' => 'tabel_buku', // Sebagai penanda buat Router Make.com
            'jenis_aktivitas' => 'buku_baru',
            'waktu_update' => now()->format('Y-m-d H:i:s'),
            'judul_buku' => $buku->judul_buku,
            'penulis' => $buku->penulis ?? '-',
            'penerbit' => $buku->penerbit ?? '-',
            'stok' => $buku->stok,
            'kategori' => '-' // Opsional (karena kategori ada di tabel relasi pivot jika banyak)
        ]);
    }

    /**
     * Opsional jika ingin melacak perubahan buku juga bisa gunakan updated()
     */
    public function updated(Buku $buku)
    {
        // ... (Bisa ditambah nanti jika butuh melacak update info buku)
    }
}
