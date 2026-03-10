@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <!-- Breadcrumb -->
    <nav class="mb-5 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('admin.series.index') }}" class="hover:text-brand-primary transition-colors">Series</a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-200 font-medium">{{ $series->nama_series }}</span>
    </nav>

    <!-- Header -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div class="flex items-center gap-4">
            <!-- Cover mini -->
            <div class="h-20 w-14 rounded-lg overflow-hidden shrink-0 bg-linear-to-br from-indigo-500 via-purple-500 to-pink-500 shadow-md">
                @if($series->sampul_series)
                    <img src="{{ Storage::url($series->sampul_series) }}" alt="{{ $series->nama_series }}" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full w-full items-center justify-center">
                        <svg class="h-8 w-8 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div>
                <h2 class="text-title-md2 font-bold text-black dark:text-white">{{ $series->nama_series }}</h2>
                @if($series->deskripsi)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-xl">{{ $series->deskripsi }}</p>
                @endif
                <div class="mt-2 flex items-center gap-3">
                    <span class="inline-flex items-center gap-1 rounded-full bg-brand-primary/10 px-3 py-1 text-xs font-semibold text-brand-primary">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        {{ $series->buku->count() }} Volume
                    </span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.series.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-stroke px-4 py-2 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white text-sm">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            <a href="{{ route('admin.buku.index', ['series' => $series->id_series]) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-primary px-4 py-2 font-medium text-white hover:bg-opacity-90 text-sm">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Filter Buku di Series ini
            </a>
        </div>
    </div>

    <!-- Daftar Buku dalam Series -->
    <div class="rounded-[20px] border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5">
        <h3 class="mb-5 text-lg font-bold text-black dark:text-white flex items-center gap-2">
            <svg class="h-5 w-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Daftar Volume dalam Series
        </h3>

        @if($series->buku->isEmpty())
            <div class="py-14 text-center">
                <div class="flex flex-col items-center gap-3">
                    <svg class="h-14 w-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <p class="text-gray-400 font-medium">Belum ada buku yang ditambahkan ke series ini.</p>
                    <p class="text-sm text-gray-400">Pergi ke halaman <a href="{{ route('admin.buku.index') }}" class="text-brand-primary hover:underline">Kelola Buku</a> dan edit buku, lalu pilih series ini.</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($series->buku as $buku)
                    <a href="{{ route('admin.buku.show', $buku->id_buku) }}"
                        class="group flex gap-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 p-4 hover:border-brand-primary hover:shadow-sm transition-all duration-200">
                        <!-- Cover -->
                        <div class="h-20 w-14 rounded-md overflow-hidden shrink-0 bg-gray-200 dark:bg-gray-700">
                            @if($buku->sampul)
                                <img src="{{ Storage::url($buku->sampul) }}" alt="{{ $buku->judul_buku }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <!-- Volume badge -->
                            @if($buku->nomor_volume)
                                <span class="inline-block rounded bg-brand-primary/10 px-2 py-0.5 text-xs font-bold text-brand-primary mb-1">
                                    Vol. {{ $buku->nomor_volume }}
                                </span>
                            @endif
                            <p class="font-semibold text-black dark:text-white text-sm leading-tight line-clamp-2 group-hover:text-brand-primary transition-colors">
                                {{ $buku->judul_buku }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $buku->penulis ?? '-' }}</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-xs {{ $buku->stok > 0 ? 'text-green-600' : 'text-red-500' }} font-medium">
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
@endsection
