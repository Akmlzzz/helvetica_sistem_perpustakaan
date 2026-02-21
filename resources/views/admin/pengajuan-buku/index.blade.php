@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Pengajuan Buku</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar buku yang diusulkan oleh anggota perpustakaan</p>
            </div>
            <div class="flex items-center gap-3">
                @php $menunggu = $pengajuan->where('status', 'menunggu')->count(); @endphp
                @if($menunggu > 0)
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1.5 text-sm font-semibold text-amber-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $menunggu }} Menunggu Review
                    </span>
                @endif
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="rounded-2xl border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm sm:px-7.5 xl:pb-1">
            <form method="GET" action="{{ route('admin.pengajuan-buku.index') }}"
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center">

                {{-- Search --}}
                <div class="relative flex-1">
                    <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari judul buku, penulis, atau nama pengusul..."
                        class="w-full rounded-xl border border-gray-200 bg-white pl-12 pr-4 py-2.5 text-sm font-medium outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20 transition-all" />
                </div>

                {{-- Filter Status --}}
                <div class="relative w-full sm:w-48">
                    <select name="status" onchange="this.form.submit()"
                        class="w-full appearance-none rounded-xl border border-gray-200 bg-white px-4 py-2.5 pr-10 text-sm font-medium outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20 transition-all">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>✅ Disetujui
                        </option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                    </select>
                    <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none">
                            <path
                                d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z"
                                fill="currentColor" />
                        </svg>
                    </div>
                </div>
            </form>

            {{-- Table --}}
            <div class="flex flex-col overflow-x-auto">
                <div class="min-w-[900px]">
                    {{-- Table Header --}}
                    <div class="grid grid-cols-7 rounded-xl bg-gray-50 px-4 py-3">
                        <div class="col-span-2">
                            <h5 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Judul Buku</h5>
                        </div>
                        <div>
                            <h5 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Penulis</h5>
                        </div>
                        <div>
                            <h5 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Pengusul</h5>
                        </div>
                        <div class="text-center">
                            <h5 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Kategori</h5>
                        </div>
                        <div class="text-center">
                            <h5 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Status</h5>
                        </div>
                        <div class="text-center">
                            <h5 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</h5>
                        </div>
                    </div>

                    {{-- Table Body --}}
                    @forelse($pengajuan as $item)
                        <div class="grid grid-cols-7 border-b border-gray-100 px-4 py-4 hover:bg-gray-50 transition-colors items-center
                                @if($item->status === 'menunggu' && !$item->sudah_dibaca) bg-amber-50/60 @endif">

                            {{-- Judul Buku --}}
                            <div class="col-span-2 pr-4">
                                <p class="font-semibold text-gray-900 text-sm leading-tight">{{ $item->judul_buku }}</p>
                                @if($item->isbn)
                                    <p class="text-xs text-gray-400 mt-0.5">ISBN: {{ $item->isbn }}</p>
                                @endif
                                @if($item->tahun_terbit)
                                    <p class="text-xs text-gray-400">{{ $item->tahun_terbit }} · {{ $item->penerbit ?? '-' }}</p>
                                @endif
                            </div>

                            {{-- Penulis --}}
                            <div class="pr-3">
                                <p class="text-sm text-gray-700">{{ $item->nama_penulis }}</p>
                            </div>

                            {{-- Pengusul --}}
                            <div class="pr-3">
                                <p class="text-sm font-medium text-gray-800">{{ $item->nama_pengusul }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ $item->dibuat_pada ? $item->dibuat_pada->format('d M Y') : '-' }}</p>
                            </div>

                            {{-- Kategori --}}
                            <div class="text-center">
                                @if($item->kategori)
                                    <span class="inline-block rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                        {{ $item->kategori }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </div>

                            {{-- Status --}}
                            <div class="text-center">
                                @php
                                    $statusConfig = [
                                        'menunggu' => 'bg-amber-100 text-amber-700',
                                        'disetujui' => 'bg-green-100 text-green-700',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusClass = $statusConfig[$item->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                    @if($item->status === 'menunggu') ⏳
                                    @elseif($item->status === 'disetujui') ✅
                                    @else ❌
                                    @endif
                                    {{ $item->label_status }}
                                </span>
                            </div>

                            {{-- Aksi --}}
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.pengajuan-buku.show', $item->id_pengajuan) }}"
                                    class="inline-flex items-center gap-1 rounded-lg border border-[#004236] px-3 py-1.5 text-xs font-semibold text-[#004236] hover:bg-[#004236] hover:text-white transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>

                                <form method="POST" action="{{ route('admin.pengajuan-buku.destroy', $item->id_pengajuan) }}"
                                    onsubmit="return confirm('Hapus pengajuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 rounded-lg border border-red-300 px-3 py-1.5 text-xs font-semibold text-red-500 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-base font-semibold text-gray-600">Belum ada pengajuan buku</p>
                            <p class="text-sm text-gray-400 mt-1">Pengajuan dari anggota akan muncul di sini</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-4 px-4 pb-4">
                {{ $pengajuan->links() }}
            </div>
        </div>
    </div>
@endsection