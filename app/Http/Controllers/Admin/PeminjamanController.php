<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['pengguna.anggota', 'buku', 'detail.buku']);

        // Search by Borrower Name or Book Title (if single) or Code
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pengguna.anggota', function ($subQ) use ($search) {
                    $subQ->where('nama_lengkap', 'like', "%{$search}%");
                })
                    ->orWhereHas('pengguna', function ($subQ) use ($search) {
                        $subQ->where('nama_pengguna', 'like', "%{$search}%");
                    })
                    ->orWhere('kode_booking', 'like', "%{$search}%")
                    ->orWhereHas('detail.buku', function ($subQ) use ($search) {
                        $subQ->where('judul_buku', 'like', "%{$search}%");
                    })
                    ->orWhereHas('buku', function ($subQ) use ($search) {
                        $subQ->where('judul_buku', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_transaksi', $request->status);
        }

        $peminjaman = $query->orderBy('tgl_pinjam', 'desc')->paginate(10);

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['pengguna.anggota', 'buku', 'detail.buku', 'denda'])->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }
}
