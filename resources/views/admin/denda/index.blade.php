@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Header Section -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Pengaturan Denda
            </h2>
            <button @click="$dispatch('open-edit-config-modal')"
                class="inline-flex items-center justify-center gap-2.5 rounded-xl bg-brand-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-8">
                <!-- Assuming there should be some content here, e.g., an icon or text -->
                <span>Edit Konfigurasi</span>
            </button>
        </div>

        <!-- Search & Filter -->
        <div
            class="rounded-[20px] border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 xl:pb-1">
            <form method="GET" action="{{ route('admin.denda.index') }}"
                class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center">

                <!-- Search Bar -->
                <div class="relative flex-1">
                    <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2">
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
                        class="w-full rounded-lg border border-stroke bg-transparent pl-12 pr-4 py-2 font-medium outline-none focus:border-primary dark:border-strokedark dark:text-white" />
                </div>

                <!-- Filter Status -->
                <div class="relative w-full sm:w-48">
                    <select name="status" onchange="this.form.submit()"
                        class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                        <option value="" class="text-gray-500">Semua Status</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z" fill="currentColor"/>
                        </svg>
                    </div>
                </div>

                <!-- Sort Filter -->
                <div class="relative w-full sm:w-48">
                    <select name="sort" onchange="this.form.submit()"
                        class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A-Z (Peminjam)</option>
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z" fill="currentColor"/>
                        </svg>
                    </div>
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

                    @foreach($denda as $item)
                        <div class="grid grid-cols-6 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors sm:grid-cols-6">
                            <!-- Nama Peminjam -->
                            <div class="flex items-center p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">
                                    {{ $item->peminjaman->pengguna->anggota->nama_lengkap ?? $item->peminjaman->pengguna->nama_pengguna ?? 'Unknown' }}
                                </p>
                            </div>

                            <!-- Judul Buku -->
                            <div class="flex items-center p-2.5 xl:p-5">
                                @if($item->peminjaman->id_buku)
                                     <p class="text-black dark:text-white">{{ $item->peminjaman->buku->judul_buku ?? '-' }}</p>
                                @elseif($item->peminjaman->detail && $item->peminjaman->detail->count() > 0)
                                     <div class="flex flex-col">
                                        @foreach($item->peminjaman->detail->take(2) as $detail)
                                            <span class="text-sm text-black dark:text-white">{{ $detail->buku->judul_buku ?? '-' }}</span>
                                        @endforeach
                                        @if($item->peminjaman->detail->count() > 2)
                                            <span class="text-xs text-gray-500">+{{ $item->peminjaman->detail->count() - 2 }} lainnya</span>
                                        @endif
                                     </div>
                                @else
                                    <span class="text-black dark:text-white">-</span>
                                @endif
                            </div>

                            <!-- Tgl Pinjam -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">{{ $item->peminjaman->tgl_pinjam }}</p>
                            </div>

                            <!-- Deadline -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">{{ $item->peminjaman->tgl_kembali }}</p>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <x-status-badge :type="$item->peminjaman->status_transaksi" />
                            </div>

                            <!-- Aksi -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <a href="{{ route('admin.denda.show', $item->id_denda) }}"
                                   class="inline-flex items-center justify-center rounded-md border border-brand-primary px-4 py-2 text-center font-medium text-black hover:bg-brand-primary dark:border-brand-primary dark:text-white dark:hover:bg-brand-primary transition-colors lg:px-4 xl:px-4">
                                   Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 px-4 pb-4 sm:px-7.5">
                 {{ $denda->links() }}
            </div>
        </div>
    </div>
@endsection
