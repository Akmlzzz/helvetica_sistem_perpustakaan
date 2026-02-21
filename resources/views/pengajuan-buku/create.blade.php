@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-xl p-4 md:p-6 2xl:p-10">

        {{-- Alert Success - full width --}}
        @if(session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl bg-green-50 border border-green-100 px-5 py-4">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100">
                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-green-800">Pengajuan berhasil dikirim!</p>
                    <p class="text-xs text-green-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Validation Errors - full width --}}
        @if($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-100 px-5 py-4">
                <p class="text-sm font-semibold text-red-700 mb-2">Terdapat beberapa kesalahan:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-xs text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('pengajuan-buku.store') }}">
            @csrf

            {{-- 2-Kolom Grid --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">

                {{-- Kolom Kiri: Header + Info Buku --}}
                <div class="flex flex-col gap-6">

                    {{-- Header Card --}}
                    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                        <div class="bg-linear-to-r from-[#004236] to-[#006b57] px-6 py-5 flex items-center gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-white">Usulkan Buku Baru</h3>
                                <p class="text-xs text-green-200 mt-0.5">Bantu kembangkan koleksi perpustakaan</p>
                            </div>
                        </div>
                    </div>

                    {{-- Card Info Buku --}}
                    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h4 class="text-sm font-semibold text-gray-800">Informasi Buku</h4>
                            <p class="text-xs text-gray-400 mt-0.5">Detail buku yang ingin Anda usulkan</p>
                        </div>
                        <div class="px-6 py-5 space-y-5">

                            {{-- Judul Buku --}}
                            <div>
                                <label for="judul_buku" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Judul Buku <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="judul_buku" name="judul_buku" value="{{ old('judul_buku') }}"
                                    placeholder="Contoh: Clean Code: A Handbook of Agile Software Craftsmanship"
                                    class="w-full rounded-xl border px-4 py-2.5 text-sm text-gray-800 outline-none focus:ring-2 transition-all {{ $errors->has('judul_buku') ? 'border-red-400 focus:border-red-400 focus:ring-red-200' : 'border-gray-200 focus:border-[#004236] focus:ring-[#004236]/20' }}">
                                @error('judul_buku')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nama Penulis --}}
                            <div>
                                <label for="nama_penulis" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Nama Penulis / Pengarang <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama_penulis" name="nama_penulis" value="{{ old('nama_penulis') }}"
                                    placeholder="Contoh: Robert C. Martin"
                                    class="w-full rounded-xl border px-4 py-2.5 text-sm text-gray-800 outline-none focus:ring-2 transition-all {{ $errors->has('nama_penulis') ? 'border-red-400 focus:border-red-400 focus:ring-red-200' : 'border-gray-200 focus:border-[#004236] focus:ring-[#004236]/20' }}">
                                @error('nama_penulis')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- ISBN & Penerbit --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="isbn" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Nomor ISBN <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                                    </label>
                                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}"
                                        placeholder="Contoh: 978-0-13-235088-4"
                                        class="w-full rounded-xl border px-4 py-2.5 text-sm text-gray-800 outline-none focus:ring-2 transition-all {{ $errors->has('isbn') ? 'border-red-400 focus:border-red-400 focus:ring-red-200' : 'border-gray-200 focus:border-[#004236] focus:ring-[#004236]/20' }}">
                                    @error('isbn')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="penerbit" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Penerbit <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                                    </label>
                                    <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit') }}"
                                        placeholder="Contoh: Prentice Hall"
                                        class="w-full rounded-xl border px-4 py-2.5 text-sm text-gray-800 outline-none focus:ring-2 transition-all {{ $errors->has('penerbit') ? 'border-red-400 focus:border-red-400 focus:ring-red-200' : 'border-gray-200 focus:border-[#004236] focus:ring-[#004236]/20' }}">
                                    @error('penerbit')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tahun Terbit & Kategori --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="tahun_terbit" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Tahun Terbit <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                                    </label>
                                    <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
                                        placeholder="Contoh: {{ date('Y') }}" min="1800" max="{{ date('Y') }}"
                                        class="w-full rounded-xl border px-4 py-2.5 text-sm text-gray-800 outline-none focus:ring-2 transition-all {{ $errors->has('tahun_terbit') ? 'border-red-400 focus:border-red-400 focus:ring-red-200' : 'border-gray-200 focus:border-[#004236] focus:ring-[#004236]/20' }}">
                                    @error('tahun_terbit')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Kategori <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                                    </label>
                                    <div class="relative">
                                        <select id="kategori" name="kategori"
                                            class="w-full appearance-none rounded-xl border px-4 py-2.5 pr-10 text-sm text-gray-800 outline-none focus:ring-2 transition-all {{ $errors->has('kategori') ? 'border-red-400 focus:border-red-400 focus:ring-red-200' : 'border-gray-200 focus:border-[#004236] focus:ring-[#004236]/20' }}">
                                            <option value="">Pilih Kategori...</option>
                                            @foreach($kategoriList as $kat)
                                                <option value="{{ $kat->nama_kategori }}" {{ old('kategori') == $kat->nama_kategori ? 'selected' : '' }}>
                                                    {{ $kat->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <svg width="10" height="6" viewBox="0 0 10 6" fill="none">
                                                <path d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z" fill="currentColor"/>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('kategori')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- Akhir Kolom Kiri --}}

                </div>

                {{-- Kolom Kanan: Info Pengusul + Alasan + Submit --}}
                <div class="flex flex-col gap-6">

                    {{-- Card Info Pengusul --}}
                    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h4 class="text-sm font-semibold text-gray-800">Informasi Pengusul</h4>
                            <p class="text-xs text-gray-400 mt-0.5">Data diri dan alasan pengusulan</p>
                        </div>
                        <div class="px-6 py-5 space-y-5">

                            {{-- Nama Pengusul --}}
                            <div>
                                <label for="nama_pengusul" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Nama Lengkap Pengusul <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama_pengusul" name="nama_pengusul"
                                    value="{{ old('nama_pengusul', auth()->user()->anggota->nama_lengkap ?? auth()->user()->nama_pengguna) }}"
                                    placeholder="Nama lengkap Anda"
                                    class="w-full rounded-xl border px-4 py-2.5 text-sm text-gray-800 outline-none focus:ring-2 transition-all {{ $errors->has('nama_pengusul') ? 'border-red-400 focus:border-red-400 focus:ring-red-200' : 'border-gray-200 focus:border-[#004236] focus:ring-[#004236]/20' }}">
                                @error('nama_pengusul')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Alasan Pengusulan --}}
                            <div>
                                <label for="alasan_pengusulan" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Alasan Pengusulan <span class="text-red-500">*</span>
                                </label>
                                <textarea id="alasan_pengusulan" name="alasan_pengusulan" rows="7"
                                    placeholder="Jelaskan mengapa buku ini perlu diadakan di perpustakaan..."
                                    class="w-full rounded-xl border px-4 py-3 text-sm text-gray-800 outline-none focus:ring-2 transition-all resize-none {{ $errors->has('alasan_pengusulan') ? 'border-red-400 focus:border-red-400 focus:ring-red-200' : 'border-gray-200 focus:border-[#004236] focus:ring-[#004236]/20' }}">{{ old('alasan_pengusulan') }}</textarea>
                                @error('alasan_pengusulan')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-400">Minimal 10 karakter</p>
                            </div>

                        </div>

                        {{-- Footer Form --}}
                        <div class="flex items-center justify-between border-t border-gray-100 bg-gray-50 px-6 py-4">
                            <p class="text-xs text-gray-400">
                                <span class="text-red-500">*</span> Wajib diisi
                            </p>
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-[#004236] px-6 py-2.5 text-sm font-bold text-white hover:bg-[#00362b] transition-all shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Kirim Pengajuan
                            </button>
                        </div>
                    </div>

                    {{-- Info note --}}
                    <div class="flex items-start gap-2 rounded-xl bg-blue-50 border border-blue-100 px-4 py-3">
                        <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xs text-blue-700">Pengajuan Anda akan ditinjau oleh admin perpustakaan. Proses review biasanya membutuhkan 1–3 hari kerja.</p>
                    </div>

                </div>
                {{-- Akhir Kolom Kanan --}}

            </div>
            {{-- Akhir Grid --}}

        </form>
    </div>
@endsection