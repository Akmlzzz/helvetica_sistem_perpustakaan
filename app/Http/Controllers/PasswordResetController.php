<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    // 1. Tampilkan form "Lupa Password"
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Proses kirim link reset ke email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Kirim link reset password
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // 3. Tampilkan form "Reset Password" (input password baru)
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // 4. Proses simpan password baru
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'kata_sandi' => 'required|confirmed|min:8',
        ]);

        $status = Password::broker()->reset(
            [
                'email' => $request->email,
                'password' => $request->kata_sandi,
                'password_confirmation' => $request->kata_sandi_confirmation,
                'token' => $request->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'kata_sandi' => \Illuminate\Support\Facades\Hash::make($password)
                ])->save();

                $user->setRememberToken(\Illuminate\Support\Str::random(60));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
