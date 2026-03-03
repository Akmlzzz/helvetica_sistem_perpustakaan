@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

        {{-- Page Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-black tracking-tight">Kelola Musik Player</h2>
                <p class="text-gray-500 text-sm mt-1">Tambah dan atur lagu yang diputar di background music player.</p>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-[#e8f4f0] rounded-2xl border border-[#c8e6d8]">
                <svg class="h-5 w-5 text-[#0f4c3a]" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
                </svg>
                <span class="text-xs font-bold text-[#0f4c3a]">{{ $musikList->where('aktif', true)->count() }} lagu
                    aktif</span>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div
                class="mb-6 flex items-center gap-3 rounded-2xl bg-green-50 border border-green-200 px-5 py-4 text-sm font-medium text-green-700">
                <svg class="h-5 w-5 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div
                class="mb-6 flex items-center gap-3 rounded-2xl bg-red-50 border border-red-200 px-5 py-4 text-sm font-medium text-red-700">
                <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ===== KOLOM KIRI: Form Tambah Lagu ===== --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sticky top-4"
                    x-data="{ sumber: '{{ old('sumber_tipe', 'file') }}' }">
                    <div class="mb-5">
                        <h3 class="text-lg font-bold text-gray-800">Tambah Lagu Baru</h3>
                        <p class="text-xs text-gray-400 mt-1">Upload file MP3/OGG atau masukkan URL langsung.</p>
                    </div>

                    {{-- Tab Pilih Sumber --}}
                    <div class="flex rounded-2xl bg-gray-100 p-1 mb-6 gap-1">
                        <button type="button" @click="sumber = 'file'"
                            :class="sumber === 'file' ? 'bg-white shadow-sm text-[#0f4c3a] font-bold' : 'text-gray-400 hover:text-gray-600'"
                            class="flex-1 flex items-center justify-center gap-1.5 rounded-xl py-2.5 text-xs font-medium transition-all">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Upload File
                        </button>
                        <button type="button" @click="sumber = 'url'"
                            :class="sumber === 'url' ? 'bg-white shadow-sm text-[#0f4c3a] font-bold' : 'text-gray-400 hover:text-gray-600'"
                            class="flex-1 flex items-center justify-center gap-1.5 rounded-xl py-2.5 text-xs font-medium transition-all">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            URL Link
                        </button>
                    </div>

                    <form action="{{ route('admin.musik.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-5">
                        @csrf
                        <input type="hidden" name="sumber_tipe" :value="sumber">

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Judul
                                Lagu</label>
                            <input type="text" name="judul" value="{{ old('judul') }}" required
                                class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 focus:outline-none transition placeholder:text-gray-400"
                                placeholder="e.g. Midnight Library">
                            @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Artis /
                                Album</label>
                            <input type="text" name="artis" value="{{ old('artis') }}" required
                                class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 focus:outline-none transition placeholder:text-gray-400"
                                placeholder="e.g. Lofi Ambient">
                            @error('artis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Input Upload File --}}
                        <div x-show="sumber === 'file'">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">File
                                Audio</label>
                            <label id="dropzone-label"
                                class="flex flex-col items-center justify-center w-full h-32 rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 cursor-pointer hover:border-[#0f4c3a] hover:bg-[#f0faf5] transition-all group"
                                x-data="{ fileName: '' }"
                                @dragover.prevent="$el.classList.add('border-[#0f4c3a]', 'bg-[#f0faf5]')"
                                @dragleave.prevent="$el.classList.remove('border-[#0f4c3a]', 'bg-[#f0faf5]')"
                                @drop.prevent="
                                    $el.classList.remove('border-[#0f4c3a]', 'bg-[#f0faf5]');
                                    const f = $event.dataTransfer.files[0];
                                    if (f) { fileName = f.name; $refs.fileInput.files = $event.dataTransfer.files; }
                                ">
                                <div x-show="!fileName" class="flex flex-col items-center gap-2 pointer-events-none">
                                    <svg class="h-8 w-8 text-gray-300 group-hover:text-[#0f4c3a] transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                    <p class="text-xs text-gray-400 font-medium">Klik atau seret file ke sini</p>
                                    <p class="text-[10px] text-gray-300">MP3 atau OGG, maks 20MB</p>
                                </div>
                                <div x-show="fileName" class="flex flex-col items-center gap-2 pointer-events-none">
                                    <svg class="h-8 w-8 text-[#0f4c3a]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <p class="text-xs text-[#0f4c3a] font-bold truncate max-w-[180px]"
                                        x-text="fileName"></p>
                                    <p class="text-[10px] text-gray-400">Klik untuk ganti file</p>
                                </div>
                                <input x-ref="fileInput" type="file" name="file_audio" accept=".mp3,.ogg,audio/mpeg,audio/ogg"
                                    class="hidden"
                                    @change="fileName = $event.target.files[0]?.name ?? ''">
                            </label>
                            @error('file_audio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Input URL --}}
                        <div x-show="sumber === 'url'" style="display:none;">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">URL File
                                MP3 / OGG</label>
                            <input type="url" name="url" value="{{ old('url') }}"
                                class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 focus:outline-none transition placeholder:text-gray-400"
                                placeholder="https://example.com/song.mp3">
                            <p class="text-[10px] text-gray-400 mt-1">URL langsung ke file .mp3 atau .ogg</p>
                            @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Urutan</label>
                                <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0"
                                    class="w-full rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:border-[#0f4c3a] focus:ring-0 focus:outline-none transition">
                            </div>
                            <div class="flex flex-col justify-end">
                                <label
                                    class="flex items-center gap-3 cursor-pointer p-3 rounded-2xl border border-gray-100 bg-gray-50">
                                    <input type="checkbox" name="aktif" value="1" checked class="sr-only peer">
                                    <div
                                        class="relative w-10 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0f4c3a]">
                                    </div>
                                    <span class="text-xs font-bold text-gray-500">Aktif</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full rounded-2xl bg-[#0f4c3a] py-4 text-sm font-bold text-white hover:bg-[#0a382b] shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Lagu
                        </button>
                    </form>
                </div>
            </div>

            {{-- ===== KOLOM KANAN: Daftar Lagu ===== --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                        <div>
                            <h3 class="font-bold text-black text-base">Daftar Playlist</h3>
                            <p class="text-xs text-gray-400 mt-0.5">Semua lagu yang tersimpan di database</p>
                        </div>
                        <span class="text-xs font-bold bg-gray-100 text-gray-500 px-3 py-1 rounded-full">
                            {{ $musikList->count() }} lagu
                        </span>
                    </div>

                    @if($musikList->isEmpty())
                        <div class="text-center py-20">
                            <div class="mx-auto w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mb-4">
                                <svg class="h-10 w-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                            </div>
                            <p class="text-gray-400 font-bold">Belum ada lagu</p>
                            <p class="text-gray-400 text-sm mt-1">Tambahkan lagu pertama lewat form di sebelah kiri.</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-50">
                            @foreach($musikList as $musik)
                                <div x-data="{ editMode: false, editSumber: '{{ $musik->file_path ? 'file' : 'url' }}' }"
                                    class="px-6 py-4 hover:bg-gray-50/60 transition-colors">
                                    <div x-show="!editMode" class="flex items-center gap-4">
                                        {{-- Rank Icon --}}
                                        <div
                                            class="h-10 w-10 shrink-0 rounded-2xl bg-[#e8f4f0] flex items-center justify-center text-[#0f4c3a] font-black text-sm">
                                            {{ $musik->urutan > 0 ? $musik->urutan : '#' }}
                                        </div>
                                        {{-- Info --}}
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-800 truncate">{{ $musik->judul }}</p>
                                            <p class="text-xs text-gray-400 truncate">{{ $musik->artis }}</p>
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                @if($musik->file_path)
                                                    <span
                                                        class="inline-flex items-center gap-1 text-[10px] font-medium text-[#0f4c3a] bg-[#e8f4f0] px-2 py-0.5 rounded-full">
                                                        <svg class="h-3 w-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                        </svg>
                                                        File Upload
                                                    </span>
                                                    <p class="text-[10px] text-gray-300 truncate">
                                                        {{ basename($musik->file_path) }}</p>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1 text-[10px] font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                                                        <svg class="h-3 w-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                        </svg>
                                                        URL Link
                                                    </span>
                                                    <p class="text-[10px] text-gray-300 truncate">{{ $musik->url }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Status --}}
                                        <form action="{{ route('admin.musik.toggle', $musik) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="shrink-0 px-3 py-1.5 rounded-full text-xs font-bold transition-all {{ $musik->aktif ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-400 hover:bg-gray-200' }}">
                                                {{ $musik->aktif ? '● Aktif' : '○ Nonaktif' }}
                                            </button>
                                        </form>
                                        {{-- Actions --}}
                                        <div class="flex items-center gap-2 shrink-0">
                                            <button @click="editMode = true"
                                                class="p-2 rounded-xl text-gray-400 hover:text-[#0f4c3a] hover:bg-[#e8f4f0] transition-all">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('admin.musik.destroy', $musik) }}" method="POST"
                                                onsubmit="return confirm('Hapus lagu \'{{ $musik->judul }}\'?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 rounded-xl text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Edit Form --}}
                                    <div x-show="editMode" style="display:none;" class="mt-2">
                                        <form action="{{ route('admin.musik.update', $musik) }}" method="POST"
                                            enctype="multipart/form-data" class="space-y-3">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="sumber_tipe" :value="editSumber">

                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label
                                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Judul</label>
                                                    <input type="text" name="judul" value="{{ $musik->judul }}" required
                                                        class="w-full mt-1 rounded-xl border border-gray-100 bg-gray-50 px-3 py-2 text-sm focus:border-[#0f4c3a] focus:outline-none">
                                                </div>
                                                <div>
                                                    <label
                                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Artis</label>
                                                    <input type="text" name="artis" value="{{ $musik->artis }}" required
                                                        class="w-full mt-1 rounded-xl border border-gray-100 bg-gray-50 px-3 py-2 text-sm focus:border-[#0f4c3a] focus:outline-none">
                                                </div>
                                            </div>

                                            {{-- Tab edit sumber --}}
                                            <div>
                                                <label
                                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Sumber
                                                    Audio</label>
                                                <div class="flex rounded-xl bg-gray-100 p-0.5 mb-2 gap-0.5">
                                                    <button type="button" @click="editSumber = 'file'"
                                                        :class="editSumber === 'file' ? 'bg-white shadow-sm text-[#0f4c3a] font-bold' : 'text-gray-400'"
                                                        class="flex-1 rounded-lg py-1.5 text-xs font-medium transition-all">Upload
                                                        File</button>
                                                    <button type="button" @click="editSumber = 'url'"
                                                        :class="editSumber === 'url' ? 'bg-white shadow-sm text-[#0f4c3a] font-bold' : 'text-gray-400'"
                                                        class="flex-1 rounded-lg py-1.5 text-xs font-medium transition-all">URL
                                                        Link</button>
                                                </div>

                                                {{-- Edit: Upload File --}}
                                                <div x-show="editSumber === 'file'">
                                                    @if($musik->file_path)
                                                        <p class="text-[10px] text-gray-400 mb-1">File saat ini:
                                                            <span
                                                                class="font-medium text-[#0f4c3a]">{{ basename($musik->file_path) }}</span>
                                                        </p>
                                                    @endif
                                                    <label
                                                        class="flex items-center gap-3 w-full rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 px-3 py-3 cursor-pointer hover:border-[#0f4c3a] hover:bg-[#f0faf5] transition-all"
                                                        x-data="{ editFileName: '' }">
                                                        <svg class="h-5 w-5 text-gray-400 shrink-0" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                        </svg>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-xs text-gray-500 truncate"
                                                                x-text="editFileName || 'Klik untuk pilih file MP3/OGG baru'"></p>
                                                            <p class="text-[10px] text-gray-300">Kosongkan jika tidak ingin
                                                                mengganti file</p>
                                                        </div>
                                                        <input type="file" name="file_audio"
                                                            accept=".mp3,.ogg,audio/mpeg,audio/ogg" class="hidden"
                                                            @change="editFileName = $event.target.files[0]?.name ?? ''">
                                                    </label>
                                                </div>

                                                {{-- Edit: URL --}}
                                                <div x-show="editSumber === 'url'" style="display:none;">
                                                    <input type="url" name="url" value="{{ $musik->url }}"
                                                        class="w-full rounded-xl border border-gray-100 bg-gray-50 px-3 py-2 text-sm focus:border-[#0f4c3a] focus:outline-none"
                                                        placeholder="https://example.com/song.mp3">
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label
                                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Urutan</label>
                                                    <input type="number" name="urutan" value="{{ $musik->urutan }}"
                                                        min="0"
                                                        class="w-full mt-1 rounded-xl border border-gray-100 bg-gray-50 px-3 py-2 text-sm focus:border-[#0f4c3a] focus:outline-none">
                                                </div>
                                                <div class="flex items-end pb-1">
                                                    <label class="flex items-center gap-2 cursor-pointer">
                                                        <input type="hidden" name="aktif" value="0">
                                                        <input type="checkbox" name="aktif" value="1"
                                                            {{ $musik->aktif ? 'checked' : '' }}
                                                            class="rounded border-gray-300 text-[#0f4c3a] focus:ring-0">
                                                        <span class="text-xs font-bold text-gray-500">Aktif</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="flex gap-2 pt-1">
                                                <button type="submit"
                                                    class="flex-1 rounded-xl bg-[#0f4c3a] py-2.5 text-xs font-bold text-white hover:bg-[#0a382b] transition">Simpan
                                                    Perubahan</button>
                                                <button type="button" @click="editMode = false"
                                                    class="flex-1 rounded-xl border border-gray-200 py-2.5 text-xs font-bold text-gray-600 hover:bg-gray-50 transition">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection