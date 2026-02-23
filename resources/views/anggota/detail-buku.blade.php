@extends('layouts.app')

@section('content')
    {{-- Breadcrumb --}}
    <nav class="mb-4 flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('anggota.dashboard') }}" class="hover:text-[#0f4c3a] transition-colors flex items-center gap-1">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Katalog Buku
        </a>
        <span>/</span>
        <span class="text-gray-800 font-medium line-clamp-1">{{ $buku->judul_buku }}</span>
    </nav>

    {{-- Main Card: 2 kolom, muat di layar tanpa scroll --}}
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden"
        style="height: calc(100vh - 160px); min-height: 520px;">
        <div class="flex h-full">

            {{-- ===== KOLOM KIRI: Cover + Tombol Pinjam ===== --}}
            <div
                class="w-64 xl:w-72 flex-shrink-0 flex flex-col bg-gradient-to-b from-[#e8f4f0] to-[#d0ebe0] border-r border-gray-100">

                {{-- Cover --}}
                <div class="flex-1 flex items-center justify-center p-5 overflow-hidden">
                    @if($buku->sampul)
                        <img src="{{ Storage::url($buku->sampul) }}" alt="{{ $buku->judul_buku }}"
                            class="max-h-full w-full object-contain rounded-xl shadow-lg"
                            style="max-height: calc(100vh - 340px);">
                    @else
                        <div class="w-full rounded-xl shadow-lg bg-white/50 flex items-center justify-center"
                            style="aspect-ratio: 2/3; max-height: calc(100vh - 340px);">
                            <svg class="h-20 w-20 text-[#0f4c3a] opacity-30" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                                </path>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Status + Tombol (bagian bawah kolom kiri, tetap) --}}
                <div class="px-5 pb-5 space-y-3 shrink-0">
                    {{-- Status Stok --}}
                    <div class="text-center">
                        @if($buku->stok > 0)
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1.5 text-xs font-bold text-green-700">
                                <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                                Tersedia &bull; {{ $buku->stok }} stok
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700">
                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                Stok Habis
                            </span>
                        @endif
                    </div>

                    {{-- Tombol Aksi --}}
                    @if($sedangMeminjam)
                        <div class="rounded-xl bg-yellow-50 border border-yellow-200 p-3">
                            <p class="text-xs font-medium text-yellow-800 text-center">
                                Sedang dipinjam.
                                <a href="{{ route('anggota.pinjaman') }}"
                                    class="underline block mt-1 hover:text-yellow-900">Lihat pinjaman saya →</a>
                            </p>
                        </div>
                    @elseif($buku->stok > 0)
                        <div x-data="{ durasi: 7, showConfirm: false }">
                            {{-- Slider durasi ringkas --}}
                            <div class="mb-2">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-gray-500">Durasi: <strong class="text-[#0f4c3a]"
                                            x-text="durasi"></strong> hari</span>
                                    <span class="text-xs text-gray-400">Maks. 14 hari</span>
                                </div>
                                <input type="range" min="1" max="14" x-model="durasi"
                                    class="w-full h-2 bg-white rounded-lg appearance-none cursor-pointer accent-[#0f4c3a]">
                                <div class="flex justify-between mt-0.5">
                                    <span class="text-[10px] text-gray-400">1</span>
                                    <span class="text-[10px] text-gray-400">14 hari</span>
                                </div>
                            </div>

                            {{-- Info jatuh tempo mini --}}
                            <div class="mb-3 rounded-lg bg-white/70 border border-[#c8e6d8] p-2 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Pinjam:</span>
                                    <span
                                        class="font-semibold text-black">{{ \Carbon\Carbon::today()->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                </div>
                                <div class="flex justify-between mt-0.5">
                                    <span class="text-gray-500">Jatuh tempo:</span>
                                    <span class="font-semibold text-[#0f4c3a]" id="jatuh-tempo-label">-</span>
                                </div>
                            </div>

                            {{-- Tombol Pinjam --}}
                            <button @click="showConfirm = true"
                                class="w-full rounded-xl bg-[#0f4c3a] py-3 text-sm font-bold text-white transition hover:bg-[#0a382b] flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Pinjam Buku Sekarang
                            </button>

                            {{-- Confirm Modal --}}
                            <div x-show="showConfirm" x-transition
                                class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
                                style="display: none;">
                                <div @click.outside="showConfirm = false"
                                    class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl">
                                    <div class="mb-6 text-center">
                                        <div
                                            class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#e8f4f0]">
                                            <svg class="h-8 w-8 text-[#0f4c3a]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-black mb-1">Konfirmasi Peminjaman</h3>
                                        <p class="text-gray-500 text-sm">Pastikan data peminjaman sudah benar</p>
                                    </div>

                                    <div class="mb-6 rounded-xl bg-gray-50 p-4 space-y-2">
                                        <div class="flex items-start justify-between gap-2">
                                            <span class="text-sm text-gray-500 shrink-0">Buku:</span>
                                            <span
                                                class="text-sm font-semibold text-black text-right">{{ $buku->judul_buku }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500">Durasi:</span>
                                            <span class="text-sm font-semibold text-[#0f4c3a]" x-text="durasi + ' hari'"></span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500">Jatuh Tempo:</span>
                                            <span class="text-sm font-semibold text-[#0f4c3a]" id="confirm-jatuh-tempo">-</span>
                                        </div>
                                    </div>

                                    <form action="{{ route('anggota.booking.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">
                                        <input type="hidden" name="durasi_pinjam" :value="durasi">
                                        <div class="flex gap-3">
                                            <button type="button" @click="showConfirm = false"
                                                class="flex-1 rounded-xl border border-gray-300 py-3 font-medium text-gray-700 hover:bg-gray-50 transition">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                class="flex-1 rounded-xl bg-[#0f4c3a] py-3 font-bold text-white hover:bg-[#0a382b] transition shadow-md">
                                                Ya, Pinjam!
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('alpine:init', () => {
                                const today = new Date();
                                const updateLabel = (durasi) => {
                                    const jatuhTempo = new Date(today);
                                    jatuhTempo.setDate(today.getDate() + parseInt(durasi));
                                    const formatted = jatuhTempo.toLocaleDateString('id-ID', {
                                        day: 'numeric', month: 'short', year: 'numeric'
                                    });
                                    const el = document.getElementById('jatuh-tempo-label');
                                    const el2 = document.getElementById('confirm-jatuh-tempo');
                                    if (el) el.textContent = formatted;
                                    if (el2) el2.textContent = formatted;
                                };
                                updateLabel(7);
                                document.querySelector('input[type=range]')?.addEventListener('input', (e) => {
                                    updateLabel(e.target.value);
                                });
                            });
                        </script>
                    @else
                        <button disabled
                            class="w-full rounded-xl bg-gray-200 py-3 text-sm font-bold text-gray-400 cursor-not-allowed">
                            Stok Habis - Tidak Tersedia
                        </button>
                    @endif
                </div>
            </div>

            {{-- ===== KOLOM KANAN: Info Buku + Sinopsis (scroll mandiri) ===== --}}
            <div class="flex-1 overflow-y-auto">
                <div class="p-6 xl:p-8">

                    {{-- Kategori badges --}}
                    <div class="mb-3 flex flex-wrap gap-2">
                        @forelse($buku->kategori as $kat)
                            <a href="{{ route('anggota.dashboard', ['kategori' => $kat->nama_kategori]) }}"
                                class="inline-flex items-center rounded-full bg-[#e8f4f0] px-3 py-1 text-xs font-bold text-[#0f4c3a] hover:bg-[#0f4c3a] hover:text-white transition-colors">
                                {{ $kat->nama_kategori }}
                            </a>
                        @empty
                            <span
                                class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">Umum</span>
                        @endforelse
                    </div>

                    {{-- Judul & Penulis --}}
                    <h1 class="mb-1 text-2xl xl:text-3xl font-bold text-black leading-tight">{{ $buku->judul_buku }}</h1>
                    <p class="mb-5 text-base text-[#0f4c3a] font-medium">{{ $buku->penulis }}</p>

                    {{-- Info Grid --}}
                    <div class="mb-5 grid grid-cols-2 xl:grid-cols-3 gap-3 rounded-xl bg-gray-50 p-4">
                        @if($buku->isbn)
                            <div>
                                <span
                                    class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">ISBN</span>
                                <span class="text-sm font-semibold text-black">{{ $buku->isbn }}</span>
                            </div>
                        @endif
                        @if($buku->penerbit)
                            <div>
                                <span
                                    class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">Penerbit</span>
                                <span class="text-sm font-semibold text-black">{{ $buku->penerbit }}</span>
                            </div>
                        @endif
                        @if($buku->tahun_terbit)
                            <div>
                                <span class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">Tahun
                                    Terbit</span>
                                <span class="text-sm font-semibold text-black">{{ $buku->tahun_terbit }}</span>
                            </div>
                        @endif
                        @if($buku->jumlah_halaman)
                            <div>
                                <span class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">Jumlah
                                    Halaman</span>
                                <span
                                    class="text-sm font-semibold text-black">{{ number_format($buku->jumlah_halaman, 0, ',', '.') }}
                                    hal.</span>
                            </div>
                        @endif
                        @if($buku->bahasa)
                            <div>
                                <span
                                    class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">Bahasa</span>
                                <span class="text-sm font-semibold text-black">{{ $buku->formatted_bahasa }}</span>
                            </div>
                        @endif
                        @if($buku->lokasi_rak)
                            <div>
                                <span class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">Lokasi
                                    Rak</span>
                                <span class="text-sm font-semibold text-black">{{ $buku->lokasi_rak }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Sinopsis --}}
                    @if($buku->sinopsis)
                        <div>
                            <h2
                                class="mb-2 text-sm font-bold text-gray-500 flex items-center gap-2 uppercase tracking-wide text-gray-500">
                                <svg class="h-4 w-4 text-[#0f4c3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Sinopsis
                            </h2>
                            <div
                                class="prose prose-sm max-w-none text-gray-600 leading-relaxed
                                                                        [&_p]:mb-3 [&_strong]:font-semibold [&_em]:italic
                                                                        [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5">
                                {!! $buku->sinopsis !!}
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

    {{-- Buku Terkait --}}
    @if($bukuTerkait->count() > 0)
        <div class="mt-8">
            <h2 class="mb-4 text-lg font-bold text-black">Buku Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($bukuTerkait as $related)
                    <a href="{{ route('anggota.buku.detail', $related->id_buku) }}"
                        class="group flex flex-col rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 overflow-hidden">
                        <div class="aspect-2/3 w-full overflow-hidden bg-gray-100">
                            @if($related->sampul)
                                <img src="{{ Storage::url($related->sampul) }}" alt="{{ $related->judul_buku }}" loading="lazy"
                                    class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-linear-to-br from-[#e8f4f0] to-[#c8e6d8]">
                                    <svg class="h-10 w-10 text-[#0f4c3a] opacity-30" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <p class="text-xs text-[#0f4c3a] font-medium mb-0.5">
                                {{ $related->kategori->first()?->nama_kategori ?? 'Umum' }}
                            </p>
                            <h4 class="text-sm font-bold text-black line-clamp-2 leading-snug">{{ $related->judul_buku }}</h4>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $related->penulis }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

@endsection