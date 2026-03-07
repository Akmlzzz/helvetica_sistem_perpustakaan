<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Peminjaman;
use Carbon\Carbon;

class NotifDendaKeterlambatan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notif:denda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi denda keterlambatan buku via Make.com';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Cari peminjaman yang telat (lewat dari tanggal jatuh tempo) dan belum dikembalikan
        $hariIni = Carbon::now()->startOfDay();

        $peminjamanTelat = Peminjaman::with(['buku', 'pengguna']) // Ambil relasi data buku dan user
            ->whereIn('status_transaksi', ['dipinjam', 'terlambat']) // Hanya yang belum kembali
            ->whereDate('tgl_jatuh_tempo', '<', $hariIni)
            ->get();

        if ($peminjamanTelat->isEmpty()) {
            $this->info('Tidak ada anggota yang telat mengembalikan buku hari ini.');
            return;
        }

        // --- PENTING: Ganti URL di bawah ini dengan URL Webhook dari Make.com ---
        $urlMakeCom = 'https://hook.eu1.make.com/2iaoxfsxic1il191chdf3vkcwpxemudl';

        foreach ($peminjamanTelat as $pinjam) {
            // Jika ada pengguna yang tidak memiliki email, lewati.
            if (empty($pinjam->pengguna->email)) {
                $this->warn("Pengguna {$pinjam->pengguna->nama_pengguna} tidak memiliki email.");
                continue;
            }

            // 2. Hitung jumlah keterlambatan (hari) dan denda (misal denda Rp 500 per hari telat)
            $telatHari = Carbon::parse($pinjam->tgl_jatuh_tempo)->startOfDay()->diffInDays($hariIni);
            $totalDenda = $telatHari * 500;

            // 3. Kirim data ke Make.com
            try {
                $response = Http::post($urlMakeCom, [
                    'email_tujuan' => $pinjam->pengguna->email,
                    'nama_anggota' => $pinjam->pengguna->nama_pengguna,
                    'judul_buku' => $pinjam->buku->judul_buku,
                    'tanggal_jatuh_tempo' => Carbon::parse($pinjam->tgl_jatuh_tempo)->format('d M Y'),
                    'jumlah_telat' => $telatHari . ' Hari',
                    'total_denda' => 'Rp ' . number_format($totalDenda, 0, ',', '.')
                ]);

                if ($response->successful()) {
                    $this->info("Berhasil mengirim notif ke: " . $pinjam->pengguna->email);
                } else {
                    $this->error("Gagal mengirim notif ke: " . $pinjam->pengguna->email . " (Cek URL Webhook/Koneksi)");
                }
            } catch (\Exception $e) {
                $this->error("Error saat mengirim ke Make.com: " . $e->getMessage());
            }
        }

        $this->info('Pengecekan denda selesai!');
    }
}
