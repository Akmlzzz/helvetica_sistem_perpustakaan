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
            ->where('status_transaksi', 'dikembalikan')
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
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
        ]);

        $buku = \App\Models\Buku::findOrFail($request->id_buku);

        if ($buku->stok <= 0) {
            return redirect()->back()->with('error', 'Stok buku tidak tersedia.');
        }

        // Generate unique kode booking
        $kodeBooking = 'BK-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $kodeBooking) {
            \App\Models\Peminjaman::create([
                'id_pengguna' => auth()->id(),
                'id_buku' => $request->id_buku,
                'kode_booking' => $kodeBooking,
                'tgl_booking' => now(),
                'status_transaksi' => 'booking',
            ]);

            // Optional: Decrement stock immediately on booking? 
            // Usually booking reserves stock.
            \App\Models\Buku::where('id_buku', $request->id_buku)->decrement('stok');
        });

        return redirect()->route('anggota.pinjaman')->with('success', 'Booking berhasil dibuat. Kode Booking: ' . $kodeBooking);
    }

    public function profile()
    {
        $user = auth()->user();
        $anggota = $user->anggota;
        return view('anggota.profile', compact('user', 'anggota'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $anggota = $user->anggota;

        $request->validate([
            'email' => 'required|email|unique:pengguna,email,' . $user->id_pengguna . ',id_pengguna',
            'nama_pengguna' => 'required|unique:pengguna,nama_pengguna,' . $user->id_pengguna . ',id_pengguna',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'password' => 'nullable|min:6',
        ]);

        // Update Pengguna
        $user->email = $request->email;
        $user->nama_pengguna = $request->nama_pengguna;
        if ($request->filled('password')) {
            $user->kata_sandi = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $user->save();

        // Update Anggota
        $anggota->nama_lengkap = $request->nama_lengkap;
        $anggota->alamat = $request->alamat;
        $anggota->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
