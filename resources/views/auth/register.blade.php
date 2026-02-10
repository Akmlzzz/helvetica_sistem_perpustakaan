@extends('layouts.auth')

@section('content')
    <div class="mb-4">
        <a href="/" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>
    <div class="auth-logo">
        <img src="{{ asset('./img/Logo.svg') }}" class="custom-logo" alt="Logo Biblio">
    </div>
    <p class="auth-subtitle">
        Yuk, daftarkan akun Anda dan nikmati kemudahan layanan Sistem Perpustakaan Digital.
    </p>

    <form action="{{ route('register') }}" method="POST">
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

        @if (session('error'))
            <div
                style="background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; padding: 10px; border-radius: 10px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-group">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <div class="relative">
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control-glass"
                        value="{{ old('nama_lengkap') }}" placeholder="" required>
                </div>
            </div>

            <div class="form-group">
                <label for="nama_pengguna" class="form-label">Username</label>
                <div class="relative">
                    <input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control-glass pe-10"
                        value="{{ old('nama_pengguna') }}" placeholder="" required>
                    <i class="bi bi-person input-icon absolute top-1/2 right-4 -translate-y-1/2"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email" class="form-control-glass pe-10" value="{{ old('email') }}"
                        placeholder="" required>
                    <i class="bi bi-envelope input-icon absolute top-1/2 right-4 -translate-y-1/2"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="nomor_telepon" class="form-label">No. Telepon</label>
                <div class="relative">
                    <input type="tel" name="nomor_telepon" id="nomor_telepon" class="form-control-glass pe-10"
                        value="{{ old('nomor_telepon') }}" placeholder="" required>
                    <i class="bi bi-telephone input-icon absolute top-1/2 right-4 -translate-y-1/2"></i>
                </div>
            </div>

            <div class="form-group" x-data="{ showPassword: false }">
                <label for="kata_sandi" class="form-label">Kata Sandi</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="kata_sandi" id="kata_sandi"
                        class="form-control-glass pe-10" placeholder="" required>
                    <i class="bi input-icon absolute top-1/2 right-4 -translate-y-1/2 cursor-pointer"
                        :class="showPassword ? 'bi-eye' : 'bi-eye-slash'" @click="showPassword = !showPassword"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="alamat" class="form-label">Alamat</label>
                <div class="relative">
                    <input type="text" name="alamat" id="alamat" class="form-control-glass pe-10"
                        value="{{ old('alamat') }}" placeholder="" required>
                    <i class="bi bi-house input-icon absolute top-1/2 right-4 -translate-y-1/2"></i>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-primary-glass">Daftar</button>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Klik disini untuk login</a>
        </div>
    </form>
@endsection