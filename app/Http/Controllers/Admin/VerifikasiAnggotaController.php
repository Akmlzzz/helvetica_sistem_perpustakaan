<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class VerifikasiAnggotaController extends Controller
{
    /**
     * Display a listing of pending members.
     */
    public function index(Request $request)
    {
        $query = Pengguna::with('anggota')
            ->where('level_akses', 'anggota')
            ->where('status', 'pending');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pengguna', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('anggota', function($subQuery) use ($search) {
                      $subQuery->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nomor_telepon', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by registration date
        if ($request->filled('tanggal_daftar')) {
            switch($request->tanggal_daftar) {
                case 'hari_ini':
                    $query->whereDate('dibuat_pada', now());
                    break;
                case 'minggu_ini':
                    $query->whereBetween('dibuat_pada', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'bulan_ini':
                    $query->whereMonth('dibuat_pada', now()->month)
                          ->whereYear('dibuat_pada', now()->year);
                    break;
                case 'tahun_ini':
                    $query->whereYear('dibuat_pada', now()->year);
                    break;
            }
        }

        // Sort functionality
        $sort = $request->get('sort', 'terbaru');
        switch($sort) {
            case 'terlama':
                $query->oldest('dibuat_pada');
                break;
            case 'nama_az':
                $query->orderBy('nama_pengguna', 'asc');
                break;
            case 'nama_za':
                $query->orderBy('nama_pengguna', 'desc');
                break;
            default: // terbaru
                $query->latest('dibuat_pada');
                break;
        }

        $pendingMembers = $query->paginate(10)->withQueryString();

        return view('admin.verifikasi-anggota.index', compact('pendingMembers'));
    }

    /**
     * Show the details of a pending member.
     */
    public function show($id)
    {
        $member = Pengguna::with('anggota')
            ->where('level_akses', 'anggota')
            ->findOrFail($id);

        return view('admin.verifikasi-anggota.show', compact('member'));
    }

    /**
     * Approve a pending member.
     */
    public function approve($id)
    {
        $member = Pengguna::where('level_akses', 'anggota')
            ->findOrFail($id);

        if ($member->status !== 'pending') {
            return back()->with('error', 'Hanya anggota dengan status pending yang dapat disetujui.');
        }

        $member->approve();

        return redirect()->route('admin.verifikasi-anggota.index')
            ->with('success', "Anggota {$member->nama_pengguna} telah disetujui dengan nomor anggota: {$member->nomor_anggota}");
    }

    /**
     * Reject a pending member.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:500'
        ]);

        $member = Pengguna::where('level_akses', 'anggota')
            ->findOrFail($id);

        if ($member->status !== 'pending') {
            return back()->with('error', 'Hanya anggota dengan status pending yang dapat ditolak.');
        }

        $member->reject();

        // Optional: Store rejection reason in notifications or logs
        // For now, we'll just flash it to session
        session()->flash('rejection_reason', [
            'member' => $member->nama_pengguna,
            'reason' => $request->alasan_penolakan
        ]);

        return redirect()->route('admin.verifikasi-anggota.index')
            ->with('success', "Anggota {$member->nama_pengguna} telah ditolak.");
    }

    /**
     * Display all members with their status.
     */
    public function allMembers()
    {
        $members = Pengguna::with('anggota')
            ->where('level_akses', 'anggota')
            ->latest('dibuat_pada')
            ->paginate(15);

        return view('admin.verifikasi-anggota.all', compact('members'));
    }

    /**
     * Toggle member status (active/rejected).
     */
    public function toggleStatus(Request $request, $id)
    {
        $member = Pengguna::where('level_akses', 'anggota')
            ->findOrFail($id);

        if ($member->status === 'active') {
            $member->status = 'rejected';
            $message = "Status anggota {$member->nama_pengguna} diubah menjadi ditolak.";
        } elseif ($member->status === 'rejected') {
            if ($member->nomor_anggota) {
                $member->status = 'active';
                $message = "Status anggota {$member->nama_pengguna} diubah menjadi aktif.";
            } else {
                $member->approve();
                $message = "Status anggota {$member->nama_pengguna} diubah menjadi aktif dengan nomor: {$member->nomor_anggota}";
            }
        } else {
            return back()->with('error', 'Tidak dapat mengubah status pending dari sini. Gunakan menu verifikasi.');
        }

        $member->save();

        return back()->with('success', $message);
    }
}
