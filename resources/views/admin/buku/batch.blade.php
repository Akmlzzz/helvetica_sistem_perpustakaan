@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <!-- Header: Lebih Manusiawi -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-black tracking-tight flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#e8f4f0] text-[#0f4c3a]">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </span>
                Tambah Banyak Buku Sekaligus
            </h2>
            <p class="text-gray-500 text-sm mt-1 font-medium italic">Bagikan data penulis & penerbit yang sama untuk banyak jilid.</p>
        </div>
        <a href="{{ route('admin.buku.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-500 hover:text-black font-semibold rounded-2xl text-xs transition-all uppercase tracking-widest border border-gray-100 shadow-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Batal & Kembali
        </a>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="mb-6 flex items-center gap-3 rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm font-medium text-emerald-700 animate-fade-in shadow-sm">
            <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="mb-6 flex items-center gap-3 rounded-2xl bg-red-50 border border-red-200 px-5 py-4 text-sm font-medium text-red-700 animate-fade-in shadow-sm">
            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.buku.batch.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- ===== INFORMASI MASTER ===== --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sticky top-4">
                    <div class="mb-6">
                        <h3 class="text-base font-bold text-gray-800 tracking-tight">Informasi Utama</h3>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mt-1">Gunakan data ini untuk semua buku below</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Judul Utama / Seri <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_buku_common" value="{{ old('judul_buku_common') }}" required
                                class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 focus:outline-none transition font-semibold"
                                placeholder="Contoh: Naruto Shippuden">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Penulis</label>
                                <input type="text" name="penulis_common" value="{{ old('penulis_common') }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 outline-none" placeholder="Masashi Kishimoto">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Penerbit</label>
                                <input type="text" name="penerbit_common" value="{{ old('penerbit_common') }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 outline-none" placeholder="Elex Media">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit_common" value="{{ old('tahun_terbit_common', date('Y')) }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm text-center focus:border-[#0f4c3a] focus:ring-0 outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Bahasa</label>
                                <select name="bahasa_common" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 outline-none appearance-none">
                                    <option value="id">Bahasa Indonesia</option>
                                    <option value="en">English</option>
                                    <option value="ja">Japanese</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Lokasi Rak</label>
                            <input type="text" name="lokasi_rak_common" value="{{ old('lokasi_rak_common', 'A-1') }}" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 outline-none" placeholder="Rak Koleksi">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Sambungkan ke Series</label>
                            <select name="id_series" class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 outline-none appearance-none font-semibold">
                                <option value="">-- Lewati --</option>
                                @foreach($series as $s)
                                    <option value="{{ $s->id_series }}">{{ $s->nama_series }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Pilih Kategori</label>
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

            {{-- ===== DATA RINCIAN (ITEMS) ===== --}}
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
                            <h3 class="font-bold text-black text-base tracking-tight uppercase">Rincian Koleksi</h3>
                            <p class="text-[10px] font-semibold text-gray-400 mt-0.5 tracking-widest uppercase">Input detail tiap jilid/salinan</p>
                        </div>
                        <button type="button" @click="addItem" class="inline-flex items-center gap-2 px-4 py-2 bg-[#e8f4f0] text-[#0f4c3a] rounded-xl text-xs font-bold shadow-sm border border-[#c8e6d8] hover:bg-[#d0ebe0] transition-all transform active:scale-95">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            TAMBAH BARIS
                        </button>
                    </div>

                    <div class="divide-y divide-gray-50 p-6 space-y-6">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex flex-col md:flex-row gap-5 p-6 rounded-3xl bg-gray-50/50 border border-transparent hover:border-[#c8e6d8] hover:bg-white hover:shadow-md transition-all group relative">
                                
                                {{-- Penomoran --}}
                                <div class="h-10 w-10 shrink-0 rounded-2xl bg-[#e8f4f0] flex items-center justify-center text-[#0f4c3a] font-bold text-sm shadow-sm" x-text="index + 1"></div>

                                <div class="flex-1 grid grid-cols-1 md:grid-cols-12 gap-6">
                                    {{-- Kolom Kiri: Meta --}}
                                    <div class="md:col-span-4 grid gap-4">
                                        <div class="flex gap-3">
                                            <div class="flex-1">
                                                <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Jilid/Vol</label>
                                                <input type="number" :name="'items['+index+'][nomor_volume]'" x-model="item.volume" 
                                                    class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold focus:border-[#0f4c3a] focus:ring-0 outline-none">
                                            </div>
                                            <div class="w-24">
                                                <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Stok</label>
                                                <input type="number" :name="'items['+index+'][stok]'" x-model="item.stok" 
                                                    class="w-full rounded-2xl border border-gray-200 bg-white px-2 py-2.5 text-center text-sm font-bold focus:border-[#0f4c3a] focus:ring-0 outline-none" required>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Nomor ISBN</label>
                                            <input type="text" :name="'items['+index+'][isbn]'" x-model="item.isbn" placeholder="ISBN-13..."
                                                class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold focus:border-[#0f4c3a] focus:ring-0 outline-none">
                                        </div>
                                    </div>

                                    {{-- Kolom Tengah: Deskripsi & Foto --}}
                                    <div class="md:col-span-6 flex flex-col gap-4">
                                        <div>
                                            <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Keterangan Khusus (Opsional)</label>
                                            <textarea :name="'items['+index+'][sinopsis]'" x-model="item.sinopsis" rows="1" 
                                                class="w-full h-10 rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-xs outline-none focus:border-[#0f4c3a] focus:ring-0 shadow-xs" 
                                                placeholder="Berbeda dari sinopsis utama? Isi di sini."></textarea>
                                        </div>
                                        <div class="bg-white p-2 rounded-2xl border border-gray-100 shadow-xs group/file">
                                            <label class="flex items-center gap-3 cursor-pointer">
                                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#e8f4f0] text-[#0f4c3a] group-hover/file:bg-[#0f4c3a] group-hover/file:text-white transition-colors">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                                </div>
                                                <input type="file" :name="'items['+index+'][sampul]'" class="block w-full text-[10px] text-gray-400 file:hidden cursor-pointer" />
                                                <span class="text-[10px] font-bold text-gray-400 mr-2 uppercase tracking-widest">Pilih Sampul</span>
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Kolom Kanan: Aksi --}}
                                    <div class="md:col-span-2 flex items-center justify-end">
                                        <button type="button" @click="removeItem(index)" x-show="items.length > 1" 
                                            class="h-10 w-10 flex items-center justify-center rounded-2xl text-gray-200 hover:text-red-500 hover:bg-red-50 transition-all border border-gray-100 hover:border-red-200 shadow-xs group/del">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover/del:scale-110 transition-transform"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="pt-10 flex flex-col md:flex-row items-center justify-between gap-6">
                            <div class="flex items-center gap-4 group/ready">
                                <div class="flex px-4 py-2.5 bg-[#e8f4f0] border border-[#c8e6d8] rounded-2xl transition-all group-hover/ready:bg-[#0f4c3a] group-hover/ready:text-white group-hover/ready:border-[#0f4c3a]">
                                    <svg class="h-5 w-5 text-[#0f4c3a] group-hover/ready:text-white" fill="none" stroke="currentColor" viewBox="0 0 18 18">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.8333 10H4.16666" />
                                    </svg>
                                    <span class="ml-2 text-xs font-bold self-center uppercase tracking-widest" x-text="items.length + ' Koleksi Siap Simpan'"></span>
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full md:w-auto rounded-3xl bg-[#0f4c3a] py-5 px-12 text-sm font-bold text-white hover:bg-[#0a382b] shadow-2xl hover:shadow-[#0f4c3a]/30 transition-all flex items-center justify-center gap-3 active:scale-95 uppercase tracking-widest">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                Konfirmasi & Simpan Koleksi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- ===== KARTU KEDUA: ASSIGN BUKU KE SERIES ===== --}}
    <div class="mt-12">
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-black tracking-tight flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#e8f4f0] text-[#0f4c3a]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </span>
                    Kelompokkan Buku ke Series
                </h2>
                <p class="text-gray-500 text-sm mt-1 font-medium italic">Masukkan buku-buku yang sudah ada ke dalam suatu series.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 lg:p-8">
            <form action="{{ route('admin.buku.batch.series') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Select Series --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Pilih Series Tujuan <span class="text-red-500">*</span></label>
                        <select name="id_series" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-bold focus:border-[#0f4c3a] focus:ring-0 outline-none appearance-none transition shadow-sm hover:border-[#c8e6d8]">
                            <option value="">-- Pilih Series --</option>
                            @foreach($series as $s)
                                <option value="{{ $s->id_series }}">{{ $s->nama_series }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select Buku (Checkboxes) --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Pilih Buku Belum Punya Series <span class="text-red-500">*</span></label>
                        <div class="flex flex-col gap-2 max-h-[220px] overflow-y-auto pr-2 custom-scrollbar p-1">
                            @forelse($buku_tanpa_series as $bukuItem)
                                <label class="group flex items-center gap-3 cursor-pointer select-none px-4 py-3 rounded-2xl border border-gray-100 bg-white hover:bg-[#e8f4f0] hover:border-[#c8e6d8] transition-all shadow-sm text-gray-600 hover:text-[#0f4c3a]">
                                    <input type="checkbox" name="buku_ids[]" value="{{ $bukuItem->id_buku }}" class="w-4 h-4 rounded text-[#0f4c3a] focus:ring-[#0f4c3a] border-gray-300 cursor-pointer">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold leading-tight">{{ $bukuItem->judul_buku }}</span>
                                        @if($bukuItem->nomor_volume)
                                            <span class="text-[10px] opacity-80 mt-0.5 font-medium">Volume {{ $bukuItem->nomor_volume }}</span>
                                        @endif
                                    </div>
                                </label>
                            @empty
                                <div class="px-4 py-4 text-xs text-gray-400 font-medium italic text-center rounded-2xl border border-dashed border-gray-200">
                                    Keren! Semua buku di sistem sudah saling terhubung ke series.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="w-full md:w-auto rounded-3xl bg-[#0f4c3a] py-4 px-10 text-sm font-bold text-white hover:bg-[#0a382b] shadow-xl hover:shadow-[#0f4c3a]/30 transition-all flex items-center justify-center gap-3 active:scale-95 uppercase tracking-widest">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Simpan ke Series
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== KARTU KETIGA: PINDAH BUKU ANTAR SERIES ===== --}}
    <div class="mt-10"
        x-data="{
            seriesAsal: '',
            bukuList: @js($buku_dalam_series->map(fn($b) => ['id' => $b->id_buku, 'judul' => $b->judul_buku, 'volume' => $b->nomor_volume, 'series_id' => $b->id_series, 'series_nama' => $b->series?->nama_series])->values()),
            get filteredBuku() {
                if (!this.seriesAsal) return [];
                return this.bukuList.filter(b => String(b.series_id) === String(this.seriesAsal));
            }
        }"
    >
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-black tracking-tight flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </span>
                    Pindah Buku ke Series Lain
                </h2>
                <p class="text-gray-500 text-sm mt-1 font-medium italic">Pindahkan buku yang sudah ada di suatu series ke series yang berbeda.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 lg:p-8">
            <form action="{{ route('admin.buku.batch.pindah-series') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- 1. Pilih Series Asal --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">
                            1. Pilih Series Asal <span class="text-red-500">*</span>
                        </label>
                        <select x-model="seriesAsal"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-bold focus:border-amber-500 focus:ring-0 outline-none appearance-none transition shadow-sm hover:border-amber-300">
                            <option value="">-- Pilih Series Asal --</option>
                            @foreach($series as $s)
                                <option value="{{ $s->id_series }}">{{ $s->nama_series }}</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-gray-400 mt-1.5 ml-1">Series tempat buku kini berada.</p>
                    </div>

                    {{-- 2. Pilih Buku dari Series Asal --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">
                            2. Pilih Buku yang Dipindah <span class="text-red-500">*</span>
                        </label>

                        <div class="flex flex-col gap-2 max-h-[240px] overflow-y-auto pr-2 custom-scrollbar p-1 rounded-2xl border border-gray-200 bg-gray-50">

                            {{-- Placeholder kalau belum pilih series asal --}}
                            <template x-if="!seriesAsal">
                                <div class="px-4 py-6 text-xs text-gray-400 font-medium italic text-center">
                                    Pilih series asal dulu di kolom kiri.
                                </div>
                            </template>

                            {{-- Tidak ada buku di series ini --}}
                            <template x-if="seriesAsal && filteredBuku.length === 0">
                                <div class="px-4 py-6 text-xs text-gray-400 font-medium italic text-center">
                                    Tidak ada buku di series ini.
                                </div>
                            </template>

                            {{-- Daftar buku --}}
                            <template x-for="buku in filteredBuku" :key="buku.id">
                                <label class="group flex items-center gap-3 cursor-pointer select-none px-4 py-3 rounded-2xl border border-transparent bg-white hover:bg-amber-50 hover:border-amber-200 transition-all shadow-sm text-gray-600 hover:text-amber-700 mx-1 my-0.5">
                                    <input type="checkbox" name="buku_pindah_ids[]" :value="buku.id"
                                        class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 border-gray-300 cursor-pointer">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold leading-tight" x-text="buku.judul"></span>
                                        <span class="text-[10px] opacity-70 mt-0.5 font-medium" x-text="buku.volume ? 'Vol. ' + buku.volume : ''"></span>
                                    </div>
                                </label>
                            </template>
                        </div>
                    </div>

                    {{-- 3. Pilih Series Tujuan --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">
                            3. Pilih Series Tujuan <span class="text-red-500">*</span>
                        </label>
                        <select name="id_series_tujuan" required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-bold focus:border-amber-500 focus:ring-0 outline-none appearance-none transition shadow-sm hover:border-amber-300">
                            <option value="">-- Pilih Series Tujuan --</option>
                            @foreach($series as $s)
                                <option value="{{ $s->id_series }}">{{ $s->nama_series }}</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-gray-400 mt-1.5 ml-1">Series yang ingin dituju.</p>

                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="w-full rounded-3xl bg-amber-500 py-4 px-8 text-sm font-bold text-white hover:bg-amber-600 shadow-xl hover:shadow-amber-300/40 transition-all flex items-center justify-center gap-3 active:scale-95 uppercase tracking-widest">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                Pindahkan ke Series Tujuan
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
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
