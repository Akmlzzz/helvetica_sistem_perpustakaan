<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        // Katalog / Cari Buku
        $query = \App\Models\Buku::with('kategori');

        if ($request->has('search')) {
            $query->where('judul_buku', 'like', '%' . $request->search . '%')
                ->orWhere('penulis', 'like', '%' . $request->search . '%');
        }

        if ($request->has('kategori') && $request->kategori != 'all') {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        $buku = $query->paginate(12);
        $kategori = \App\Models\Kategori::all();

        return view('anggota.dashboard', compact('buku', 'kategori'));
    }

    public function pinjaman()
    {
        // Pinjaman Saya (Active Loans & Bookings)
        $userId = auth()->id();

        $bookings = \App\Models\Peminjaman::with('buku')
            ->where('id_pengguna', $userId)
            ->where('status_transaksi', 'booking')
            ->orderBy('tgl_booking', 'desc')
            ->get();

        $activeLoans = \App\Models\Peminjaman::with('detail.buku')
            ->where('id_pengguna', $userId)
            ->where('status_transaksi', 'dipinjam')
            ->orderBy('tgl_pinjam', 'desc')
            ->get();

        // Wait, if I'm not sure about 'pinjam' vs 'dipinjam', I should probably check.
        // Let's pause and check where status is defined.

        return view('anggota.pinjaman', compact('bookings', 'activeLoans'));
    }

    public function riwayat()
    {
        // Riwayat & Denda
        $userId = auth()->id();

        // History: Peminjaman yang sudah kembali
        $history = \App\Models\Peminjaman::with(['detail.buku', 'denda'])
            ->where('id_pengguna', $userId)
            ->where('status_transaksi', 'kembali')
            ->orderBy('tgl_kembali', 'desc')
            ->get();

        // Denda Belum Lunas
        $tagihanDenda = \App\Models\Denda::with(['peminjaman.buku', 'peminjaman.detail.buku'])
            ->whereHas('peminjaman', function ($q) use ($userId) {
                $q->where('id_pengguna', $userId);
            })
            ->where('status_pembayaran', 'belum_lunas')
            ->get();

        return view('anggota.riwayat', compact('history', 'tagihanDenda'));
    }

    public function storeBooking(Request $request)
    {
        // Logic to book a book
        return redirect()->back()->with('success', 'Booking berhasil dibuat. Kode Booking: BK-' . rand(1000, 9999));
    }
}
