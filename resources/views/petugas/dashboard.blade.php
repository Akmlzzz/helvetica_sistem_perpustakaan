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
                                    // Cek kalo inputnya kosong
                                    if(!isbn) return;
                                    this.tempBooks.push({
                                        id: Date.now(),
                                        isbn: isbn,
                                        title: 'Buku Contoh (' + isbn + ')',
                                        author: 'Penulis'
                                    });
                                    this.scannedBookId = '';
                                },

                                removeBook(idx) {
                                    this.tempBooks.splice(idx, 1);
                                },

                                processReturn(id) {
                                    // Contoh logika buat balikin buku
                                    // Kalo telat nanti munculin modal denda
                                    this.fineData = {
                                        overdue_days: 3,
                                        amount: 15000
                                    };
                                    this.showFineModal = true;
                                }
                            }">

        <!-- Page Header -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-title-md2 font-bold text-black">Layanan Sirkulasi</h2>
                <p class="text-sm text-gray-500 mt-1">Selamat datang, <span
                        class="font-semibold text-[#004236]">{{ auth()->user()->nama_pengguna }}</span></p>
            </div>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium text-gray-500" href="/petugas/dashboard">Dashboard /</a></li>
                    <li class="font-medium text-[#004236]">Sirkulasi</li>
                </ol>
            </nav>
        </div>

        {{-- ===== FITUR AKSES (Dinamis berdasarkan izin dari admin) ===== --}}
        @if($fiturAkses->isNotEmpty())
            <div class="mb-8">
                <div class="mb-3 flex items-center gap-2">
                    <div class="h-5 w-1 rounded-full bg-[#004236]"></div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Fitur yang Dapat Anda Akses</h3>
                </div>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                    {{-- KATEGORI --}}
                    @if($fiturAkses->contains('kategori'))
                        <a href="{{ route('admin.kategori.index') }}"
                            class="group relative overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-blue-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-blue-200">
                            <div class="mb-4 flex items-center justify-between">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500 shadow-sm shadow-blue-200">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <svg class="h-4 w-4 text-blue-300 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-blue-500/70">Kelola</p>
                            <p class="text-lg font-bold text-blue-800">Kategori</p>
                            @if(isset($stats['kategori']))
                                <p class="mt-1 text-2xl font-extrabold text-blue-600">{{ $stats['kategori'] }}</p>
                                <p class="text-xs text-blue-400">total kategori</p>
                            @endif
                        </a>
                    @endif

                    {{-- BUKU --}}
                    @if($fiturAkses->contains('buku'))
                        <a href="{{ route('admin.buku.index') }}"
                            class="group relative overflow-hidden rounded-2xl border border-green-100 bg-gradient-to-br from-green-50 to-green-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-green-200">
                            <div class="mb-4 flex items-center justify-between">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-500 shadow-sm shadow-green-200">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <svg class="h-4 w-4 text-green-300 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-green-500/70">Kelola</p>
                            <p class="text-lg font-bold text-green-800">Data Buku</p>
                            @if(isset($stats['buku']))
                                <p class="mt-1 text-2xl font-extrabold text-green-600">{{ $stats['buku'] }}</p>
                                <p class="text-xs text-green-400">total buku</p>
                            @endif
                        </a>
                    @endif

                    {{-- PEMINJAMAN --}}
                    @if($fiturAkses->contains('peminjaman'))
                        <a href="{{ route('admin.peminjaman.index') }}"
                            class="group relative overflow-hidden rounded-2xl border border-purple-100 bg-gradient-to-br from-purple-50 to-purple-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-purple-200">
                            <div class="mb-4 flex items-center justify-between">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-500 shadow-sm shadow-purple-200">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </div>
                                <svg class="h-4 w-4 text-purple-300 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-purple-500/70">Kelola</p>
                            <p class="text-lg font-bold text-purple-800">Peminjaman</p>
                            @if(isset($stats['peminjaman_aktif']))
                                <p class="mt-1 text-2xl font-extrabold text-purple-600">{{ $stats['peminjaman_aktif'] }}</p>
                                <p class="text-xs text-purple-400">dipinjam &bull; {{ $stats['peminjaman_booking'] ?? 0 }} booking</p>
                            @endif
                        </a>
                    @endif

                    {{-- DENDA --}}
                    @if($fiturAkses->contains('denda'))
                        <a href="{{ route('admin.denda.index') }}"
                            class="group relative overflow-hidden rounded-2xl border border-red-100 bg-gradient-to-br from-red-50 to-red-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-red-200">
                            <div class="mb-4 flex items-center justify-between">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-500 shadow-sm shadow-red-200">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <svg class="h-4 w-4 text-red-300 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-red-500/70">Kelola</p>
                            <p class="text-lg font-bold text-red-800">Denda</p>
                            @if(isset($stats['denda_belum_bayar']))
                                <p class="mt-1 text-2xl font-extrabold text-red-600">{{ $stats['denda_belum_bayar'] }}</p>
                                <p class="text-xs text-red-400">belum dibayar</p>
                            @endif
                        </a>
                    @endif

                    {{-- LAPORAN --}}
                    @if($fiturAkses->contains('laporan'))
                        <a href="{{ route('admin.laporan.index') }}"
                            class="group relative overflow-hidden rounded-2xl border border-orange-100 bg-gradient-to-br from-orange-50 to-orange-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-orange-200">
                            <div class="mb-4 flex items-center justify-between">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-500 shadow-sm shadow-orange-200">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <svg class="h-4 w-4 text-orange-300 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-orange-500/70">Lihat</p>
                            <p class="text-lg font-bold text-orange-800">Laporan</p>
                            @if(isset($stats['laporan_bulan_ini']))
                                <p class="mt-1 text-2xl font-extrabold text-orange-600">{{ $stats['laporan_bulan_ini'] }}</p>
                                <p class="text-xs text-orange-400">transaksi bulan ini</p>
                            @endif
                        </a>
                    @endif

                </div>
            </div>

            {{-- Divider --}}
            <div class="mb-6 flex items-center gap-3">
                <div class="h-5 w-1 rounded-full bg-[#004236]"></div>
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Layanan Sirkulasi Langsung</h3>
            </div>
        @endif

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
                                        <p class="text-danger">08 Jan 2024</p> <!-- Telat nih -->
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

        <!-- Modal Denda -->
        <div x-show="showFineModal"
            class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 backdrop-blur-sm"
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