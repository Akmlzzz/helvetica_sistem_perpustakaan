<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nama_pengguna' => ['required', 'string'],
            'kata_sandi' => ['required', 'string'],
        ]);


        $authCredentials = [
            'nama_pengguna' => $credentials['nama_pengguna'],
            'password' => $credentials['kata_sandi']
        ];


        if (filter_var($credentials['nama_pengguna'], FILTER_VALIDATE_EMAIL)) {
            $authCredentials = [
                'email' => $credentials['nama_pengguna'],
                'password' => $credentials['kata_sandi']
            ];
        }

        if (Auth::attempt($authCredentials)) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('dashboard'));
            } elseif (Auth::user()->isPetugas()) {
                return redirect()->intended(route('petugas.dashboard'));
            } elseif (Auth::user()->isAnggota()) {
                return redirect()->intended(route('anggota.dashboard'));
            } else {
                return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'nama_pengguna' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('nama_pengguna');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nama_pengguna' => ['required', 'string', 'max:100', 'unique:pengguna'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:pengguna'],
            'kata_sandi' => ['required', 'string', 'min:8'],
            'nomor_telepon' => ['required', 'string', 'max:15'],
            'alamat' => ['required', 'string'],
        ]);

        DB::beginTransaction();

        try {
            // 1. Create Pengguna (Account)
            $pengguna = Pengguna::create([
                'nama_pengguna' => $validated['nama_pengguna'],
                'email' => $validated['email'],
                'kata_sandi' => Hash::make($validated['kata_sandi']),
                'level_akses' => 'anggota', // Default registration is always 'anggota'
            ]);

            // 2. Create Anggota (Profile)
            Anggota::create([
                'id_pengguna' => $pengguna->id_pengguna,
                'nama_lengkap' => $validated['nama_lengkap'],
                'alamat' => $validated['alamat'],
                'nomor_telepon' => $validated['nomor_telepon'],
            ]);

            DB::commit();

            // Auto login after register
            Auth::login($pengguna);

            return redirect($pengguna->isAdmin() ? '/dashboard' : '/');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat pendaftaran: ' . $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
