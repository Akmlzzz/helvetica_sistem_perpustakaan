@extends('layouts.app')

@section('content')
    <div>
        {{-- Header & Filter --}}
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-black">
                    Katalog Buku
                </h2>
                <p class="text-gray-500">Klik pada buku untuk melihat detail dan meminjam</p>
            </div>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                {{-- Search (live, tanpa reload) --}}
                <div class="relative">
                    <input type="text" id="katalog-search" placeholder="Cari Judul / Penulis / Sinopsis..."
                        value="{{ request('search') }}"
                        class="w-full rounded-full border border-stroke bg-gray-50 py-2.5 pl-12 pr-10 focus:border-primary focus:outline-none md:w-64"
                        autocomplete="off" />
                    <span class="absolute left-4 top-3">
                        <svg class="fill-current text-gray-400" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15.7499 14.3332L21.4166 19.9999L19.9999 21.4166L14.3332 15.7499C13.0666 16.7332 11.4925 17.3332 9.74992 17.3332C5.55825 17.3332 2.16659 13.9416 2.16659 9.74992C2.16659 5.55825 5.55825 2.16659 9.74992 2.16659C13.9416 2.16659 17.3332 5.55825 17.3332 9.74992C17.3332 11.4925 16.7332 13.0666 15.7499 14.3332ZM9.74992 4.16659C6.66659 4.16659 4.16659 6.66659 4.16659 9.74992C4.16659 12.8333 6.66659 15.3333 9.74992 15.3333C12.8333 15.3333 15.3333 12.8333 15.3333 9.74992C15.3333 6.66659 12.8333 4.16659 9.74992 4.16659Z" />
                        </svg>
                    </span>
                    {{-- Spinner --}}
                    <span id="search-spinner" class="absolute right-4 top-3 hidden">
                        <svg class="h-4 w-4 animate-spin text-gray-400" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </span>
                </div>

                {{-- Category Dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-2 rounded-full border border-stroke bg-gray-50 px-4 py-2.5 font-medium text-black focus:border-primary focus:outline-none">
                        <span id="selected-kategori-label">{{ request('kategori') ? request('kategori') : 'Semua Kategori' }}</span>
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg" :class="open && 'rotate-180'">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.29289 7.29289C5.68342 6.90237 6.31658 6.90237 6.70711 7.29289L10 10.5858L13.2929 7.29289C13.6834 6.90237 14.3166 6.90237 14.7071 7.29289C15.0976 7.68342 15.0976 8.31658 14.7071 8.70711L10.7071 12.7071C10.3166 13.0976 9.68342 13.0976 9.29289 12.7071L5.29289 8.70711C4.90237 8.31658 4.90237 7.68342 5.29289 7.29289Z" />
                        </svg>
                    </button>

                    <div x-show="open" @click.outside="open = false"
                        class="absolute right-0 top-full mt-2 w-48 rounded-md border border-stroke bg-white shadow-default z-50 py-1"
                        style="display: none;">
                        <button type="button" onclick="filterKategori('')"
                            class="block w-full text-left px-4 py-2 text-sm text-black hover:bg-gray-100 {{ !request('kategori') ? 'font-bold bg-gray-50' : '' }}">
                            Semua Kategori
                        </button>
                        @foreach($kategori as $kat)
                            <button type="button" onclick="filterKategori('{{ $kat->nama_kategori }}')"
                                class="block w-full text-left px-4 py-2 text-sm text-black hover:bg-gray-100 {{ request('kategori') == $kat->nama_kategori ? 'font-bold bg-gray-50' : '' }}">
                                {{ $kat->nama_kategori }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Label filter aktif --}}
        <div id="filter-label" class="{{ (request('search') || request('kategori')) ? '' : 'hidden' }} mb-4">
            <span class="inline-flex items-center gap-2 rounded-full bg-[#e8f4f0] px-3 py-1 text-sm font-medium text-[#0f4c3a]">
                <span id="filter-label-text">
                    @php
                        $parts = [];
                        if (request('search')) $parts[] = '"' . request('search') . '"';
                        if (request('kategori')) $parts[] = 'Kategori: ' . request('kategori');
                    @endphp
                    {{ count($parts) ? 'Filter: ' . implode(' · ', $parts) : '' }}
                </span>
                <button onclick="clearFilters()" class="hover:text-red-600 transition-colors font-bold">&times;</button>
            </span>
        </div>

        {{-- Grid --}}
        <div id="buku-grid" class="grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4">
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
                                <svg class="h-16 w-16 text-[#0f4c3a] opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <div class="rounded-full bg-white/90 px-4 py-2 text-sm font-bold text-[#0f4c3a] shadow-lg backdrop-blur-sm">
                                    Lihat Detail →
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex flex-col flex-1 p-3">
                        <p class="mb-0.5 text-xs text-[#0f4c3a] font-medium">
                            {{ $item->kategori->first()?->nama_kategori ?? 'Umum' }}
                        </p>
                        <h4 class="text-sm font-bold text-black line-clamp-2 leading-snug mb-1"
                            title="{{ $item->judul_buku }}">
                            {{ $item->judul_buku }}
                        </h4>
                        <p class="text-xs text-gray-500 line-clamp-1">{{ $item->penulis }}</p>
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
                            <p class="mt-1 text-gray-500">Coba gunakan kata kunci lain atau filter kategori yang berbeda.</p>
                        </div>
                        @if(request('search') || request('kategori'))
                            <button onclick="clearFilters()"
                                class="mt-2 inline-flex items-center text-primary hover:underline">
                                Bersihkan semua filter
                            </button>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <div id="pagination-container" class="mt-8">
            {{ $buku->links() }}
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            let searchTimeout = null;
            let currentSearch = @json(request('search', ''));
            let currentKategori = @json(request('kategori', ''));

            const searchInput = document.getElementById('katalog-search');
            const spinner = document.getElementById('search-spinner');
            const grid = document.getElementById('buku-grid');
            const paginationContainer = document.getElementById('pagination-container');
            const filterLabel = document.getElementById('filter-label');
            const filterLabelText = document.getElementById('filter-label-text');
            const selectedKategoriLabel = document.getElementById('selected-kategori-label');

            // Update label chip filter
            function updateFilterLabel() {
                const parts = [];
                if (currentSearch) parts.push('"' + currentSearch + '"');
                if (currentKategori) parts.push('Kategori: ' + currentKategori);

                if (parts.length > 0) {
                    filterLabelText.textContent = 'Filter: ' + parts.join(' · ');
                    filterLabel.classList.remove('hidden');
                } else {
                    filterLabel.classList.add('hidden');
                }
            }

            // Fetch buku via AJAX
            function fetchBuku(page) {
                page = page || 1;
                spinner.classList.remove('hidden');

                const params = new URLSearchParams();
                if (currentSearch) params.set('search', currentSearch);
                if (currentKategori) params.set('kategori', currentKategori);
                params.set('page', page);
                params.set('ajax', '1');

                // Update URL bar tanpa reload
                const displayParams = new URLSearchParams();
                if (currentSearch) displayParams.set('search', currentSearch);
                if (currentKategori) displayParams.set('kategori', currentKategori);
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
                    spinner.classList.add('hidden');
                    updateFilterLabel();
                })
                .catch(function() {
                    spinner.classList.add('hidden');
                    // Fallback: reload biasa jika AJAX gagal
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

            // Filter kategori (dipanggil dari onclick button)
            window.filterKategori = function(nama) {
                currentKategori = nama;
                selectedKategoriLabel.textContent = nama || 'Semua Kategori';
                fetchBuku(1);
            };

            // Clear semua filter
            window.clearFilters = function() {
                currentSearch = '';
                currentKategori = '';
                if (searchInput) searchInput.value = '';
                selectedKategoriLabel.textContent = 'Semua Kategori';
                fetchBuku(1);
            };

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

            // Init: bind pagination yang sudah di-render server
            bindPaginationLinks();
            updateFilterLabel();
        })();
    </script>
    @endpush
@endsection