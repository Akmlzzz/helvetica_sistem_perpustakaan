<?php

namespace App\Observers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\Http;

class PeminjamanObserver
{
    /**
     * URL Webhook Make.com (Harus menggunakan fitur "Router" nanti di Make.com jika ingin dipisah sheet-nya)
     */
    private $webhookUrl = 'https://hook.eu1.make.com/c3l27bc4597a67hr3bdknqbhsw6636pw';

    /**
     * Terjadi saat baris data Peminjaman baru ditambahkan ke database (Entah itu baru Booking atau langsung Dipinjam)
     */
    public function created(Peminjaman $peminjaman)
    {
        $this->kirimDataKeMakeCom('peminjaman_baru', $peminjaman);
    }

    /**
     * Terjadi saat baris data Peminjaman diupdate (Entah itu dikembalikan atau terlambat)
     */
    public function updated(Peminjaman $peminjaman)
    {
        // Cek apakah status berubah menjadi "dikembalikan"
        if ($peminjaman->isDirty('status_transaksi') && $peminjaman->status_transaksi === 'dikembalikan') {
            $this->kirimDataKeMakeCom('pengembalian_buku', $peminjaman);
        }
    }

    private function kirimDataKeMakeCom($tipeAktivitas, Peminjaman $peminjaman)
    {
        // Sangat penting: Load data relasi dari database agar tidak kosong (null)
        $peminjaman->loadMissing(['pengguna.anggota', 'buku', 'detail.buku']);

        // Ambil judul buku. Jika menggunakan tabel detail (banyak buku), gabungkan judulnya
        $judulBuku = 'Tidak diketahui';
        if ($peminjaman->detail && $peminjaman->detail->count() > 0) {
            $judulBuku = $peminjaman->detail->pluck('buku.judul_buku')->filter()->implode(', ');
        } elseif ($peminjaman->buku) {
            $judulBuku = $peminjaman->buku->judul_buku;
        }

        Http::post($this->webhookUrl, [
            'jenis_tabel' => 'tabel_peminjaman',
            'jenis_aktivitas' => $tipeAktivitas,
            'waktu_update' => now()->timezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            'kode_booking' => $peminjaman->kode_booking ?? '-',
            'nama_anggota' => optional(optional($peminjaman->pengguna)->anggota)->nama_lengkap ?? optional($peminjaman->pengguna)->nama_pengguna ?? 'Tidak diketahui',
            'judul_buku' => $judulBuku,
            'status' => $peminjaman->status_transaksi ?? '-'
        ]);
    }
}
