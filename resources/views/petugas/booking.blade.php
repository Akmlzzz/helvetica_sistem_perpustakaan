@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-5 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 shadow-sm">
            <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-500">
                <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
            </div>
            <p class="text-sm font-medium text-green-800">{!! session('success') !!}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 shadow-sm">
            <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-500">
                <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
            </div>
            <p class="text-sm font-medium text-red-800">{!! session('error') !!}</p>
        </div>
    @endif

    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <svg class="h-6 w-6 text-[#004236]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Proses Booking
            </h2>
            <p class="text-sm text-gray-500 mt-1">Input kode booking untuk menyerahkan buku ke anggota</p>
        </div>
        <a href="{{ route('petugas.dashboard') }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Kembali ke Sirkulasi
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-5">

        {{-- Form Input Kode Booking --}}
        <div class="xl:col-span-2">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 bg-gradient-to-r from-[#004236]/5 to-transparent px-6 py-4">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="h-5 w-5 text-[#004236]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        Input Kode Booking
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">Masukkan kode booking yang ditunjukkan anggota</p>
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
                        </div>
                        <button type="submit"
                            class="w-full rounded-xl bg-[#004236] py-3 text-sm font-bold text-white transition hover:bg-[#003028] flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Proses — Serahkan Buku
                        </button>
                    </form>
                    <div class="mt-5 rounded-xl bg-blue-50 border border-blue-100 p-4">
                        <p class="text-xs font-bold text-blue-700 mb-2 flex items-center gap-1">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Cara Kerja:
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
                <div class="border-b border-gray-100 bg-gradient-to-r from-amber-50 to-transparent px-6 py-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <svg class="h-5 w-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Antrian Booking Menunggu
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">Belum diambil anggota</p>
                    </div>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-sm font-bold text-amber-700">
                        {{ $bookingAktif->count() }} antrian
                    </span>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($bookingAktif as $item)
                        <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition">
                            <div class="h-14 w-10 shrink-0 overflow-hidden rounded-lg bg-gray-100">
                                @if($item->buku?->sampul)
                                    <img src="{{ Storage::url($item->buku->sampul) }}" alt="{{ $item->buku->judul_buku }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-amber-50">
                                        <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->buku?->judul_buku ?? '-' }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $item->pengguna?->anggota?->nama_lengkap ?? $item->pengguna?->nama_pengguna ?? '-' }}</p>
                                <div class="mt-1 flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-0.5 font-mono text-xs font-bold text-gray-700">{{ $item->kode_booking }}</span>
                                    @if($item->tgl_booking)
                                        <span class="text-xs text-gray-400">Booking: {{ $item->tgl_booking->format('d M Y') }}</span>
                                    @endif
                                    @if($item->tgl_jatuh_tempo)
                                        <span class="text-xs text-red-500 font-medium">JT: {{ $item->tgl_jatuh_tempo->format('d M Y') }}</span>
                                    @endif
                                </div>
                            </div>
                            <button onclick="document.getElementById('kode_booking').value='{{ $item->kode_booking }}'; document.getElementById('kode_booking').focus();"
                                class="shrink-0 rounded-lg border border-[#004236] px-3 py-1.5 text-xs font-bold text-[#004236] hover:bg-[#004236] hover:text-white transition">
                                Pakai
                            </button>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                                <svg class="h-8 w-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-500">Tidak ada booking aktif</p>
                            <p class="text-xs text-gray-300 mt-1">Semua buku sudah diambil anggota ✓</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection