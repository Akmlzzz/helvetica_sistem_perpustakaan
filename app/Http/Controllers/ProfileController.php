<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        
        // Return view based on role
        if ($user->level_akses === 'admin') {
            return view('admin.profile', compact('user'));
        } elseif ($user->level_akses === 'petugas') {
            return view('petugas.profile', compact('user'));
        }
        
        return redirect('/dashboard');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:pengguna,email,' . $user->id_pengguna . ',id_pengguna',
            'nama_pengguna' => 'required|unique:pengguna,nama_pengguna,' . $user->id_pengguna . ',id_pengguna',
            'password' => 'nullable|min:6',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cropped_foto' => 'nullable|string',
        ]);

        if ($request->filled('cropped_foto')) {
            $image_parts = explode(";base64,", $request->cropped_foto);
            if (count($image_parts) == 2) {
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'profile_pictures/' . uniqid() . '.png';
                
                if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                    Storage::disk('public')->delete($user->foto_profil);
                }
                
                Storage::disk('public')->put($fileName, $image_base64);
                $user->foto_profil = $fileName;
            }
        } elseif ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('profile_pictures', 'public');
            $user->foto_profil = $path;
        }

        $user->email = $request->email;
        $user->nama_pengguna = $request->nama_pengguna;
        if ($request->filled('password')) {
            $user->kata_sandi = Hash::make($request->password);
        }
        /** @var \App\Models\Pengguna $user */
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function hapusFotoProfil()
    {
        $user = Auth::user();
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
            $user->foto_profil = null;
            $user->save();
        }
        return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
    }
}
