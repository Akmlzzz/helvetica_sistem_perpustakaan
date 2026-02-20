<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->loadMissing('hakAkses');

        // Fitur yang boleh diakses petugas ini
        $fiturAkses = $user->daftarFiturAkses(); // Collection

        // Statistik untuk stat cards (hanya fitur yang boleh diakses)
        $stats = [];

        if ($fiturAkses->contains('buku')) {
            $stats['buku'] = \App\Models\Buku::count();
        }
        if ($fiturAkses->contains('peminjaman')) {
            $stats['peminjaman_aktif'] = \App\Models\Peminjaman::where('status_transaksi', 'dipinjam')->count();
            $stats['peminjaman_booking'] = \App\Models\Peminjaman::where('status_transaksi', 'booking')->count();
        }
        if ($fiturAkses->contains('denda')) {
            $stats['denda_belum_bayar'] = \App\Models\Denda::where('status_pembayaran', 'belum_bayar')->count();
        }
        if ($fiturAkses->contains('kategori')) {
            $stats['kategori'] = \App\Models\Kategori::count();
        }

        return view('petugas.dashboard', compact('fiturAkses', 'stats'));
    }

    public function booking()
    {
        // Daftar Booking Online
        return view('petugas.booking');
    }

    public function katalog()
    {
        // Katalog Buku (Read Only)
        $buku = \App\Models\Buku::with('kategori')->paginate(10);
        return view('petugas.katalog', compact('buku'));
    }

    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|exists:pengguna,id_pengguna',
            'buku_ids' => 'required|array|min:1',
            'buku_ids.*' => 'exists:buku,id_buku',
            'kode_booking' => 'nullable|string', // Optional if processing from booking
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            // If there's a booking, update it
            if ($request->filled('kode_booking')) {
                $peminjaman = \App\Models\Peminjaman::where('kode_booking', $request->kode_booking)
                    ->where('status_transaksi', 'booking')
                    ->first();

                if ($peminjaman) {
                    $peminjaman->update([
                        'tgl_pinjam' => now(),
                        'tgl_kembali' => now()->addDays(7), // Default 7 days
                        'status_transaksi' => 'dipinjam',
                    ]);
                    return;
                }
            }

            // Direct borrowing
            $kodeBooking = 'BK-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));
            $peminjaman = \App\Models\Peminjaman::create([
                'id_pengguna' => $request->id_pengguna,
                'id_buku' => $request->buku_ids[0], // Simplified for now, or handle multiple
                'kode_booking' => $kodeBooking,
                'tgl_pinjam' => now(),
                'tgl_kembali' => now()->addDays(7),
                'status_transaksi' => 'dipinjam',
            ]);

            foreach ($request->buku_ids as $bukuId) {
                \App\Models\Buku::where('id_buku', $bukuId)->decrement('stok');
                \App\Models\DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_buku' => $bukuId,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Peminjaman berhasil diproses');
    }

    public function returnBuku(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $peminjaman = \App\Models\Peminjaman::findOrFail($request->id_peminjaman);

            // Calculate Denda
            $tglKembali = \Carbon\Carbon::parse($peminjaman->tgl_kembali);
            $now = now();

            if ($now->greaterThan($tglKembali)) {
                $daysLate = $now->diffInDays($tglKembali);
                $fineAmount = $daysLate * 1000; // 1000 per day example

                \App\Models\Denda::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'jumlah_denda' => $fineAmount,
                    'status_pembayaran' => 'belum_bayar',
                ]);
            }

            $peminjaman->update([
                'status_transaksi' => 'dikembalikan',
            ]);

            // Restore stock
            $details = \App\Models\DetailPeminjaman::where('id_peminjaman', $peminjaman->id_peminjaman)->get();
            foreach ($details as $detail) {
                \App\Models\Buku::where('id_buku', $detail->id_buku)->increment('stok');
            }
        });

        return redirect()->back()->with('success', 'Pengembalian berhasil diproses');
    }
}
