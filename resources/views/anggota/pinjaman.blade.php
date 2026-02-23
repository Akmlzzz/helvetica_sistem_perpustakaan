@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">

        {{-- Header --}}
        <div>
            <h2 class="text-2xl font-bold text-black">Pinjaman Saya</h2>
            <p class="text-gray-500 mt-1">Kelola dan pantau status pinjaman buku Anda</p>
        </div>

        {{-- Pinjaman Aktif --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                <h3 class="font-bold text-black text-lg flex items-center gap-2">
                    <svg class="h-5 w-5 text-[#0f4c3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"></path>
                    </svg>
                    Daftar Pinjaman Aktif
                </h3>
                <span class="text-sm text-gray-500">{{ $pinjaman->count() }} buku</span>
            </div>

            @if($pinjaman->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($pinjaman as $item)
                        @php
                            $jatuhTempo = $item->tgl_jatuh_tempo ?? $item->tgl_kembali;
                            $sisaHari = $jatuhTempo ? (int) \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($jatuhTempo->toDateString()), false) : null;
                            $status = $item->status_transaksi;
                        @endphp
                        <div class="p-6 flex flex-col md:flex-row items-start md:items-center gap-4">

                            {{-- Cover Buku --}}
                            <div class="shrink-0">
                                @if($item->buku?->sampul)
                                    <img src="{{ Storage::url($item->buku->sampul) }}" alt="{{ $item->buku->judul_buku }}"
                                        class="h-20 w-14 rounded-lg object-cover shadow-sm">
                                @else
                                    <div class="h-20 w-14 rounded-lg bg-gradient-to-br from-[#e8f4f0] to-[#c8e6d8] flex items-center justify-center">
                                        <svg class="h-7 w-7 text-[#0f4c3a] opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Info Buku --}}
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-black text-base line-clamp-1">{{ $item->buku?->judul_buku ?? 'Judul Tidak Diketahui' }}</h4>
                                <p class="text-sm text-gray-500 mb-2">{{ $item->buku?->penulis ?? '-' }}</p>

                                <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                    {{-- Kode Booking --}}
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-1 font-mono font-bold text-gray-700">
                                        🎫 {{ $item->kode_booking }}
                                    </span>

                                    {{-- Tgl Pinjam --}}
                                    @if($item->tgl_pinjam)
                                    <span class="flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Pinjam: {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}
                                    </span>
                                    @endif

                                    {{-- Jatuh Tempo --}}
                                    @if($jatuhTempo)
                                    <span class="flex items-center gap-1 {{ $status == 'terlambat' ? 'text-red-600 font-semibold' : '' }}">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Jatuh tempo: {{ \Carbon\Carbon::parse($jatuhTempo->toDateString())->format('d M Y') }}
                                    </span>
                                    @endif

                                    {{-- Durasi --}}
                                    @if($item->durasi_pinjam)
                                    <span class="text-gray-400">{{ $item->durasi_pinjam }} hari</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Status & Aksi --}}
                            <div class="flex flex-col items-end gap-3 shrink-0">
                                {{-- Badge Status --}}
                                @if($status == 'terlambat')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700">
                                        <span class="h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
                                        TERLAMBAT
                                        @if($sisaHari !== null)
                                            ({{ abs($sisaHari) }} hari)
                                        @endif
                                    </span>
                                @elseif($status == 'dipinjam')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-yellow-100 px-3 py-1.5 text-xs font-bold text-yellow-700">
                                        <span class="h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                        AKTIF
                                        @if($sisaHari !== null)
                                            ({{ $sisaHari }} hari lagi)
                                        @endif
                                    </span>
                                @elseif($status == 'booking')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1.5 text-xs font-bold text-blue-700">
                                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                        BOOKING
                                    </span>
                                @endif

                                {{-- Tombol Perpanjang (hanya untuk dipinjam atau terlambat) --}}
                                @if(in_array($status, ['dipinjam', 'terlambat']))
                                    <div x-data="{ showPerpanjang: false }">
                                        <button @click="showPerpanjang = true"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-[#0f4c3a] px-3 py-1.5 text-xs font-bold text-[#0f4c3a] hover:bg-[#0f4c3a] hover:text-white transition-colors">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Perpanjang
                                        </button>

                                        {{-- Modal Perpanjang --}}
                                        <div x-show="showPerpanjang" x-transition
                                            class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
                                            style="display: none;">
                                            <div @click.outside="showPerpanjang = false"
                                                class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-2xl">
                                                <h3 class="mb-2 text-xl font-bold text-black">Perpanjang Pinjaman</h3>
                                                <p class="mb-1 text-sm text-gray-500 line-clamp-2">{{ $item->buku?->judul_buku }}</p>
                                                <p class="mb-5 text-xs text-gray-400">
                                                    Perpanjangan hanya bisa dilakukan 1 kali (2-3 hari)
                                                </p>

                                                <form action="{{ route('anggota.pinjaman.perpanjang', $item->id_peminjaman) }}" method="POST">
                                                    @csrf
                                                    <div class="mb-5">
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tambah Durasi</label>
                                                        <div class="grid grid-cols-2 gap-3">
                                                            <label class="flex items-center gap-2 cursor-pointer rounded-xl border-2 border-gray-200 p-3 has-[:checked]:border-[#0f4c3a] has-[:checked]:bg-[#e8f4f0] transition-all">
                                                                <input type="radio" name="tambah_hari" value="2" class="text-[#0f4c3a]" required>
                                                                <div>
                                                                    <div class="font-bold text-black">+2 Hari</div>
                                                                    <div class="text-xs text-gray-500">Perpanjang 2 hari</div>
                                                                </div>
                                                            </label>
                                                            <label class="flex items-center gap-2 cursor-pointer rounded-xl border-2 border-gray-200 p-3 has-[:checked]:border-[#0f4c3a] has-[:checked]:bg-[#e8f4f0] transition-all">
                                                                <input type="radio" name="tambah_hari" value="3" class="text-[#0f4c3a]">
                                                                <div>
                                                                    <div class="font-bold text-black">+3 Hari</div>
                                                                    <div class="text-xs text-gray-500">Perpanjang 3 hari</div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="flex gap-3">
                                                        <button type="button" @click="showPerpanjang = false"
                                                            class="flex-1 rounded-xl border border-gray-300 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="flex-1 rounded-xl bg-[#0f4c3a] py-2.5 text-sm font-bold text-white hover:bg-[#0a382b] transition">
                                                            Perpanjang
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-16 text-center">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-base font-bold text-black mb-1">Belum ada pinjaman aktif</h4>
                    <p class="text-sm text-gray-500 mb-4">Kunjungi katalog untuk meminjam buku</p>
                    <a href="{{ route('anggota.dashboard') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#0f4c3a] px-5 py-2 text-sm font-bold text-white hover:bg-[#0a382b] transition">
                        Lihat Katalog Buku
                    </a>
                </div>
            @endif
        </div>

        {{-- Keterangan Status --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-5">
            <h3 class="font-bold text-black mb-3 text-sm">Keterangan Status</h3>
            <div class="flex flex-wrap gap-3 text-xs">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-yellow-100 px-3 py-1.5 font-bold text-yellow-700">
                    <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
                    AKTIF — Sedang dipinjam, belum jatuh tempo
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1.5 font-bold text-green-700">
                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                    DIKEMBALIKAN — Buku sudah dikembalikan
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1.5 font-bold text-red-700">
                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                    TERLAMBAT — Melewati batas waktu
                </span>
            </div>
        </div>

        {{-- Riwayat Terakhir Dikembalikan --}}
        @if($riwayat->count() > 0)
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-gray-100 px-6 py-4">
                <h3 class="font-bold text-black text-lg flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Riwayat Terakhir Dikembalikan
                </h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($riwayat as $item)
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="shrink-0">
                        @if($item->buku?->sampul)
                            <img src="{{ Storage::url($item->buku->sampul) }}" alt="{{ $item->buku->judul_buku }}"
                                class="h-12 w-9 rounded object-cover shadow-sm">
                        @else
                            <div class="h-12 w-9 rounded bg-gray-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-black line-clamp-1">{{ $item->buku?->judul_buku ?? '-' }}</h4>
                        <p class="text-xs text-gray-400">
                            Dikembalikan: {{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') : '-' }}
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-1 text-xs font-bold text-green-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                        Dikembalikan
                    </span>
                </div>
                @endforeach
            </div>
            <div class="px-6 py-3 border-t border-gray-100">
                <a href="{{ route('anggota.riwayat') }}" class="text-sm text-[#0f4c3a] font-medium hover:underline">
                    Lihat semua riwayat →
                </a>
            </div>
        </div>
        @endif

    </div>
@endsection