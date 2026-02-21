<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Notifikasi;
use App\Models\Pengguna;
use App\Models\PengajuanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanBukuPublikController extends Controller
{
    /**
     * Tampilkan form pengajuan buku publik
     */
    public function create()
    {
        $kategoriList = Kategori::orderBy('nama_kategori')->get();
        return view('pengajuan-buku.create', compact('kategoriList'));
    }

    /**
     * Simpan pengajuan buku dari form publik
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_buku' => 'required|string|max:255',
            'nama_penulis' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer|min:1800|max:' . date('Y'),
            'kategori' => 'nullable|string|max:100',
            'nama_pengusul' => 'required|string|max:255',
            'alasan_pengusulan' => 'required|string|min:10',
        ], [
            'judul_buku.required' => 'Judul buku wajib diisi.',
            'nama_penulis.required' => 'Nama penulis wajib diisi.',
            'nama_pengusul.required' => 'Nama pengusul wajib diisi.',
            'alasan_pengusulan.required' => 'Alasan pengusulan wajib diisi.',
            'alasan_pengusulan.min' => 'Alasan pengusulan minimal 10 karakter.',
            'tahun_terbit.min' => 'Tahun terbit tidak valid.',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh melebihi tahun ini.',
        ]);

        // Simpan id pengguna yang mengajukan
        $validated['id_pengguna'] = Auth::id();

        $pengajuan = PengajuanBuku::create($validated);

        // Kirim notifikasi ke semua admin
        $adminList = Pengguna::where('level_akses', 'admin')->get();
        foreach ($adminList as $admin) {
            Notifikasi::create([
                'id_pengguna' => $admin->id_pengguna,
                'tipe' => 'pengajuan_baru',
                'judul' => 'Pengajuan Buku Baru',
                'pesan' => "Pengguna \"{$validated['nama_pengusul']}\" mengajukan buku \"{$validated['judul_buku']}\".",
                'id_pengajuan' => $pengajuan->id_pengajuan,
                'sudah_dibaca' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Terima kasih! Pengajuan buku Anda berhasil dikirim dan akan segera diproses oleh admin.');
    }
}

