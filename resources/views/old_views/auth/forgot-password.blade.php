@extends('layouts.auth')

@section('content')
    <div class="auth-logo">
        <i class="bi bi-key-fill"></i> Lupa Kata Sandi
    </div>

    <p class="auth-subtitle">
        Masukkan email yang terdaftar. Kami akan mengirimkan link untuk mereset kata sandi Anda.
    </p>

    @if (session('status'))
        <div
            style="background: rgba(25, 135, 84, 0.1); border: 1px solid #198754; color: #198754; padding: 10px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('status') }}
        </div>
    @endif

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

    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control-glass" value="{{ old('email') }}"
                placeholder="contoh@email.com" required autofocus>
            <i class="bi bi-envelope input-icon"></i>
        </div>

        <button type="submit" class="btn-primary-glass">Kirim Link Reset</button>

        <div class="auth-footer">
            <a href="{{ route('login') }}"><i class="bi bi-arrow-left"></i> Kembali ke Login</a>
        </div>
    </form>
@endsection