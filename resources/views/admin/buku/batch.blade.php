@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <!-- Page Header (Adopted from Music Player) -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-black tracking-tight flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#e8f4f0] text-[#0f4c3a]">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </span>
                Bulk Add Books
            </h2>
            <p class="text-gray-500 text-sm mt-1 font-medium">Tambah banyak jilid atau koleksi buku sekaligus secara instan.</p>
        </div>
        <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-500 hover:text-black font-semibold rounded-2xl text-xs transition-all uppercase tracking-widest border border-gray-200">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl bg-red-50 border border-red-200 px-5 py-4 text-sm font-medium text-red-700 animate-fade-in shadow-sm">
            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.buku.batch.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- ===== KOLOM KIRI: Master Info (Styled like Form Lagu) ===== --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sticky top-4">
                    <div class="mb-6 border-b border-gray-50 pb-4">
                        <h3 class="text-lg font-bold text-gray-800 tracking-tight">Main Info</h3>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mt-1">Data yang sama untuk semua item</p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Judul Utama / Seri <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_buku_common" value="{{ old('judul_buku_common') }}" required
                                class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 focus:outline-none transition font-semibold"
                                placeholder="e.g. Oshi no Ko">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Penulis</label>
                                <input type="text" name="penulis_common" value="{{ old('penulis_common') }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 outline-none" placeholder="Aka Akasaka">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Penerbit</label>
                                <input type="text" name="penerbit_common" value="{{ old('penerbit_common') }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 outline-none" placeholder="M&C!">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Tahun</label>
                                <input type="number" name="tahun_terbit_common" value="{{ old('tahun_terbit_common', date('Y')) }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm text-center focus:border-[#0f4c3a] focus:ring-0 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Bahasa</label>
                                <select name="bahasa_common" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 outline-none appearance-none">
                                    <option value="id">Indonesia</option>
                                    <option value="en">English</option>
                                    <option value="ja">Japanese</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Lokasi Rak</label>
                            <input type="text" name="lokasi_rak_common" value="{{ old('lokasi_rak_common', 'A-1') }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 outline-none" placeholder="Rak Komik">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Series Koleksi</label>
                            <select name="id_series" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 outline-none appearance-none font-semibold">
                                <option value="">-- Tidak Ada --</option>
                                @foreach($series as $s)
                                    <option value="{{ $s->id_series }}">{{ $s->nama_series }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Pilih Kategori</label>
                            <div class="flex flex-wrap gap-2 max-h-40 overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($kategori as $kat)
                                    <label class="group relative cursor-pointer select-none">
                                        <input type="checkbox" name="kategori[]" value="{{ $kat->id_kategori }}" class="peer hidden">
                                        <div class="px-3 py-1.5 rounded-xl border border-gray-100 bg-gray-50 text-[10px] font-bold text-gray-400 uppercase group-hover:bg-gray-100 transition-all peer-checked:bg-[#e8f4f0] peer-checked:text-[#0f4c3a] peer-checked:border-[#c8e6d8]">
                                            {{ $kat->nama_kategori }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== KOLOM KANAN: Items List (Styled like Playlist Musik) ===== --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden" x-data="{ 
                    items: [ { volume: '1', isbn: '', stok: 1, sinopsis: '' } ],
                    addItem() { 
                        const nextVol = this.items.length + 1;
                        this.items.push({ volume: nextVol.toString(), isbn: '', stok: 1, sinopsis: '' }) 
                    },
                    removeItem(index) { if(this.items.length > 1) this.items.splice(index, 1) }
                }">
                    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-50">
                        <div>
                            <h3 class="font-bold text-black text-base tracking-tight uppercase">Daftar Batch Item</h3>
                            <p class="text-[10px] font-semibold text-gray-400 mt-0.5 tracking-widest uppercase">Detail untuk tiap volume</p>
                        </div>
                        <button type="button" @click="addItem" class="inline-flex items-center gap-2 px-4 py-2 bg-[#e8f4f0] text-[#0f4c3a] rounded-xl text-xs font-bold shadow-sm border border-[#c8e6d8] hover:bg-[#d0ebe0] transition-all transform active:scale-95">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            TAMBAH ITEM
                        </button>
                    </div>

                    <div class="divide-y divide-gray-50 p-6 space-y-4">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex flex-col md:flex-row gap-4 p-5 rounded-3xl bg-gray-50/50 border border-transparent hover:border-[#c8e6d8] hover:bg-[#f9fdfc] transition-all group relative">
                                
                                {{-- Index Badge (Music Rank Style) --}}
                                <div class="h-12 w-12 shrink-0 rounded-2xl bg-[#e8f4f0] flex items-center justify-center text-[#0f4c3a] font-bold text-lg shadow-sm" x-text="index + 1"></div>

                                <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-5">
                                    {{-- Vol & ISBN --}}
                                    <div class="md:col-span-3 grid gap-3">
                                        <div class="relative">
                                            <span class="absolute left-4 top-[10px] text-[8px] font-semibold text-gray-300 uppercase">Vol</span>
                                            <input type="number" :name="'items['+index+'][nomor_volume]'" x-model="item.volume" 
                                                class="w-full rounded-2xl border border-gray-200 bg-white pl-10 pr-4 py-3 text-sm font-bold focus:border-[#0f4c3a] focus:ring-0 outline-none shadow-xs">
                                        </div>
                                        <div class="relative">
                                            <span class="absolute left-4 top-[10px] text-[8px] font-semibold text-gray-300 uppercase">ISBN</span>
                                            <input type="text" :name="'items['+index+'][isbn]'" x-model="item.isbn" placeholder="..."
                                                class="w-full rounded-2xl border border-gray-200 bg-white pl-11 pr-4 py-3 text-sm font-bold focus:border-[#0f4c3a] focus:ring-0 outline-none shadow-xs">
                                        </div>
                                    </div>

                                    {{-- Stok & Sinopsis --}}
                                    <div class="md:col-span-6 flex flex-col gap-3">
                                        <div class="flex gap-3">
                                            <div class="w-20 shrink-0 relative">
                                                <span class="absolute left-1/2 -translate-x-1/2 top-[6px] text-[7px] font-semibold text-gray-300 uppercase">Stok</span>
                                                <input type="number" :name="'items['+index+'][stok]'" x-model="item.stok" 
                                                    class="w-full rounded-2xl border border-gray-200 bg-white px-2 pt-4 pb-2 text-center text-sm font-bold focus:border-[#0f4c3a] focus:ring-0 outline-none shadow-xs" required>
                                            </div>
                                            <div class="flex-1">
                                                <textarea :name="'items['+index+'][sinopsis]'" x-model="item.sinopsis" rows="1" 
                                                    class="w-full h-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-xs outline-none focus:border-[#0f4c3a] focus:ring-0 shadow-xs placeholder:text-gray-300" 
                                                    placeholder="Deskripsi individual (kosongkan jika sama)..."></textarea>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 bg-white p-2.5 rounded-2xl border border-gray-100 shadow-xs">
                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#e8f4f0] text-[#0f4c3a]">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                            </div>
                                            <input type="file" :name="'items['+index+'][sampul]'" class="block w-full text-[10px] text-gray-400 file:mr-3 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[9px] font-medium file:bg-[#e8f4f0] file:text-[#0f4c3a] cursor-pointer" />
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="md:col-span-3 flex items-center justify-end">
                                        <button type="button" @click="removeItem(index)" x-show="items.length > 1" 
                                            class="h-10 w-10 flex items-center justify-center rounded-2xl text-gray-200 hover:text-red-500 hover:bg-red-50 transition-all transform active:scale-95 border border-gray-100 hover:border-red-200 shadow-xs">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="pt-10 flex flex-col md:flex-row items-center justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <div class="flex p-2 bg-[#e8f4f0] border border-[#c8e6d8] rounded-2xl">
                                    <svg class="h-6 w-6 text-[#0f4c3a]" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
                                    </svg>
                                    <span class="ml-2 text-xs font-bold text-[#0f4c3a] self-center uppercase tracking-widest" x-text="items.length + ' Item Ready'"></span>
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full md:w-auto rounded-3xl bg-[#0f4c3a] py-5 px-12 text-sm font-bold text-white hover:bg-[#0a382b] shadow-2xl hover:shadow-[#0f4c3a]/30 transition-all flex items-center justify-center gap-3 active:scale-95 uppercase tracking-widest">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                Simpan Koleksi Batch
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
