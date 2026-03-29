@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl md:text-3xl font-black text-black dark:text-white flex items-center gap-3">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </span>
                Tambah Batch Buku
            </h2>
            <p class="mt-1 text-sm text-gray-500 font-medium">Input koleksi buku dalam jumlah banyak secara efisien</p>
        </div>
        <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-bold text-gray-600 shadow-sm hover:bg-gray-50 hover:text-primary transition-all">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 flex w-full animate-fade-in border-l-6 border-danger bg-danger/10 p-5 shadow-sm rounded-xl">
            <div class="mr-5 flex h-10 w-10 items-center justify-center rounded-full bg-danger text-white shrink-0">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <div class="w-full">
                <h5 class="text-danger font-bold text-sm uppercase tracking-wider">Terjadi Kesalahan</h5>
                <p class="text-sm text-danger/80 mt-1">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.buku.batch.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Section 1: Shared Meta -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-1">
                <div class="sticky top-24">
                    <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <div class="mb-6 flex items-center gap-3 border-b border-gray-50 pb-4 dark:border-gray-800">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary text-white shadow-lg shadow-primary/20">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                            <h3 class="font-black text-black dark:text-white uppercase tracking-tighter text-lg">Data Master</h3>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="mb-2 block text-[10px] font-black uppercase tracking-widest text-gray-400">Judul Koleksi <span class="text-danger">*</span></label>
                                <input type="text" name="judul_buku_common" value="{{ old('judul_buku_common') }}" placeholder="Contoh: Blue Lock" class="w-full rounded-2xl border border-gray-100 bg-gray-50/50 px-5 py-3.5 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/5 dark:border-gray-800 dark:bg-boxdark" required />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-2 block text-[10px] font-black uppercase tracking-widest text-gray-400">Penulis</label>
                                    <input type="text" name="penulis_common" value="{{ old('penulis_common') }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50/50 px-5 py-3.5 outline-none transition-all focus:border-primary focus:bg-white dark:border-gray-800 dark:bg-boxdark" />
                                </div>
                                <div>
                                    <label class="mb-2 block text-[10px] font-black uppercase tracking-widest text-gray-400">Penerbit</label>
                                    <input type="text" name="penerbit_common" value="{{ old('penerbit_common') }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50/50 px-5 py-3.5 outline-none transition-all focus:border-primary focus:bg-white dark:border-gray-800 dark:bg-boxdark" />
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-2 block text-[10px] font-black uppercase tracking-widest text-gray-400">Tahun</label>
                                    <input type="number" name="tahun_terbit_common" value="{{ old('tahun_terbit_common', date('Y')) }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50/50 px-5 py-3.5 text-center outline-none transition-all focus:border-primary focus:bg-white dark:border-gray-800 dark:bg-boxdark" />
                                </div>
                                <div>
                                    <label class="mb-2 block text-[10px] font-black uppercase tracking-widest text-gray-400">Bahasa</label>
                                    <select name="bahasa_common" class="w-full rounded-2xl border border-gray-100 bg-gray-50/50 px-5 py-3.5 outline-none transition-all focus:border-primary focus:bg-white dark:border-gray-800 dark:bg-boxdark">
                                        <option value="id">Indonesia</option>
                                        <option value="en">English</option>
                                        <option value="ja">Japanese</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="mb-2 block text-[10px] font-black uppercase tracking-widest text-gray-400">Lokasi Rak</label>
                                <input type="text" name="lokasi_rak_common" value="{{ old('lokasi_rak_common', 'A-1') }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50/50 px-5 py-3.5 outline-none transition-all focus:border-primary focus:bg-white dark:border-gray-800 dark:bg-boxdark" />
                            </div>

                            <div>
                                <label class="mb-2 block text-[10px] font-black uppercase tracking-widest text-gray-400">Hubungkan ke Series</label>
                                <select name="id_series" class="w-full rounded-2xl border border-gray-100 bg-gray-50/50 px-5 py-3.5 outline-none transition-all focus:border-primary focus:bg-white dark:border-gray-800 dark:bg-boxdark">
                                    <option value="">-- Manual (Tanpa Series) --</option>
                                    @foreach($series as $s)
                                        <option value="{{ $s->id_series }}">{{ $s->nama_series }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="mb-3 block text-[10px] font-black uppercase tracking-widest text-gray-400">Kategori</label>
                                <div class="flex flex-wrap gap-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                                    @foreach($kategori as $kat)
                                        <label class="inline-flex cursor-pointer select-none items-center gap-2 rounded-xl border border-gray-100 bg-gray-50/50 px-3 py-2 transition-all hover:bg-white hover:shadow-sm has-checked:border-primary has-checked:bg-primary/5 group">
                                            <input type="checkbox" name="kategori[]" value="{{ $kat->id_kategori }}" class="peer hidden">
                                            <div class="flex h-4 w-4 shrink-0 items-center justify-center rounded-md border border-gray-300 transition-all peer-checked:border-primary peer-checked:bg-primary">
                                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="hidden peer-checked:block"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                            </div>
                                            <span class="text-xs font-bold text-gray-600 transition-colors group-hover:text-primary peer-checked:text-primary">{{ $kat->nama_kategori }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Items Table -->
            <div class="xl:col-span-2">
                <div class="rounded-[2.5rem] border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 overflow-hidden" x-data="{ 
                    items: [ { volume: '1', isbn: '', stok: 1, sinopsis: '' } ],
                    addItem() { 
                        const nextVol = this.items.length + 1;
                        this.items.push({ volume: nextVol.toString(), isbn: '', stok: 1, sinopsis: '' }) 
                    },
                    removeItem(index) { if(this.items.length > 1) this.items.splice(index, 1) }
                }">
                    <div class="flex flex-col sm:flex-row items-center justify-between border-b border-gray-50 px-8 py-6 dark:border-gray-800 bg-gray-50/30 dark:bg-white/5">
                        <div class="mb-4 sm:mb-0">
                            <h3 class="font-black text-black dark:text-white uppercase tracking-tighter text-xl">Daftar Item Detail</h3>
                            <p class="text-xs text-gray-400 font-medium mt-1">Gunakan volume berurut untuk seri buku</p>
                        </div>
                        <button type="button" @click="addItem" class="group flex items-center gap-3 rounded-2xl bg-[#0f4c3a] px-6 py-3.5 text-sm font-black text-white shadow-xl shadow-success/20 transition-all hover:scale-105 active:scale-95">
                            <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-white/20 group-hover:bg-white/30 transition-colors">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </span>
                            TAMBAH ITEM
                        </button>
                    </div>
                    
                    <div class="p-8">
                        <div class="space-y-4">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="group relative rounded-3xl border border-gray-50 bg-gray-50/20 p-6 transition-all hover:border-primary/20 hover:bg-white hover:shadow-md dark:border-gray-800 dark:bg-white/5">
                                    <div class="absolute -left-3 top-1/2 -translate-y-1/2 flex h-8 w-8 items-center justify-center rounded-full bg-white border border-gray-100 text-[10px] font-black text-primary shadow-sm" x-text="index + 1"></div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                                        <!-- Volume & ISBN -->
                                        <div class="md:col-span-3 grid grid-cols-1 gap-4">
                                            <div>
                                                <label class="mb-1.5 block text-[9px] font-black uppercase tracking-widest text-gray-400">Volume</label>
                                                <input type="number" :name="'items['+index+'][nomor_volume]'" x-model="item.volume" placeholder="Vol" class="w-full rounded-xl border border-gray-100 bg-white px-4 py-2.5 text-sm font-bold outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 dark:bg-boxdark dark:border-gray-700" />
                                            </div>
                                            <div>
                                                <label class="mb-1.5 block text-[9px] font-black uppercase tracking-widest text-gray-400">ISBN</label>
                                                <input type="text" :name="'items['+index+'][isbn]'" x-model="item.isbn" placeholder="ISBN..." class="w-full rounded-xl border border-gray-100 bg-white px-4 py-2.5 text-sm font-bold outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 dark:bg-boxdark dark:border-gray-700" />
                                            </div>
                                        </div>

                                        <!-- Stock & Sinopsis -->
                                        <div class="md:col-span-6 grid grid-cols-1 gap-4">
                                            <div class="grid grid-cols-4 gap-4">
                                                <div class="col-span-1">
                                                    <label class="mb-1.5 block text-[9px] font-black uppercase tracking-widest text-gray-400 text-center">Stok</label>
                                                    <input type="number" :name="'items['+index+'][stok]'" x-model="item.stok" class="w-full rounded-xl border border-gray-100 bg-white px-2 py-2.5 text-center text-sm font-bold outline-none focus:border-primary dark:bg-boxdark dark:border-gray-700" required />
                                                </div>
                                                <div class="col-span-3">
                                                    <label class="mb-1.5 block text-[9px] font-black uppercase tracking-widest text-gray-400">Sinopsis Custom (Opsional)</label>
                                                    <textarea :name="'items['+index+'][sinopsis]'" x-model="item.sinopsis" rows="1" class="w-full rounded-xl border border-gray-100 bg-white px-4 py-2.5 text-sm outline-none focus:border-primary dark:bg-boxdark dark:border-gray-700" placeholder="Biarkan kosong untuk sinopsis utama..."></textarea>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-4 bg-white/50 dark:bg-boxdark p-3 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-400">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-[9px] font-black uppercase text-gray-400 leading-none mb-1.5">Sampul Volume <span x-text="item.volume"></span></p>
                                                    <input type="file" :name="'items['+index+'][sampul]'" class="block w-full text-xs text-gray-400 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-black file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all cursor-pointer" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="md:col-span-3 flex md:flex-col items-center justify-end gap-3 self-center">
                                            <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="flex h-12 w-12 items-center justify-center rounded-2xl border border-gray-100 bg-white text-gray-300 transition-all hover:border-danger hover:bg-danger/5 hover:text-danger active:scale-95 shadow-sm">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-12 flex flex-col md:flex-row items-center justify-between gap-8 border-t border-gray-50 pt-10 dark:border-gray-800">
                            <div class="flex items-center gap-4">
                                <div class="flex -space-x-3">
                                    <template x-for="n in Math.min(items.length, 5)">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-white bg-primary/10 text-[10px] font-black text-primary shadow-sm dark:border-gray-900" x-text="n"></div>
                                    </template>
                                    <div x-show="items.length > 5" class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-white bg-gray-100 text-[10px] font-black text-gray-500 shadow-sm dark:border-gray-900" x-text="'+' + (items.length - 5)"></div>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-black dark:text-white uppercase tracking-tighter">Ringkasan Batch</p>
                                    <p class="text-[11px] text-gray-400 font-medium"><span x-text="items.length"></span> entitas buku akan dibuat sekaligus</p>
                                </div>
                            </div>
                            
                            <button type="submit" class="group w-full md:w-auto flex items-center justify-center gap-4 rounded-3xl bg-black px-12 py-5 text-base font-black text-white shadow-2xl transition-all hover:bg-primary hover:shadow-primary/40 active:scale-95">
                                KONFIRMASI & SIMPAN BATCH
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #D1D5DB; }
    
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }
</style>
@endsection
