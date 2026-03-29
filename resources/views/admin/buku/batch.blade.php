@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-black dark:text-white">
            🚀 Tambah Batch Buku
        </h2>
        <a href="{{ route('admin.buku.index') }}" class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary transition-colors">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.8333 10H4.16666" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10 15.8333L4.16666 10L10 4.16666" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 flex w-full border-l-6 border-danger bg-danger/10 p-4 shadow-md dark:bg-[#1b1b24]">
            <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-danger text-white">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85786 13.1421 1.5 9 1.5C4.85786 1.5 1.5 4.85786 1.5 9C1.5 13.1421 4.85786 16.5 9 16.5Z" stroke="currentColor" stroke-width="1.5"/><path d="M9 6V10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="9" cy="12.5" r="0.75" fill="currentColor"/></svg>
            </div>
            <div class="w-full">
                <h5 class="text-black dark:text-white font-bold">Terjadi Kesalahan</h5>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.buku.batch.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Common Data Card -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 mb-6 overflow-hidden">
            <div class="border-b border-gray-100 px-6.5 py-4 dark:border-gray-800 bg-gray-50/50 dark:bg-white/5">
                <h3 class="font-bold text-black dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Informasi Umum (Shared Data)
                </h3>
            </div>
            <div class="p-6.5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                    <label class="mb-2 block text-sm font-bold text-gray-500 uppercase tracking-widest">Judul Utama <span class="text-meta-1">*</span></label>
                    <input type="text" name="judul_buku_common" value="{{ old('judul_buku_common') }}" placeholder="Contoh: The 100 Girlfriends" class="w-full rounded-xl border border-gray-200 bg-transparent px-5 py-3 outline-none transition focus:border-primary dark:border-gray-700" required />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-500 uppercase tracking-widest">Penulis</label>
                    <input type="text" name="penulis_common" value="{{ old('penulis_common') }}" placeholder="Nama Penulis" class="w-full rounded-xl border border-gray-200 bg-transparent px-5 py-3 outline-none transition focus:border-primary dark:border-gray-700" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-500 uppercase tracking-widest">Penerbit</label>
                    <input type="text" name="penerbit_common" value="{{ old('penerbit_common') }}" placeholder="Penerbit" class="w-full rounded-xl border border-gray-200 bg-transparent px-5 py-3 outline-none transition focus:border-primary dark:border-gray-700" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-500 uppercase tracking-widest">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit_common" value="{{ old('tahun_terbit_common', date('Y')) }}" class="w-full rounded-xl border border-gray-200 bg-transparent px-5 py-3 outline-none transition focus:border-primary dark:border-gray-700" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-500 uppercase tracking-widest">Bahasa</label>
                    <select name="bahasa_common" class="w-full rounded-xl border border-gray-200 bg-transparent px-5 py-3 outline-none transition focus:border-primary dark:border-gray-700 dark:bg-gray-800">
                        <option value="id">Indonesia</option>
                        <option value="en">English</option>
                        <option value="ja">Japanese</option>
                        <option value="ko">Korean</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-500 uppercase tracking-widest">Lokasi Rak</label>
                    <input type="text" name="lokasi_rak_common" value="{{ old('lokasi_rak_common') }}" placeholder="Rak A-2" class="w-full rounded-xl border border-gray-200 bg-transparent px-5 py-3 outline-none transition focus:border-primary dark:border-gray-700" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-500 uppercase tracking-widest">Series Koleksi</label>
                    <select name="id_series" class="w-full rounded-xl border border-gray-200 bg-transparent px-5 py-3 outline-none transition focus:border-primary dark:border-gray-700 dark:bg-gray-800">
                        <option value="">-- Bukan Bagian Series --</option>
                        @foreach($series as $s)
                            <option value="{{ $s->id_series }}">{{ $s->nama_series }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <label class="mb-3 block text-sm font-bold text-gray-500 uppercase tracking-widest">Kategori</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($kategori as $kat)
                            <label class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-100 cursor-pointer bg-gray-50 hover:bg-white hover:border-primary transition-all group">
                                <input type="checkbox" name="kategori[]" value="{{ $kat->id_kategori }}" class="rounded text-primary focus:ring-primary border-gray-300">
                                <span class="text-sm font-semibold text-gray-700 group-hover:text-primary">{{ $kat->nama_kategori }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Batch Items Card -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900" x-data="{ 
            items: [ { volume: '', isbn: '', stok: 1, sinopsis: '' } ],
            addItem() { this.items.push({ volume: '', isbn: '', stok: 1, sinopsis: '' }) },
            removeItem(index) { if(this.items.length > 1) this.items.splice(index, 1) }
        }">
            <div class="flex items-center justify-between border-b border-gray-100 px-6.5 py-4 dark:border-gray-800 bg-gray-50/50 dark:bg-white/5">
                <h3 class="font-bold text-black dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Daftar Item (Detail Individual)
                </h3>
                <button type="button" @click="addItem" class="inline-flex items-center gap-2 px-5 py-2.5 bg-success text-white rounded-xl text-sm font-black hover:bg-opacity-90 shadow-md transform active:scale-95 transition-all">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    TAMBAH BARIS
                </button>
            </div>
            
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-y-2">
                        <thead>
                            <tr class="text-gray-400">
                                <th class="px-3 pb-3 text-[10px] font-black uppercase tracking-widest w-24 text-center">Volume</th>
                                <th class="px-3 pb-3 text-[10px] font-black uppercase tracking-widest w-48">ISBN</th>
                                <th class="px-3 pb-3 text-[10px] font-black uppercase tracking-widest w-24 text-center">Stok</th>
                                <th class="px-3 pb-3 text-[10px] font-black uppercase tracking-widest">Sinopsis (Jika Beda)</th>
                                <th class="px-3 pb-3 text-[10px] font-black uppercase tracking-widest w-56">Sampul</th>
                                <th class="px-3 pb-3 text-[10px] font-black uppercase tracking-widest w-16 text-center text-danger">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="bg-gray-50/50 dark:bg-white/5 group hover:bg-gray-100/50 transition-colors">
                                    <td class="px-3 py-4 first:rounded-l-xl">
                                        <input type="number" :name="'items['+index+'][nomor_volume]'" x-model="item.volume" placeholder="Vol" class="w-full rounded-xl border border-gray-200 bg-white px-2 py-3 text-center outline-none focus:border-primary dark:border-gray-700 dark:bg-boxdark" />
                                    </td>
                                    <td class="px-3 py-4">
                                        <input type="text" :name="'items['+index+'][isbn]'" x-model="item.isbn" placeholder="ISBN-13" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 outline-none focus:border-primary dark:border-gray-700 dark:bg-boxdark" />
                                    </td>
                                    <td class="px-3 py-4 text-center">
                                        <input type="number" :name="'items['+index+'][stok]'" x-model="item.stok" class="w-full rounded-xl border border-gray-200 bg-white px-2 py-3 text-center outline-none focus:border-primary dark:border-gray-700 dark:bg-boxdark font-bold" required />
                                    </td>
                                    <td class="px-3 py-4">
                                        <textarea :name="'items['+index+'][sinopsis]'" x-model="item.sinopsis" rows="1" class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 outline-none focus:border-primary dark:border-gray-700 dark:bg-boxdark text-sm" placeholder="Opsional..."></textarea>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="flex items-center gap-2">
                                            <input type="file" :name="'items['+index+'][sampul]'" class="w-full text-[10px] text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-black file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 transition-all" />
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 last:rounded-r-xl text-center">
                                        <button type="button" @click="removeItem(index)" class="text-gray-300 hover:text-danger p-2 rounded-xl hover:bg-danger/10 transition-all">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="mt-10 flex flex-col sm:flex-row items-center justify-between gap-6 border-t border-gray-100 pt-8 dark:border-gray-800">
                    <p class="text-sm text-gray-500">
                        <span class="font-bold text-black dark:text-white" x-text="items.length"></span> item siap ditambahkan dengan informasi umum di atas.
                    </p>
                    <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-3 rounded-2xl bg-primary px-12 py-5 font-black text-white hover:bg-opacity-90 shadow-xl hover:shadow-primary/30 transform hover:-translate-y-1 transition-all">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        SIMPAN SEMUA BUKU SEKALIGUS
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
