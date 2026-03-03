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
                    {{-- Wishlist Button --}}
                    @php
                        $inWishlist = \App\Models\KoleksiPribadi::where('id_pengguna', auth()->user()->id_pengguna)->where('id_buku', $buku->id_buku)->exists();
                    @endphp
                    <div x-data="{
                                        inWishlist: {{ $inWishlist ? 'true' : 'false' }},
                                        loading: false,
                                        toggleWishlist() {
                                            if (this.loading) return;
                                            this.loading = true;

                                            const isAdding = !this.inWishlist;
                                            const url = isAdding 
                                                ? '{{ route('anggota.koleksi.store', $buku->id_buku) }}' 
                                                : '{{ route('anggota.koleksi.destroy', $buku->id_buku) }}';

                                            const method = isAdding ? 'POST' : 'DELETE';

                                            fetch(url, {
                                                method: method,
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'X-Requested-With': 'XMLHttpRequest',
                                                    'Accept': 'application/json',
                                                    'Content-Type': 'application/json'
                                                }
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    this.inWishlist = !this.inWishlist;
                                                    // Optional: show toast notification here
                                                }
                                            })
                                            .catch(error => console.error('Error:', error))
                                            .finally(() => {
                                                this.loading = false;
                                            });
                                        }
                                    }">
                        <button @click="toggleWishlist" :disabled="loading"
                            :class="inWishlist ? 'border-red-500 bg-red-50 text-red-600 hover:bg-red-100' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'"
                            class="w-full flex items-center justify-center gap-2 rounded-xl border py-2.5 text-sm font-semibold transition shadow-sm mb-3">

                            <template x-if="loading">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                </svg>
                            </template>

                            <template x-if="!loading && inWishlist">
                                <span class="flex items-center gap-2">
                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                        <path
                                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                    </svg>
                                    Hapus dari Koleksi
                                </span>
                            </template>

                            <template x-if="!loading && !inWishlist">
                                <span class="flex items-center gap-2">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Tambah ke Koleksi
                                </span>
                            </template>
                        </button>
                    </div>

                    @if(!$akunTerverifikasi)
                        {{-- Akun belum diverifikasi --}}
                        <div class="rounded-xl border-2 border-amber-300 bg-amber-50 p-4 text-center">
                            <div class="mb-2 flex items-center justify-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100">
                                    <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs font-bold text-amber-800 leading-snug mb-1">
                                @if(auth()->user()->status === 'pending')
                                    Akun Menunggu Verifikasi
                                @else
                                    Akun Tidak Aktif
                                @endif
                            </p>
                            <p class="text-[11px] text-amber-700 leading-snug mb-3">
                                @if(auth()->user()->status === 'pending')
                                    Akun Anda sedang diproses admin. Anda hanya dapat melihat katalog.
                                @else
                                    Akun Anda ditolak. Hubungi petugas untuk info lebih lanjut.
                                @endif
                            </p>
                            <a href="{{ route('anggota.profile') }}"
                                class="inline-flex items-center gap-1 rounded-lg bg-amber-600 px-3 py-1.5 text-[11px] font-bold text-white hover:bg-amber-700 transition">
                                Lihat Status Akun →
                            </a>
                        </div>
                        <button disabled
                            class="w-full rounded-xl bg-gray-200 py-3 text-sm font-bold text-gray-400 cursor-not-allowed mt-2">
                            Peminjaman Tidak Tersedia
                        </button>
                    @elseif($sedangMeminjam)

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

                    {{-- AI Magic Summary --}}
                    <div class="mb-5" x-data="{ 
                                showAi: false, 
                                loading: false, 
                                summary: '', 
                                getSummary() {
                                    if (this.summary) {
                                        this.showAi = true;
                                        return;
                                    }
                                    this.loading = true;
                                    this.showAi = true;
                                    fetch('{{ route('api.ai.summary') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ id_buku: {{ $buku->id_buku }} })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.summary) this.summary = data.summary;
                                        else this.summary = 'Gagal mendapatkan ringkasan AI.';
                                    })
                                    .catch(() => this.summary = 'Terjadi kesalahan koneksi.')
                                    .finally(() => this.loading = false);
                                }
                            }">
                        <button @click="getSummary"
                            class="w-full flex items-center justify-between gap-3 p-4 rounded-2xl bg-linear-to-r from-[#0f4c3a] to-[#1a6b54] text-white shadow-md hover:shadow-lg transition-all group overflow-hidden relative">
                            <div class="flex items-center gap-3 relative z-10">
                                <div
                                    class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-md group-hover:scale-110 transition-transform">
                                    <svg class="h-6 w-6 text-yellow-300 animate-pulse" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <span class="block text-sm font-bold">AI Magic Summary</span>
                                    <span
                                        class="block text-[10px] text-white/70 uppercase tracking-widest font-medium">Bantu
                                        pahami isi buku dalam sekejap</span>
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-white/50 group-hover:translate-x-1 transition-transform relative z-10"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>

                            {{-- Decorative Background element --}}
                            <div
                                class="absolute -right-4 -top-4 h-24 w-24 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all">
                            </div>
                        </button>

                        {{-- AI Summary Modal/Panel --}}
                        <div x-show="showAi" x-transition
                            class="mt-4 bg-[#f0f9f6] rounded-3xl border border-[#c8e6d8] p-6 shadow-inner relative overflow-hidden"
                            style="display: none;">
                            <button @click="showAi = false"
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <template x-if="loading">
                                <div class="flex flex-col items-center py-8">
                                    <div class="flex gap-1 mb-3">
                                        <div class="h-2 w-2 bg-[#0f4c3a] rounded-full animate-bounce"
                                            style="animation-delay: 0.1s"></div>
                                        <div class="h-2 w-2 bg-[#0f4c3a] rounded-full animate-bounce"
                                            style="animation-delay: 0.2s"></div>
                                        <div class="h-2 w-2 bg-[#0f4c3a] rounded-full animate-bounce"
                                            style="animation-delay: 0.3s"></div>
                                    </div>
                                    <p class="text-xs font-bold text-[#0f4c3a] uppercase tracking-widest">AI sedang
                                        membaca...</p>
                                </div>
                            </template>

                            <template x-if="!loading && summary">
                                <div
                                    class="prose prose-sm max-w-none text-gray-700 leading-relaxed prose-headings:text-[#0f4c3a] prose-strong:text-black">
                                    <div x-html="summary"></div>
                                    <div class="mt-6 pt-4 border-t border-[#c8e6d8] flex items-center justify-between">
                                        <p class="text-[10px] text-gray-400 italic">Dihasilkan oleh Biblio AI Assistant</p>
                                        <div class="flex gap-2">
                                            <span class="text-[9px] font-black text-[#0f4c3a] opacity-50">#AI</span>
                                            <span class="text-[9px] font-black text-[#0f4c3a] opacity-50">#REKAP</span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
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

    {{-- Reviews Section --}}
    <div class="mt-8 border-t border-gray-100 pt-8" id="ulasan-section">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-black flex items-center gap-2">
                    Ulasan & Rating
                </h2>
                <p class="text-gray-500 text-sm mt-1">Apa kata mereka tentang buku ini?</p>
            </div>
            @if($buku->ulasan->count() > 0)
                <div class="flex items-center gap-3 bg-[#e8f4f0] p-3 rounded-2xl border border-[#c8e6d8]">
                    <div class="text-center">
                        <span class="text-3xl font-black text-[#0f4c3a]">{{ $buku->average_rating }}</span>
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="h-3 w-3 {{ $i <= round($buku->average_rating) ? 'fill-current' : 'fill-gray-300' }}"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                    <div class="border-l border-[#c8e6d8] pl-3">
                        <span
                            class="block text-xs font-bold text-[#0f4c3a] uppercase tracking-tighter">{{ $buku->ulasan->count() }}
                            ULASAN</span>
                        <span class="block text-[10px] text-gray-500">DARI PEMBACA</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Form Column --}}
            <div class="lg:col-span-1">
                @php
                    $userReview = $buku->ulasan->where('id_anggota', auth()->user()->anggota->id_anggota)->first();
                @endphp

                @if(!$userReview)
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm sticky top-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Tulis Ulasan</h3>
                        <p class="text-xs text-gray-400 mb-6">Bagikan pendapat Anda</p>

                        <form action="{{ route('anggota.ulasan.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">

                            <div class="mb-6" x-data="{ rating: 0, hover: 0 }">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Rating
                                    Anda</label>
                                <div class="flex items-center gap-2">
                                    <template x-for="i in 5">
                                        <button type="button" @click="rating = i" @mouseenter="hover = i"
                                            @mouseleave="hover = 0"
                                            class="transition-transform hover:scale-110 focus:outline-none">
                                            <svg class="h-8 w-8 transition-colors duration-150"
                                                :class="(hover || rating) >= i ? 'text-yellow-400 fill-current' : 'text-gray-200 fill-current'"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                                <input type="hidden" name="rating" x-model="rating" required>
                                @error('rating') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-6">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Pesan
                                    Ulasan</label>
                                <textarea name="ulasan" rows="4" required
                                    class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 text-sm focus:border-[#0f4c3a] focus:ring-0 transition-all placeholder:text-gray-400"
                                    placeholder="Apa yang Anda suka dari buku ini?"></textarea>
                                @error('ulasan') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit"
                                class="w-full rounded-2xl bg-[#0f4c3a] py-4 text-sm font-bold text-white transition hover:bg-[#0a382b] shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                Kirim Ulasan
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    <div
                        class="bg-gradient-to-br from-[#0f4c3a] to-[#0a382b] rounded-3xl p-6 text-white shadow-lg sticky top-4">
                        <div class="h-12 w-12 bg-white/20 rounded-2xl flex items-center justify-center mb-4 backdrop-blur-md">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold mb-1">Ulasan Terkirim</h3>
                        <p class="text-xs text-white/70 leading-relaxed">Terima kasih telah berbagi pengalaman membaca Anda
                            dengan komunitas kami!</p>
                    </div>
                @endif
            </div>

            {{-- List Column --}}
            <div class="lg:col-span-2 space-y-6">
                @forelse($buku->ulasan as $ulasan)
                    <div
                        class="bg-white rounded-3xl p-6 border border-gray-50 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="h-12 w-12 flex-shrink-0 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center text-[#0f4c3a] font-black text-xl border border-gray-100 shadow-inner">
                                    {{ substr($ulasan->anggota->nama_lengkap, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                        {{ $ulasan->anggota->nama_lengkap }}
                                        @if($ulasan->id_anggota === auth()->user()->anggota->id_anggota)
                                            <span
                                                class="text-[9px] bg-gray-100 text-gray-400 px-1.5 py-0.5 rounded font-black uppercase tracking-widest">SAYA</span>
                                        @endif
                                    </h4>
                                    <p class="text-[10px] text-gray-400 font-medium">
                                        {{ $ulasan->dibuat_pada->locale('id')->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-4 w-4 {{ $i <= $ulasan->rating ? 'text-yellow-400' : 'text-gray-100' }} fill-current"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <div class="bg-gray-50/50 rounded-2xl p-4 border border-gray-50">
                            <p class="text-sm text-gray-600 leading-relaxed">"{{ $ulasan->ulasan }}"</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-gray-50/50 rounded-[40px] border-2 border-dashed border-gray-100">
                        <div class="mx-auto w-20 h-20 bg-white rounded-3xl flex items-center justify-center shadow-sm mb-6">
                            <svg class="h-10 w-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <p class="text-base font-bold text-gray-400">Belum ada ulasan.</p>
                        <p class="text-sm text-gray-400 mt-2">Berikan ulasan pertama untuk buku ini!</p>
                    </div>
                @endforelse
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