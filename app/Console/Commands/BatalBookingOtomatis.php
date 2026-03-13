<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class BatalBookingOtomatis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:batal-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membatalkan peminjaman berstatus booking yang lewat dari 7 hari.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Cari booking (7 hari yang lalu).
        $bookinganKadaluarsa = Peminjaman::where('status_transaksi', 'booking')
            ->where('tgl_booking', '<=', now()->subDays(7))
            ->with('buku')
            ->get();

        if ($bookinganKadaluarsa->isEmpty()) {
            $this->info('Tidak ada tiket booking kadaluarsa.');
            return;
        }

        DB::transaction(function () use ($bookinganKadaluarsa) {
            foreach ($bookinganKadaluarsa as $item) {
                /** @var \App\Models\Peminjaman $item */
                // 1. Ubah status (biasanya 'batal' atau 'kadaluarsa')
                $item->update(['status_transaksi' => 'batal']);
                
                // 2. Kembalikan stok langsung via relasi
                if ($item->buku) {
                    $item->buku->increment('stok'); 
                }
            }
        });

        $this->info("Berhasil membatalkan {$bookinganKadaluarsa->count()} booking.");
    }
}
