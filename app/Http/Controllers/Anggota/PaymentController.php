<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Generate Snap Token untuk pembayaran denda.
     * Dipanggil via AJAX dari halaman riwayat/pinjaman anggota.
     */
    public function createSnapToken(Request $request)
    {
        $request->validate([
            'id_denda' => 'required|integer|exists:denda,id_denda',
        ]);

        $denda = Denda::with(['peminjaman.pengguna.anggota', 'peminjaman.buku'])
            ->findOrFail($request->id_denda);

        // Pastikan denda milik user yang sedang login
        if ($denda->peminjaman->id_pengguna !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        // Pastikan belum lunas
        if ($denda->status_pembayaran === 'lunas') {
            return response()->json(['message' => 'Denda ini sudah dilunasi.'], 422);
        }

        $user    = Auth::user();
        $anggota = $user->anggota;
        $buku    = $denda->peminjaman->buku;

        // Pastikan jumlah denda valid (minimal Rp 100)
        $grossAmount = (int) round($denda->jumlah_denda);
        if ($grossAmount < 100) {
            return response()->json(['message' => 'Jumlah denda terlalu kecil untuk diproses via pembayaran digital (minimum Rp 100).'], 422);
        }

        // Order ID unik per denda (agar tidak tabrakan saat retry)
        $orderId = 'DENDA-' . $denda->id_denda . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => [[
                'id'       => 'DENDA-' . $denda->id_denda,
                'price'    => $grossAmount,
                'quantity' => 1,
                'name'     => 'Denda Keterlambatan: ' . ($buku->judul_buku ?? 'Buku'),
            ]],
            'customer_details' => [
                'first_name' => $anggota->nama_lengkap ?? $user->nama_pengguna,
                'email'      => $user->email,
            ],
            // Aktifkan semua channel pembayaran populer
            'enabled_payments' => [
                'credit_card', 'bca_va', 'bni_va', 'bri_va', 'mandiri_bill',
                'permata_va', 'other_va', 'gopay', 'shopeepay', 'qris',
                'indomaret', 'alfamart',
            ],
            'callbacks' => [
                'finish' => route('anggota.pinjaman'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Simpan order_id ke kolom midtrans_order_id di tabel denda
            // (dipakai untuk verifikasi callback)
            $denda->update(['midtrans_order_id' => $orderId]);

            return response()->json([
                'snap_token' => $snapToken,
                'client_key' => config('midtrans.client_key'),
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal membuat token pembayaran. Coba lagi.'], 500);
        }
    }

    /**
     * Handle Notification / Webhook dari server Midtrans.
     * URL ini wajib dikecualikan dari CSRF (lihat VerifyCsrfToken.php).
     */
    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();

            $orderId           = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status;
            $signatureKey      = $notification->signature_key;
            $grossAmount       = $notification->gross_amount;
            $statusCode        = $notification->status_code;

            // === VERIFIKASI SIGNATURE KEY ===
            $expectedSignature = hash(
                'sha512',
                $orderId . $statusCode . $grossAmount . config('midtrans.server_key')
            );

            if ($signatureKey !== $expectedSignature) {
                Log::warning('Midtrans: Invalid signature for order ' . $orderId);
                return response()->json(['message' => 'Invalid signature.'], 403);
            }

            // Cari denda berdasarkan midtrans_order_id
            $denda = Denda::where('midtrans_order_id', $orderId)->first();

            if (!$denda) {
                Log::warning('Midtrans: Denda tidak ditemukan untuk order ' . $orderId);
                return response()->json(['message' => 'Order not found.'], 404);
            }

            // Tentukan status berdasarkan notifikasi Midtrans
            if ($transactionStatus === 'capture' && $fraudStatus === 'accept') {
                // Kartu kredit: capture + accept → lunas
                $denda->update(['status_pembayaran' => 'lunas']);
            } elseif ($transactionStatus === 'settlement') {
                // Transfer bank / GoPay / dll → settlement = lunas
                $denda->update(['status_pembayaran' => 'lunas']);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                // Pembayaran dibatalkan/ditolak/kadaluarsa → tetap belum_bayar
                Log::info("Midtrans: Order {$orderId} status: {$transactionStatus}");
            }

            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error.'], 500);
        }
    }
}
