@extends('layouts.app')

@section('content')
<div class="mx-auto space-y-6" x-data>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 shadow-sm">
            <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-500">
                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m4.5 12.75 6 6 9-13.5"/></svg>
            </div>
            <p class="text-sm font-medium text-green-800">{!! session('success') !!}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 shadow-sm">
            <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-500">
                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18 18 6M6 6l12 12"/></svg>
            </div>
            <p class="text-sm font-medium text-red-800">{!! session('error') !!}</p>
        </div>
    @endif

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="mt-0.5 text-sm text-gray-400">Selamat datang, <span class="font-semibold text-[#004236]">{{ auth()->user()->nama_pengguna }}</span> 👋</p>
        </div>
        <span class="hidden sm:inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-500 shadow-sm">
            <svg class="h-3.5 w-3.5 text-[#004236]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">

        {{-- Card: Total Buku --}}
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
            <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100">
                <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            </div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Buku</p>
            <p class="mt-1 text-3xl font-black text-gray-800">{{ number_format($totalBuku) }}</p>
            <div class="mt-2 flex items-center gap-1">
                @if($bukuTrend >= 0)
                    <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    <span class="text-xs font-bold text-emerald-500">+{{ $bukuTrend }}%</span>
                @else
                    <svg class="h-3.5 w-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    <span class="text-xs font-bold text-red-400">{{ $bukuTrend }}%</span>
                @endif
                <span class="text-xs text-gray-400">vs minggu lalu</span>
            </div>
        </div>

        {{-- Card: Total Anggota --}}
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
            <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100">
                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Anggota</p>
            <p class="mt-1 text-3xl font-black text-gray-800">{{ number_format($totalAnggota) }}</p>
            <div class="mt-2 flex items-center gap-1">
                @if($anggotaTrend >= 0)
                    <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    <span class="text-xs font-bold text-emerald-500">+{{ $anggotaTrend }}%</span>
                @else
                    <svg class="h-3.5 w-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    <span class="text-xs font-bold text-red-400">{{ $anggotaTrend }}%</span>
                @endif
                <span class="text-xs text-gray-400">vs minggu lalu</span>
            </div>
        </div>

        {{-- Card: Peminjaman Aktif --}}
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
            <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100">
                <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
            </div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Peminjaman Aktif</p>
            <p class="mt-1 text-3xl font-black text-gray-800">{{ number_format($totalPeminjaman) }}</p>
            <div class="mt-2 flex items-center gap-1">
                <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $totalBooking }} booking
                </span>
            </div>
        </div>

        {{-- Card: Buku Terlambat --}}
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
            <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-rose-100">
                <svg class="h-5 w-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Buku Terlambat</p>
            <p class="mt-1 text-3xl font-black text-gray-800">{{ number_format($totalTerlambat) }}</p>
            <div class="mt-2 flex items-center gap-1">
                <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2 py-0.5 text-xs font-bold text-red-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    {{ $totalDenda }} denda belum lunas
                </span>
            </div>
        </div>

    </div>

    {{-- CHARTS ROW --}}
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-5">

        {{-- Quick Actions --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 lg:col-span-2">
            <div class="mb-4">
                <h3 class="font-bold text-gray-800">Akses Cepat</h3>
                <p class="text-xs text-gray-400">Fitur utama layanan sirkulasi</p>
            </div>
            <div class="space-y-2.5">
                @if($fiturAkses->contains('peminjaman'))
                <a href="{{ route('petugas.booking.index') }}" class="group flex items-center gap-3 rounded-xl border border-purple-100 bg-purple-50 px-4 py-3 transition hover:border-purple-300 hover:bg-purple-100">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-purple-500">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-purple-800">Proses Booking</p>
                        <p class="text-xs text-purple-500">{{ $totalBooking }} antrian menunggu</p>
                    </div>
                    <svg class="h-4 w-4 text-purple-300 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('petugas.pengembalian.index') }}" class="group flex items-center gap-3 rounded-xl border border-teal-100 bg-teal-50 px-4 py-3 transition hover:border-teal-300 hover:bg-teal-100">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#004236]">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-teal-800">Pengembalian Buku</p>
                        <p class="text-xs text-teal-500">{{ $totalPeminjaman }} sedang dipinjam</p>
                    </div>
                    <svg class="h-4 w-4 text-teal-300 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @endif
                @if($fiturAkses->contains('buku'))
                <a href="{{ route('admin.buku.index') }}" class="group flex items-center gap-3 rounded-xl border border-green-100 bg-green-50 px-4 py-3 transition hover:border-green-300 hover:bg-green-100">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-green-500">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-green-800">Data Buku</p>
                        <p class="text-xs text-green-500">{{ $totalBuku }} judul tersedia</p>
                    </div>
                    <svg class="h-4 w-4 text-green-300 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @endif
                @if($fiturAkses->contains('denda'))
                <a href="{{ route('admin.denda.index') }}" class="group flex items-center gap-3 rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 transition hover:border-rose-300 hover:bg-rose-100">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-rose-500">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75m0 5.25v.75m0 5.25v.75m15-12v.75m0 5.25v.75m0 5.25v.75M3.75 6h15M3.75 12h15M3.75 18h15"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-rose-800">Kelola Denda</p>
                        <p class="text-xs text-rose-500">{{ $totalDenda }} belum dibayar</p>
                    </div>
                    <svg class="h-4 w-4 text-rose-300 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @endif
            </div>
        </div>

        {{-- Bar Chart Peminjaman --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 lg:col-span-3">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-800">Statistik Peminjaman</h3>
                    <p class="text-xs text-gray-400">7 hari terakhir</p>
                </div>
                <div class="flex items-center gap-1.5 rounded-lg border border-gray-200 px-3 py-1.5">
                    <span class="h-2 w-2 rounded-full bg-[#004236]"></span>
                    <span class="text-xs font-medium text-gray-500">Peminjaman</span>
                </div>
            </div>
            <div class="relative w-full" style="height: 240px;">
                <canvas id="peminjamanChartPetugas"></canvas>
            </div>
        </div>

    </div>

    {{-- RECENT PEMINJAMAN --}}
    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <div>
                <h3 class="font-bold text-gray-800">Peminjaman Terbaru</h3>
                <p class="text-xs text-gray-400">Transaksi peminjaman yang baru masuk</p>
            </div>
            @if($fiturAkses->contains('peminjaman'))
            <a href="{{ route('petugas.pengembalian.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#004236] hover:underline">
                Lihat semua
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endif
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($latestPeminjaman as $p)
                @php
                    $nama = $p->pengguna?->anggota?->nama_lengkap ?? $p->pengguna?->nama_pengguna ?? 'Unknown';
                    $initial = strtoupper(substr($nama, 0, 1));
                    $statusConfig = match($p->status_transaksi) {
                        'dipinjam'     => ['bg' => 'bg-blue-100',  'text' => 'text-blue-700',  'dot' => 'bg-blue-500',  'label' => 'Dipinjam'],
                        'booking'      => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Booking'],
                        'dikembalikan' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'dot' => 'bg-green-500', 'label' => 'Dikembalikan'],
                        'terlambat'    => ['bg' => 'bg-rose-100',  'text' => 'text-rose-700',  'dot' => 'bg-rose-500',  'label' => 'Terlambat'],
                        default        => ['bg' => 'bg-gray-100',  'text' => 'text-gray-600',  'dot' => 'bg-gray-400',  'label' => ucfirst($p->status_transaksi)],
                    };
                    $avatarColors = ['bg-emerald-500','bg-blue-500','bg-violet-500','bg-rose-500','bg-amber-500','bg-teal-500'];
                    $avatarColor  = $avatarColors[crc32($nama) % count($avatarColors)];
                @endphp
                <div class="flex items-center gap-4 px-6 py-3.5 transition hover:bg-gray-50/70">
                    @if($p->pengguna?->foto_profil)
                        <img src="{{ Storage::url($p->pengguna->foto_profil) }}" alt="{{ $nama }}" class="h-9 w-9 shrink-0 rounded-full object-cover">
                    @else
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $avatarColor }} text-sm font-bold text-white">{{ $initial }}</div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-gray-800">{{ $nama }}</p>
                        <p class="truncate text-xs text-gray-400">{{ $p->buku?->judul_buku ?? '-' }}</p>
                    </div>
                    <div class="hidden text-right sm:block">
                        <p class="text-xs text-gray-500">{{ $p->tgl_pinjam?->format('d M Y') ?? '-' }}</p>
                        <p class="text-xs text-gray-300">{{ $p->kode_booking }}</p>
                    </div>
                    <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full {{ $statusConfig['bg'] }} px-3 py-1 text-xs font-bold {{ $statusConfig['text'] }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }} {{ in_array($p->status_transaksi, ['booking','terlambat']) ? 'animate-pulse' : '' }}"></span>
                        {{ $statusConfig['label'] }}
                    </span>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                        <svg class="h-7 w-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-400">Belum ada data peminjaman</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

