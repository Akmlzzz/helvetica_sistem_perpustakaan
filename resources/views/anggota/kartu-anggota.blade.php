@extends('layouts.app')

@section('title', 'Kartu Anggota')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kartu Anggota</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Identitas resmi Anda sebagai anggota perpustakaan</p>
            </div>
        </div>

        <!-- ID Card & Informasi Tambahan — Side by Side -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

            <!-- ID Card Component -->
            <div class="flex justify-center">
                <x-id-card :user="$user" :anggota="$anggota" />
            </div>

            <!-- Additional Information -->
            @if($user->isActive())
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 h-full">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Tambahan</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Nomor Anggota</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->nomor_anggota }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Status Keanggotaan</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Aktif
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Tanggal Bergabung</span>
                            <span
                                class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->dibuat_pada->format('d F Y') }}</span>
                        </div>

                        @if($anggota)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Email</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->email }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Telepon</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $anggota->nomor_telepon }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Kartu ini berlaku selama Anda menjadi anggota aktif perpustakaan
                        </div>
                    </div>
                </div>
            @else
                <!-- Placeholder kosong jika tidak aktif agar grid tetap rapi -->
                <div></div>
            @endif

        </div>
    </div>
@endsection