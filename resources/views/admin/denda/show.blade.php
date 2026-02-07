@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex items-center justify-between gap-3">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Detail Denda
            </h2>
            <a href="{{ route('admin.denda.index') }}"
                class="inline-flex items-center justify-center rounded-md border border-stroke px-6 py-2 text-center font-medium text-black hover:bg-opacity-90 dark:border-strokedark dark:text-white">
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
            <!-- Denda Specific Info -->
            <div class="flex flex-col gap-9">
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-800 dark:bg-gray-900">
                    <div class="border-b border-stroke px-6.5 py-4 dark:border-gray-800">
                        <h3 class="font-medium text-black dark:text-white">
                            Informasi Denda
                        </h3>
                    </div>
                    <div class="p-6.5">
                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Jumlah Denda
                            </label>
                            <input type="text" readonly value="Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary font-bold text-danger" />
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Status Pembayaran
                            </label>
                            <input type="text" readonly value="{{ ucfirst($denda->status_pembayaran) }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary" />
                        </div>
                    </div>
                </div>
            </div>

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
                            <input type="text" readonly value="{{ $denda->peminjaman->kode_booking }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Tanggal Pinjam
                            </label>
                            <input type="text" readonly value="{{ $denda->peminjaman->tgl_pinjam }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary" />
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Tanggal Kembali (Deadline)
                            </label>
                            <input type="text" readonly value="{{ $denda->peminjaman->tgl_kembali }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrower Info -->
            <div class="flex flex-col gap-9 col-span-1 sm:col-span-2">
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
                                value="{{ $denda->peminjaman->pengguna->anggota->nama_lengkap ?? $denda->peminjaman->pengguna->nama_pengguna ?? '-' }}"
                                class="w-full rounded border border-stroke bg-gray py-3 px-5 text-black focus:border-primary focus-visible:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-primary" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection