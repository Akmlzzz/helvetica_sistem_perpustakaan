@extends('layouts.auth')

@section('content')
    <div class="auth-logo">
        <i class="bi bi-book-half"></i> Biblio.
    </div>
    <p class="auth-subtitle">
        Yuk, masuk ke akun Anda dan nikmati kemudahan layanan Sistem Perpustakaan Digital.
    </p>

    <form action="{{ route('login') }}" method="POST">
        @csrf

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

        @if (session('status'))
            <div
                style="background: rgba(25, 135, 84, 0.1); border: 1px solid #198754; color: #198754; padding: 10px; border-radius: 10px; margin-bottom: 20px;">
                {{ session('status') }}
            </div>
        @endif

        <div class="form-group">
            <label for="nama_pengguna" class="form-label">Username / Email</label>
            <input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control-glass"
                value="{{ old('nama_pengguna') }}" placeholder="" required>
            <i class="bi bi-envelope input-icon" style="top: 38px;"></i>
        </div>

        <div class="form-group">
            <label for="kata_sandi" class="form-label">Kata Sandi</label>
            <input type="password" name="kata_sandi" id="kata_sandi" class="form-control-glass" placeholder="" required>
            <i class="bi bi-eye-slash input-icon" style="top: 38px; cursor: pointer;"></i>
            <div style="text-align: right; margin-top: 5px;">
                <a href="{{ route('password.request') }}"
                    style="font-size: 0.8rem; color: #3b82f6; text-decoration: none;">Lupa kata sandi?</a>
            </div>
        </div>

        <button type="submit" class="btn-primary-glass">Masuk</button>

        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Klik disini untuk register</a>
        </div>
    </form>
@endsection