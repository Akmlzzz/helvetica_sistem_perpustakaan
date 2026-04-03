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
            'kata_sandi'    => ['required', 'string'],
        ]);

        if (!Auth::attempt($this->resolveAuthCredentials($credentials))) {
            return back()->withErrors([
                'nama_pengguna' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
            ])->onlyInput('nama_pengguna');
        }

        $request->session()->regenerate();

        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();

        return redirect()->intended(match (true) {
            $user->isAdmin()   => route('dashboard'),
            $user->isPetugas() => route('petugas.dashboard'),
            $user->isAnggota() => route('anggota.dashboard'),
            default            => '/',
        });
    }

    private function resolveAuthCredentials(array $credentials): array
    {
        $isEmail = filter_var($credentials['nama_pengguna'], FILTER_VALIDATE_EMAIL);

        return [
            $isEmail ? 'email' : 'nama_pengguna' => $credentials['nama_pengguna'],
            'password' => $credentials['kata_sandi'],
        ];
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'    => ['required', 'string', 'max:255'],
            'nama_pengguna'   => ['required', 'string', 'max:100', 'unique:pengguna'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:pengguna'],
            'kata_sandi'      => ['required', 'string', 'min:8'],
            'nomor_telepon'   => ['required', 'string', 'max:15'],
            'alamat'          => ['required', 'string'],
        ]);

        DB::beginTransaction();

        try {
            $pengguna = Pengguna::create([
                'nama_pengguna' => $validated['nama_pengguna'],
                'email'         => $validated['email'],
                'kata_sandi'    => Hash::make($validated['kata_sandi']),
                'level_akses'   => 'anggota',
                'status'        => 'pending',
            ]);

            Anggota::create([
                'id_pengguna'   => $pengguna->id_pengguna,
                'nama_lengkap'  => $validated['nama_lengkap'],
                'alamat'        => $validated['alamat'],
                'nomor_telepon' => $validated['nomor_telepon'],
            ]);

            DB::commit();
            Auth::login($pengguna);

            return redirect()->route('anggota.dashboard')->with('success', 'Akun berhasil dibuat! Silakan jelajahi katalog buku kami sementara menunggu verifikasi Admin untuk mulai meminjam.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Registrasi gagal: ' . $e->getMessage()]);
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
