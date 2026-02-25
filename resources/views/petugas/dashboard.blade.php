@extends('layouts.app')

@section('content')
    <div class="mx-auto">

        {{-- ===== ALERTS ===== --}}
        @if(session('success'))
            <div class="mb-5 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 shadow-sm">
                <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-500">
                    <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-green-800">{!! session('success') !!}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 shadow-sm">
                <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-500">
                    <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-red-800">{!! session('error') !!}</p>
            </div>
        @endif

        {{-- ===== PAGE HEADER ===== --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Layanan Sirkulasi</h2>
                <p class="text-sm text-gray-500 mt-1">Selamat datang, <span
                        class="font-semibold text-[#004236]">{{ auth()->user()->nama_pengguna }}</span></p>
            </div>
            <nav>
                <ol class="flex items-center gap-2 text-sm">
                    <li><span class="text-gray-400">Dashboard</span></li>
                    <li class="text-gray-300">/</li>
                    <li class="font-semibold text-[#004236]">Sirkulasi</li>
                </ol>
            </nav>
        </div>

        {{-- ===== STAT CARDS FITUR AKSES ===== --}}
        @if($fiturAkses->isNotEmpty())
            <div class="mb-8">
                <div class="mb-3 flex items-center gap-2">
                    <div class="h-5 w-1 rounded-full bg-[#004236]"></div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Fitur yang Dapat Anda Akses</h3>
                </div>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                    @if($fiturAkses->contains('kategori'))
                        <a href="{{ route('admin.kategori.index') }}"
                            class="group relative overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-blue-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-blue-200">
                            <div class="mb-4 flex items-center justify-between">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500 shadow-sm shadow-blue-200">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <svg class="h-4 w-4 text-blue-300 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-blue-500/70">Kelola</p>
                            <p class="text-lg font-bold text-blue-800">Kategori</p>
                            @if(isset($stats['kategori']))
                                <p class="mt-1 text-2xl font-extrabold text-blue-600">{{ $stats['kategori'] }}</p>
                                <p class="text-xs text-blue-400">total kategori</p>
                            @endif
                        </a>
                    @endif

                    @if($fiturAkses->contains('buku'))
                        <a href="{{ route('admin.buku.index') }}"
                            class="group relative overflow-hidden rounded-2xl border border-green-100 bg-gradient-to-br from-green-50 to-green-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-green-200">
                            <div class="mb-4 flex items-center justify-between">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-500 shadow-sm shadow-green-200">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <svg class="h-4 w-4 text-green-300 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-green-500/70">Kelola</p>
                            <p class="text-lg font-bold text-green-800">Data Buku</p>
                            @if(isset($stats['buku']))
                                <p class="mt-1 text-2xl font-extrabold text-green-600">{{ $stats['buku'] }}</p>
                                <p class="text-xs text-green-400">total buku</p>
                            @endif
                        </a>
                    @endif

                    @if($fiturAkses->contains('peminjaman'))
                        <a href="{{ route('admin.peminjaman.index') }}"
                            class="group relative overflow-hidden rounded-2xl border border-purple-100 bg-gradient-to-br from-purple-50 to-purple-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-purple-200">
                            <div class="mb-4 flex items-center justify-between">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-500 shadow-sm shadow-purple-200">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </div>
                                <svg class="h-4 w-4 text-purple-300 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-purple-500/70">Kelola</p>
                            <p class="text-lg font-bold text-purple-800">Peminjaman</p>
                            @if(isset($stats['peminjaman_aktif']))
                                <p class="mt-1 text-2xl font-extrabold text-purple-600">{{ $stats['peminjaman_aktif'] }}</p>
                                <p class="text-xs text-purple-400">aktif &bull; {{ $stats['peminjaman_booking'] ?? 0 }} menunggu booking
                                </p>
                            @endif
                        </a>
                    @endif

                    @if($fiturAkses->contains('denda'))
                        <a href="{{ route('admin.denda.index') }}"
                            class="group relative overflow-hidden rounded-2xl border border-red-100 bg-gradient-to-br from-red-50 to-red-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-red-200">
                            <div class="mb-4 flex items-center justify-between">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-500 shadow-sm shadow-red-200">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <svg class="h-4 w-4 text-red-300 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-red-500/70">Kelola</p>
                            <p class="text-lg font-bold text-red-800">Denda</p>
                            @if(isset($stats['denda_belum_bayar']))
                                <p class="mt-1 text-2xl font-extrabold text-red-600">{{ $stats['denda_belum_bayar'] }}</p>
                                <p class="text-xs text-red-400">belum dibayar</p>
                            @endif
                        </a>
                    @endif

                    @if($fiturAkses->contains('laporan'))
                        <a href="{{ route('admin.laporan.index') }}"
                            class="group relative overflow-hidden rounded-2xl border border-orange-100 bg-gradient-to-br from-orange-50 to-orange-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-orange-200">
                            <div class="mb-4 flex items-center justify-between">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-500 shadow-sm shadow-orange-200">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <svg class="h-4 w-4 text-orange-300 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-orange-500/70">Lihat</p>
                            <p class="text-lg font-bold text-orange-800">Laporan</p>
                            @if(isset($stats['laporan_bulan_ini']))
                                <p class="mt-1 text-2xl font-extrabold text-orange-600">{{ $stats['laporan_bulan_ini'] }}</p>
                                <p class="text-xs text-orange-400">transaksi bulan ini</p>
                            @endif
                        </a>
                    @endif

                </div>
            </div>
        @endif

        {{-- ===== DIVIDER ===== --}}
        <div class="mb-6 flex items-center gap-3">
            <div class="h-5 w-1 rounded-full bg-[#004236]"></div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Layanan Sirkulasi Langsung</h3>
        </div>

        {{-- ===== TABS ===== --}}
        <div x-data="{ activeTab: '{{ session('error') || old('kode_booking') ? 'booking' : 'pengembalian' }}' }">

            <div class="mb-6 flex gap-1 rounded-xl border border-gray-200 bg-gray-50 p-1">
                {{-- Tab 1: Proses Booking --}}
                <button @click="activeTab = 'booking'" :class="activeTab === 'booking'
                        ? 'bg-white shadow-sm text-[#004236] font-bold'
                        : 'text-gray-500 hover:text-gray-700'"
                    class="flex flex-1 items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm transition-all duration-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Proses Booking
                    @if($bookingAktif->count() > 0)
                        <span class="rounded-full bg-[#004236] px-2 py-0.5 text-xs font-bold text-white">
                            {{ $bookingAktif->count() }}
                        </span>
                    @endif
                </button>

                {{-- Tab 2: Pengembalian --}}
                <button @click="activeTab = 'pengembalian'" :class="activeTab === 'pengembalian'
                        ? 'bg-white shadow-sm text-[#004236] font-bold'
                        : 'text-gray-500 hover:text-gray-700'"
                    class="flex flex-1 items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm transition-all duration-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                    Pengembalian
                </button>
            </div>

            {{-- ============================================================== --}}
            {{-- TAB 1: PROSES BOOKING --}}
            {{-- ============================================================== --}}
            <div x-show="activeTab === 'booking'" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">

                <div class="grid grid-cols-1 gap-6 xl:grid-cols-5">

                    {{-- Form Input Kode Booking --}}
                    <div class="xl:col-span-2">
                        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                            <div
                                class="border-b border-gray-100 bg-gradient-to-r from-[#004236]/5 to-transparent px-6 py-4">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <svg class="h-5 w-5 text-[#004236]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                    Input Kode Booking
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">Masukkan kode booking dari anggota untuk memproses
                                    pengambilan buku</p>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('petugas.booking.proses') }}" method="POST">
                                    @csrf
                                    <div class="mb-5">
                                        <label for="kode_booking" class="mb-2 block text-sm font-semibold text-gray-700">
                                            Kode Booking <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="kode_booking" name="kode_booking"
                                            value="{{ old('kode_booking') }}" placeholder="Contoh: BK250224ABCD" autofocus
                                            class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 font-mono text-sm font-semibold uppercase tracking-widest text-gray-800 placeholder:font-normal placeholder:normal-case placeholder:tracking-normal placeholder:text-gray-400 outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/10 @error('kode_booking') border-red-400 bg-red-50 @enderror">
                                        @error('kode_booking')
                                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1.5 text-xs text-gray-400">Kode booking diberikan otomatis saat anggota
                                            melakukan booking online</p>
                                    </div>

                                    <button type="submit"
                                        class="w-full rounded-xl bg-[#004236] py-3 text-sm font-bold text-white transition hover:bg-[#003028] flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Proses — Serahkan Buku
                                    </button>
                                </form>

                                {{-- Info cara kerja --}}
                                <div class="mt-5 rounded-xl bg-blue-50 border border-blue-100 p-4">
                                    <p class="text-xs font-bold text-blue-700 mb-2 flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Cara Kerja Sistem Booking:
                                    </p>
                                    <ol class="text-xs text-blue-600 space-y-1 list-decimal list-inside">
                                        <li>Anggota booking buku secara online</li>
                                        <li>Stok buku langsung dikurangi (reservasi)</li>
                                        <li>Anggota datang & tunjukkan kode booking</li>
                                        <li>Petugas input kode → status menjadi <strong>Dipinjam</strong></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Booking Menunggu --}}
                    <div class="xl:col-span-3">
                        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                            <div
                                class="border-b border-gray-100 bg-gradient-to-r from-amber-50 to-transparent px-6 py-4 flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                        <svg class="h-5 w-5 text-amber-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Booking Menunggu Diambil
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Anggota sudah booking, buku belum diambil</p>
                                </div>
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-bold text-amber-700">
                                    {{ $bookingAktif->count() }} antrian
                                </span>
                            </div>
                            <div class="divide-y divide-gray-50">
                                @forelse($bookingAktif as $item)
                                    <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition">
                                        {{-- Icon Buku --}}
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100">
                                            <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                            </svg>
                                        </div>
                                        {{-- Info --}}
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-800 truncate">
                                                {{ $item->buku?->judul_buku ?? '-' }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">
                                                {{ $item->pengguna?->anggota?->nama_lengkap ?? $item->pengguna?->nama_pengguna ?? '-' }}
                                            </p>
                                            <div class="mt-1 flex flex-wrap items-center gap-2">
                                                <span
                                                    class="inline-flex items-center rounded-md bg-gray-100 px-2 py-0.5 font-mono text-xs font-bold text-gray-700">
                                                    {{ $item->kode_booking }}
                                                </span>
                                                @if($item->tgl_booking)
                                                <span class="text-xs text-gray-400">
                                                    Booking: {{ $item->tgl_booking->format('d M Y') }}
                                                </span>
                                                @endif
                                                @if($item->tgl_jatuh_tempo)
                                                <span class="text-xs text-red-500 font-medium">
                                                    Jatuh tempo: {{ $item->tgl_jatuh_tempo->format('d M Y') }}
                                                </span>
                                                @else
                                                <span class="text-xs text-gray-400">Jatuh tempo: -</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex flex-col items-center justify-center py-16 text-center">
                                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                                            <svg class="h-8 w-8 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-400">Tidak ada booking aktif</p>
                                        <p class="text-xs text-gray-300 mt-1">Semua buku sudah diambil anggota</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ============================================================== --}}
            {{-- TAB 2: PENGEMBALIAN BUKU --}}
            {{-- ============================================================== --}}
            <div x-show="activeTab === 'pengembalian'" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">

                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                    <div
                        class="border-b border-gray-100 px-6 py-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800">Peminjaman Aktif</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Daftar buku yang sedang dipinjam — klik tombol untuk
                                proses pengembalian</p>
                        </div>
                        {{-- Search --}}
                        <form method="GET" action="{{ route('petugas.dashboard') }}" class="flex gap-2">
                            <input type="hidden" name="search_return" value="">
                            <input type="text" name="search_return" value="{{ $searchReturn }}"
                                placeholder="Cari nama / kode / buku..."
                                class="w-64 rounded-xl border border-gray-300 bg-gray-50 px-4 py-2 text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/10">
                            <button type="submit"
                                class="rounded-xl bg-[#004236] px-4 py-2 text-sm font-semibold text-white hover:bg-[#003028] transition">
                                Cari
                            </button>
                            @if($searchReturn)
                                <a href="{{ route('petugas.dashboard') }}"
                                    class="rounded-xl border border-gray-300 px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 transition">
                                    Reset
                                </a>
                            @endif
                        </form>
                    </div>

                    {{-- Tabel --}}
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50 text-left">
                                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Kode</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Anggota
                                    </th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Buku</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Tgl
                                        Pinjam</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Jatuh
                                        Tempo</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Status
                                    </th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($peminjamanAktif as $p)
                                    @php
                                        $jatuhTempo = $p->tgl_jatuh_tempo ?? $p->tgl_kembali;
                                        $hariTerlambat = 0;
                                        $isLate = false;
                                        if ($jatuhTempo) {
                                            $jatuhTempoCarbon = $jatuhTempo instanceof \Carbon\Carbon
                                                ? $jatuhTempo
                                                : \Carbon\Carbon::parse((string) $jatuhTempo);
                                            $isLate = \Carbon\Carbon::today()->gt($jatuhTempoCarbon);
                                            if ($isLate) {
                                                $hariTerlambat = (int) \Carbon\Carbon::today()->diffInDays($jatuhTempoCarbon);
                                            }
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition {{ $isLate ? 'bg-red-50/30' : '' }}">
                                        {{-- Kode --}}
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-1 font-mono text-xs font-bold text-gray-700">
                                                {{ $p->kode_booking }}
                                            </span>
                                        </td>
                                        {{-- Anggota --}}
                                        <td class="px-4 py-4">
                                            <p class="text-sm font-semibold text-gray-800">
                                                {{ $p->pengguna?->anggota?->nama_lengkap ?? $p->pengguna?->nama_pengguna ?? '-' }}
                                            </p>
                                            <p class="text-xs text-gray-400">{{ $p->pengguna?->nomor_anggota ?? '-' }}</p>
                                        </td>
                                        {{-- Buku --}}
                                        <td class="px-4 py-4">
                                            <p class="text-sm font-medium text-gray-800 max-w-[200px] truncate">
                                                {{ $p->buku?->judul_buku ?? '-' }}
                                            </p>
                                            <p class="text-xs text-gray-400">{{ $p->buku?->penulis ?? '-' }}</p>
                                        </td>
                                        {{-- Tgl Pinjam --}}
                                        <td class="px-4 py-4">
                                            <p class="text-sm text-gray-600 whitespace-nowrap">
                                                {{ $p->tgl_pinjam ? $p->tgl_pinjam->format('d M Y') : '-' }}
                                            </p>
                                        </td>
                                        {{-- Jatuh Tempo --}}
                                        <td class="px-4 py-4">
                                            @if($jatuhTempo)
                                                @php
                                                    $jtCarbon = isset($jatuhTempoCarbon) ? $jatuhTempoCarbon
                                                        : (($jatuhTempo instanceof \Carbon\Carbon) ? $jatuhTempo : \Carbon\Carbon::parse((string) $jatuhTempo));
                                                @endphp
                                                <p class="text-sm font-semibold whitespace-nowrap {{ $isLate ? 'text-red-600' : 'text-gray-700' }}">
                                                    {{ $jtCarbon->format('d M Y') }}
                                                </p>
                                                @if($isLate)
                                                    <p class="text-xs font-bold text-red-500">+{{ $hariTerlambat }} hari terlambat</p>
                                                    <p class="text-xs text-red-400">Denda: Rp
                                                        {{ number_format($hariTerlambat * 2000, 0, ',', '.') }}</p>
                                                @else
                                                    @php $sisaHari = (int) \Carbon\Carbon::today()->diffInDays($jtCarbon, false); @endphp
                                                    <p class="text-xs {{ $sisaHari <= 2 ? 'text-amber-500 font-bold' : 'text-gray-400' }}">
                                                        {{ $sisaHari > 0 ? "Sisa {$sisaHari} hari" : 'Jatuh tempo hari ini' }}
                                                    </p>
                                                @endif
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                        {{-- Status --}}
                                        <td class="px-4 py-4">
                                            @if($p->status_transaksi === 'terlambat')
                                                <span
                                                    class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-bold text-red-700">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                                    Terlambat
                                                </span>
                                            @elseif($p->status_transaksi === 'dipinjam')
                                                <span
                                                    class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-1 text-xs font-bold text-blue-700">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                                                    Dipinjam
                                                </span>
                                            @elseif($p->status_transaksi === 'booking')
                                                <span
                                                    class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-700">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                    Booking
                                                </span>
                                            @endif
                                        </td>
                                        {{-- Aksi --}}
                                        <td class="px-4 py-4">
                                            <button x-data @click="$dispatch('open-return-modal', {
                                                        id: '{{ $p->id_peminjaman }}',
                                                        buku: '{{ addslashes($p->buku->judul_buku ?? '-') }}',
                                                        anggota: '{{ addslashes($p->pengguna->anggota->nama_lengkap ?? $p->pengguna->nama_pengguna ?? '-') }}',
                                                        kode: '{{ $p->kode_booking }}',
                                                        terlambat: {{ $isLate ? 'true' : 'false' }},
                                                        hariTerlambat: {{ $hariTerlambat }},
                                                        denda: {{ $hariTerlambat * 2000 }},
                                                    })"
                                                class="inline-flex items-center gap-1.5 rounded-xl border border-[#004236] bg-white px-3 py-1.5 text-xs font-bold text-[#004236] transition hover:bg-[#004236] hover:text-white">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                                </svg>
                                                Kembalikan
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-16 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div
                                                    class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                                                    <svg class="h-7 w-7 text-gray-300" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-semibold text-gray-400">
                                                    {{ $searchReturn ? 'Tidak ada hasil untuk "' . $searchReturn . '"' : 'Tidak ada peminjaman aktif' }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($peminjamanAktif->hasPages())
                        <div class="border-t border-gray-100 px-6 py-4">
                            {{ $peminjamanAktif->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>{{-- end x-data tabs --}}

    </div>

    {{-- ===================================================================== --}}
    {{-- MODAL KONFIRMASI PENGEMBALIAN --}}
    {{-- ===================================================================== --}}
    <div x-data="{
            show: false,
            id: '',
            buku: '',
            anggota: '',
            kode: '',
            terlambat: false,
            hariTerlambat: 0,
            denda: 0,
        }" @open-return-modal.window="
            id            = $event.detail.id;
            buku          = $event.detail.buku;
            anggota       = $event.detail.anggota;
            kode          = $event.detail.kode;
            terlambat     = $event.detail.terlambat;
            hariTerlambat = $event.detail.hariTerlambat;
            denda         = $event.detail.denda;
            show          = true;
        " x-show="show" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
        style="display:none;">

        <div @click.outside="show = false" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="w-full max-w-md rounded-2xl bg-white p-0 shadow-2xl overflow-hidden">

            {{-- Modal Header --}}
            <div class="relative bg-gradient-to-br from-[#004236] to-[#00644f] px-6 pt-6 pb-8">
                <button @click="show = false"
                    class="absolute right-4 top-4 flex h-7 w-7 items-center justify-center rounded-full bg-white/20 text-white hover:bg-white/30 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Konfirmasi Pengembalian</h3>
                        <p class="text-xs text-white/70">Pastikan buku sudah diterima fisik</p>
                    </div>
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="-mt-4 rounded-t-2xl bg-white px-6 pt-5 pb-6">

                {{-- Detail Peminjaman --}}
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
                        <span class="font-mono text-sm font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded"
                            x-text="kode"></span>
                    </div>
                </div>

                {{-- Alert Denda jika terlambat --}}
                <template x-if="terlambat">
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="h-4 w-4 text-red-600 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="text-sm font-bold text-red-700">Terdapat Keterlambatan!</p>
                        </div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-red-600">Hari terlambat:</span>
                                <span class="font-bold text-red-700" x-text="hariTerlambat + ' hari'"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-red-600">Denda (Rp 2.000/hari):</span>
                                <span class="font-bold text-red-700 text-base"
                                    x-text="'Rp ' + denda.toLocaleString('id-ID')"></span>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-red-500">Denda akan otomatis tercatat dan anggota wajib melunasinya.</p>
                    </div>
                </template>

                {{-- Alert sukses jika tepat waktu --}}
                <template x-if="!terlambat">
                    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 p-3">
                        <p class="text-sm text-green-700 flex items-center gap-2">
                            <svg class="h-4 w-4 text-green-600 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Buku dikembalikan <strong>tepat waktu</strong>. Tidak ada denda.
                        </p>
                    </div>
                </template>

                {{-- Form Action --}}
                <form :action="`/petugas/pengembalian`" method="POST">
                    @csrf
                    <input type="hidden" name="id_peminjaman" :value="id">

                    <div class="flex gap-3">
                        <button type="button" @click="show = false"
                            class="flex-1 rounded-xl border border-gray-300 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 rounded-xl bg-[#004236] py-3 text-sm font-bold text-white hover:bg-[#003028] transition shadow">
                            Konfirmasi Kembali
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection