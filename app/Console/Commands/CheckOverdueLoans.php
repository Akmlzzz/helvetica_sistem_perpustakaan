<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckOverdueLoans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loans:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue loans and notify officers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueLoans = \App\Models\Peminjaman::whereIn('status_transaksi', ['dipinjam', 'terlambat'])
            ->whereDate('tgl_jatuh_tempo', '<', now())
            ->with(['pengguna', 'buku'])
            ->get();

        if ($overdueLoans->isEmpty()) {
            $this->info('No overdue loans found.');
            return;
        }

        $petugas = \App\Models\Pengguna::where('level_akses', 'petugas')->get();
        $admin = \App\Models\Pengguna::where('level_akses', 'admin')->get();
        $officers = $petugas->merge($admin);

        foreach ($overdueLoans as $loan) {
            // Update status to 'terlambat' if it's still 'dipinjam'
            if ($loan->status_transaksi === 'dipinjam') {
                $loan->update(['status_transaksi' => 'terlambat']);
            }

            $daysOverdue = now()->diffInDays($loan->tgl_jatuh_tempo);
            
            // Notify officers (Petugas & Admin)
            foreach ($officers as $officer) {
                // Check if notification already exists for today to prevent spam
                $exists = \App\Models\Notifikasi::where('id_pengguna', $officer->id_pengguna)
                    ->where('tipe', 'keterlambatan')
                    ->where('pesan', 'like', "%{$loan->kode_booking}%")
                    ->whereDate('created_at', now())
                    ->exists();

                if (!$exists) {
                    \App\Models\Notifikasi::create([
                        'id_pengguna' => $officer->id_pengguna,
                        'tipe' => 'keterlambatan',
                        'judul' => 'Keterlambatan Pengembalian',
                        'pesan' => "Anggota {$loan->pengguna->nama_pengguna} terlambat {$daysOverdue} hari mengembalikan buku '{$loan->buku->judul_buku}' (Kode: {$loan->kode_booking}).",
                        'sudah_dibaca' => false,
                    ]);
                }
            }

            // Notify Member (Anggota)
             $memberExists = \App\Models\Notifikasi::where('id_pengguna', $loan->id_pengguna)
                ->where('tipe', 'keterlambatan')
                ->where('pesan', 'like', "%{$loan->kode_booking}%")
                ->whereDate('created_at', now())
                ->exists();

            if (!$memberExists) {
                \App\Models\Notifikasi::create([
                    'id_pengguna' => $loan->id_pengguna,
                    'tipe' => 'keterlambatan',
                    'judul' => 'Peringatan Keterlambatan',
                    'pesan' => "Anda terlambat {$daysOverdue} hari mengembalikan buku '{$loan->buku->judul_buku}'. Harap segera kembalikan untuk menghindari denda lebih lanjut.",
                    'sudah_dibaca' => false,
                ]);
            }
        }

        $this->info("Checked " . $overdueLoans->count() . " overdue loans and sent notifications.");
    }
}
