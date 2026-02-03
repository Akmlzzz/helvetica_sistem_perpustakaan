@extends('layouts.auth')

@section('content')
    <div class="auth-logo">
        <i class="bi bi-shield-lock-fill"></i> Reset Kata Sandi
    </div>

    <p class="auth-subtitle">
        Buat kata sandi baru untuk akun <strong>{{ $email }}</strong>.
    </p>

    @if ($errors->any())
        <div
            style="background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; padding: 10px; border-radius: 10px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control-glass" value="{{ $email ?? old('email') }}"
                required readonly style="background: rgba(0,0,0,0.05);">
            <i class="bi bi-envelope input-icon"></i>
        </div>

        <div class="form-group">
            <label for="kata_sandi" class="form-label">Kata Sandi Baru</label>
            <input type="password" name="kata_sandi" id="kata_sandi" class="form-control-glass" required autofocus>
            <i class="bi bi-eye-slash input-icon" style="cursor: pointer;"></i>
        </div>

        <div class="form-group">
            <label for="kata_sandi_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
            <input type="password" name="kata_sandi_confirmation" id="kata_sandi_confirmation" class="form-control-glass"
                required>
            <i class="bi bi-eye-slash input-icon" style="cursor: pointer;"></i>
        </div>

        <button type="submit" class="btn-primary-glass">Reset Password</button>
    </form>
@endsection