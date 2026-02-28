@forelse($buku as $item)
    <a href="{{ route('anggota.buku.detail', $item->id_buku) }}"
        class="group flex flex-col rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 overflow-hidden cursor-pointer"
        title="Lihat detail: {{ $item->judul_buku }}">

        {{-- Image --}}
        <div class="relative aspect-2/3 w-full overflow-hidden bg-gray-100">
            @if($item->sampul)
                <img src="{{ Storage::url($item->sampul) }}" alt="{{ $item->judul_buku }}" loading="lazy"
                    style="image-rendering: -webkit-optimize-contrast;"
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
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-green-500/90 px-2 py-0.5 text-[10px] font-bold uppercase text-white backdrop-blur-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                        Tersedia
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-red-500/90 px-2 py-0.5 text-[10px] font-bold uppercase text-white backdrop-blur-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                        Habis
                    </span>
                @endif
            </div>

            {{-- Hover overlay --}}
            <div
                class="absolute inset-0 bg-[#0f4c3a]/0 group-hover:bg-[#0f4c3a]/20 transition-all duration-300 flex items-center justify-center">
                <div
                    class="opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-100 scale-90">
                    <div
                        class="rounded-full bg-white/90 px-4 py-2 text-sm font-bold text-[#0f4c3a] shadow-lg backdrop-blur-sm">
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
            <h4 class="text-sm font-bold text-black line-clamp-2 leading-snug mb-1" title="{{ $item->judul_buku }}">
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
            <button onclick="clearFilters()" class="mt-2 inline-flex items-center text-primary hover:underline">
                Bersihkan semua filter
            </button>
        </div>
    </div>
@endforelse