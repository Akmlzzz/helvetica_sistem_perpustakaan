<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\PengajuanBuku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PengajuanBukuController extends Controller
{
    /**
     * Tampilkan semua pengajuan buku (admin)
     */
    public function index(Request $request)
    {
        $query = PengajuanBuku::latest('dibuat_pada');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                    ->orWhere('nama_penulis', 'like', "%{$search}%")
                    ->orWhere('nama_pengusul', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuan = $query->paginate(10)->withQueryString();

        // Tandai semua sebagai sudah dibaca ketika admin membuka halaman ini
        PengajuanBuku::where('sudah_dibaca', false)->update(['sudah_dibaca' => true]);

        return view('admin.pengajuan-buku.index', compact('pengajuan'));
    }

    /**
     * Tampilkan detail satu pengajuan
     */
    public function show($id)
    {
        $pengajuan = PengajuanBuku::findOrFail($id);

        // Tandai sebagai sudah dibaca
        if (!$pengajuan->sudah_dibaca) {
            $pengajuan->update(['sudah_dibaca' => true]);
        }

        return view('admin.pengajuan-buku.show', compact('pengajuan'));
    }

    /**
     * Update status pengajuan (setujui/tolak)
     */
    public function updateStatus(Request $request, $id)
    {
        $pengajuan = PengajuanBuku::findOrFail($id);

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $pengajuan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        $label = $request->status === 'disetujui' ? 'disetujui' : 'ditolak';

        // Kirim notifikasi ke pengguna yang mengajukan (jika ada id_pengguna)
        if ($pengajuan->id_pengguna) {
            $emoji = $request->status === 'disetujui' ? '✅' : '❌';
            $pesanStatus = $request->status === 'disetujui'
                ? "Selamat! Pengajuan buku \"{$pengajuan->judul_buku}\" telah disetujui oleh admin."
                : "Pengajuan buku \"{$pengajuan->judul_buku}\" telah ditolak oleh admin.";

            if ($request->catatan_admin) {
                $pesanStatus .= " Catatan admin: {$request->catatan_admin}";
            }

            Notifikasi::create([
                'id_pengguna' => $pengajuan->id_pengguna,
                'tipe' => 'status_pengajuan',
                'judul' => "{$emoji} Pengajuan Buku " . ucfirst($label),
                'pesan' => $pesanStatus,
                'id_pengajuan' => $pengajuan->id_pengajuan,
                'sudah_dibaca' => false,
            ]);
        }

        return redirect()->route('admin.pengajuan-buku.index')
            ->with('success', "Pengajuan buku \"{$pengajuan->judul_buku}\" telah {$label}.");
    }

    /**
     * Hapus pengajuan
     */
    public function destroy($id)
    {
        $pengajuan = PengajuanBuku::findOrFail($id);
        $judul = $pengajuan->judul_buku;
        $pengajuan->delete();

        return redirect()->route('admin.pengajuan-buku.index')
            ->with('success', "Pengajuan buku \"{$judul}\" berhasil dihapus.");
    }
}

