@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10" x-data="hakAksesManager()">

        {{-- ===== HEADER ===== --}}
        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-black">Manajemen Hak Akses</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Konfigurasikan fitur apa saja yang dapat diakses oleh setiap <span
                        class="font-semibold text-brand-primary">Petugas</span>.
                </p>
            </div>
            <div class="flex items-center gap-2 rounded-xl border border-blue-100 bg-blue-50 px-4 py-2.5">
                <svg class="h-5 w-5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs text-blue-700 font-medium">
                    Perubahan tersimpan secara <span class="font-bold">otomatis</span> saat toggle ditekan.
                </p>
            </div>
        </div>

        {{-- ===== ALERT ===== --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                class="mb-6 flex w-full items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 shadow-sm">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-green-100">
                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-green-700">{{ session('success') }}</p>
                <button @click="show = false" class="ml-auto hover:text-green-900 text-green-500 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 flex w-full items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 shadow-sm">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    @foreach($errors->all() as $error)
                        <p class="text-sm font-medium text-red-700">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ===== LEGENDA FITUR ===== --}}
        <div class="mb-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
            @foreach($daftarFitur as $key => $fitur)
                @php
                    $warnaBg = [
                        'blue' => 'bg-blue-50 border-blue-100',
                        'green' => 'bg-green-50 border-green-100',
                        'purple' => 'bg-purple-50 border-purple-100',
                        'red' => 'bg-red-50 border-red-100',
                        'orange' => 'bg-orange-50 border-orange-100',
                    ][$fitur['warna']];
                    $warnaText = [
                        'blue' => 'text-blue-700',
                        'green' => 'text-green-700',
                        'purple' => 'text-purple-700',
                        'red' => 'text-red-700',
                        'orange' => 'text-orange-700',
                    ][$fitur['warna']];
                    $warnaIcon = [
                        'blue' => 'text-blue-500',
                        'green' => 'text-green-500',
                        'purple' => 'text-purple-500',
                        'red' => 'text-red-500',
                        'orange' => 'text-orange-500',
                    ][$fitur['warna']];
                @endphp
                <div class="flex items-start gap-3 rounded-xl border {{ $warnaBg }} p-4">
                    <div class="mt-0.5">
                        @if($fitur['icon'] === 'tag')
                            <svg class="h-5 w-5 {{ $warnaIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        @elseif($fitur['icon'] === 'book')
                            <svg class="h-5 w-5 {{ $warnaIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        @elseif($fitur['icon'] === 'swap')
                            <svg class="h-5 w-5 {{ $warnaIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        @elseif($fitur['icon'] === 'money')
                            <svg class="h-5 w-5 {{ $warnaIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @elseif($fitur['icon'] === 'report')
                            <svg class="h-5 w-5 {{ $warnaIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-bold {{ $warnaText }}">{{ $fitur['label'] }}</p>
                        <p class="mt-0.5 text-xs text-gray-500">{{ $fitur['deskripsi'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ===== TABEL PETUGAS ===== --}}
        @if($petugas->isEmpty())
            {{-- Empty State --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-16 text-center shadow-sm">
                <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-bold text-black">Belum Ada Petugas</h3>
                <p class="mb-6 text-sm text-gray-500">Tambahkan akun petugas terlebih dahulu di menu <strong>Kelola
                        Pengguna</strong>.</p>
                <a href="{{ route('admin.pengguna.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-brand-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-opacity-90 transition-all">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Petugas
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($petugas as $p)
                    @php
                        $fiturDimiliki = $p->hakAkses->pluck('fitur')->toArray();
                        $totalFitur = count($daftarFitur);
                        $totalDimiliki = count($fiturDimiliki);
                    @endphp

                    <div
                        class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition-all hover:shadow-md">

                        {{-- --- Petugas Header --- --}}
                        <div class="flex items-center justify-between gap-4 border-b border-gray-100 bg-gray-50 px-6 py-4">
                            <div class="flex items-center gap-4">
                                {{-- Avatar --}}
                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-linear-to-br from-brand-primary to-blue-600 text-white font-bold text-lg shadow-sm">
                                    {{ strtoupper(substr($p->nama_pengguna, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-black text-base">{{ $p->nama_pengguna }}</p>
                                    <p class="text-xs text-gray-500">{{ $p->email }}</p>
                                </div>
                            </div>

                            {{-- Progres Badge --}}
                            <div class="flex items-center gap-3">
                                <div class="hidden sm:block">
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 w-32 overflow-hidden rounded-full bg-gray-200">
                                            @php $persen = $totalFitur > 0 ? ($totalDimiliki / $totalFitur) * 100 : 0; @endphp
                                            <div id="progress-bar-{{ $p->id_pengguna }}"
                                                class="h-full rounded-full transition-all duration-500
                                                        {{ $persen == 100 ? 'bg-green-500' : ($persen > 0 ? 'bg-brand-primary' : 'bg-gray-300') }}"
                                                style="width: {{ $persen }}%"></div>
                                        </div>
                                        <span id="progress-text-{{ $p->id_pengguna }}"
                                            class="text-xs font-semibold text-gray-500">{{ $totalDimiliki }}/{{ $totalFitur }}
                                            fitur</span>
                                    </div>
                                </div>
                                <span id="badge-{{ $p->id_pengguna }}"
                                    class="rounded-full px-3 py-1 text-xs font-bold
                                            {{ $totalDimiliki == $totalFitur ? 'bg-green-100 text-green-700' :
                        ($totalDimiliki > 0 ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                    {{ $totalDimiliki == $totalFitur ? 'Akses Penuh' :
                        ($totalDimiliki > 0 ? 'Partial' : 'Tidak Ada Akses') }}
                                </span>
                            </div>
                        </div>

                        {{-- --- Grid Fitur Toggle --- --}}
                        <div class="grid grid-cols-1 gap-0 divide-y divide-gray-100 sm:grid-cols-2 sm:divide-y-0 sm:divide-x">
                            @foreach($daftarFitur as $key => $fitur)
                                @php
                                    $aktif = in_array($key, $fiturDimiliki);
                                    $toggleId = "toggle-{$p->id_pengguna}-{$key}";
                                    $toggleUrl = route('admin.hak-akses.toggle', $p->id_pengguna);

                                    $dotColor = [
                                        'blue' => 'bg-blue-500',
                                        'green' => 'bg-green-500',
                                        'purple' => 'bg-purple-500',
                                        'red' => 'bg-red-500',
                                        'orange' => 'bg-orange-500',
                                    ][$fitur['warna']];

                                    $pillActive = [
                                        'blue' => 'bg-blue-100 text-blue-700',
                                        'green' => 'bg-green-100 text-green-700',
                                        'purple' => 'bg-purple-100 text-purple-700',
                                        'red' => 'bg-red-100 text-red-700',
                                        'orange' => 'bg-orange-100 text-orange-700',
                                    ][$fitur['warna']];
                                @endphp

                                <div class="flex items-center justify-between gap-4 px-6 py-4 transition-colors
                                                {{ $aktif ? 'bg-white' : 'bg-gray-50/50' }}
                                                {{ !$loop->last ? 'sm:border-r border-gray-100' : '' }}">

                                    {{-- Icon + Info --}}
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                                                        {{ $aktif ? ($fitur['warna'] === 'blue' ? 'bg-blue-100' : ($fitur['warna'] === 'green' ? 'bg-green-100' : ($fitur['warna'] === 'purple' ? 'bg-purple-100' : ($fitur['warna'] === 'red' ? 'bg-red-100' : 'bg-orange-100')))) : 'bg-gray-100' }}
                                                        transition-colors">
                                            @if($fitur['icon'] === 'tag')
                                                <svg class="h-4 w-4 {{ $aktif ? ($fitur['warna'] === 'blue' ? 'text-blue-600' : ($fitur['warna'] === 'green' ? 'text-green-600' : ($fitur['warna'] === 'purple' ? 'text-purple-600' : 'text-red-600'))) : 'text-gray-400' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                            @elseif($fitur['icon'] === 'book')
                                                <svg class="h-4 w-4 {{ $aktif ? ($fitur['warna'] === 'blue' ? 'text-blue-600' : ($fitur['warna'] === 'green' ? 'text-green-600' : ($fitur['warna'] === 'purple' ? 'text-purple-600' : 'text-red-600'))) : 'text-gray-400' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            @elseif($fitur['icon'] === 'swap')
                                                <svg class="h-4 w-4 {{ $aktif ? ($fitur['warna'] === 'blue' ? 'text-blue-600' : ($fitur['warna'] === 'green' ? 'text-green-600' : ($fitur['warna'] === 'purple' ? 'text-purple-600' : 'text-red-600'))) : 'text-gray-400' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                                </svg>
                                            @elseif($fitur['icon'] === 'money')
                                                <svg class="h-4 w-4 {{ $aktif ? ($fitur['warna'] === 'blue' ? 'text-blue-600' : ($fitur['warna'] === 'green' ? 'text-green-600' : ($fitur['warna'] === 'purple' ? 'text-purple-600' : ($fitur['warna'] === 'red' ? 'text-red-600' : 'text-orange-600')))) : 'text-gray-400' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @elseif($fitur['icon'] === 'report')
                                                <svg class="h-4 w-4 {{ $aktif ? ($fitur['warna'] === 'blue' ? 'text-blue-600' : ($fitur['warna'] === 'green' ? 'text-green-600' : ($fitur['warna'] === 'purple' ? 'text-purple-600' : ($fitur['warna'] === 'red' ? 'text-red-600' : 'text-orange-600')))) : 'text-gray-400' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold {{ $aktif ? 'text-black' : 'text-gray-500' }}">
                                                {{ $fitur['label'] }}
                                            </p>
                                            <p class="text-xs text-gray-400">{{ $fitur['deskripsi'] }}</p>
                                        </div>
                                    </div>

                                    {{-- Toggle Switch --}}
                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="text-xs font-medium {{ $aktif ? 'text-green-600' : 'text-gray-400' }}">
                                            {{ $aktif ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                        <button type="button" id="{{ $toggleId }}" data-url="{{ $toggleUrl }}" data-fitur="{{ $key }}"
                                            data-pengguna="{{ $p->id_pengguna }}" data-aktif="{{ $aktif ? 'true' : 'false' }}"
                                            onclick="toggleHakAkses(this)" class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-1
                                                            {{ $aktif ? 'bg-brand-primary' : 'bg-gray-200' }}"
                                            aria-label="Toggle akses {{ $fitur['label'] }} untuk {{ $p->nama_pengguna }}">
                                            <span class="inline-block h-4 w-4 rounded-full bg-white shadow-sm transition-transform duration-300
                                                            {{ $aktif ? 'translate-x-6' : 'translate-x-1' }}">
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>

    {{-- ===== TOAST NOTIFICATION ===== --}}
    <div id="hakAksesToast" style="display:none;"
        class="fixed bottom-6 right-6 z-99999 flex items-center gap-3 rounded-xl px-5 py-3.5 text-white shadow-xl transition-all">
        <svg id="hakAksesToastIcon" class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <p id="hakAksesToastMsg" class="text-sm font-medium"></p>
    </div>

    @push('scripts')
        <script>
            /**
             * Toggle hak akses via AJAX — tanpa reload halaman.
             */
            function toggleHakAkses(btn) {
                const url = btn.dataset.url;
                const fitur = btn.dataset.fitur;
                const aktif = btn.dataset.aktif === 'true';
                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Disable tombol sementara
                btn.disabled = true;
                btn.classList.add('opacity-60', 'cursor-not-allowed');

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ fitur: fitur }),
                })
                    .then(res => res.json())
                    .then(data => {
                        const isAktif = data.status;

                        // Update visual toggle
                        if (isAktif) {
                            btn.classList.replace('bg-gray-200', 'bg-brand-primary');
                            btn.querySelector('span').classList.replace('translate-x-1', 'translate-x-6');
                            btn.dataset.aktif = 'true';
                        } else {
                            btn.classList.replace('bg-brand-primary', 'bg-gray-200');
                            btn.querySelector('span').classList.replace('translate-x-6', 'translate-x-1');
                            btn.dataset.aktif = 'false';
                        }

                        // Update label teks "Aktif/Nonaktif"
                        const labelEl = btn.previousElementSibling;
                        if (labelEl) {
                            labelEl.textContent = isAktif ? 'Aktif' : 'Nonaktif';
                            labelEl.className = 'text-xs font-medium ' + (isAktif ? 'text-green-600' : 'text-gray-400');
                        }

                        // Tampilkan toast
                        showToast(data.pesan, isAktif ? 'success' : 'warning');

                        // Update progress bar & badge (reload partial)
                        updatePetugasProgress(btn.dataset.pengguna);
                    })
                    .catch(() => {
                        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.classList.remove('opacity-60', 'cursor-not-allowed');
                    });
            }

            function updatePetugasProgress(idPengguna) {
                // Hitung jumlah toggle yang aktif pada kartu petugas ini
                const allToggles = document.querySelectorAll(`[data-pengguna="${idPengguna}"]`);
                let aktifCount = 0;
                let totalCount = allToggles.length;

                allToggles.forEach(t => {
                    if (t.dataset.aktif === 'true') aktifCount++;
                });

                const persen = totalCount > 0 ? (aktifCount / totalCount) * 100 : 0;

                // Update progress bar
                const progressBar = document.getElementById(`progress-bar-${idPengguna}`);
                const progressText = document.getElementById(`progress-text-${idPengguna}`);
                const badge = document.getElementById(`badge-${idPengguna}`);

                if (progressBar) {
                    progressBar.style.width = persen + '%';
                    if (persen === 100) progressBar.className = 'h-full rounded-full bg-green-500 transition-all duration-500';
                    else if (persen > 0) progressBar.className = 'h-full rounded-full bg-brand-primary transition-all duration-500';
                    else progressBar.className = 'h-full rounded-full bg-gray-300 transition-all duration-500';
                }

                if (progressText) progressText.textContent = aktifCount + '/' + totalCount + ' fitur';
                if (badge) {
                    if (aktifCount === totalCount) {
                        badge.textContent = 'Akses Penuh';
                        badge.className = 'rounded-full px-3 py-1 text-xs font-bold bg-green-100 text-green-700';
                    } else if (aktifCount > 0) {
                        badge.textContent = 'Partial';
                        badge.className = 'rounded-full px-3 py-1 text-xs font-bold bg-blue-100 text-blue-700';
                    } else {
                        badge.textContent = 'Tidak Ada Akses';
                        badge.className = 'rounded-full px-3 py-1 text-xs font-bold bg-gray-100 text-gray-600';
                    }
                }
            }

            function showToast(pesan, tipe = 'success') {
                const toast = document.getElementById('hakAksesToast');
                const msg = document.getElementById('hakAksesToastMsg');
                const icon = document.getElementById('hakAksesToastIcon');

                msg.textContent = pesan;

                // Warna berdasarkan tipe
                toast.className = 'fixed bottom-6 right-6 z-[99999] flex items-center gap-3 rounded-xl px-5 py-3.5 text-white shadow-xl transition-all ';
                if (tipe === 'success') {
                    toast.classList.add('bg-green-600');
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
                } else if (tipe === 'warning') {
                    toast.classList.add('bg-orange-500');
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />';
                } else {
                    toast.classList.add('bg-red-600');
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                }

                toast.style.display = 'flex';
                toast.style.opacity = '1';

                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => { toast.style.display = 'none'; toast.style.opacity = '1'; }, 300);
                }, 3500);
            }

            function hakAksesManager() {
                return {};
            }
        </script>
    @endpush

@endsection