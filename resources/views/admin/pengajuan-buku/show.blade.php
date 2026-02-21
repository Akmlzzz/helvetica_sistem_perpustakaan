@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-xl p-4 md:p-6 2xl:p-10">

        {{-- Breadcrumb --}}
        <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('admin.pengajuan-buku.index') }}" class="hover:text-[#004236] transition-colors">Pengajuan
                Buku</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800 font-medium">Detail Pengajuan</span>
        </nav>

        {{-- Status Badge Header --}}
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Detail Pengajuan Buku</h2>
            @php
                $statusConfig = [
                    'menunggu' => ['class' => 'bg-amber-100 text-amber-700 border-amber-200', 'emoji' => '⏳'],
                    'disetujui' => ['class' => 'bg-green-100 text-green-700 border-green-200', 'emoji' => '✅'],
                    'ditolak' => ['class' => 'bg-red-100 text-red-700 border-red-200', 'emoji' => '❌'],
                ];
                $cfg = $statusConfig[$pengajuan->status] ?? ['class' => 'bg-gray-100 text-gray-700 border-gray-200', 'emoji' => '?'];
            @endphp
            <span
                class="inline-flex items-center gap-1.5 rounded-full border px-4 py-1.5 text-sm font-semibold {{ $cfg['class'] }}">
                {{ $cfg['emoji'] }} {{ $pengajuan->label_status }}
            </span>
        </div>

        {{-- 2-Kolom Grid Layout --}}
        <div class="grid grid-cols-1 xl:grid-cols-5 gap-6 items-start">

            {{-- Kolom Kiri: Info Buku + Info Pengusul + Catatan Admin --}}
            <div class="xl:col-span-3 flex flex-col gap-6">

                {{-- Kartu Detail Buku --}}
                <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                    <div class="bg-linear-to-r from-[#004236] to-[#006b57] px-6 py-4">
                        <h3 class="text-lg font-bold text-white">Informasi Buku yang Diusulkan</h3>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <div class="grid grid-cols-3 px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">Judul Buku</span>
                            <span class="col-span-2 text-sm font-semibold text-gray-900">{{ $pengajuan->judul_buku }}</span>
                        </div>
                        <div class="grid grid-cols-3 px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">Nama Penulis</span>
                            <span class="col-span-2 text-sm text-gray-800">{{ $pengajuan->nama_penulis }}</span>
                        </div>
                        <div class="grid grid-cols-3 px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">Nomor ISBN</span>
                            <span class="col-span-2 text-sm text-gray-800">{{ $pengajuan->isbn ?? '—' }}</span>
                        </div>
                        <div class="grid grid-cols-3 px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">Penerbit</span>
                            <span class="col-span-2 text-sm text-gray-800">{{ $pengajuan->penerbit ?? '—' }}</span>
                        </div>
                        <div class="grid grid-cols-3 px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">Tahun Terbit</span>
                            <span class="col-span-2 text-sm text-gray-800">{{ $pengajuan->tahun_terbit ?? '—' }}</span>
                        </div>
                        <div class="grid grid-cols-3 px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">Kategori</span>
                            <span class="col-span-2 text-sm text-gray-800">
                                @if($pengajuan->kategori)
                                    <span
                                        class="inline-block rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">{{ $pengajuan->kategori }}</span>
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Kartu Info Pengusul --}}
                <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h3 class="text-base font-semibold text-gray-800">Informasi Pengusul</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <div class="grid grid-cols-3 px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">Nama Pengusul</span>
                            <span
                                class="col-span-2 text-sm font-semibold text-gray-900">{{ $pengajuan->nama_pengusul }}</span>
                        </div>
                        <div class="grid grid-cols-3 px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">Tanggal Pengajuan</span>
                            <span class="col-span-2 text-sm text-gray-800">
                                {{ $pengajuan->dibuat_pada ? $pengajuan->dibuat_pada->format('d F Y \p\u\k\u\l H:i') : '—' }}
                            </span>
                        </div>
                        <div class="grid grid-cols-3 px-6 py-4">
                            <span class="text-sm font-medium text-gray-500 pt-0.5">Alasan Pengusulan</span>
                            <div class="col-span-2">
                                <p
                                    class="text-sm text-gray-800 leading-relaxed bg-gray-50 rounded-xl p-3 border border-gray-100">
                                    {{ $pengajuan->alasan_pengusulan }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Catatan Admin (jika ada) --}}
                @if($pengajuan->catatan_admin)
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 px-6 py-4">
                        <h4 class="text-sm font-semibold text-blue-800 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            Catatan Admin
                        </h4>
                        <p class="text-sm text-blue-800">{{ $pengajuan->catatan_admin }}</p>
                    </div>
                @endif

            </div>
            {{-- Akhir Kolom Kiri --}}

            {{-- Kolom Kanan: Review Form / Tombol Kembali --}}
            <div class="xl:col-span-2">
                @if($pengajuan->status === 'menunggu')
                    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden sticky top-6"
                        x-data="{ action: '' }">
                        <div class="border-b border-gray-100 px-6 py-4">
                            <h3 class="text-base font-semibold text-gray-800">Review Pengajuan</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Pilih keputusan Anda untuk pengajuan buku ini</p>
                        </div>

                        <form method="POST" action="{{ route('admin.pengajuan-buku.status', $pengajuan->id_pengajuan) }}">
                            @csrf
                            @method('PATCH')

                            <div class="px-6 py-5 space-y-5">
                                {{-- Pilih Keputusan --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Keputusan</label>
                                    <div class="flex flex-col gap-3">
                                        <label
                                            class="flex cursor-pointer items-center gap-3 rounded-xl border-2 border-gray-200 p-4 transition-all hover:border-green-300 has-checked:border-green-500 has-checked:bg-green-50">
                                            <input type="radio" name="status" value="disetujui" class="text-green-600 w-4 h-4"
                                                required x-model="action">
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm">✅ Setujui</p>
                                                <p class="text-xs text-gray-500">Buku akan dipertimbangkan untuk diadakan</p>
                                            </div>
                                        </label>
                                        <label
                                            class="flex cursor-pointer items-center gap-3 rounded-xl border-2 border-gray-200 p-4 transition-all hover:border-red-300 has-checked:border-red-500 has-checked:bg-red-50">
                                            <input type="radio" name="status" value="ditolak" class="text-red-600 w-4 h-4"
                                                x-model="action">
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm">❌ Tolak</p>
                                                <p class="text-xs text-gray-500">Pengajuan tidak akan diproses lebih lanjut</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                {{-- Catatan Admin --}}
                                <div>
                                    <label for="catatan_admin" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Catatan Admin <span class="text-gray-400 font-normal">(opsional)</span>
                                    </label>
                                    <textarea id="catatan_admin" name="catatan_admin" rows="4"
                                        placeholder="Tambahkan alasan atau catatan untuk keputusan ini..."
                                        class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm text-gray-800 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20 transition-all resize-none">{{ old('catatan_admin') }}</textarea>
                                </div>
                            </div>

                            <div class="flex items-center justify-between border-t border-gray-100 px-6 py-4">
                                <a href="{{ route('admin.pengajuan-buku.index') }}"
                                    class="text-sm font-medium text-gray-500 hover:text-gray-800 transition-colors">
                                    ← Kembali
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl bg-[#004236] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[#00362b] transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Keputusan
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    {{-- Status sudah diproses --}}
                    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm px-6 py-8 text-center sticky top-6">
                        @php
                            $iconColor = $pengajuan->status === 'disetujui' ? 'text-green-500 bg-green-50' : 'text-red-500 bg-red-50';
                        @endphp
                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full {{ $iconColor }}">
                            @if($pengajuan->status === 'disetujui')
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-gray-700">Pengajuan sudah diproses</p>
                        <p class="text-xs text-gray-400 mt-1 mb-5">Status: {{ $pengajuan->label_status }}</p>
                        <a href="{{ route('admin.pengajuan-buku.index') }}"
                            class="inline-flex items-center gap-2 text-sm font-medium text-[#004236] hover:underline transition-colors">
                            ← Kembali ke Daftar
                        </a>
                    </div>
                @endif
            </div>
            {{-- Akhir Kolom Kanan --}}

        </div>
        {{-- Akhir Grid --}}
    </div>
@endsection