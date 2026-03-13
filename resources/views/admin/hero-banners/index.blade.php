@extends('layouts.app')

@section('content')
    <div class="mx-auto">
        {{-- ===== PAGE HEADER ===== --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Banner Hero</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola tampilan carousel pada halaman anggota</p>
            </div>
            <a href="{{ route('admin.hero-banners.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-[#004236] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#003028] hover:shadow-md">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Banner
            </a>
        </div>

        {{-- ===== BANNER CARDS ===== --}}
        @forelse($banners as $banner)
            <div class="mb-4 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md">
                <div class="flex flex-col md:flex-row">
                    {{-- Preview --}}
                    <div class="relative h-40 w-full shrink-0 overflow-hidden md:h-auto md:w-64">
                        <img src="{{ Storage::url($banner->bg_img) }}" alt="Background"
                            class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-linear-to-r from-black/40 to-transparent"></div>
                        {{-- Order Badge --}}
                        <div class="absolute left-3 top-3 flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-sm font-bold text-gray-800 shadow">
                            {{ $banner->order_priority }}
                        </div>
                        {{-- Status Badge --}}
                        <div class="absolute right-3 top-3">
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-bold {{ $banner->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $banner->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        @if($banner->char_img)
                            <img src="{{ Storage::url($banner->char_img) }}" alt="Char"
                                class="absolute bottom-0 right-4 h-32 w-auto object-contain opacity-90">
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex flex-1 flex-col justify-between p-5">
                        <div>
                            {{-- Title img + synopsis --}}
                            <div class="mb-3 flex items-start gap-4">
                                @if($banner->title_img)
                                    <img src="{{ Storage::url($banner->title_img) }}" alt="Title" class="h-10 w-auto shrink-0 object-contain">
                                @endif
                                <div class="min-w-0">
                                    @if($banner->series)
                                        <div class="mb-1 inline-flex items-center gap-1 rounded-full bg-[#004236]/10 px-2 py-0.5 text-xs font-semibold text-[#004236]">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                            Series: {{ $banner->series->nama_series }}
                                        </div>
                                    @endif
                                    @if($banner->synopsis)
                                        <p class="line-clamp-2 text-sm text-gray-600">{{ $banner->synopsis }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Tags --}}
                            @if($banner->tags)
                                @php $tagsArr = is_array($banner->tags) ? $banner->tags : (json_decode($banner->tags, true) ?? []); @endphp
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($tagsArr as $tag)
                                        <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="mt-4 flex items-center justify-between gap-3">
                            <div class="text-xs text-gray-400">
                                @if($banner->target_link)
                                    <span class="truncate font-mono">{{ Str::limit($banner->target_link, 40) }}</span>
                                @else
                                    <span class="italic">Tidak ada target link</span>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.hero-banners.edit', $banner->id) }}"
                                    class="inline-flex items-center gap-1.5 rounded-xl border border-[#004236] bg-white px-4 py-2 text-xs font-bold text-[#004236] transition hover:bg-[#004236] hover:text-white">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.hero-banners.destroy', $banner->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus banner ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-red-300 bg-white px-4 py-2 text-xs font-bold text-red-500 transition hover:bg-red-500 hover:text-white">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-gray-200 bg-white py-20 text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                    <svg class="h-8 w-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-400">Belum ada banner yang ditambahkan</p>
                <p class="mt-1 text-xs text-gray-300">Klik tombol "Tambah Banner" untuk mulai membuat carousel</p>
            </div>
        @endforelse
    </div>
@endsection