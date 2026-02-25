@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    {{-- Page Header --}}
    <div class="mb-6">
        <h2 class="text-title-md2 font-bold text-black">Riwayat & Denda</h2>
        <p class="text-sm text-gray-500 mt-1">Lihat riwayat peminjaman buku dan tagihan denda Anda.</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm font-medium text-green-700">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-5 flex items-center gap-3 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm font-medium text-red-700">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ====== KIRI: Tabel Riwayat Peminjaman (2/3) ====== --}}
        <div class="xl:col-span-2">
            <div class="rounded-[20px] border border-gray-100 bg-white shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <div>
                        <h3 class="font-bold text-black text-base">Riwayat Peminjaman</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Semua buku yang pernah Anda kembalikan</p>
                    </div>
                    <span class="text-xs font-semibold bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                        {{ $history->count() }} data
                    </span>
                </div>

                <div class="p-6">
                    @if($history->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-100">
                                        <th class="text-left py-3 px-3 font-semibold text-gray-500 text-xs uppercase tracking-wide">Buku</th>
                                        <th class="text-left py-3 px-3 font-semibold text-gray-500 text-xs uppercase tracking-wide hidden sm:table-cell">Tgl Pinjam</th>
                                        <th class="text-left py-3 px-3 font-semibold text-gray-500 text-xs uppercase tracking-wide hidden sm:table-cell">Tgl Kembali</th>
                                        <th class="text-left py-3 px-3 font-semibold text-gray-500 text-xs uppercase tracking-wide">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($history as $loan)
                                        <tr class="hover:bg-gray-50/60 transition-colors group">
                                            <td class="py-4 px-3">
                                                <div class="flex items-center gap-3">
                                                    {{-- Sampul mini --}}
                                                    <div class="h-12 w-9 flex-shrink-0 rounded-md overflow-hidden bg-gray-100">
                                                        @if($loan->buku?->sampul)
                                                            <img src="{{ Storage::url($loan->buku->sampul) }}" alt="{{ $loan->buku->judul_buku }}" class="h-full w-full object-cover">
                                                        @else
                                                            <div class="h-full w-full flex items-center justify-center bg-[#e8f4f0]">
                                                                <svg class="h-4 w-4 text-[#0f4c3a] opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="font-semibold text-black text-sm line-clamp-2 leading-snug">
                                                            {{ $loan->buku?->judul_buku ?? 'Judul Tidak Diketahui' }}
                                                        </p>
                                                        <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $loan->buku?->penulis ?? '-' }}</p>
                                                        {{-- Show dates on mobile too --}}
                                                        <p class="text-xs text-gray-400 mt-0.5 sm:hidden">
                                                            {{ $loan->tgl_pinjam ? \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d M Y') : '-' }}
                                                            →
                                                            {{ $loan->tgl_kembali ? \Carbon\Carbon::parse($loan->tgl_kembali)->format('d M Y') : '-' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-3 hidden sm:table-cell">
                                                <span class="text-sm text-gray-600">
                                                    {{ $loan->tgl_pinjam ? \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d M Y') : '-' }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-3 hidden sm:table-cell">
                                                <span class="text-sm text-gray-600">
                                                    {{ $loan->tgl_kembali ? \Carbon\Carbon::parse($loan->tgl_kembali)->format('d M Y') : '-' }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-3">
                                                <div class="flex flex-col gap-1.5">
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700 self-start">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                                        Dikembalikan
                                                    </span>
                                                    @if($loan->denda)
                                                        <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-semibold self-start
                                                            {{ $loan->denda->status_pembayaran === 'lunas' ? 'bg-gray-100 text-gray-500' : 'bg-red-100 text-red-600' }}">
                                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Denda {{ $loan->denda->status_pembayaran === 'lunas' ? '(Lunas)' : '' }}: Rp {{ number_format($loan->denda->jumlah_denda, 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <div class="rounded-full bg-gray-50 p-5 mb-4">
                                <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <p class="font-bold text-black">Belum ada riwayat</p>
                            <p class="text-sm text-gray-400 mt-1">Buku yang sudah Anda kembalikan akan muncul disini.</p>
                            <a href="{{ route('anggota.dashboard') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-[#0f4c3a] hover:underline">
                                Jelajahi katalog →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ====== KANAN: Widget Tagihan Denda (1/3) ====== --}}
        <div class="flex flex-col gap-6">

            {{-- Total Denda Summary Card --}}
            @php $totalDenda = $tagihanDenda->sum('jumlah_denda'); @endphp
            <div class="rounded-[20px] border bg-white shadow-sm overflow-hidden {{ $totalDenda > 0 ? 'border-red-200' : 'border-gray-100' }}">
                <div class="px-6 py-5 border-b {{ $totalDenda > 0 ? 'border-red-100 bg-red-50' : 'border-gray-100' }}">
                    <h3 class="font-bold text-black text-base">Tagihan Denda</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Denda yang harus diselesaikan</p>
                </div>

                <div class="p-6">
                    @if($tagihanDenda->count() > 0)
                        <div class="flex flex-col gap-3 mb-5">
                            @foreach($tagihanDenda as $denda)
                                <div class="flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 p-3">
                                    <div class="mt-0.5 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-red-100">
                                        <svg class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-black line-clamp-1">
                                            {{ $denda->peminjaman?->buku?->judul_buku ?? 'Buku tidak diketahui' }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            Kembali: {{ $denda->peminjaman?->tgl_kembali ? \Carbon\Carbon::parse($denda->peminjaman->tgl_kembali)->format('d M Y') : '-' }}
                                        </p>
                                        <p class="text-sm font-bold text-red-600 mt-1">
                                            Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Total --}}
                        <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 border border-gray-100">
                            <span class="text-sm font-medium text-gray-600">Total Tagihan</span>
                            <span class="text-lg font-bold text-red-600">Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
                        </div>

                        {{-- Info bayar --}}
                        <div class="mt-4 flex items-start gap-2 rounded-xl border border-amber-100 bg-amber-50 p-3">
                            <svg class="h-4 w-4 mt-0.5 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-amber-700 leading-relaxed">
                                Silakan bayar denda langsung di meja petugas perpustakaan atau hubungi staff terkait.
                            </p>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <div class="rounded-full bg-green-50 p-4 mb-3">
                                <svg class="h-8 w-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <p class="font-bold text-black text-sm">Tidak ada denda!</p>
                            <p class="text-xs text-gray-400 mt-1">Anda tidak memiliki tagihan denda saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Stats Card --}}
            <div class="rounded-[20px] border border-gray-100 bg-white shadow-sm p-6">
                <h4 class="font-bold text-black text-sm mb-4">Statistik Peminjaman</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Total Dipinjam</span>
                        <span class="font-bold text-black">{{ $history->count() }} buku</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Pernah Kena Denda</span>
                        <span class="font-bold {{ $history->filter(fn($l) => $l->denda)->count() > 0 ? 'text-red-500' : 'text-black' }}">
                            {{ $history->filter(fn($l) => $l->denda)->count() }} kali
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Total Denda Dibayar</span>
                        <span class="font-bold text-gray-500">
                            Rp {{ number_format($history->filter(fn($l) => $l->denda && $l->denda->status_pembayaran === 'lunas')->sum(fn($l) => $l->denda->jumlah_denda), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection