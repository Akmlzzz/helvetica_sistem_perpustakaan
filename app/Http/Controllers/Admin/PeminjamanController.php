<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['pengguna', 'detail.buku']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_booking', 'like', "%{$search}%")
                    ->orWhereHas('pengguna', function ($q) use ($search) {
                        $q->where('nama_pengguna', 'like', "%{$search}%")
                            ->orWhereHas('anggota', function ($q) use ($search) {
                                $q->where('nama_lengkap', 'like', "%{$search}%");
                            });
                    })
                    ->orWhereHas('buku', function ($q) use ($search) {
                        $q->where('judul_buku', 'like', "%{$search}%");
                    })
                    ->orWhereHas('detail.buku', function ($q) use ($search) {
                        $q->where('judul_buku', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status_transaksi', $request->status);
        }

        // Sort
        if ($request->has('sort')) {
            if ($request->sort == 'terbaru') {
                $query->orderBy('tgl_pinjam', 'desc');
            } elseif ($request->sort == 'terlama') {
                $query->orderBy('tgl_pinjam', 'asc');
            } elseif ($request->sort == 'az') {
                $query->join('pengguna', 'peminjaman.id_pengguna', '=', 'pengguna.id_pengguna')
                    ->leftJoin('anggota', 'pengguna.id_pengguna', '=', 'anggota.id_pengguna')
                    ->select('peminjaman.*')
                    ->orderByRaw('COALESCE(anggota.nama_lengkap, pengguna.nama_pengguna) ASC');
            } else {
                $query->orderBy('tgl_pinjam', 'desc');
            }
        } else {
            $query->orderBy('tgl_pinjam', 'desc');
        }

        $peminjaman = $query->paginate(10);

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        // Generate unique kode booking
        $kodeBooking = 'BK-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // Get all anggota (users with role anggota)
        $anggota = Pengguna::where('level_akses', 'anggota')->get();

        return view('admin.peminjaman.create', compact('kodeBooking', 'anggota'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_booking' => 'required|unique:peminjaman,kode_booking',
            'id_pengguna' => 'required|exists:pengguna,id_pengguna',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
            'buku_ids' => 'required|array|min:1',
            'buku_ids.*' => 'exists:buku,id_buku',
        ]);

        // Validate stock for all books
        foreach ($request->buku_ids as $bukuId) {
            $buku = Buku::find($bukuId);
            if ($buku->stok <= 0) {
                return back()->withErrors(['error' => "Stok buku '{$buku->judul_buku}' tidak tersedia!"])->withInput();
            }
        }

        // Create peminjaman
        $peminjaman = Peminjaman::create([
            'kode_booking' => $request->kode_booking,
            'id_pengguna' => $request->id_pengguna,
            'tgl_booking' => now(),
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali' => $request->tgl_kembali,
            'status_transaksi' => 'dipinjam',
        ]);

        // Create detail peminjaman and decrease stock
        foreach ($request->buku_ids as $bukuId) {
            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_buku' => $bukuId,
            ]);

            // Decrease book stock
            $buku = Buku::find($bukuId);
            $buku->decrement('stok');
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibuat!');
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['pengguna', 'detail.buku', 'denda'])->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }
}
