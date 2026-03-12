@extends('layouts.app')

@section('content')
<div class="mx-auto space-y-6" x-data>

    {{-- ================================================== --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================== --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard</h1>
            <p class="mt-0.5 text-sm text-gray-400">Selamat datang kembali, <span class="font-semibold text-[#004236]">{{ auth()->user()->nama_pengguna }}</span> 👋</p>
        </div>
        <span class="hidden sm:inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-500 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
            <svg class="h-3.5 w-3.5 text-[#004236]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

    {{-- ================================================== --}}
    {{-- ROW 1: STAT CARDS --}}
    {{-- ================================================== --}}
    <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">

        {{-- Card: Total Buku --}}
        <div class="group relative overflow-hidden rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-800 dark:ring-gray-700">
            <div class="absolute right-0 top-0 h-20 w-20 translate-x-4 -translate-y-4 rounded-full bg-emerald-50 transition-transform group-hover:scale-125 dark:bg-emerald-900/20"></div>
            <div class="relative">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-900/40">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Buku</p>
                <p class="mt-1 text-3xl font-black text-gray-800 dark:text-white">{{ number_format($totalBuku) }}</p>
                <div class="mt-2 flex items-center gap-1">
                    @if($bukuTrend >= 0)
                        <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        <span class="text-xs font-bold text-emerald-500">+{{ $bukuTrend }}%</span>
                    @else
                        <svg class="h-3.5 w-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        <span class="text-xs font-bold text-red-400">{{ $bukuTrend }}%</span>
                    @endif
                    <span class="text-xs text-gray-400">vs minggu lalu</span>
                </div>
            </div>
        </div>

        {{-- Card: Total Anggota --}}
        <div class="group relative overflow-hidden rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-800 dark:ring-gray-700">
            <div class="absolute right-0 top-0 h-20 w-20 translate-x-4 -translate-y-4 rounded-full bg-blue-50 transition-transform group-hover:scale-125 dark:bg-blue-900/20"></div>
            <div class="relative">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/40">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Anggota</p>
                <p class="mt-1 text-3xl font-black text-gray-800 dark:text-white">{{ number_format($totalAnggota) }}</p>
                <div class="mt-2 flex items-center gap-1">
                    @if($anggotaTrend >= 0)
                        <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        <span class="text-xs font-bold text-emerald-500">+{{ $anggotaTrend }}%</span>
                    @else
                        <svg class="h-3.5 w-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        <span class="text-xs font-bold text-red-400">{{ $anggotaTrend }}%</span>
                    @endif
                    <span class="text-xs text-gray-400">vs minggu lalu</span>
                </div>
            </div>
        </div>

        {{-- Card: Peminjaman Aktif --}}
        <div class="group relative overflow-hidden rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-800 dark:ring-gray-700">
            <div class="absolute right-0 top-0 h-20 w-20 translate-x-4 -translate-y-4 rounded-full bg-violet-50 transition-transform group-hover:scale-125 dark:bg-violet-900/20"></div>
            <div class="relative">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 dark:bg-violet-900/40">
                    <svg class="h-5 w-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Peminjaman Aktif</p>
                <p class="mt-1 text-3xl font-black text-gray-800 dark:text-white">{{ number_format($totalPeminjaman) }}</p>
                <div class="mt-2 flex items-center gap-1">
                    @if($peminjamanTrend >= 0)
                        <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        <span class="text-xs font-bold text-emerald-500">+{{ $peminjamanTrend }}%</span>
                    @else
                        <svg class="h-3.5 w-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        <span class="text-xs font-bold text-red-400">{{ $peminjamanTrend }}%</span>
                    @endif
                    <span class="text-xs text-gray-400">vs minggu lalu</span>
                </div>
            </div>
        </div>

        {{-- Card: Buku Terlambat --}}
        <div class="group relative overflow-hidden rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-800 dark:ring-gray-700">
            <div class="absolute right-0 top-0 h-20 w-20 translate-x-4 -translate-y-4 rounded-full bg-rose-50 transition-transform group-hover:scale-125 dark:bg-rose-900/20"></div>
            <div class="relative">
                <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-rose-100 dark:bg-rose-900/40">
                    <svg class="h-5 w-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Buku Terlambat</p>
                <p class="mt-1 text-3xl font-black text-gray-800 dark:text-white">{{ number_format($totalTerlambat) }}</p>
                <div class="mt-2 flex items-center gap-1">
                    @if($terlambatTrend <= 0)
                        <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        <span class="text-xs font-bold text-emerald-500">{{ $terlambatTrend }}%</span>
                    @else
                        <svg class="h-3.5 w-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        <span class="text-xs font-bold text-red-400">+{{ $terlambatTrend }}%</span>
                    @endif
                    <span class="text-xs text-gray-400">vs minggu lalu</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ================================================== --}}
    {{-- ROW 2: CHARTS --}}
    {{-- ================================================== --}}
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-5">

        {{-- LEFT: Donut Chart - Kategori Buku --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700 lg:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-white">Kategori Buku</h3>
                    <p class="text-xs text-gray-400">Distribusi koleksi perpustakaan</p>
                </div>
            </div>

            @php
                $totalKategoriBuku = $kategoriData->sum('buku_count');
                $donutColors = ['#004236','#00644f','#34d399','#6366f1','#f59e0b','#f43f5e'];
                $lightColors = ['bg-emerald-700','bg-emerald-600','bg-emerald-400','bg-indigo-500','bg-amber-500','bg-rose-500'];
                $cumulativePct = 0;
                $gradientParts = [];
                foreach($kategoriData as $i => $kat) {
                    $pct = $totalKategoriBuku > 0 ? ($kat->buku_count / $totalKategoriBuku) * 100 : 0;
                    $gradientParts[] = $donutColors[$i % count($donutColors)] . ' ' . $cumulativePct . '% ' . ($cumulativePct + $pct) . '%';
                    $cumulativePct += $pct;
                }
                $conicGradient = 'conic-gradient(' . implode(', ', $gradientParts) . ')';
            @endphp

            {{-- Donut --}}
            <div class="flex flex-col items-center">
                <div class="relative my-4 flex h-44 w-44 items-center justify-center">
                    <div class="absolute inset-0 rounded-full" style="background: {{ $conicGradient }}; border-radius:50%;"></div>
                    <div class="absolute inset-[28px] rounded-full bg-white dark:bg-gray-800"></div>
                    <div class="relative z-10 text-center">
                        <p class="text-2xl font-black text-gray-800 dark:text-white">{{ $totalKategoriBuku }}</p>
                        <p class="text-xs text-gray-400">Total Buku</p>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="mt-2 w-full space-y-2">
                    @foreach($kategoriData as $i => $kat)
                        @php $pct = $totalKategoriBuku > 0 ? round(($kat->buku_count / $totalKategoriBuku) * 100) : 0; @endphp
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full" style="background-color: {{ $donutColors[$i % count($donutColors)] }}"></span>
                                <span class="text-xs text-gray-600 dark:text-gray-300 truncate max-w-[120px]">{{ $kat->nama_kategori }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-gray-700 dark:text-white">{{ $kat->buku_count }}</span>
                                <span class="w-8 text-right text-xs text-gray-400">{{ $pct }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT: Bar Chart - Peminjaman Mingguan --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700 lg:col-span-3">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-white">Statistik Peminjaman</h3>
                    <p class="text-xs text-gray-400">7 hari terakhir</p>
                </div>
                <div class="flex items-center gap-1.5 rounded-lg border border-gray-200 px-3 py-1.5 dark:border-gray-600">
                    <span class="h-2 w-2 rounded-full bg-[#004236]"></span>
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Peminjaman</span>
                </div>
            </div>

            @php
                $maxCount = $weeklyData->max('count') ?: 1;
            @endphp

            <div class="flex h-48 items-end gap-2">
                @foreach($weeklyData as $i => $day)
                    @php
                        $heightPct = $maxCount > 0 ? max(4, ($day['count'] / $maxCount) * 100) : 4;
                        $isToday = ($i === count($weeklyData) - 1);
                    @endphp
                    <div class="group flex flex-1 flex-col items-center gap-1"
                        x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false">
                        {{-- Tooltip --}}
                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="mb-1 whitespace-nowrap rounded-lg bg-gray-800 px-2 py-1 text-xs font-bold text-white dark:bg-gray-600"
                            style="display:none;">
                            {{ $day['count'] }} pinjam
                        </div>
                        {{-- Bar --}}
                        <div class="w-full rounded-t-xl transition-all duration-500 ease-out"
                            style="height: {{ $heightPct }}%; background-color: {{ $isToday ? '#004236' : '#a7f3d0' }};">
                        </div>
                        {{-- Label --}}
                        <span class="text-[10px] font-semibold {{ $isToday ? 'text-[#004236]' : 'text-gray-400' }} dark:text-gray-400">
                            {{ $day['label'] }}
                        </span>
                    </div>
                @endforeach
            </div>

            {{-- Y-axis hints --}}
            <div class="mt-2 flex items-center justify-between border-t border-gray-100 pt-2 dark:border-gray-700">
                <span class="text-xs text-gray-400">{{ now()->subDays(6)->format('d M') }}</span>
                <span class="text-xs font-medium text-[#004236]">Maks: {{ $maxCount }}</span>
                <span class="text-xs text-gray-400">{{ now()->format('d M') }}</span>
            </div>
        </div>

    </div>

    {{-- ================================================== --}}
    {{-- ROW 3: RECENT PEMINJAMAN --}}
    {{-- ================================================== --}}
    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4 dark:border-gray-700">
            <div>
                <h3 class="font-bold text-gray-800 dark:text-white">Peminjaman Terbaru</h3>
                <p class="text-xs text-gray-400">Transaksi peminjaman yang baru masuk</p>
            </div>
            <a href="{{ route('admin.peminjaman.index') }}"
                class="inline-flex items-center gap-1 text-xs font-semibold text-[#004236] hover:underline">
                Lihat semua
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- List --}}
        <div class="divide-y divide-gray-50 dark:divide-gray-700">
            @forelse($latestPeminjaman as $p)
                @php
                    $nama = $p->pengguna?->anggota?->nama_lengkap ?? $p->pengguna?->nama_pengguna ?? 'Unknown';
                    $initial = strtoupper(substr($nama, 0, 1));
                    $statusConfig = match($p->status_transaksi) {
                        'dipinjam'    => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'dot' => 'bg-blue-500',   'label' => 'Dipinjam'],
                        'booking'     => ['bg' => 'bg-amber-100',  'text' => 'text-amber-700',  'dot' => 'bg-amber-500',  'label' => 'Booking'],
                        'dikembalikan'=> ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'dot' => 'bg-green-500',  'label' => 'Dikembalikan'],
                        'terlambat'   => ['bg' => 'bg-rose-100',   'text' => 'text-rose-700',   'dot' => 'bg-rose-500',   'label' => 'Terlambat'],
                        default       => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600',   'dot' => 'bg-gray-400',   'label' => ucfirst($p->status_transaksi)],
                    };
                    $avatarColors = ['bg-emerald-500','bg-blue-500','bg-violet-500','bg-rose-500','bg-amber-500','bg-teal-500'];
                    $avatarColor = $avatarColors[crc32($nama) % count($avatarColors)];
                @endphp
                <div class="flex items-center gap-4 px-6 py-3.5 transition hover:bg-gray-50/70 dark:hover:bg-gray-700/30">

                    {{-- Avatar --}}
                    @if($p->pengguna?->foto_profil)
                        <img src="{{ Storage::url($p->pengguna->foto_profil) }}" alt="{{ $nama }}"
                            class="h-9 w-9 shrink-0 rounded-full object-cover">
                    @else
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $avatarColor }} text-sm font-bold text-white">
                            {{ $initial }}
                        </div>
                    @endif

                    {{-- Info --}}
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-gray-800 dark:text-white">{{ $nama }}</p>
                        <p class="truncate text-xs text-gray-400">{{ $p->buku?->judul_buku ?? '-' }}</p>
                    </div>

                    {{-- Date --}}
                    <div class="hidden text-right sm:block">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $p->tgl_pinjam?->format('d M Y') ?? '-' }}</p>
                        <p class="text-xs text-gray-300 dark:text-gray-600">{{ $p->kode_booking }}</p>
                    </div>

                    {{-- Status Badge --}}
                    <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full {{ $statusConfig['bg'] }} px-3 py-1 text-xs font-bold {{ $statusConfig['text'] }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}
                            {{ in_array($p->status_transaksi, ['booking','terlambat']) ? 'animate-pulse' : '' }}">
                        </span>
                        {{ $statusConfig['label'] }}
                    </span>

                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                        <svg class="h-7 w-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-400">Belum ada data peminjaman</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection