@extends('layouts.app')

@section('content')
{{-- Wrap semua dalam satu Alpine component agar modal bisa diakses dari mana saja --}}
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10"
     x-data="{
        showDeleteModal: false,
        deleteJudul: '',
        deleteUrl: '',
        openDeleteModal(judul, idBuku) {
            this.deleteJudul = judul;
            this.deleteUrl = '/anggota/koleksi/' + idBuku;
            this.showDeleteModal = true;
        }
     }">

    {{-- ===== MODAL HAPUS — dirender di sini (level atas, bukan di card) ===== --}}
    <div x-show="showDeleteModal" x-transition
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
        style="display: none;">
        <div @click.outside="showDeleteModal = false"
            class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-2xl">

            {{-- Icon --}}
            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-red-50">
                <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>

            <div class="mb-6 text-center">
                <h3 class="text-xl font-bold text-black mb-1">Hapus dari Koleksi?</h3>
                <p class="text-sm text-gray-500">Buku <span class="font-semibold text-black" x-text="deleteJudul"></span> akan dihapus dari daftar koleksi Anda.</p>
            </div>

            <form :action="deleteUrl" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" @click="showDeleteModal = false"
                        class="flex-1 rounded-xl border border-gray-300 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 rounded-xl bg-red-500 py-3 text-sm font-bold text-white hover:bg-red-600 transition shadow-md">
                        Ya, Hapus!
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-title-md2 font-bold text-black flex items-center gap-2">
                Koleksi / Wishlist Saya
                <span class="text-[#0f4c3a]">✨</span>
            </h2>
            <p class="text-sm text-gray-500 mt-1">Daftar buku yang Anda simpan untuk dibaca nanti.</p>
        </div>
    </div>

    {{-- Cards Layout --}}
    @if($koleksi->count() > 0)
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
            @foreach($koleksi as $item)
                <div class="relative group rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 overflow-hidden">
                    <a href="{{ route('anggota.buku.detail', $item->id_buku) }}" class="flex flex-col h-full" title="Lihat detail: {{ $item->buku->judul_buku }}">

                        {{-- Image --}}
                        <div class="relative aspect-2/3 w-full overflow-hidden bg-gray-100">
                            @if($item->buku->sampul)
                                <img src="{{ Storage::url($item->buku->sampul) }}" alt="{{ $item->buku->judul_buku }}" loading="lazy"
                                    class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#e8f4f0] to-[#c8e6d8]">
                                    <svg class="h-12 w-12 text-[#0f4c3a] opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            {{-- Status overlay --}}
                            <div class="absolute top-2 left-2 z-10">
                                @if($item->buku->stok > 0)
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
                            <div class="absolute inset-0 bg-[#0f4c3a]/0 group-hover:bg-[#0f4c3a]/20 transition-all duration-300 flex items-center justify-center pointer-events-none">
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
                                {{ $item->buku->kategori->first()?->nama_kategori ?? 'Umum' }}
                            </p>
                            <h4 class="text-xs font-bold text-black line-clamp-2 leading-snug mb-1"
                                title="{{ $item->buku->judul_buku }}">
                                {{ $item->buku->judul_buku }}
                            </h4>
                            <p class="text-[10px] text-gray-500 line-clamp-1 flex-1">{{ $item->buku->penulis }}</p>
                        </div>
                    </a>

                    {{-- Tombol hapus — hanya trigger, bukan modal. Modal ada di atas --}}
                    <button
                        @click.prevent="openDeleteModal('{{ addslashes($item->buku->judul_buku) }}', {{ $item->id_buku }})"
                        class="absolute top-2 right-2 z-20 flex items-center justify-center w-7 h-7 bg-white hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-md shadow-md border border-gray-200 transition-colors opacity-0 group-hover:opacity-100"
                        title="Hapus dari Koleksi">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-8 text-center mt-6 flex flex-col items-center justify-center min-h-[400px]">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 text-gray-300 mb-5">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h2 class="text-xl font-bold text-black mb-2">Belum ada buku di Koleksi</h2>
            <p class="text-sm text-gray-500 mb-6 max-w-md mx-auto">Anda dapat menyimpan buku ke koleksi dengan menekan tombol "Tambah ke Koleksi" pada halaman detail buku.</p>
            <a href="{{ route('anggota.dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold rounded-lg text-white bg-[#0f4c3a] hover:bg-[#0a382b] shadow-sm transition-all hover:shadow-md">
                Jelajahi Katalog Buku
            </a>
        </div>
    @endif
</div>
@endsection
