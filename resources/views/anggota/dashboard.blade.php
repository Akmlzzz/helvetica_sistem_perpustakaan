@extends('layouts.app')

@section('content')
    <div x-data="{
                                                                    showDetailModal: false,
                                                                    selectedBook: null,

                                                                    openModal(book) {
                                                                        this.selectedBook = book;
                                                                        this.showDetailModal = true;
                                                                    }
                                                                }">
        <!-- Header & Filter -->
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Katalog Buku
                </h2>
                <p class="text-gray-500 dark:text-gray-400">Temukan buku favoritmu di sini</p>
            </div>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <!-- Search -->
                <form action="{{ route('anggota.dashboard') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Cari Judul / Penulis..." value="{{ request('search') }}"
                        class="w-full rounded-full border border-stroke bg-gray-50 py-2.5 pl-12 pr-5 focus:border-primary focus:outline-none dark:border-strokedark dark:bg-meta-4 dark:focus:border-primary md:w-64" />
                    <span class="absolute left-4 top-3">
                        <svg class="fill-current text-gray-400" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15.7499 14.3332L21.4166 19.9999L19.9999 21.4166L14.3332 15.7499C13.0666 16.7332 11.4925 17.3332 9.74992 17.3332C5.55825 17.3332 2.16659 13.9416 2.16659 9.74992C2.16659 5.55825 5.55825 2.16659 9.74992 2.16659C13.9416 2.16659 17.3332 5.55825 17.3332 9.74992C17.3332 11.4925 16.7332 13.0666 15.7499 14.3332ZM9.74992 4.16659C6.66659 4.16659 4.16659 6.66659 4.16659 9.74992C4.16659 12.8333 6.66659 15.3333 9.74992 15.3333C12.8333 15.3333 15.3333 12.8333 15.3333 9.74992C15.3333 6.66659 12.8333 4.16659 9.74992 4.16659Z" />
                        </svg>
                    </span>
                </form>

                <!-- Category Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-2 rounded-full border border-stroke bg-gray-50 px-4 py-2.5 font-medium text-black focus:border-primary focus:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary">
                        <span>{{ request('kategori') ? request('kategori') : 'Semua Kategori' }}</span>
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg" :class="open && 'rotate-180'">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.29289 7.29289C5.68342 6.90237 6.31658 6.90237 6.70711 7.29289L10 10.5858L13.2929 7.29289C13.6834 6.90237 14.3166 6.90237 14.7071 7.29289C15.0976 7.68342 15.0976 8.31658 14.7071 8.70711L10.7071 12.7071C10.3166 13.0976 9.68342 13.0976 9.29289 12.7071L5.29289 8.70711C4.90237 8.31658 4.90237 7.68342 5.29289 7.29289Z" />
                        </svg>
                    </button>

                    <!-- Dropdown Content -->
                    <div x-show="open" @click.outside="open = false"
                        class="absolute right-0 top-full mt-2 w-48 rounded-md border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark z-50 py-1"
                        style="display: none;">
                        <a href="{{ route('anggota.dashboard') }}"
                            class="block px-4 py-2 text-sm text-black hover:bg-gray-100 dark:text-white dark:hover:bg-meta-4 {{ !request('kategori') ? 'font-bold bg-gray-50 dark:bg-meta-4' : '' }}">
                            Semua Kategori
                        </a>
                        @foreach($kategori as $kat)
                            <a href="{{ route('anggota.dashboard', ['kategori' => $kat->nama_kategori]) }}"
                                class="block px-4 py-2 text-sm text-black hover:bg-gray-100 dark:text-white dark:hover:bg-meta-4 {{ request('kategori') == $kat->nama_kategori ? 'font-bold bg-gray-50 dark:bg-meta-4' : '' }}">
                                {{ $kat->nama_kategori }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid Content -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($buku as $item)
                <div
                    class="group flex flex-col rounded-lg border border-gray-200 bg-white shadow-sm transition hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                    <!-- Image -->
                    <div class="relative aspect-2/3 w-full overflow-hidden rounded-t-lg bg-gray-200">
                        @if($item->sampul)
                            <img src="{{ Storage::url($item->sampul) }}" alt="{{ $item->judul_buku }}"
                                class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-gray-100 text-gray-400">
                                <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex flex-col grow p-4">
                        <!-- Badge -->
                        <div class="mb-2">
                            <span
                                class="inline-block px-3 py-1 rounded text-[10px] font-bold uppercase tracking-wider text-white {{ $item->stok > 0 ? 'bg-[#4ade80]' : 'bg-red-500' }}">
                                {{ $item->stok > 0 ? 'TERSEDIA' : 'STOK KOSONG' }}
                            </span>
                        </div>

                        <!-- Category -->
                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $item->kategori->first()?->nama_kategori ?? 'Umum' }}
                        </p>

                        <!-- Title -->
                        <h4 class="mb-4 text-xl font-bold text-black dark:text-white line-clamp-2"
                            title="{{ $item->judul_buku }}">
                            {{ $item->judul_buku }}
                        </h4>

                        <!-- Button -->
                        <div class="mt-auto">
                            @if($item->stok > 0)
                                <button @click="openModal({{ $item }})"
                                    class="w-full rounded-md bg-[#0f4c3a] py-2.5 text-sm font-bold text-white transition hover:bg-[#0a382b]">
                                    Pinjam buku
                                </button>
                            @else
                                <button disabled
                                    class="w-full rounded-md bg-gray-300 py-2.5 text-sm font-bold text-gray-500 cursor-not-allowed dark:bg-gray-700 dark:text-gray-400">
                                    Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="flex flex-col items-center justify-center gap-4">
                        <div class="rounded-full bg-gray-100 p-6 dark:bg-gray-800">
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-black dark:text-white">Buku tidak ditemukan</h3>
                            <p class="mt-1 text-gray-500">Coba gunakan kata kunci lain atau filter kategori yang berbeda.
                            </p>
                        </div>
                        @if(request('search') || request('kategori'))
                            <a href="{{ route('anggota.dashboard') }}"
                                class="mt-2 inline-flex items-center text-primary hover:underline">
                                Bersihkan semua filter
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $buku->links() }}
        </div>

        <!-- Modal Detail Buku -->
        <div x-show="showDetailModal"
            class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;"
            x-transition>
            <div @click.outside="showDetailModal = false"
                class="w-full max-w-3xl rounded-lg border border-stroke bg-white p-8 shadow-default dark:border-strokedark dark:bg-boxdark relative">
                <button @click="showDetailModal = false"
                    class="absolute top-4 right-4 text-gray-500 hover:text-black dark:hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <div class="flex flex-col gap-8 md:flex-row">
                    <!-- Cover -->
                    <div class="w-full md:w-1/3">
                        <template x-if="selectedBook?.sampul">
                            <div class="aspect-2/3 w-full rounded-lg bg-gray-200 overflow-hidden">
                                <img :src="'/storage/' + selectedBook?.sampul" :alt="selectedBook?.judul_buku"
                                    class="h-full w-full object-cover">
                            </div>
                        </template>
                        <template x-if="!selectedBook?.sampul">
                            <div
                                class="aspect-2/3 w-full rounded-lg bg-gray-200 flex items-center justify-center text-gray-400">
                                <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </template>
                    </div>

                    <!-- Info -->
                    <div class="w-full md:w-2/3">
                        <h2 class="mb-2 text-2xl font-bold text-black dark:text-white" x-text="selectedBook?.judul_buku">
                        </h2>
                        <p class="mb-4 text-lg text-primary" x-text="selectedBook?.penulis"></p>

                        <div class="mb-6 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="block text-gray-500">ISBN</span>
                                <span class="font-medium text-black dark:text-white" x-text="selectedBook?.isbn"></span>
                            </div>
                            <div>
                                <span class="block text-gray-500">Penerbit</span>
                                <span class="font-medium text-black dark:text-white" x-text="selectedBook?.penerbit"></span>
                            </div>
                            <div>
                                <span class="block text-gray-500">Tahun Terbit</span>
                                <span class="font-medium text-black dark:text-white"
                                    x-text="selectedBook?.tahun_terbit"></span>
                            </div>
                            <div>
                                <span class="block text-gray-500">Stok</span>
                                <span class="font-medium text-black dark:text-white" x-text="selectedBook?.stok"></span>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h4 class="mb-2 font-bold text-black dark:text-white">Sinopsis</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut
                                labore et dolore magna aliqua. Ut enim ad minim veniam.
                            </p>
                        </div>

                        <!-- Action -->
                        <form action="{{ route('anggota.booking.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_buku" :value="selectedBook?.id_buku">
                            <button type="submit" :disabled="selectedBook?.stok <= 0"
                                class="flex w-full items-center justify-center gap-2 rounded bg-primary py-3 px-6 font-medium text-white hover:bg-opacity-90 disabled:bg-opacity-50 disabled:cursor-not-allowed">
                                <span x-text="selectedBook?.stok > 0 ? 'Pinjam Sekarang' : 'Stok Habis'"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection