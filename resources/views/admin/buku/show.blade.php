@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('admin.buku.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary md:ml-2 dark:text-gray-400 dark:hover:text-white">Data Buku</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $buku->judul_buku }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Book Detail Card -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Cover Image -->
            <div class="lg:col-span-1">
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden bg-white dark:bg-gray-800">
                    <div class="aspect-[3/4] bg-gray-100 dark:bg-gray-700">
                        @if($buku->sampul)
                            <img src="{{ Storage::url($buku->sampul) }}" alt="{{ $buku->judul_buku }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                 onclick="window.open('{{ Storage::url($buku->sampul) }}', '_blank')">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="p-4 space-y-2">
                        <button onclick="window.print()" class="w-full flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak Detail
                        </button>
                        
                        <div class="flex gap-2">
                            <button @click="$dispatch('open-edit-book-modal', { 
                                id: '{{ $buku->id_buku }}',
                                judul: '{{ addslashes($buku->judul_buku) }}',
                                isbn: '{{ $buku->isbn }}',
                                penulis: '{{ addslashes($buku->penulis) }}',
                                penerbit: '{{ addslashes($buku->penerbit) }}',
                                stok: '{{ $buku->stok }}',
                                sinopsis: '{{ addslashes($buku->sinopsis ?? '') }}',
                                jumlah_halaman: '{{ $buku->jumlah_halaman ?? '' }}',
                                tahun_terbit: '{{ $buku->tahun_terbit ?? '' }}',
                                bahasa: '{{ $buku->bahasa ?? '' }}',
                                kategori: {{ $buku->kategori->pluck('id_kategori') }},
                                lokasi: '{{ addslashes($buku->lokasi_rak) }}'
                            })" class="flex-1 flex items-center justify-center gap-2 rounded-lg bg-brand-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </button>
                            
                            <button onclick="shareBook()" class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m9.032 4.026a9.001 9.001 0 01-7.432 0m9.032-4.026A9.001 9.001 0 0112 3c-4.474 0-8.268 2.943-9.543 7a9.97 9.97 0 011.827 3.342M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Book Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title and Status -->
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $buku->judul_buku }}</h1>
                            <div class="flex flex-wrap gap-2">
                                @foreach($buku->kategori as $kategori)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $kategori->nama_kategori }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $buku->stok > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 mt-1">Stok: {{ $buku->stok }}</span>
                        </div>
                    </div>

                    <!-- Book Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">ISBN</h3>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $buku->isbn ?? 'Tidak tersedia' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Penulis</h3>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $buku->penulis ?? 'Tidak diketahui' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Penerbit</h3>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $buku->penerbit ?? 'Tidak diketahui' }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Halaman</h3>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $buku->formatted_jumlah_halaman }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tahun Terbit</h3>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $buku->formatted_tahun_terbit }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Bahasa</h3>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $buku->formatted_bahasa }}</p>
                            </div>
                        </div>
                    </div>

                    @if($buku->lokasi_rak)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi Rak</h3>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $buku->lokasi_rak }}</p>
                    </div>
                    @endif
                </div>

                <!-- Synopsis -->
                @if($buku->sinopsis)
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Sinopsis</h2>
                    <div class="prose prose-sm dark:prose-invert max-w-none">
                        {!! $buku->sinopsis !!}
                    </div>
                </div>
                @endif

                <!-- Related Books -->
                @if($relatedBooks->count() > 0)
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Buku Terkait</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($relatedBooks as $book)
                        <a href="{{ route('admin.buku.show', $book->id_buku) }}" class="group block">
                            <div class="rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="aspect-[3/4] bg-gray-100 dark:bg-gray-700">
                                    @if($book->sampul)
                                        <img src="{{ Storage::url($book->sampul) }}" alt="{{ $book->judul_buku }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-3">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-primary line-clamp-2">{{ $book->judul_buku }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $book->penulis ?? 'Unknown' }}</p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Include Modal -->
    @include('admin.buku.partials.modal')

    <script>
    function shareBook() {
        const url = window.location.href;
        const title = '{{ $buku->judul_buku }}';
        
        if (navigator.share) {
            navigator.share({
                title: title,
                text: `Lihat buku "${title}" di perpustakaan digital`,
                url: url
            });
        } else {
            // Fallback: Copy to clipboard
            navigator.clipboard.writeText(url).then(() => {
                alert('Link buku telah disalin ke clipboard!');
            });
        }
    }
    </script>
@endsection
