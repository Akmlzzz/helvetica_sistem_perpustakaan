@extends('layouts.auth')

@section('content')
    <div class="auth-logo">
        <i class="bi bi-book-half"></i> Biblio.
    </div>
    <p class="auth-subtitle">
        Yuk, daftarkan akun Anda dan nikmati kemudahan layanan Sistem Perpustakaan Digital.
    </p>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        @if ($errors->any())
            <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; padding: 10px; border-radius: 10px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; padding: 10px; border-radius: 10px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control-glass" value="{{ old('nama_lengkap') }}" placeholder="" required>
            </div>

            <div class="form-group">
                <label for="nama_pengguna" class="form-label">Username</label>
                <input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control-glass" value="{{ old('nama_pengguna') }}" placeholder=""
                    required>
                <i class="bi bi-person input-icon" style="top: 38px;"></i>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control-glass" value="{{ old('email') }}" placeholder="" required>
                <i class="bi bi-envelope input-icon" style="top: 38px;"></i>
            </div>

            <div class="form-group">
                <label for="nomor_telepon" class="form-label">No. Telepon</label>
                <input type="tel" name="nomor_telepon" id="nomor_telepon" class="form-control-glass" value="{{ old('nomor_telepon') }}" placeholder=""
                    required>
                <i class="bi bi-telephone input-icon" style="top: 38px;"></i>
            </div>

            <div class="form-group">
                <label for="kata_sandi" class="form-label">Kata Sandi</label>
                <input type="password" name="kata_sandi" id="kata_sandi" class="form-control-glass" placeholder="" required>
                <i class="bi bi-eye-slash input-icon" style="top: 38px; cursor: pointer;"></i>
            </div>

            <div class="form-group">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control-glass" value="{{ old('alamat') }}" placeholder="" required>
                <i class="bi bi-house input-icon" style="top: 38px;"></i>
            </div>
        </div>

        <button type="submit" class="btn-primary-glass">Daftar</button>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Klik disini untuk login</a>
        </div>
    </form>
@endsection