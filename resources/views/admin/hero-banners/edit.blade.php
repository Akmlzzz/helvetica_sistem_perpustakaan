@extends('layouts.app')

@section('content')
    <div class="mx-auto">
        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('admin.hero-banners.index') }}" class="mb-1 inline-flex items-center gap-1 text-sm text-gray-400 hover:text-[#004236] transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke daftar
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Edit Banner Hero</h2>
            </div>
        </div>

        <form action="{{ route('admin.hero-banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                {{-- ===== LEFT COLUMN: Images ===== --}}
                <div class="xl:col-span-1 space-y-5">
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gradient-to-r from-[#004236]/5 to-transparent px-5 py-4">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="h-5 w-5 text-[#004236]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Gambar Layers
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">Biarkan kosong untuk mempertahankan gambar lama</p>
                        </div>
                        <div class="space-y-5 p-5">
                            {{-- Background --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Background Image</label>
                                @if($banner->bg_img)
                                    <div class="mb-2 h-24 w-full overflow-hidden rounded-xl">
                                        <img src="{{ Storage::url($banner->bg_img) }}" class="h-full w-full object-cover">
                                    </div>
                                @endif
                                <input type="file" name="bg_img" accept="image/*"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-[#004236] file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-white hover:file:bg-[#003028] transition focus:border-[#004236] focus:outline-none">
                            </div>
                            {{-- Character --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Character Image</label>
                                @if($banner->char_img)
                                    <div class="mb-2 flex items-center gap-2">
                                        <img src="{{ Storage::url($banner->char_img) }}" class="h-16 w-auto rounded-lg object-contain bg-gray-100 p-1">
                                    </div>
                                @endif
                                <input type="file" name="char_img" accept="image/*"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-gray-600 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-white hover:file:bg-gray-700 transition focus:border-[#004236] focus:outline-none">
                            </div>
                            {{-- Title --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Title / Logo Image</label>
                                @if($banner->title_img)
                                    <div class="mb-2 flex items-center gap-2">
                                        <img src="{{ Storage::url($banner->title_img) }}" class="h-12 w-auto rounded-lg object-contain bg-gray-100 p-1">
                                    </div>
                                @endif
                                <input type="file" name="title_img" accept="image/*"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-gray-600 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-white hover:file:bg-gray-700 transition focus:border-[#004236] focus:outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- Settings --}}
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gradient-to-r from-[#004236]/5 to-transparent px-5 py-4">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="h-5 w-5 text-[#004236]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Pengaturan
                            </h3>
                        </div>
                        <div class="space-y-4 p-5">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Urutan Tampil</label>
                                <input type="number" name="order_priority" value="{{ old('order_priority', $banner->order_priority) }}"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/10">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Warna Teks Sinopsis</label>
                                <select name="synopsis_color"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/10">
                                    <option value="#084734" {{ old('synopsis_color', $banner->synopsis_color) === '#084734' ? 'selected' : '' }}>Hijau Gelap (Tema)</option>
                                    <option value="#FFFFFF" {{ old('synopsis_color', $banner->synopsis_color) === '#FFFFFF' ? 'selected' : '' }}>Putih Terang</option>
                                </select>
                            </div>
                            <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">Aktifkan Banner</p>
                                    <p class="text-xs text-gray-400">Banner akan muncul di halaman anggota</p>
                                </div>
                                <label class="relative inline-flex cursor-pointer items-center">
                                    <input type="checkbox" name="is_active" class="peer sr-only" {{ $banner->is_active ? 'checked' : '' }}>
                                    <div class="peer h-6 w-11 rounded-full bg-gray-300 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:bg-[#004236] peer-checked:after:translate-x-full"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== RIGHT COLUMN: Content ===== --}}
                <div class="xl:col-span-2 space-y-5">

                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gradient-to-r from-[#004236]/5 to-transparent px-5 py-4">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="h-5 w-5 text-[#004236]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Konten Banner
                            </h3>
                        </div>
                        <div class="space-y-4 p-5">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Sinopsis</label>
                                <textarea rows="3" name="synopsis" placeholder="Deskripsi singkat dan menarik..."
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/10">{{ old('synopsis', $banner->synopsis) }}</textarea>
                            </div>

                            {{-- Series --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-700">
                                    Series Terkait
                                    <span class="ml-1 text-xs font-normal text-gray-400">(Tombol "Lihat Buku" & "Koleksi Saya" akan mengarah ke sini)</span>
                                </label>
                                <select name="id_series"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/10">
                                    <option value="">-- Tidak ada series --</option>
                                    @foreach($series as $ser)
                                        <option value="{{ $ser->id_series }}" {{ old('id_series', $banner->id_series) == $ser->id_series ? 'selected' : '' }}>
                                            {{ $ser->nama_series }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-400">Jika dipilih, tombol "Lihat Buku" akan mengarah ke halaman series ini.</p>
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Target Link (Opsional)</label>
                                <input type="text" name="target_link" placeholder="/anggota/buku/1"
                                    value="{{ old('target_link', $banner->target_link) }}"
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/10">
                                <p class="mt-1 text-xs text-gray-400">Hanya dipakai jika "Series Terkait" tidak dipilih di atas.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tags --}}
                    @php
                        $existingTags = $banner->tags;
                        if (is_string($existingTags)) {
                            $existingTags = json_decode($existingTags, true) ?? [];
                        }
                        if (!is_array($existingTags)) {
                            $existingTags = [];
                        }
                    @endphp
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                        <div class="border-b border-gray-100 bg-gradient-to-r from-[#004236]/5 to-transparent px-5 py-4">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="h-5 w-5 text-[#004236]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                Tags / Kategori
                            </h3>
                        </div>
                        <div class="p-5"
                            x-data="{ selectedTags: {{ json_encode($existingTags) }}, toggleTag(tag) { const i = this.selectedTags.indexOf(tag); i > -1 ? this.selectedTags.splice(i, 1) : this.selectedTags.push(tag); } }">
                            <p class="mb-3 text-xs text-gray-500">Klik kategori untuk memilih/batal. Bisa pilih lebih dari satu.</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($kategori as $kat)
                                    <div @click="toggleTag('{{ $kat->nama_kategori }}')"
                                        class="cursor-pointer select-none rounded-full border px-4 py-1.5 text-sm font-medium transition-all"
                                        :class="selectedTags.includes('{{ $kat->nama_kategori }}')
                                            ? 'bg-[#004236] border-[#004236] text-white shadow-sm'
                                            : 'bg-white border-gray-200 text-gray-600 hover:border-[#004236] hover:text-[#004236]'">
                                        {{ $kat->nama_kategori }}
                                        <span x-show="selectedTags.includes('{{ $kat->nama_kategori }}')" class="ml-1">✓</span>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="tags" :value="JSON.stringify(selectedTags)">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#004236] py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#003028] hover:shadow-md">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
