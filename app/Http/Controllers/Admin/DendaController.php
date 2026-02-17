<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Denda::with(['peminjaman.pengguna.anggota', 'peminjaman.buku', 'peminjaman.detail.buku']);

        // Search by Borrower Name or Book Title via Peminjaman
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('peminjaman', function ($q) use ($search) {
                $q->whereHas('pengguna.anggota', function ($subQ) use ($search) {
                    $subQ->where('nama_lengkap', 'like', "%{$search}%");
                })
                    ->orWhereHas('pengguna', function ($subQ) use ($search) {
                        $subQ->where('nama_pengguna', 'like', "%{$search}%");
                    })
                    ->orWhere('kode_booking', 'like', "%{$search}%")
                    ->orWhereHas('buku', function ($subQ) use ($search) {
                        $subQ->where('judul_buku', 'like', "%{$search}%");
                    })
                    ->orWhereHas('detail.buku', function ($subQ) use ($search) {
                        $subQ->where('judul_buku', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by Peminjaman Status (Dipinjam/Telat)
        if ($request->has('status') && $request->status != '') {
            $query->whereHas('peminjaman', function ($q) use ($request) {
                $q->where('status_transaksi', $request->status);
            });
        }

        // Sort
        if ($request->has('sort')) {
            if ($request->sort == 'terbaru') {
                $query->orderBy('dibuat_pada', 'desc');
            } elseif ($request->sort == 'terlama') {
                $query->orderBy('dibuat_pada', 'asc');
            } elseif ($request->sort == 'az') {
                $query->join('peminjaman', 'denda.id_peminjaman', '=', 'peminjaman.id_peminjaman')
                    ->join('pengguna', 'peminjaman.id_pengguna', '=', 'pengguna.id_pengguna')
                    ->leftJoin('anggota', 'pengguna.id_pengguna', '=', 'anggota.id_pengguna')
                    ->select('denda.*')
                    ->orderByRaw('COALESCE(anggota.nama_lengkap, pengguna.nama_pengguna) ASC');
            } else {
                $query->orderBy('dibuat_pada', 'desc');
            }
        } else {
            $query->orderBy('dibuat_pada', 'desc');
        }

        $denda = $query->paginate(10);

        return view('admin.denda.index', compact('denda'));
    }

    public function show($id)
    {
        $denda = Denda::with(['peminjaman.pengguna.anggota', 'peminjaman.buku', 'peminjaman.detail.buku'])->findOrFail($id);
        return view('admin.denda.show', compact('denda'));
    }
}
