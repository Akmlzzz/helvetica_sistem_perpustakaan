<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Buka notifikasi: tandai dibaca lalu redirect ke halaman terkait
     */
    public function buka($id)
    {
        $notifikasi = Notifikasi::where('id_notifikasi', $id)
            ->where('id_pengguna', Auth::id())
            ->firstOrFail();

        $notifikasi->update(['sudah_dibaca' => true]);

        $user = Auth::user();

        if ($notifikasi->id_pengajuan) {
            if ($user->isAdmin()) {
                return redirect()->route('admin.pengajuan-buku.show', $notifikasi->id_pengajuan);
            }
            // Anggota: arahkan ke detail pengajuan miliknya
            return redirect()->route('anggota.pengajuan-buku.show', $notifikasi->id_pengajuan);
        }

        return redirect()->back();
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead(Request $request, $id)
    {
        $notifikasi = Notifikasi::where('id_notifikasi', $id)
            ->where('id_pengguna', Auth::id())
            ->firstOrFail();

        $notifikasi->update(['sudah_dibaca' => true]);

        return redirect()->back();
    }

    /**
     * Tandai semua notifikasi user sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        Notifikasi::where('id_pengguna', Auth::id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        return redirect()->back();
    }

    /**
     * Hapus notifikasi
     */
    public function destroy($id)
    {
        $notifikasi = Notifikasi::where('id_notifikasi', $id)
            ->where('id_pengguna', Auth::id())
            ->firstOrFail();

        $notifikasi->delete();

        return redirect()->back();
    }
}
