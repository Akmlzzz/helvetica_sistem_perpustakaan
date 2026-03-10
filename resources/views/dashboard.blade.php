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
            <x-stat-card title="Total Buku" value="{{ $totalBuku ?? '0' }}"
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>' />
            <x-stat-card title="Total Anggota" value="{{ $totalAnggota ?? '0' }}"
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a5.97 5.97 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>' />
            <x-stat-card title="Peminjaman Aktif" value="{{ $totalPeminjaman ?? '0' }}"
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>' />
            <x-stat-card title="Total Denda" value="IDR {{ $totalDenda ?? '0' }}"
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75m0 5.25v.75m0 5.25v.75m15-12v.75m0 5.25v.75m0 5.25v.75m-15-10.5h15c.621 0 1.125.504 1.125 1.125v10.5c0 .621-.504 1.125-1.125 1.125h-15a1.125 1.125 0 0 1-1.125-1.125v-10.5c0-.621.504-1.125 1.125-1.125Zm1.5 0v10.5m12-10.5v10.5m-10.5-8.25h3m-3 2.25h3m-3 2.25h3m3.75-6.75h3m-3 2.25h3m-3 2.25h3" /></svg>' />
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