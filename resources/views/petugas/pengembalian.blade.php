@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10" x-data="{
            show: false, id: '', buku: '', anggota: '', kode: '', terlambat: false, hariTerlambat: 0, denda: 0,
         }" @open-return-modal.window="
            id = $event.detail.id; buku = $event.detail.buku; anggota = $event.detail.anggota;
            kode = $event.detail.kode; terlambat = $event.detail.terlambat;
            hariTerlambat = $event.detail.hariTerlambat; denda = $event.detail.denda; show = true;
         ">

        {{-- Alerts --}}
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

        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="h-6 w-6 text-[#004236]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                    Pengembalian Buku
                </h2>
                <p class="text-sm text-gray-500 mt-1">Proses pengembalian buku dari anggota, denda dihitung otomatis</p>
            </div>
            <a href="{{ route('petugas.dashboard') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Sirkulasi
            </a>
        </div>

        {{-- Tabel Peminjaman Aktif --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div
                class="border-b border-gray-100 px-6 py-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="font-bold text-gray-800">Daftar Peminjaman Aktif</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Klik tombol "Kembalikan" untuk memproses pengembalian buku</p>
                </div>
                {{-- Search --}}
                <form method="GET" action="{{ route('petugas.pengembalian.index') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ $searchReturn }}" placeholder="Cari nama / kode / buku..."
                        class="w-64 rounded-xl border border-gray-300 bg-gray-50 px-4 py-2 text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/10">
                    <button type="submit"
                        class="rounded-xl bg-[#004236] px-4 py-2 text-sm font-semibold text-white hover:bg-[#003028] transition">
                        Cari
                    </button>
                    @if($searchReturn)
                        <a href="{{ route('petugas.pengembalian.index') }}"
                            class="rounded-xl border border-gray-300 px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50 text-left">
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Kode</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Anggota</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Buku</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Tgl Pinjam</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Jatuh Tempo</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
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
                                    $jatuhTempoCarbon = $jatuhTempo instanceof \Carbon\Carbon ? $jatuhTempo : \Carbon\Carbon::parse((string) $jatuhTempo);
                                    $isLate = \Carbon\Carbon::today()->gt($jatuhTempoCarbon);
                                    if ($isLate)
                                        $hariTerlambat = (int) \Carbon\Carbon::today()->diffInDays($jatuhTempoCarbon);
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 transition {{ $isLate ? 'bg-red-50/30' : '' }}">
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-1 font-mono text-xs font-bold text-gray-700">{{ $p->kode_booking }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $p->pengguna?->anggota?->nama_lengkap ?? $p->pengguna?->nama_pengguna ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ $p->pengguna?->nomor_anggota ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-medium text-gray-800 max-w-[200px] truncate">
                                        {{ $p->buku?->judul_buku ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ $p->buku?->penulis ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm text-gray-600 whitespace-nowrap">
                                        {{ $p->tgl_pinjam ? $p->tgl_pinjam->format('d M Y') : '-' }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    @if($jatuhTempo)
                                        @php $jtCarbon = isset($jatuhTempoCarbon) ? $jatuhTempoCarbon : (($jatuhTempo instanceof \Carbon\Carbon) ? $jatuhTempo : \Carbon\Carbon::parse((string) $jatuhTempo)); @endphp
                                        <p
                                            class="text-sm font-semibold whitespace-nowrap {{ $isLate ? 'text-red-600' : 'text-gray-700' }}">
                                            {{ $jtCarbon->format('d M Y') }}</p>
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
                                <td class="px-4 py-4">
                                    @if($p->status_transaksi === 'terlambat')
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-bold text-red-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-pulse"></span> Terlambat
                                        </span>
                                    @elseif($p->status_transaksi === 'dipinjam')
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-1 text-xs font-bold text-blue-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span> Dipinjam
                                        </span>
                                    @elseif($p->status_transaksi === 'booking')
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span> Booking
                                        </span>
                                    @endif
                                </td>
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
                                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
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

            @if($peminjamanAktif->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">{{ $peminjamanAktif->links() }}</div>
            @endif
        </div>

        {{-- ===== MODAL KONFIRMASI PENGEMBALIAN ===== --}}
        <div x-show="show" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
            style="display:none;">
            <div @click.outside="show = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="w-full max-w-md rounded-2xl bg-white p-0 shadow-2xl overflow-hidden">

                <div class="relative bg-gradient-to-br from-[#004236] to-[#00644f] px-6 pt-6 pb-8">
                    <button @click="show = false"
                        class="absolute right-4 top-4 flex h-7 w-7 items-center justify-center rounded-full bg-white/20 text-white hover:bg-white/30 transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
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
                            <span class="font-mono text-sm font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded"
                                x-text="kode"></span>
                        </div>
                    </div>

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
                            <p class="mt-2 text-xs text-red-500">Denda akan otomatis tercatat.</p>
                        </div>
                    </template>
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

                    <form action="{{ route('petugas.pengembalian.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_peminjaman" :value="id">
                        <div class="flex gap-3">
                            <button type="button" @click="show = false"
                                class="flex-1 rounded-xl border border-gray-300 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Batal</button>
                            <button type="submit"
                                class="flex-1 rounded-xl bg-[#004236] py-3 text-sm font-bold text-white hover:bg-[#003028] transition shadow">Konfirmasi
                                Kembali</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection