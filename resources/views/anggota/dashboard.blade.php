@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

        {{-- Hero Carousel --}}
        <x-hero-carousel :banners="$banners" />

        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-title-md2 font-bold text-black">Katalog Buku</h2>
                <p class="text-sm text-gray-500 mt-1">Klik pada buku untuk melihat detail dan meminjam</p>
            </div>
        </div>

        {{-- Filter & Search Box (sama dengan admin data buku) --}}
        <div class="rounded-[20px] border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm sm:px-7.5 xl:pb-1 mb-6">
            <form id="filter-form" method="GET" action="{{ route('anggota.dashboard') }}"
                class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center">

                {{-- Search Bar --}}
                <div class="relative flex-1">
                    <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2">
                        <svg class="fill-current text-black hover:text-primary transition-colors" width="20"
                            height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                    <input type="text" id="katalog-search" name="search" value="{{ request('search') }}"
                        placeholder="Cari Judul, Penulis, Sinopsis, atau ISBN..."
                        class="w-full rounded-lg border border-stroke bg-transparent pl-12 pr-4 py-2 font-medium outline-none focus:border-primary dark:border-strokedark dark:text-white"
                        autocomplete="off" />
                    {{-- Spinner --}}
                    <span id="search-spinner" class="absolute right-4 top-1/2 -translate-y-1/2 hidden">
                        <svg class="h-4 w-4 animate-spin text-gray-400" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </span>
                </div>

                {{-- Filter Kategori --}}
                <div class="relative w-full sm:w-48">
                    <select id="filter-kategori" name="kategori" onchange="document.getElementById('filter-form').submit()"
                        class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->nama_kategori }}"
                                {{ request('kategori') == $kat->nama_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                {{-- Sort --}}
                <div class="relative w-full sm:w-48">
                    <select id="filter-sort" name="sort" onchange="document.getElementById('filter-form').submit()"
                        class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                        <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A - Z</option>
                        <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Z - A</option>
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                {{-- Tombol Reset --}}
                @if(request('search') || request('kategori') || (request('sort') && request('sort') != 'terbaru'))
                    <a href="{{ route('anggota.dashboard') }}"
                        class="flex items-center gap-1 rounded-lg border border-stroke px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors whitespace-nowrap">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset Filter
                    </a>
                @endif
            </form>

            {{-- Grid Buku --}}
            <div id="buku-grid" class="grid grid-cols-2 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @forelse($buku as $item)
                    <a href="{{ route('anggota.buku.detail', $item->id_buku) }}"
                        class="group flex flex-col rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 overflow-hidden cursor-pointer"
                        title="Lihat detail: {{ $item->judul_buku }}">

                        {{-- Image --}}
                        <div class="relative aspect-2/3 w-full overflow-hidden bg-gray-100">
                            @if($item->sampul)
                                <img src="{{ Storage::url($item->sampul) }}" alt="{{ $item->judul_buku }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-linear-to-br from-[#e8f4f0] to-[#c8e6d8]">
                                    <svg class="h-12 w-12 text-[#0f4c3a] opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            {{-- Status overlay --}}
                            <div class="absolute top-2 left-2">
                                @if($item->stok > 0)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-500/90 px-2 py-0.5 text-[10px] font-bold uppercase text-white backdrop-blur-sm">
                                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-500/90 px-2 py-0.5 text-[10px] font-bold uppercase text-white backdrop-blur-sm">
                                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                                        Habis
                                    </span>
                                @endif
                            </div>

                            {{-- Hover overlay --}}
                            <div class="absolute inset-0 bg-[#0f4c3a]/0 group-hover:bg-[#0f4c3a]/20 transition-all duration-300 flex items-center justify-center">
                                <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-100 scale-90">
                                    <div class="rounded-full bg-white/90 px-3 py-1.5 text-xs font-bold text-[#0f4c3a] shadow-lg backdrop-blur-sm">
                                        Lihat Detail →
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-col flex-1 p-2.5">
                            <p class="mb-0.5 text-[10px] text-[#0f4c3a] font-medium uppercase tracking-wide">
                                {{ $item->kategori->first()?->nama_kategori ?? 'Umum' }}
                            </p>
                            <h4 class="text-xs font-bold text-black line-clamp-2 leading-snug mb-1"
                                title="{{ $item->judul_buku }}">
                                {{ $item->judul_buku }}
                            </h4>
                            <p class="text-[10px] text-gray-500 line-clamp-1">{{ $item->penulis }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <div class="rounded-full bg-gray-100 p-6">
                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-black">Buku tidak ditemukan</h3>
                                <p class="mt-1 text-gray-500">Coba gunakan kata kunci lain atau ubah filter.</p>
                            </div>
                            <a href="{{ route('anggota.dashboard') }}"
                                class="mt-2 inline-flex items-center text-primary hover:underline text-sm font-medium">
                                Bersihkan semua filter
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div id="pagination-container" class="mt-6">
                {{ $buku->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let searchTimeout = null;
            let currentSearch = "{{ request('search', '') }}";
            let currentKategori = "{{ request('kategori', '') }}";
            let currentSort = "{{ request('sort', 'terbaru') }}";

            const searchInput = document.getElementById('katalog-search');
            const spinner = document.getElementById('search-spinner');
            const grid = document.getElementById('buku-grid');
            const paginationContainer = document.getElementById('pagination-container');
            const selectKategori = document.getElementById('filter-kategori');
            const selectSort = document.getElementById('filter-sort');

            // Fetch buku via AJAX
            function fetchBuku(page) {
                page = page || 1;
                if (spinner) spinner.classList.remove('hidden');

                const params = new URLSearchParams();
                if (currentSearch) params.set('search', currentSearch);
                if (currentKategori) params.set('kategori', currentKategori);
                if (currentSort) params.set('sort', currentSort);
                params.set('page', page);
                params.set('ajax', '1');

                // Update URL bar tanpa reload
                const displayParams = new URLSearchParams();
                if (currentSearch) displayParams.set('search', currentSearch);
                if (currentKategori) displayParams.set('kategori', currentKategori);
                if (currentSort && currentSort !== 'terbaru') displayParams.set('sort', currentSort);
                if (page > 1) displayParams.set('page', page);
                const newUrl = window.location.pathname + (displayParams.toString() ? '?' + displayParams.toString() : '');
                history.replaceState(null, '', newUrl);

                fetch(window.location.pathname + '?' + params.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function(res) {
                    if (!res.ok) throw new Error('Network error');
                    return res.json();
                })
                .then(function(data) {
                    grid.innerHTML = data.html;
                    paginationContainer.innerHTML = data.pagination;
                    bindPaginationLinks();
                    if (spinner) spinner.classList.add('hidden');
                })
                .catch(function() {
                    if (spinner) spinner.classList.add('hidden');
                    window.location.reload();
                });
            }

            // Bind pagination links agar tidak reload
            function bindPaginationLinks() {
                paginationContainer.querySelectorAll('a[href]').forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        try {
                            var url = new URL(this.href);
                            var page = url.searchParams.get('page') || 1;
                            fetchBuku(page);
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        } catch(err) {
                            window.location.href = this.href;
                        }
                    });
                });
            }

            // Live search dengan debounce 400ms
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function() {
                        currentSearch = searchInput.value.trim();
                        fetchBuku(1);
                    }, 400);
                });
            }

            // Kategori & sort: AJAX saat berubah (bukan submit form)
            if (selectKategori) {
                selectKategori.onchange = function() {
                    currentKategori = this.value;
                    fetchBuku(1);
                };
            }

            if (selectSort) {
                selectSort.onchange = function() {
                    currentSort = this.value;
                    fetchBuku(1);
                };
            }

            // Init: bind pagination yang sudah di-render server
            bindPaginationLinks();
        });
    </script>
    @endpush
@endsection
