<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\UlasanBuku;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'ulasan' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();
        $anggota = $user->anggota;

        if (!$anggota) {
            return redirect()->back()->with('error', 'Hanya anggota yang terdaftar yang dapat memberikan ulasan.');
        }

        // Cek apakah sudah pernah mengulas buku ini
        $alreadyReviewed = UlasanBuku::where('id_anggota', $anggota->id_anggota)
            ->where('id_buku', $request->id_buku)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk buku ini.');
        }

        UlasanBuku::create([
            'id_anggota' => $anggota->id_anggota,
            'id_buku' => $request->id_buku,
            'ulasan' => $request->ulasan,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan. Terima kasih!');
    }
}
