<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KoleksiPribadi;
use App\Models\Buku;
use App\Models\Series;
use Illuminate\Support\Facades\Auth;

class KoleksiPribadiController extends Controller
{
    public function index()
    {
        $koleksi = KoleksiPribadi::with(['buku.kategori', 'buku.peminjamanAktif'])
            ->where('id_pengguna', Auth::user()->id_pengguna)
            ->latest()
            ->get();

        return view('anggota.koleksi.index', compact('koleksi'));
    }

    public function store(Request $request, $id_buku)
    {
        $buku = Buku::findOrFail($id_buku);
        $id_pengguna = Auth::user()->id_pengguna;

        // Check if already in wishlist
        $exists = KoleksiPribadi::where('id_pengguna', $id_pengguna)
            ->where('id_buku', $id_buku)
            ->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Buku sudah ada di daftar koleksi/wishlist Anda.']);
            }
            return redirect()->back()->with('error', 'Buku sudah ada di daftar koleksi/wishlist Anda.');
        }

        KoleksiPribadi::create([
            'id_pengguna' => $id_pengguna,
            'id_buku' => $id_buku,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Buku berhasil ditambahkan ke koleksi/wishlist.']);
        }

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke koleksi/wishlist.');
    }

    public function storeFromSeries(Request $request, $id_series)
    {
        $series = Series::with('buku')->findOrFail($id_series);
        $id_pengguna = Auth::user()->id_pengguna;
        $added = 0;

        foreach ($series->buku as $buku) {
            $exists = KoleksiPribadi::where('id_pengguna', $id_pengguna)
                ->where('id_buku', $buku->id_buku)
                ->exists();

            if (!$exists) {
                KoleksiPribadi::create([
                    'id_pengguna' => $id_pengguna,
                    'id_buku' => $buku->id_buku,
                ]);
                $added++;
            }
        }

        if ($added === 0) {
            return redirect()->back()->with('error', 'Semua buku dalam seri ini sudah ada di koleksi Anda.');
        }

        return redirect()->back()->with('success', "{$added} buku dari seri '{$series->nama_series}' berhasil ditambahkan ke koleksi.");
    }

    public function destroy(Request $request, $id_buku)
    {
        $id_pengguna = Auth::user()->id_pengguna;

        $koleksi = KoleksiPribadi::where('id_pengguna', $id_pengguna)
            ->where('id_buku', $id_buku)
            ->firstOrFail();

        $koleksi->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Buku berhasil dihapus dari koleksi/wishlist.']);
        }

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari koleksi/wishlist.');
    }
}
