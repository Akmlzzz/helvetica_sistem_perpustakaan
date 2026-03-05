@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Edit Banner Hero
            </h2>
        </div>

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <form action="{{ route('admin.hero-banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data"
                class="p-6.5">
                @csrf
                @method('PUT')

                <!-- Images Section -->
                <div class="mb-6 border-b border-stroke pb-6 dark:border-strokedark">
                    <h3 class="mb-4 font-medium text-black dark:text-white">Gambar (Layers)</h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <!-- Background -->
                        <div>
                            <label class="mb-2.5 block text-black dark:text-white">Background Image</label>
                            @if($banner->bg_img)
                                <img src="{{ Storage::url($banner->bg_img) }}" class="mb-2 h-20 w-auto rounded object-cover" />
                            @endif
                            <input type="file" name="bg_img" accept="image/*"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        </div>

                        <!-- Character -->
                        <div>
                            <label class="mb-2.5 block text-black dark:text-white">Character Image</label>
                            @if($banner->char_img)
                                <img src="{{ Storage::url($banner->char_img) }}"
                                    class="mb-2 h-20 w-auto rounded object-contain" />
                            @endif
                            <input type="file" name="char_img" accept="image/*"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        </div>

                        <!-- Title/Logo -->
                        <div>
                            <label class="mb-2.5 block text-black dark:text-white">Title/Logo Image</label>
                            @if($banner->title_img)
                                <img src="{{ Storage::url($banner->title_img) }}"
                                    class="mb-2 h-20 w-auto rounded object-contain" />
                            @endif
                            <input type="file" name="title_img" accept="image/*"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="mb-4.5 grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-3">
                        <label class="mb-2.5 block text-black dark:text-white">Sinopsis</label>
                        <textarea rows="3" name="synopsis" placeholder="Deskripsi singkat menarik..."
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('synopsis', $banner->synopsis) }}</textarea>
                    </div>
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white">Warna Teks Sinopsis</label>
                        <select name="synopsis_color"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                            <option value="#084734" {{ old('synopsis_color', $banner->synopsis_color) === '#084734' ? 'selected' : '' }}>Warna Tema (Hijau Gelap)</option>
                            <option value="#FFFFFF" {{ old('synopsis_color', $banner->synopsis_color) === '#FFFFFF' ? 'selected' : '' }}>Putih Terang</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4.5 grid grid-cols-1 gap-6 md:grid-cols-2">
                    {{-- Tags: Clickable kategori selector --}}
                    @php
                        $existingTags = $banner->tags;
                        if (is_string($existingTags)) {
                            $existingTags = json_decode($existingTags, true) ?? [];
                        }
                        if (!is_array($existingTags)) {
                            $existingTags = [];
                        }
                    @endphp
                    <div x-data="{ selectedTags: {{ json_encode($existingTags) }}, toggleTag(tag) { const i = this.selectedTags.indexOf(tag); i > -1 ? this.selectedTags.splice(i, 1) : this.selectedTags.push(tag); } }">
                        <label class="mb-2.5 block text-black dark:text-white">Tags / Kategori</label>
                        <div
                            class="flex flex-wrap gap-2 rounded border border-stroke bg-transparent p-3 dark:border-form-strokedark dark:bg-form-input min-h-[56px]">
                            @foreach($kategori as $kat)
                                <div @click="toggleTag('{{ $kat->nama_kategori }}')"
                                    class="cursor-pointer select-none rounded border px-3 py-1 text-sm font-medium transition-colors"
                                    :class="selectedTags.includes('{{ $kat->nama_kategori }}')
                                                    ? 'bg-primary border-primary text-white'
                                                    : 'bg-white border-stroke text-gray-600 hover:border-primary dark:bg-form-input dark:border-form-strokedark dark:text-gray-300'">
                                    {{ $kat->nama_kategori }}
                                    <span x-show="selectedTags.includes('{{ $kat->nama_kategori }}')"
                                        class="ml-1 inline-block">✓</span>
                                </div>
                            @endforeach
                        </div>
                        {{-- Hidden input yang menyimpan nilai tags sebagai JSON array --}}
                        <input type="hidden" name="tags" :value="JSON.stringify(selectedTags)">
                        <p class="text-xs text-gray-500 mt-2">Klik untuk memilih tag/kategori. Bisa pilih lebih dari satu.
                        </p>
                    </div>

                    <div>
                        <label class="mb-2.5 block text-black dark:text-white">Target Link (URL Buku)</label>
                        <input type="text" name="target_link" value="{{ old('target_link', $banner->target_link) }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                </div>

                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2.5 block text-black dark:text-white">Order Priority</label>
                        <input type="number" name="order_priority"
                            value="{{ old('order_priority', $banner->order_priority) }}"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                    </div>
                    <div class="flex items-center pt-8">
                        <label for="is_active" class="flex cursor-pointer select-none items-center">
                            <div class="relative">
                                <input type="checkbox" id="is_active" name="is_active" class="sr-only" {{ $banner->is_active ? 'checked' : '' }} />
                                <div class="block h-8 w-14 rounded-full bg-meta-9 dark:bg-[#5A616B]"></div>
                                <div class="dot absolute left-1 top-1 h-6 w-6 rounded-full bg-white transition"></div>
                            </div>
                            <span class="ml-3 text-black dark:text-white">Aktifkan Banner?</span>
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                    Update Banner
                </button>
            </form>
        </div>
    </div>

@endsection
