@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#004236]">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">Pengajuan Saya</h1>
                </div>
                <p class="text-sm text-gray-500 ml-13">Daftar buku yang pernah kamu usulkan ke perpustakaan</p>
            </div>
            <a href="{{ route('pengajuan-buku.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-[#004236] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#00362b] transition-all shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Usulkan Buku Baru
            </a>
        </div>

        {{-- ===== STATISTIK CARDS ===== --}}
        @php
            $totalPengajuan = $pengajuan->total();
            $menunggu = $pengajuan->getCollection()->where('status', 'menunggu')->count();
            $disetujui = $pengajuan->getCollection()->where('status', 'disetujui')->count();
            $ditolak = $pengajuan->getCollection()->where('status', 'ditolak')->count();
            // For accurate stats, query from DB for current user
            $stats = \App\Models\PengajuanBuku::where('id_pengguna', auth()->id())
                ->selectRaw("
                                            COUNT(*) as total,
                                            SUM(CASE WHEN status='menunggu' THEN 1 ELSE 0 END) as menunggu,
                                            SUM(CASE WHEN status='disetujui' THEN 1 ELSE 0 END) as disetujui,
                                            SUM(CASE WHEN status='ditolak' THEN 1 ELSE 0 END) as ditolak
                                        ")->first();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            {{-- Total --}}
            <div class="rounded-2xl bg-white border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gray-100">
                    <svg class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats->total ?? 0 }}</p>
                </div>
            </div>

            {{-- Menunggu --}}
            <div class="rounded-2xl bg-amber-50 border border-amber-100 shadow-sm p-5 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-100">
                    <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-amber-600 uppercase tracking-wide">Menunggu</p>
                    <p class="text-2xl font-bold text-amber-700">{{ $stats->menunggu ?? 0 }}</p>
                </div>
            </div>

            {{-- Disetujui --}}
            <div class="rounded-2xl bg-green-50 border border-green-100 shadow-sm p-5 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-green-100">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-green-600 uppercase tracking-wide">Disetujui</p>
                    <p class="text-2xl font-bold text-green-700">{{ $stats->disetujui ?? 0 }}</p>
                </div>
            </div>

            {{-- Ditolak --}}
            <div class="rounded-2xl bg-red-50 border border-red-100 shadow-sm p-5 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-100">
                    <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-red-500 uppercase tracking-wide">Ditolak</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats->ditolak ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- ===== TABEL PENGAJUAN ===== --}}
        <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">

            {{-- Filter Bar --}}
            <div
                class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 p-5 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Daftar Pengajuan</h3>
                <div class="flex items-center gap-2">
                    <form method="GET" action="{{ route('anggota.pengajuan-buku.index') }}" class="flex gap-2">
                        <div class="relative">
                            <select name="status" onchange="this.form.submit()"
                                class="appearance-none rounded-xl border border-gray-200 bg-white pl-4 pr-9 py-2 text-sm font-medium text-gray-700 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20 transition-all cursor-pointer">
                                <option value="">Semua Status</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu
                                </option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>✅ Disetujui
                                </option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak
                                </option>
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
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px]">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500 w-2/5">Judul
                                Buku</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Kategori</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal Usul
                            </th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500 text-center">
                                Status</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500 text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pengajuan as $item)
                            @php
                                $statusConfig = [
                                    'menunggu' => ['bg' => 'bg-amber-100 text-amber-700', 'dot' => 'bg-amber-400', 'emoji' => '⏳', 'label' => 'Menunggu'],
                                    'disetujui' => ['bg' => 'bg-green-100 text-green-700', 'dot' => 'bg-green-500', 'emoji' => '✅', 'label' => 'Disetujui'],
                                    'ditolak' => ['bg' => 'bg-red-100 text-red-600', 'dot' => 'bg-red-500', 'emoji' => '❌', 'label' => 'Ditolak'],
                                ];
                                $cfg = $statusConfig[$item->status] ?? ['bg' => 'bg-gray-100 text-gray-600', 'dot' => 'bg-gray-400', 'emoji' => '?', 'label' => $item->status];
                            @endphp
                            <tr
                                class="hover:bg-gray-50/80 transition-colors duration-150 group {{ $item->status !== 'menunggu' ? '' : '' }}">
                                {{-- Judul --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        {{-- Icon buku kecil --}}
                                        <div
                                            class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                                                            {{ $item->status === 'disetujui' ? 'bg-green-100' : ($item->status === 'ditolak' ? 'bg-red-100' : 'bg-amber-100') }}">
                                            <svg class="w-4 h-4 {{ $item->status === 'disetujui' ? 'text-green-600' : ($item->status === 'ditolak' ? 'text-red-500' : 'text-amber-600') }}"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p
                                                class="font-semibold text-gray-900 text-sm leading-snug group-hover:text-[#004236] transition-colors">
                                                {{ $item->judul_buku }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $item->nama_penulis }}</p>
                                            @if($item->penerbit)
                                                <p class="text-xs text-gray-400">{{ $item->penerbit }}
                                                    @if($item->tahun_terbit) · {{ $item->tahun_terbit }} @endif
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Kategori --}}
                                <td class="px-4 py-4">
                                    @if($item->kategori)
                                        <span
                                            class="inline-block rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                            {{ $item->kategori }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-xs">—</span>
                                    @endif
                                </td>

                                {{-- Tanggal --}}
                                <td class="px-4 py-4">
                                    <p class="text-sm text-gray-600">
                                        {{ $item->dibuat_pada ? $item->dibuat_pada->format('d M Y') : '-' }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ $item->dibuat_pada ? $item->dibuat_pada->diffForHumans() : '' }}
                                    </p>
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $cfg['bg'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $cfg['dot'] }}"></span>
                                        {{ $cfg['label'] }}
                                    </span>
                                    @if($item->catatan_admin && $item->status !== 'menunggu')
                                        <p class="mt-1 text-xs text-gray-400 max-w-[120px] mx-auto truncate"
                                            title="{{ $item->catatan_admin }}">
                                            💬 ada catatan
                                        </p>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="px-4 py-4 text-center">
                                    <a href="{{ route('anggota.pengajuan-buku.show', $item->id_pengajuan) }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-[#004236]/30 px-3.5 py-1.5 text-xs font-semibold text-[#004236] hover:bg-[#004236] hover:text-white hover:border-[#004236] transition-all duration-150">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center">
                                    <div
                                        class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                                        <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-base font-semibold text-gray-500">Belum ada pengajuan</p>
                                    <p class="text-sm text-gray-400 mt-1 mb-5">Kamu belum pernah mengusulkan buku ke
                                        perpustakaan.</p>
                                    <a href="{{ route('pengajuan-buku.create') }}"
                                        class="inline-flex items-center gap-2 rounded-xl bg-[#004236] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#00362b] transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Usulkan Buku Sekarang
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($pengajuan->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $pengajuan->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection