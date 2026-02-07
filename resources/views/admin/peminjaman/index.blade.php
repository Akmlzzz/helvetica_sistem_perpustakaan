@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Header Section -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Sirkulasi Global
            </h2>
        </div>

        <!-- Search & Filter -->
        <div
            class="rounded-[20px] border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 xl:pb-1">
            <form method="GET" action="{{ route('admin.peminjaman.index') }}"
                class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center">

                <!-- Search Bar -->
                <div class="relative w-full sm:w-1/2">
                    <button class="absolute left-4 top-1/2 -translate-y-1/2">
                        <svg class="fill-current text-black dark:text-white hover:text-primary transition-colors" width="20"
                            height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                                fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari Nama Peminjam atau Judul Buku..."
                        class="w-full rounded-lg border border-stroke bg-transparent pl-12 pr-4 py-2 font-medium outline-none focus:border-primary dark:border-strokedark dark:text-white xl:w-125" />
                </div>

                <!-- Filter Status -->
                <div class="w-full sm:w-1/4">
                    <select name="status" onchange="this.form.submit()"
                        class="relative z-20 w-full appearance-none rounded border py-2 pl-4 pr-10 outline-none transition {{ request('status') ? 'border-primary bg-primary/5 dark:bg-primary/10' : 'border-stroke bg-transparent' }} focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">
                        <option value="" class="text-gray-700 dark:text-white dark:bg-gray-800">Semua Status</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}
                            class="text-gray-700 dark:text-white dark:bg-gray-800">Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}
                            class="text-gray-700 dark:text-white dark:bg-gray-800">Dikembalikan</option>
                        <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}
                            class="text-gray-700 dark:text-white dark:bg-gray-800">Terlambat</option>
                    </select>
                </div>
            </form>

            <!-- Table Section with Responsive Scroll -->
            <div class="flex flex-col overflow-x-auto">
                <div class="min-w-[1000px]">
                    <div class="grid grid-cols-6 rounded-sm bg-gray-50 dark:bg-gray-800 sm:grid-cols-6">
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Nama Peminjam</h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Judul Buku</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Tgl Pinjam</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Deadline</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Status</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Aksi</h5>
                        </div>
                    </div>

                    @foreach($peminjaman as $item)
                        <div
                            class="grid grid-cols-6 border-b border-stroke dark:border-strokedark hover:bg-gray-50 dark:hover:bg-white/5 sm:grid-cols-6">
                            <!-- Nama Peminjam -->
                            <div class="flex items-center p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">
                                    {{ $item->pengguna->anggota->nama_lengkap ?? $item->pengguna->nama_pengguna ?? 'Unknown' }}
                                </p>
                            </div>

                            <!-- Judul Buku -->
                            <div class="flex items-center p-2.5 xl:p-5">
                                @if($item->id_buku)
                                    <p class="text-black dark:text-white">{{ $item->buku->judul_buku ?? '-' }}</p>
                                @elseif($item->detail && $item->detail->count() > 0)
                                    <div class="flex flex-col">
                                        @foreach($item->detail->take(2) as $detail)
                                            <span
                                                class="text-sm text-black dark:text-white">{{ $detail->buku->judul_buku ?? '-' }}</span>
                                        @endforeach
                                        @if($item->detail->count() > 2)
                                            <span class="text-xs text-gray-500">+{{ $item->detail->count() - 2 }} lainnya</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-black dark:text-white">-</span>
                                @endif
                            </div>

                            <!-- Tgl Pinjam -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">{{ $item->tgl_pinjam }}</p>
                            </div>

                            <!-- Deadline -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">{{ $item->tgl_kembali }}</p>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <x-status-badge :type="$item->status_transaksi" />
                            </div>

                            <!-- Aksi -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <a href="{{ route('admin.peminjaman.show', $item->id_peminjaman) }}"
                                    class="inline-flex items-center justify-center rounded-md border border-primary px-4 py-2 text-center font-medium text-primary hover:bg-opacity-90 lg:px-4 xl:px-4 dark:text-white">
                                    Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 px-4 pb-4 sm:px-7.5">
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
@endsection