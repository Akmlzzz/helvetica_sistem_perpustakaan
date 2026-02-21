@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-xl p-4 md:p-6 2xl:p-10">

        {{-- ===== BREADCRUMB ===== --}}
        <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('anggota.pengajuan-buku.index') }}"
                class="hover:text-[#004236] transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
                </svg>
                Pengajuan Saya
            </a>
            <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-700 font-medium truncate max-w-[200px]">{{ $pengajuan->judul_buku }}</span>
        </nav>

        {{-- ===== STATUS HERO BANNER ===== --}}
        @php
            $isMenunggu = $pengajuan->status === 'menunggu';
            $isDisetujui = $pengajuan->status === 'disetujui';
            $isDitolak = $pengajuan->status === 'ditolak';

            $heroBg = $isMenunggu
                ? 'from-amber-500 to-orange-400'
                : ($isDisetujui ? 'from-[#004236] to-[#00835f]' : 'from-red-500 to-rose-600');

            $heroIcon = $isMenunggu ? '⏳' : ($isDisetujui ? '✅' : '❌');
            $heroTitle = $isMenunggu
                ? 'Sedang Diproses'
                : ($isDisetujui ? 'Pengajuan Disetujui!' : 'Pengajuan Ditolak');
            $heroDesc = $isMenunggu
                ? 'Pengajuan kamu sedang ditinjau oleh admin. Kami akan memberitahu kamu via notifikasi.'
                : ($isDisetujui
                    ? 'Selamat! Admin telah menyetujui usulan bukumu. Terima kasih atas kontribusimu!'
                    : 'Mohon maaf, pengajuan ini tidak dapat diproses. Silakan baca catatan admin di bawah.');
        @endphp

        <div class="mb-7 overflow-hidden rounded-2xl bg-linear-to-r {{ $heroBg }} shadow-lg">
            <div class="flex flex-col sm:flex-row items-center gap-5 px-7 py-6">
                {{-- Emoji icon besar --}}
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white/20 text-4xl">
                    {{ $heroIcon }}
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-xs font-semibold uppercase tracking-widest text-white/70 mb-1">Status Pengajuan</p>
                    <h2 class="text-2xl font-bold text-white leading-tight">{{ $heroTitle }}</h2>
                    <p class="text-sm text-white/80 mt-1.5 max-w-xl">{{ $heroDesc }}</p>
                </div>
                <div class="sm:ml-auto text-center shrink-0">
                    <p class="text-xs text-white/60 mb-1">Diajukan pada</p>
                    <p class="text-sm font-semibold text-white">
                        {{ $pengajuan->dibuat_pada ? $pengajuan->dibuat_pada->format('d F Y') : '—' }}
                    </p>
                    <p class="text-xs text-white/60">
                        {{ $pengajuan->dibuat_pada ? $pengajuan->dibuat_pada->diffForHumans() : '' }}
                    </p>
                </div>
            </div>
            {{-- Subtle wave underline --}}
            <div class="h-1.5 bg-white/10"></div>
        </div>

        {{-- ===== CATATAN ADMIN (jika ada & sudah diproses) ===== --}}
        @if(!$isMenunggu && $pengajuan->catatan_admin)
            <div class="mb-7 flex gap-4 rounded-2xl border
                        {{ $isDisetujui ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}
                        px-6 py-5">
                <div class="shrink-0 flex h-10 w-10 items-center justify-center rounded-xl
                            {{ $isDisetujui ? 'bg-green-100' : 'bg-red-100' }}">
                    <svg class="w-5 h-5 {{ $isDisetujui ? 'text-green-600' : 'text-red-500' }}" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold {{ $isDisetujui ? 'text-green-800' : 'text-red-700' }} mb-1">
                        Catatan dari Admin
                    </h4>
                    <p class="text-sm {{ $isDisetujui ? 'text-green-700' : 'text-red-600' }} leading-relaxed">
                        {{ $pengajuan->catatan_admin }}
                    </p>
                </div>
            </div>
        @endif

        {{-- ===== MAIN CONTENT GRID ===== --}}
        <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

            {{-- ===== KIRI: INFO DETAIL BUKU ===== --}}
            <div class="xl:col-span-3 flex flex-col gap-6">

                {{-- Kartu Informasi Buku --}}
                <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                    {{-- Card Header --}}
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#004236]">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800">Informasi Buku yang Diusulkan</h3>
                    </div>

                    {{-- Info Rows --}}
                    <dl class="divide-y divide-gray-50">
                        @php
                            $fields = [
                                ['label' => 'Judul Buku', 'value' => $pengajuan->judul_buku, 'bold' => true],
                                ['label' => 'Nama Penulis', 'value' => $pengajuan->nama_penulis, 'bold' => false],
                                ['label' => 'ISBN', 'value' => $pengajuan->isbn ?? '—', 'bold' => false],
                                ['label' => 'Penerbit', 'value' => $pengajuan->penerbit ?? '—', 'bold' => false],
                                ['label' => 'Tahun Terbit', 'value' => $pengajuan->tahun_terbit ?? '—', 'bold' => false],
                            ];
                        @endphp

                        @foreach($fields as $field)
                            <div class="grid grid-cols-5 px-6 py-4 hover:bg-gray-50/60 transition-colors">
                                <dt class="col-span-2 text-sm font-medium text-gray-500">{{ $field['label'] }}</dt>
                                <dd
                                    class="col-span-3 text-sm {{ $field['bold'] ? 'font-semibold text-gray-900' : 'text-gray-700' }}">
                                    {{ $field['value'] }}
                                </dd>
                            </div>
                        @endforeach

                        {{-- Kategori (khusus dengan badge) --}}
                        <div class="grid grid-cols-5 px-6 py-4 hover:bg-gray-50/60 transition-colors">
                            <dt class="col-span-2 text-sm font-medium text-gray-500">Kategori</dt>
                            <dd class="col-span-3">
                                @if($pengajuan->kategori)
                                    <span
                                        class="inline-block rounded-lg bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                        {{ $pengajuan->kategori }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">—</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Kartu Alasan Pengusulan --}}
                <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800">Alasan Pengusulan</h3>
                    </div>
                    <div class="px-6 py-5">
                        <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-xl p-4 border border-gray-100">
                            {{ $pengajuan->alasan_pengusulan }}
                        </p>
                    </div>
                </div>

            </div>
            {{-- ===== END KIRI ===== --}}

            {{-- ===== KANAN: RINGKASAN STATUS ===== --}}
            <div class="xl:col-span-2 flex flex-col gap-5">

                {{-- Status Card --}}
                <div class="rounded-2xl border bg-white shadow-sm overflow-hidden sticky top-6
                        {{ $isMenunggu ? 'border-amber-200' : ($isDisetujui ? 'border-green-200' : 'border-red-200') }}">

                    {{-- Header --}}
                    <div
                        class="px-6 py-4 border-b
                            {{ $isMenunggu ? 'bg-amber-50 border-amber-100' : ($isDisetujui ? 'bg-green-50 border-green-100' : 'bg-red-50 border-red-100') }}">
                        <h3
                            class="font-semibold {{ $isMenunggu ? 'text-amber-800' : ($isDisetujui ? 'text-green-800' : 'text-red-800') }}">
                            Status Pengajuan
                        </h3>
                    </div>

                    <div class="px-6 py-6 text-center">
                        {{-- Big Status Icon --}}
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full
                                {{ $isMenunggu ? 'bg-amber-100' : ($isDisetujui ? 'bg-green-100' : 'bg-red-100') }}">
                            @if($isMenunggu)
                                <svg class="w-10 h-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @elseif($isDisetujui)
                                <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg class="w-10 h-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>

                        <p class="text-xl font-bold
                                {{ $isMenunggu ? 'text-amber-700' : ($isDisetujui ? 'text-green-700' : 'text-red-600') }}">
                            {{ $heroTitle }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            Diajukan: {{ $pengajuan->dibuat_pada ? $pengajuan->dibuat_pada->format('d M Y, H:i') : '—' }}
                        </p>
                    </div>

                    {{-- Timeline --}}
                    <div class="px-6 pb-6">
                        <div class="space-y-3">
                            {{-- Step 1: Diajukan --}}
                            <div class="flex items-start gap-3">
                                <div
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#004236] mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">Pengajuan Dikirim</p>
                                    <p class="text-xs text-gray-400">
                                        {{ $pengajuan->dibuat_pada ? $pengajuan->dibuat_pada->format('d M Y') : '—' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Connector --}}
                            <div class="ml-3.5 h-5 w-px border-l-2 border-dashed
                                    {{ $isMenunggu ? 'border-gray-200' : 'border-[#004236]/40' }}"></div>

                            {{-- Step 2: Review --}}
                            <div class="flex items-start gap-3">
                                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full mt-0.5
                                        {{ $isMenunggu ? 'bg-amber-100 animate-pulse' : 'bg-[#004236]' }}">
                                    @if($isMenunggu)
                                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $isMenunggu ? 'Sedang Ditinjau Admin' : 'Ditinjau oleh Admin' }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ $isMenunggu ? 'Proses sedang berjalan...' : ($pengajuan->updated_at ? $pengajuan->updated_at->format('d M Y') : '—') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Connector --}}
                            <div
                                class="ml-3.5 h-5 w-px border-l-2 border-dashed
                                    {{ $isMenunggu ? 'border-gray-200' : ($isDisetujui ? 'border-green-300' : 'border-red-300') }}">
                            </div>

                            {{-- Step 3: Hasil --}}
                            <div class="flex items-start gap-3">
                                <div
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full mt-0.5
                                        {{ $isMenunggu ? 'bg-gray-100' : ($isDisetujui ? 'bg-green-500' : 'bg-red-500') }}">
                                    @if($isMenunggu)
                                        <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                    @elseif($isDisetujui)
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-semibold
                                            {{ $isMenunggu ? 'text-gray-400' : ($isDisetujui ? 'text-green-700' : 'text-red-600') }}">
                                        {{ $isMenunggu ? 'Menunggu Keputusan' : ($isDisetujui ? 'Disetujui ✓' : 'Ditolak ✗') }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ $isMenunggu ? 'Belum diproses' : 'Keputusan sudah ditetapkan' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Action --}}
                    <div class="border-t border-gray-100 px-6 py-4 flex flex-col gap-2">
                        <a href="{{ route('anggota.pengajuan-buku.index') }}"
                            class="flex items-center justify-center gap-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Daftar
                        </a>
                        @if($isDitolak)
                            <a href="{{ route('pengajuan-buku.create') }}"
                                class="flex items-center justify-center gap-2 w-full rounded-xl bg-[#004236] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#00362b] transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Ajukan Buku Lain
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Tips Card (hanya saat menunggu) --}}
                @if($isMenunggu)
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4">
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-100">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-blue-800 mb-1">Informasi</h4>
                                <p class="text-xs text-blue-700 leading-relaxed">
                                    Kamu akan mendapatkan notifikasi otomatis saat admin selesai memproses pengajuanmu. Pantau
                                    terus bell 🔔 di pojok kanan atas!
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            {{-- ===== END KANAN ===== --}}

        </div>
    </div>
@endsection