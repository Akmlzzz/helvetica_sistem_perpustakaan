@props(['user', 'anggota'])

@php
    $status = $user->status ?? 'pending';
    $namaLengkap = $anggota->nama_lengkap ?? $user->nama_pengguna;
    $nomorAnggota = $user->nomor_anggota ?? null;
@endphp

<!-- Status Pending State -->
@if($status === 'pending')
    <div class="max-w-2xl mx-auto">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-8 text-center">
            <div
                class="w-20 h-20 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Verifikasi Pending</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Mohon tunggu, akun Anda sedang diverifikasi oleh petugas.</p>
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                    <strong>Status:</strong> Menunggu Verifikasi<br>
                    <strong>Tanggal Daftar:</strong> {{ $user->dibuat_pada->format('d F Y') }}
                </p>
            </div>
        </div>
    </div>
@else
    <!-- ID Card Active State -->
    <div class="w-full">
        <!-- ID Card Container -->
        <div class="relative bg-linear-to-br from-green-500 to-green-400 rounded-2xl shadow-2xl overflow-hidden">
            <div class="flex flex-col">
                <!-- Top Section - Logo & Verification -->
                <div class="px-6 pt-6 pb-4 flex items-center justify-between border-b border-green-400/30">
                    <!-- Logo Brand -->
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('img/logo-id.svg') }}" alt="Logo" class="w-12 h-12">
                        <div>
                            <p class="text-white font-bold text-base leading-tight">Perpustakaan</p>
                            <p class="text-white/70 text-xs">Digital Library</p>
                        </div>
                    </div>
                    <!-- Verification Badge -->
                    <div class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1 flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-white font-medium text-xs">Terverifikasi</span>
                    </div>
                </div>

                <!-- Bottom Section - Member Info -->
                <div class="px-6 py-5">
                    <!-- ID Number -->
                    <div class="mb-4">
                        <p class="text-white/70 text-xs font-medium mb-0.5">ID Anggota</p>
                        <p class="text-white font-mono text-xl font-bold tracking-wider">{{ $nomorAnggota }}</p>
                    </div>

                    <!-- Member Details -->
                    <div class="grid grid-cols-2 gap-3 mb-5">
                        <div>
                            <p class="text-white/70 text-xs mb-0.5">Nama Lengkap</p>
                            <p class="text-white font-semibold text-sm leading-tight">{{ $namaLengkap }}</p>
                        </div>
                        <div>
                            <p class="text-white/70 text-xs mb-0.5">Username</p>
                            <p class="text-white font-semibold text-sm">{{ $user->nama_pengguna }}</p>
                        </div>
                        <div>
                            <p class="text-white/70 text-xs mb-0.5">Terdaftar</p>
                            <p class="text-white font-semibold text-sm">{{ $user->dibuat_pada->format('Y') }}</p>
                        </div>
                        <div>
                            <p class="text-white/70 text-xs mb-0.5">Status</p>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white">Aktif</span>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="pt-3 border-t border-green-400/30 text-white/60 text-xs">
                        <p>Berlaku selama menjadi anggota aktif</p>
                        <p class="mt-0.5">© {{ date('Y') }} Perpustakaan Digital</p>
                    </div>
                </div>
            </div>

            <!-- Card Shine Effect -->
            <div
                class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-transparent -skew-x-12 transform translate-x-full hover:translate-x-0 transition-transform duration-1000 pointer-events-none">
            </div>
        </div>

        <!-- Card Back Info -->
        <div class="mt-3 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Kartu Anggota Berlaku Selama Menjadi Anggota Aktif | Nomor: {{ $nomorAnggota }}
            </p>
        </div>
    </div>

    <!-- QR Code Script -->
    @if($nomorAnggota)
        <script type="module">
            import { generateMemberQR } from '/js/qr-code.js';

            document.addEventListener('DOMContentLoaded', async function () {
                const qrElement = document.querySelector('[data-qr-member-id="{{ $nomorAnggota }}"]');
                if (qrElement) {
                    const qrDataUrl = await generateMemberQR('{{ $nomorAnggota }}');
                    if (qrDataUrl) {
                        qrElement.innerHTML = `<img src="${qrDataUrl}" alt="QR Code" class="w-full h-full rounded">`;
                    }
                }
            });
        </script>
    @endif
@endif