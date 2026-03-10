@extends('layouts.app')

@section('content')
    {{-- Breadcrumb --}}
    <nav class="mb-4 flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('anggota.dashboard') }}"
            class="hover:text-[#0f4c3a] transition-colors flex items-center gap-1 shrink-0">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="hidden sm:inline">Katalog Buku</span>
            <span class="sm:hidden">Kembali</span>
        </a>
        <span>/</span>
        <span class="text-gray-800 font-medium line-clamp-1 min-w-0">Series: {{ $series->nama_series }}</span>
    </nav>

    {{-- Main Card: Responsive layout --}}
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden mb-8">
        {{-- Mobile: stack vertical | Desktop: 2 kolom --}}
        <div class="flex flex-col md:flex-row">

            {{-- ===== KOLOM KIRI ===== --}}
            <div
                class="w-full md:w-64 xl:w-72 md:shrink-0 flex flex-col bg-linear-to-b from-[#e8f4f0] to-[#d0ebe0] md:border-r border-b md:border-b-0 border-gray-100">

                {{-- Cover --}}
                <div class="flex items-center justify-center p-4 md:p-5 md:flex-1 md:overflow-hidden">
                    @if($series->sampul_series)
                        <img src="{{ Storage::url($series->sampul_series) }}" alt="{{ $series->nama_series }}"
                            class="h-36 sm:h-44 md:h-auto md:w-full md:max-h-full rounded-xl shadow-lg object-contain">
                    @else
                        <div
                            class="h-36 sm:h-44 md:h-auto md:w-full rounded-xl shadow-lg bg-white/50 flex items-center justify-center aspect-2/3">
                            <svg class="h-12 w-12 md:h-20 md:w-20 text-[#0f4c3a] opacity-30" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                                </path>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ===== KOLOM KANAN: Info Series ===== --}}
            <div class="flex-1">
                <div class="p-4 sm:p-6 xl:p-8">
                    <div class="mb-3 flex flex-wrap gap-2">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-brand-primary/10 px-3 py-1 text-xs font-bold text-brand-primary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Series Koleksi
                        </span>
                        <span
                            class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">
                            {{ $series->buku->count() }} Volume Tersedia
                        </span>
                    </div>

                    <h1 class="mb-4 text-xl sm:text-2xl xl:text-3xl font-bold text-black leading-tight">
                        {{ $series->nama_series }}
                    </h1>

                    @if($series->deskripsi)
                        <div>
                            <h2 class="mb-2 text-sm font-bold text-gray-500 flex items-center gap-2 uppercase tracking-wide">
                                <svg class="h-4 w-4 text-[#0f4c3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informasi Series
                            </h2>
                            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                                {{ $series->deskripsi }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Volume Series --}}
    <div>
        <h2 class="mb-4 text-lg font-bold text-black flex items-center gap-2">
            <svg class="h-5 w-5 text-[#0f4c3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Daftar Volume Dalam Series Ini
        </h2>

        @if($series->buku->isEmpty())
            <div class="py-10 text-center bg-white rounded-xl border border-gray-100">
                <p class="text-gray-500 mb-1 font-medium">Belum ada buku untuk series ini.</p>
            </div>
        @else
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                @foreach($series->buku->sortBy('nomor_volume') as $buku)
                    <a href="{{ route('anggota.buku.detail', $buku->id_buku) }}"
                        class="group flex flex-col rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 overflow-hidden cursor-pointer"
                        title="Lihat detail: {{ $buku->judul_buku }}">

                        {{-- Image Buku --}}
                        <div class="relative aspect-2/3 w-full overflow-hidden bg-gray-100">
                            @if($buku->sampul)
                                <img src="{{ Storage::url($buku->sampul) }}" alt="{{ $buku->judul_buku }}" loading="lazy"
                                    class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-linear-to-br from-[#e8f4f0] to-[#c8e6d8]">
                                    <svg class="h-10 w-10 text-[#0f4c3a] opacity-40" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Volume/Status --}}
                            <div class="absolute top-2 left-2 flex flex-col gap-1">
                                @if($buku->nomor_volume)
                                    <span
                                        class="inline-block rounded bg-brand-primary/90 px-2 py-0.5 text-[10px] font-bold text-white shadow-sm backdrop-blur-sm self-start whitespace-nowrap">
                                        Vol {{ $buku->nomor_volume }}
                                    </span>
                                @endif
                                @if($buku->stok == 0)
                                    <span
                                        class="inline-block rounded bg-red-500/90 px-2 py-0.5 text-[10px] font-bold text-white shadow-sm backdrop-blur-sm self-start">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-col flex-1 p-2 sm:p-3">
                            <h4 class="text-xs sm:text-sm font-bold text-black line-clamp-2 leading-snug mb-1">
                                {{ $buku->judul_buku }}
                            </h4>
                            <p class="text-[10px] text-gray-400 mt-auto flex items-center gap-1 justify-between">
                                Stok: <span
                                    class="{{ $buku->stok > 0 ? 'text-green-600 font-bold' : 'text-red-500 font-bold' }}">{{ $buku->stok }}</span>
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection