@extends('layouts.auth')

@section('content')
    <div class="auth-logo">
        <i class="bi bi-person-circle"></i> Dashboard
    </div>

    <div style="text-align: center; margin-bottom: 2rem;">
        <h3>Selamat Datang, {{ Auth::user()->nama_pengguna }}!</h3>
        <p class="auth-subtitle">Anda berhasil login sebagai <strong>{{ Auth::user()->level_akses }}</strong>.</p>

        @if(Auth::user()->level_akses == 'anggota' && Auth::user()->anggota)
            <p>Nama Lengkap: {{ Auth::user()->anggota->nama_lengkap }}</p>
        @endif
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-primary-glass" style="background: #c0392b;">Logout</button>
    </form>
@endsection