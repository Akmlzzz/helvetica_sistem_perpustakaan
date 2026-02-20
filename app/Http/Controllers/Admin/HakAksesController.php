<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HakAkses;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HakAksesController extends Controller
{
    /**
     * Tampilkan halaman manajemen hak akses semua petugas.
     */
    public function index()
    {
        $petugas = Pengguna::where('level_akses', 'petugas')
            ->with('hakAkses')
            ->orderBy('nama_pengguna')
            ->get();

        $daftarFitur = HakAkses::daftarFitur();

        return view('admin.hak-akses.index', compact('petugas', 'daftarFitur'));
    }

    /**
     * Simpan/update hak akses untuk seorang petugas.
     */
    public function update(Request $request, $id_pengguna)
    {
        // Pastikan yang diupdate hanya petugas
        $user = Pengguna::where('level_akses', 'petugas')
            ->where('id_pengguna', $id_pengguna)
            ->firstOrFail();

        $request->validate([
            'fitur' => 'nullable|array',
            'fitur.*' => 'in:kategori,buku,peminjaman,denda',
        ]);

        DB::beginTransaction();
        try {
            // Hapus semua hak akses lama petugas ini
            HakAkses::where('id_pengguna', $id_pengguna)->delete();

            // Simpan hak akses baru
            $fiturDipilih = $request->input('fitur', []);
            $fiturValid = array_keys(HakAkses::daftarFitur());

            foreach ($fiturDipilih as $fitur) {
                if (in_array($fitur, $fiturValid)) {
                    HakAkses::create([
                        'id_pengguna' => $id_pengguna,
                        'fitur' => $fitur,
                    ]);
                }
            }

            DB::commit();

            $namaFitur = empty($fiturDipilih)
                ? 'tidak ada fitur'
                : implode(', ', array_map('ucfirst', $fiturDipilih));

            return redirect()->route('admin.hak-akses.index')
                ->with('success', "Hak akses {$user->nama_pengguna} berhasil diperbarui: {$namaFitur}.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan hak akses: ' . $e->getMessage()]);
        }
    }

    /**
     * Update satu fitur saja via toggle (AJAX-friendly).
     */
    public function toggle(Request $request, $id_pengguna)
    {
        $user = Pengguna::where('level_akses', 'petugas')
            ->where('id_pengguna', $id_pengguna)
            ->firstOrFail();

        $request->validate([
            'fitur' => 'required|in:kategori,buku,peminjaman,denda',
        ]);

        $fitur = $request->input('fitur');

        $existing = HakAkses::where('id_pengguna', $id_pengguna)
            ->where('fitur', $fitur)
            ->first();

        if ($existing) {
            $existing->delete();
            $status = false;
            $pesan = "Akses '{$fitur}' untuk {$user->nama_pengguna} dicabut.";
        } else {
            HakAkses::create(['id_pengguna' => $id_pengguna, 'fitur' => $fitur]);
            $status = true;
            $pesan = "Akses '{$fitur}' untuk {$user->nama_pengguna} diberikan.";
        }

        if ($request->expectsJson()) {
            return response()->json(['status' => $status, 'pesan' => $pesan]);
        }

        return back()->with('success', $pesan);
    }
}