{{-- MODAL KONFIRMASI PENGEMBALIAN --}}
<div x-data="{
        show: false, id: '', buku: '', anggota: '', kode: '', terlambat: false, hariTerlambat: 0, denda: 0,
    }" @open-return-modal.window="
        id=\$event.detail.id; buku=\$event.detail.buku; anggota=\$event.detail.anggota;
        kode=\$event.detail.kode; terlambat=\$event.detail.terlambat;
        hariTerlambat=\$event.detail.hariTerlambat; denda=\$event.detail.denda; show=true;
    " x-show="show" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
    style="display:none;">
    <div @click.outside="show = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        class="w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden">
        <div class="relative bg-linear-to-br from-[#004236] to-[#00644f] px-6 pt-6 pb-8">
            <button @click="show = false" class="absolute right-4 top-4 flex h-7 w-7 items-center justify-center rounded-full bg-white/20 text-white hover:bg-white/30 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Konfirmasi Pengembalian</h3>
                    <p class="text-xs text-white/70">Pastikan buku sudah diterima fisik</p>
                </div>
            </div>
        </div>
        <div class="-mt-4 rounded-t-2xl bg-white px-6 pt-5 pb-6">
            <div class="mb-4 space-y-2.5">
                <div class="flex items-start justify-between gap-4">
                    <span class="text-xs text-gray-500 whitespace-nowrap">Buku</span>
                    <span class="text-sm font-bold text-gray-800 text-right" x-text="buku"></span>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-xs text-gray-500">Anggota</span>
                    <span class="text-sm font-semibold text-gray-700" x-text="anggota"></span>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-xs text-gray-500">Kode Booking</span>
                    <span class="font-mono text-sm font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded" x-text="kode"></span>
                </div>
            </div>
            <template x-if="terlambat">
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="h-4 w-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <p class="text-sm font-bold text-red-700">Terdapat Keterlambatan!</p>
                    </div>
                    <div class="space-y-1">
                        <div class="flex justify-between text-sm">
                            <span class="text-red-600">Hari terlambat:</span>
                            <span class="font-bold text-red-700" x-text="hariTerlambat + ' hari'"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-red-600">Denda (Rp 2.000/hari):</span>
                            <span class="font-bold text-red-700 text-base" x-text="'Rp ' + denda.toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-red-500">Denda akan otomatis tercatat dan anggota wajib melunasinya.</p>
                </div>
            </template>
            <template x-if="!terlambat">
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 p-3">
                    <p class="text-sm text-green-700 flex items-center gap-2">
                        <svg class="h-4 w-4 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Buku dikembalikan <strong>tepat waktu</strong>. Tidak ada denda.
                    </p>
                </div>
            </template>
            <form :action="`/petugas/pengembalian`" method="POST">
                @csrf
                <input type="hidden" name="id_peminjaman" :value="id">
                <div class="flex gap-3">
                    <button type="button" @click="show = false" class="flex-1 rounded-xl border border-gray-300 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Batal</button>
                    <button type="submit" class="flex-1 rounded-xl bg-[#004236] py-3 text-sm font-bold text-white hover:bg-[#003028] transition shadow">Konfirmasi Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('peminjamanChartPetugas').getContext('2d');
        const weeklyLabels = {!! json_encode($weeklyData->pluck('label')) !!};
        const weeklyCounts = {!! json_encode($weeklyData->pluck('count')) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Peminjaman',
                    data: weeklyCounts,
                    backgroundColor: function(context) {
                        return context.dataIndex === weeklyCounts.length - 1 ? '#004236' : '#a7f3d0';
                    },
                    borderRadius: 6,
                    borderSkipped: false,
                    barThickness: 24
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        padding: 10,
                        titleFont: { size: 12 },
                        bodyFont: { size: 13, weight: 'bold' },
                        displayColors: false,
                        callbacks: { label: ctx => ctx.raw + ' pinjam' }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6', drawBorder: false },
                        border: { display: false },
                        ticks: { stepSize: 1, font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        border: { display: false },
                        ticks: { font: { size: 11, weight: '500' } }
                    }
                },
                animation: { duration: 1000, easing: 'easeOutQuart' }
            }
        });
    });
</script>
@endpush

@endsection