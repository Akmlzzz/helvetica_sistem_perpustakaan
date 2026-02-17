<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::with('anggota');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengguna', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('anggota', function ($subQ) use ($search) {
                        $subQ->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('level_akses', $request->role);
        }

        // Sort
        if ($request->has('sort')) {
            if ($request->sort == 'terbaru') {
                $query->orderBy('dibuat_pada', 'desc');
            } elseif ($request->sort == 'terlama') {
                $query->orderBy('dibuat_pada', 'asc');
            } elseif ($request->sort == 'az') {
                $query->orderBy('nama_pengguna', 'asc');
            } else {
                $query->orderBy('dibuat_pada', 'desc');
            }
        } else {
            $query->orderBy('dibuat_pada', 'desc');
        }

        $users = $query->paginate(10);
        return view('admin.pengguna.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required|unique:pengguna,nama_pengguna',
            'email' => 'required|email|unique:pengguna,email',
            'kata_sandi' => 'required|min:8',
            'level_akses' => 'required|in:admin,petugas,anggota',
            'nama_lengkap' => 'required_if:level_akses,anggota',
        ]);

        DB::beginTransaction();
        try {
            $user = Pengguna::create([
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
                'kata_sandi' => Hash::make($request->kata_sandi),
                'level_akses' => $request->level_akses,
            ]);

            if ($request->level_akses === 'anggota') {
                Anggota::create([
                    'id_pengguna' => $user->id_pengguna,
                    'nama_lengkap' => $request->nama_lengkap,
                    'alamat' => $request->alamat,
                    'nomor_telepon' => $request->nomor_telepon,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal menambahkan pengguna: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $user = Pengguna::findOrFail($id);

        $request->validate([
            'nama_pengguna' => 'required|unique:pengguna,nama_pengguna,' . $id . ',id_pengguna',
            'email' => 'required|email|unique:pengguna,email,' . $id . ',id_pengguna',
            'level_akses' => 'required|in:admin,petugas,anggota',
            'nama_lengkap' => 'required_if:level_akses,anggota',
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
                'level_akses' => $request->level_akses,
            ];

            if ($request->filled('kata_sandi')) {
                $userData['kata_sandi'] = Hash::make($request->kata_sandi);
            }

            $user->update($userData);

            if ($request->level_akses === 'anggota') {
                Anggota::updateOrCreate(
                    ['id_pengguna' => $user->id_pengguna],
                    [
                        'nama_lengkap' => $request->nama_lengkap,
                        'alamat' => $request->alamat,
                        'nomor_telepon' => $request->nomor_telepon,
                    ]
                );
            } else {
                // If role changed from anggota, maybe we delete profile? 
                // Decision: Keep profile data but it won't be used unless role is anggota.
            }

            DB::commit();
            return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui pengguna: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $user = Pengguna::findOrFail($id);

        // Prevent deleting self
        if (auth()->id() == $user->id_pengguna) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri!']);
        }

        $user->delete(); // Assuming cascade or manual cleanup is handled by DB or Model
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
