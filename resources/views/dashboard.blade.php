@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

        <!-- Welcome Section -->
        <div
            class="mb-8 rounded-[20px] bg-white px-7.5 py-6 shadow-sm border border-gray-100 dark:border-gray-800 dark:bg-gray-900">
            <h2 class="text-2xl font-bold text-[#004236] dark:text-white sm:text-title-xl2">
                Selamat Datang, <span
                    class="font-normal text-gray-800 dark:text-gray-200">{{ auth()->user()->nama_pengguna }}</span>
            </h2>
            <p class="mt-1 text-base text-gray-500 dark:text-gray-400">
                Anda login sebagai <span class="capitalize">{{ auth()->user()->level_akses }}</span>
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 md:gap-6 2xl:gap-7.5">
            <x-stat-card title="Total Buku" value="{{ $totalBuku ?? '12' }}"
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>' />
            <x-stat-card title="Total Anggota" value="{{ $totalAnggota ?? '7' }}"
                icon='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2"/><circle cx="8.5" cy="7" r="4" stroke="currentColor" stroke-width="2"/></svg>' />
            <x-stat-card title="Peminjaman Aktif" value="{{ $totalPeminjaman ?? '4' }}"
                icon='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2"/><line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"/><line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"/><line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"/></svg>' />
            <x-stat-card title="Total Denda" value="IDR {{ $totalDenda ?? '12.000' }}"
                icon='<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><line x1="12" y1="1" x2="12" y2="23" stroke="currentColor" stroke-width="2"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" stroke="currentColor" stroke-width="2"/></svg>' />
        </div>

        <!-- Table Section -->
        <div
            class="mt-8 rounded-[20px] bg-white px-5 pt-6 pb-2.5 shadow-sm border border-gray-100 dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 xl:pb-1">
            <h4 class="mb-6 text-xl font-bold text-black dark:text-white">
                Tabel Peminjaman
            </h4>

            <!-- Responsive Table Wrapper -->
            <div class="overflow-x-auto -mx-5 px-5 sm:mx-0 sm:px-0">
                <div class="min-w-[700px]">
                    <!-- Table Header -->
                    <div class="grid grid-cols-5 rounded-sm bg-gray-50 dark:bg-gray-800 text-xs sm:text-sm">
                        <div class="p-2 xl:p-5">
                            <h5 class="font-bold uppercase text-gray-500 dark:text-gray-400">
                                Nama
                            </h5>
                        </div>
                        <div class="p-2 text-center xl:p-5">
                            <h5 class="font-bold uppercase text-gray-500 dark:text-gray-400">
                                Email
                            </h5>
                        </div>
                        <div class="p-2 text-center xl:p-5">
                            <h5 class="font-bold uppercase text-gray-500 dark:text-gray-400">
                                Tgl Pinjam
                            </h5>
                        </div>
                        <div class="p-2 text-center xl:p-5">
                            <h5 class="font-bold uppercase text-gray-500 dark:text-gray-400">
                                Tgl Kembali
                            </h5>
                        </div>
                        <div class="p-2 text-center xl:p-5">
                            <h5 class="font-bold uppercase text-gray-500 dark:text-gray-400">
                                Status
                            </h5>
                        </div>
                    </div>

                    @foreach($latestPeminjaman as $row)
                        <div
                            class="grid grid-cols-5 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors text-xs sm:text-sm">
                            <div class="flex items-center gap-1 p-2 xl:p-5">
                                <p class="font-bold text-black dark:text-white truncate">
                                    {{ $row->pengguna->nama_pengguna ?? 'Guest' }}
                                </p>
                            </div>

                            <div class="flex items-center justify-center p-2 xl:p-5">
                                <p class="text-black dark:text-white font-medium truncate">
                                    {{ $row->pengguna->email ?? '-' }}
                                </p>
                            </div>

                            <div class="flex items-center justify-center p-2 xl:p-5">
                                <p class="font-medium text-gray-600 dark:text-gray-400 truncate">
                                    {{ $row->tgl_pinjam }}
                                </p>
                            </div>

                            <div class="flex items-center justify-center p-2 xl:p-5">
                                <p class="text-black dark:text-white font-medium truncate">
                                    {{ $row->tgl_kembali }}
                                </p>
                            </div>

                            <div class="flex items-center justify-center p-2 xl:p-5">
                                <x-status-badge :type="$row->status_transaksi" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection