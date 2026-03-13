<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingApiController extends Controller
{
    /**
     * Store Booking (Pinjam Buku) via AJAX
     */
    public function storeBooking(\App\Http\Requests\StoreBookingRequest $request)
    {
        // Cek status verifikasi akun anggota
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();
        if ($user->status !== 'active') {
            $pesan = match ($user->status) {
                'pending' => 'Akun Anda belum diverifikasi oleh admin. Silakan tunggu proses verifikasi.',
                'rejected' => 'Akun Anda ditolak oleh admin. Hubungi petugas untuk informasi lebih lanjut.',
                default => 'Akun Anda tidak dapat melakukan peminjaman saat ini.',
            };
            return response()->json(['success' => false, 'message' => $pesan]);
        }

        // Cek apakah anggota memiliki denda yang belum dibayar
        $adaDendaBelumLunas = \App\Models\Denda::whereHas('peminjaman', function ($query) use ($user) {
            $query->where('id_pengguna', $user->id_pengguna);
        })->where('status_pembayaran', 'belum_lunas')->exists();

        if ($adaDendaBelumLunas) {
            return response()->json(['success' => false, 'message' => 'Peminjaman ditolak! Anda memiliki tagihan denda yang belum dilunasi.']);
        }

        // Cek apakah ada buku yang sedang dipinjam tapi sudah lewat jatuh tempo (terlambat)
        $adaPeminjamanTerlambat = \App\Models\Peminjaman::where('id_pengguna', $user->id_pengguna)
            ->where(function($q) {
                $q->where('status_transaksi', 'terlambat')
                  ->orWhere(function($sq) {
                      $sq->where('status_transaksi', 'dipinjam')
                         ->whereDate('tgl_jatuh_tempo', '<', \Carbon\Carbon::today());
                  });
            })->exists();

        if ($adaPeminjamanTerlambat) {
            return response()->json(['success' => false, 'message' => 'Peminjaman ditolak! Anda memiliki buku yang terlambat dikembalikan.']);
        }

        $validated = $request->validated();
        $kodeBookingTersimpan = null;
        try {
            DB::transaction(function () use ($validated, &$kodeBookingTersimpan) {
                // 1. Kunci baris buku eksklusif dengan lockForUpdate untuk mencegah race condition
                $buku = Buku::where('id_buku', $validated['id_buku'])
                            ->lockForUpdate()
                            ->firstOrFail();

                if ($buku->stok <= 0) {
                    throw new \Exception('Maaf, buku ini baru saja dipinjam orang lain (Stok Habis).');
                }

                // Cek apakah sudah pinjam buku ini
                $sudahPinjam = Peminjaman::where('id_pengguna', Auth::id())
                    ->where('id_buku', $validated['id_buku'])
                    ->whereIn('status_transaksi', ['booking', 'dipinjam'])
                    ->exists();

                if ($sudahPinjam) {
                    throw new \Exception('Anda sudah meminjam buku ini.');
                }

                // 2. Kurangi stok secara aman
                $buku->decrement('stok');

                $kodeBooking = Peminjaman::generateKodeBooking();
                $durasi = (int) $validated['durasi_pinjam'];
                $tglPinjam = Carbon::today();
                $tglJatuhTempo = $tglPinjam->copy()->addDays($durasi);

                // 3. Masukkan ke database
                Peminjaman::create([
                    'id_pengguna' => Auth::id(),
                    'id_buku' => $buku->id_buku,
                    'kode_booking' => $kodeBooking,
                    'tgl_booking' => $tglPinjam,
                    'tgl_pinjam' => $tglPinjam,
                    'durasi_pinjam' => $durasi,
                    'tgl_jatuh_tempo' => $tglJatuhTempo,
                    'status_transaksi' => 'booking',
                ]);
                
                $kodeBookingTersimpan = $kodeBooking;
            });

            return response()->json([
                'success' => true, 
                'message' => "Booking berhasil! Kode Booking: {$kodeBookingTersimpan}.",
                'redirect' => route('anggota.pinjaman')
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
