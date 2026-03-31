@extends('layouts.app')

@section('content')
<div x-data="{ pageLoading: true }" x-init="window.addEventListener('load', () => setTimeout(() => pageLoading = false, 300))">
    {{-- Skeleton Detail Series --}}
    <div x-show="pageLoading" class="animate-pulse">
        {{-- Breadcrumb skeleton --}}
        <div class="h-4 w-48 bg-gray-200 rounded mb-4"></div>
        
        {{-- Main Card Skeleton --}}
        <div class="rounded-2xl border border-gray-200 bg-white mb-8 overflow-hidden">
            <div class="flex flex-col md:flex-row h-full">
                <div class="w-full md:w-64 xl:w-72 bg-gray-200 h-64 md:h-96 shrink-0"></div>
                <div class="flex-1 p-4 sm:p-6 xl:p-8">
                    <div class="flex gap-2 mb-3">
                        <div class="h-6 w-24 bg-gray-200 rounded-full"></div>
                        <div class="h-6 w-32 bg-gray-200 rounded-full"></div>
                    </div>
                    <div class="h-8 md:h-10 w-3/4 bg-gray-200 rounded mb-6"></div>
                    <div class="h-5 w-32 bg-gray-200 rounded mb-3"></div>
                    <div class="space-y-2">
                        <div class="h-4 w-full bg-gray-200 rounded"></div>
                        <div class="h-4 w-full bg-gray-200 rounded"></div>
                        <div class="h-4 w-5/6 bg-gray-200 rounded"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Buku Skeleton --}}
        <div class="h-6 w-64 bg-gray-200 rounded mb-4"></div>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
            @for($i=0; $i<6; $i++)
            <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                <div class="aspect-2/3 w-full bg-gray-200"></div>
                <div class="p-3">
                    <div class="h-4 w-full bg-gray-200 rounded mb-2"></div>
                    <div class="h-3 w-1/2 bg-gray-200 rounded"></div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    {{-- Main Content --}}
    <div x-show="!pageLoading" style="display: none;" x-transition.opacity.duration.500ms>
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
                        <div class="relative aspect-2/3 w-full overflow-hidden bg-gray-50">
                            @if($buku->sampul)
                                <img src="{{ Storage::url($buku->sampul) }}" alt="{{ $buku->judul_buku }}" loading="lazy"
                                    class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out">
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
                            <div class="absolute top-2 left-2 flex flex-col gap-1 z-10">
                                @if($buku->nomor_volume)
                                    <span
                                        class="inline-block rounded-lg bg-brand-primary px-2.5 py-1 text-[10px] font-bold text-white shadow-md border border-white/20 uppercase tracking-wider">
                                        Vol {{ $buku->nomor_volume }}
                                    </span>
                                @endif
                                @if($buku->stok == 0)
                                    <span
                                        class="inline-block rounded-lg bg-red-600 px-2.5 py-1 text-[10px] font-bold text-white shadow-md border border-white/20 uppercase tracking-wider">
                                        Habis
                                    </span>
                                @endif
                            </div>

                            {{-- Hover overlay --}}
                            <div
                                class="absolute inset-0 bg-[#0f4c3a]/0 group-hover:bg-[#0f4c3a]/30 transition-all duration-500 flex items-center justify-center">
                                <div
                                    class="opacity-0 group-hover:opacity-100 transition-all duration-500 transform group-hover:scale-100 scale-90">
                                    <div
                                        class="rounded-full bg-white/95 px-4 py-2 text-xs font-bold text-[#0f4c3a] shadow-xl backdrop-blur-md border border-white/20">
                                        Lihat Detail →
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-col flex-1 p-3">
                            <h4
                                class="text-sm font-bold text-black line-clamp-2 leading-tight mb-1 group-hover:text-brand-primary transition-colors">
                                {{ $buku->judul_buku }}
                            </h4>
                            <div class="mt-auto flex items-center justify-between">
                                <span
                                    class="text-[10px] font-semibold px-1.5 py-0.5 rounded-md {{ $buku->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    Stok: {{ $buku->stok }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
    </div>
</div>
@endsection