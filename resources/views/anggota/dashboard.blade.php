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
                        <svg class="h-5 w-5 text-black hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
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
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
                {{-- Filter Series --}}
                <div class="relative w-full sm:w-48">
                    <select id="filter-series" name="series" onchange="document.getElementById('filter-form').submit()"
                        class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                        <option value="all">Semua Series</option>
                        @foreach($series as $s)
                            <option value="{{ $s->id_series }}" {{ request('series') == $s->id_series ? 'selected' : '' }}>
                                {{ $s->nama_series }}
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                        Reset Filter
                    </a>
                @endif
            </form>

            {{-- Grid Buku --}}
            <div id="buku-grid" class="grid grid-cols-2 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @include('anggota.partials.buku-grid')
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
            let currentSeries = "{{ request('series', 'all') }}";

            const searchInput = document.getElementById('katalog-search');
            const spinner = document.getElementById('search-spinner');
            const grid = document.getElementById('buku-grid');
            const paginationContainer = document.getElementById('pagination-container');
            const selectKategori = document.getElementById('filter-kategori');
            const selectSeries = document.getElementById('filter-series');
            const selectSort = document.getElementById('filter-sort');

            // Fetch buku via AJAX
            function fetchBuku(page) {
                page = page || 1;
                if (spinner) spinner.classList.remove('hidden');

                const params = new URLSearchParams();
                if (currentSearch) params.set('search', currentSearch);
                if (currentKategori) params.set('kategori', currentKategori);
                if (currentSeries && currentSeries !== 'all') params.set('series', currentSeries);
                if (currentSort) params.set('sort', currentSort);
                params.set('page', page);
                params.set('ajax', '1');

                // Update URL bar tanpa reload
                const displayParams = new URLSearchParams();
                if (currentSearch) displayParams.set('search', currentSearch);
                if (currentKategori) displayParams.set('kategori', currentKategori);
                if (currentSeries && currentSeries !== 'all') displayParams.set('series', currentSeries);
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

            if (selectSeries) {
                selectSeries.onchange = function() {
                    currentSeries = this.value;
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
