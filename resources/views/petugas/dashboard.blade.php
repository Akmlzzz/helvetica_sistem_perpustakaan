@extends('layouts.app')

@section('content')
    <div x-data="{
            activeTab: 'peminjaman',
            scannedMemberId: '',
            scannedBookId: '',
            tempBooks: [],
            showFineModal: false,
            fineData: null,

            addBook(isbn) {
                // Mock adding book to temp list
                if(!isbn) return;
                this.tempBooks.push({
                    id: Date.now(),
                    isbn: isbn,
                    title: 'Judul Buku Contoh (' + isbn + ')',
                    author: 'Penulis Contoh'
                });
                this.scannedBookId = '';
            },

            removeBook(idx) {
                this.tempBooks.splice(idx, 1);
            },

            processReturn(id) {
                // Mock return process
                // If late, show fine modal
                // else submit return
                this.fineData = {
                    overdue_days: 3,
                    amount: 15000
                };
                this.showFineModal = true;
            }
        }">

        <!-- Page Header -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Layanan Sirkulasi
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium" href="index.html">Dashboard /</a></li>
                    <li class="font-medium text-primary">Sirkulasi</li>
                </ol>
            </nav>
        </div>

        <!-- Tabs -->
        <div class="mb-6 flex gap-4 border-b border-stroke dark:border-strokedark">
            <button @click="activeTab = 'peminjaman'"
                :class="activeTab === 'peminjaman' ? 'border-primary text-primary' : 'border-transparent hover:text-primary'"
                class="border-b-2 py-2 px-4 font-medium transition-colors">
                Peminjaman
            </button>
            <button @click="activeTab = 'pengembalian'"
                :class="activeTab === 'pengembalian' ? 'border-primary text-primary' : 'border-transparent hover:text-primary'"
                class="border-b-2 py-2 px-4 font-medium transition-colors">
                Pengembalian
            </button>
        </div>

        <!-- Peminjaman Section -->
        <div x-show="activeTab === 'peminjaman'" class="grid grid-cols-1 gap-9 xl:grid-cols-2">
            <!-- Input Section -->
            <div class="flex flex-col gap-9">
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                        <h3 class="font-medium text-black dark:text-white">
                            Input Data Peminjaman
                        </h3>
                    </div>
                    <form action="#" method="POST">
                        <div class="p-6.5">
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    ID Anggota <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" x-model="scannedMemberId" placeholder="Scan Kartu / Ketik ID Anggota"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                            </div>

                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Scan ISBN / Judul Buku
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" x-model="scannedBookId" @keyup.enter.prevent="addBook(scannedBookId)"
                                        placeholder="Scan Barcode Buku"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                    <button type="button" @click="addBook(scannedBookId)"
                                        class="flex justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                        <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <button
                                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                Proses Pinjam
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Daftar Sementara List -->
            <div class="flex flex-col gap-9">
                <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                        <h3 class="font-medium text-black dark:text-white">
                            Daftar Buku (Draft)
                        </h3>
                    </div>
                    <div class="p-6.5">
                        <template x-if="tempBooks.length === 0">
                            <p class="text-center text-gray-500 py-4">Belum ada buku yang ditambahkan.</p>
                        </template>
                        <ul class="flex flex-col gap-3">
                            <template x-for="(book, index) in tempBooks" :key="book.id">
                                <li
                                    class="flex items-center justify-between rounded border border-stroke bg-gray-50 p-3 dark:border-strokedark dark:bg-meta-4">
                                    <div>
                                        <h5 class="font-medium text-black dark:text-white" x-text="book.title"></h5>
                                        <p class="text-sm" x-text="'ISBN: ' + book.isbn"></p>
                                    </div>
                                    <button @click="removeBook(index)" class="text-meta-1 hover:text-danger">
                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                        </svg>
                                    </button>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengembalian Section -->
        <div x-show="activeTab === 'pengembalian'" class="grid grid-cols-1 gap-9">
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                    <h3 class="font-medium text-black dark:text-white">
                        Peminjaman Aktif / Pengembalian
                    </h3>
                </div>
                <div class="p-6.5">
                    <div class="mb-4.5 flex gap-4">
                        <input type="text" placeholder="Cari Kode Peminjaman / Nama Anggota / ISBN"
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        <button
                            class="flex justify-center rounded bg-primary px-6 py-3 font-medium text-gray hover:bg-opacity-90">
                            Cari
                        </button>
                    </div>

                    <!-- Table -->
                    <div class="max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                    <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                                        Kode
                                    </th>
                                    <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                                        Anggota
                                    </th>
                                    <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white">
                                        Buku
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Tgl Pinjam
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Batas Kembali
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Status
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Mock Data Row -->
                                <tr>
                                    <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                        <h5 class="font-medium text-black dark:text-white">PJ-2301001</h5>
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p class="text-black dark:text-white">Ahmad Fulan</p>
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p class="text-black dark:text-white">Belajar Laravel 10</p>
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p class="text-black dark:text-white">01 Jan 2024</p>
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p class="text-danger">08 Jan 2024</p> <!-- Late -->
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p
                                            class="inline-flex rounded-full bg-danger bg-opacity-10 py-1 px-3 text-sm font-medium text-danger">
                                            Terlambat
                                        </p>
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <div class="flex items-center space-x-3.5">
                                            <button @click="processReturn(1)" class="hover:text-primary">
                                                <svg class="fill-current" width="18" height="18" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fine Modal (Mock) -->
        <div x-show="showFineModal" class="fixed inset-0 z-999 flex items-center justify-center bg-black bg-opacity-50"
            style="display: none;">
            <div
                class="w-full max-w-lg rounded-sm border border-stroke bg-white p-8 shadow-default dark:border-strokedark dark:bg-boxdark">
                <h3 class="mb-4 text-xl font-bold text-black dark:text-white">Konfirmasi Pengembalian</h3>
                <div class="mb-6">
                    <p class="mb-2">Terdeteksi keterlambatan pengembalian:</p>
                    <div class="bg-danger bg-opacity-10 p-4 rounded text-danger">
                        <p class="font-bold">Terlambat: <span x-text="fineData?.overdue_days"></span> Hari</p>
                        <p class="font-bold text-lg">Denda: Rp <span x-text="fineData?.amount"></span></p>
                    </div>
                </div>
                <div class="flex justify-end gap-4">
                    <button @click="showFineModal = false"
                        class="rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                        Batal
                    </button>
                    <button class="rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90">
                        Konfirmasi & Lunas
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection