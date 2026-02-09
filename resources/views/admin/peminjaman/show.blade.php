@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex items-center justify-between gap-3">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Detail Transaksi
            </h2>
            <a href="{{ route('admin.peminjaman.index') }}"
                class="inline-flex items-center justify-center rounded-md border border-stroke px-6 py-2 text-center font-medium text-black hover:bg-opacity-90 dark:border-strokedark dark:text-white">
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
            <!-- Transaction Info -->
            <div class="flex flex-col gap-9">
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-800 dark:bg-gray-900">
                    <div class="border-b border-stroke px-6.5 py-4 dark:border-gray-800">
                        <h3 class="font-medium text-black dark:text-white">
                            Informasi Peminjaman
                        </h3>
                    </div>
                    <div class="p-6.5">
                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Kode Booking
                            </label>
                            <input type="text" readonly value="{{ $peminjaman->kode_booking }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Tanggal Pinjam
                            </label>
                            <input type="text" readonly value="{{ $peminjaman->tgl_pinjam }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Tanggal Kembali (Deadline)
                            </label>
                            <input type="text" readonly value="{{ $peminjaman->tgl_kembali }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Status
                            </label>
                            <input type="text" readonly value="{{ ucfirst($peminjaman->status_transaksi) }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrower Info -->
            <div class="flex flex-col gap-9">
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-800 dark:bg-gray-900">
                    <div class="border-b border-stroke px-6.5 py-4 dark:border-gray-800">
                        <h3 class="font-medium text-black dark:text-white">
                            Informasi Peminjam
                        </h3>
                    </div>
                    <div class="p-6.5">
                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Nama Lengkap
                            </label>
                            <input type="text" readonly
                                value="{{ $peminjaman->pengguna->anggota->nama_lengkap ?? $peminjaman->pengguna->nama_pengguna ?? '-' }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary" />
                        </div>
                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Email
                            </label>
                            <input type="text" readonly value="{{ $peminjaman->pengguna->email ?? '-' }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book List -->
        <div
            class="mt-6 rounded-sm border border-stroke bg-white px-5 pb-5 pt-6 shadow-default dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 xl:pb-1">
            <div class="mb-6 flex items-center justify-between">
                <h4 class="text-xl font-bold text-black dark:text-white">
                    Buku yang Dipinjam
                </h4>
                <a href="{{ route('admin.peminjaman.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-brand-primary px-4 py-2 font-medium text-white hover:bg-opacity-90">
                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 4.16666V15.8333" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M4.16669 10H15.8334" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    Tambah Peminjaman
                </a>
            </div>

            <div class="flex flex-col overflow-x-auto">
                <div class="min-w-full">
                    <div class="grid grid-cols-4 rounded-sm bg-gray-2 dark:bg-gray-800 sm:grid-cols-4">
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-white">Judul Buku</h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-white">ISBN</h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-white">Penulis</h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-white">Penerbit</h5>
                        </div>
                    </div>

                    @if($peminjaman->id_buku)
                        <div class="grid grid-cols-4 border-b border-stroke dark:border-gray-700 sm:grid-cols-4">
                            <div class="p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">{{ $peminjaman->buku->judul_buku ?? '-' }}</p>
                            </div>
                            <div class="p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">{{ $peminjaman->buku->isbn ?? '-' }}</p>
                            </div>
                            <div class="p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">{{ $peminjaman->buku->penulis ?? '-' }}</p>
                            </div>
                            <div class="p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">{{ $peminjaman->buku->penerbit ?? '-' }}</p>
                            </div>
                        </div>
                    @elseif($peminjaman->detail)
                        @foreach($peminjaman->detail as $item)
                            <div class="grid grid-cols-4 border-b border-stroke dark:border-gray-700 sm:grid-cols-4">
                                <div class="p-2.5 xl:p-5">
                                    <p class="text-black dark:text-white">{{ $item->buku->judul_buku ?? '-' }}</p>
                                </div>
                                <div class="p-2.5 xl:p-5">
                                    <p class="text-black dark:text-white">{{ $item->buku->isbn ?? '-' }}</p>
                                </div>
                                <div class="p-2.5 xl:p-5">
                                    <p class="text-black dark:text-white">{{ $item->buku->penulis ?? '-' }}</p>
                                </div>
                                <div class="p-2.5 xl:p-5">
                                    <p class="text-black dark:text-white">{{ $item->buku->penerbit ?? '-' }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection