@extends('layouts.app')

@section('content')
    <div class="mx-auto">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Dashboard Admin</h2>
                <p class="text-sm text-gray-500 mt-1">Selamat datang, <span class="font-semibold text-[#004236]">{{ auth()->user()->nama_pengguna }}</span></p>
            </div>
            <nav>
                <ol class="flex items-center gap-2 text-sm">
                    <li><span class="text-gray-400">Admin</span></li>
                    <li class="text-gray-300">/</li>
                    <li class="font-semibold text-[#004236]">Dashboard</li>
                </ol>
            </nav>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="mb-8">
            <div class="mb-3 flex items-center gap-2">
                <div class="h-5 w-1 rounded-full bg-[#004236]"></div>
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Ringkasan Data</h3>
            </div>
            <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">

                {{-- Total Buku --}}
                <a href="{{ route('admin.buku.index') }}"
                    class="group relative overflow-hidden rounded-2xl border border-green-100 bg-gradient-to-br from-green-50 to-green-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-green-200">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-500 shadow-sm shadow-green-200">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <svg class="h-4 w-4 text-green-300 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-green-500/70">Kelola</p>
                    <p class="text-lg font-bold text-green-800">Total Buku</p>
                    <p class="mt-1 text-2xl font-extrabold text-green-600">{{ $totalBuku ?? 0 }}</p>
                    <p class="text-xs text-green-400">judul buku tersedia</p>
                </a>

                {{-- Total Anggota --}}
                <a href="{{ route('admin.verifikasi-anggota.index') }}"
                    class="group relative overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-blue-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-blue-200">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500 shadow-sm shadow-blue-200">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a5.97 5.97 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </div>
                        <svg class="h-4 w-4 text-blue-300 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-blue-500/70">Kelola</p>
                    <p class="text-lg font-bold text-blue-800">Total Anggota</p>
                    <p class="mt-1 text-2xl font-extrabold text-blue-600">{{ $totalAnggota ?? 0 }}</p>
                    <p class="text-xs text-blue-400">anggota terdaftar</p>
                </a>

                {{-- Peminjaman Aktif --}}
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="group relative overflow-hidden rounded-2xl border border-purple-100 bg-gradient-to-br from-purple-50 to-purple-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-purple-200">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-500 shadow-sm shadow-purple-200">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </div>
                        <svg class="h-4 w-4 text-purple-300 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-purple-500/70">Pantau</p>
                    <p class="text-lg font-bold text-purple-800">Peminjaman Aktif</p>
                    <p class="mt-1 text-2xl font-extrabold text-purple-600">{{ $totalPeminjaman ?? 0 }}</p>
                    <p class="text-xs text-purple-400">sedang dipinjam</p>
                </a>

                {{-- Laporan --}}
                <a href="{{ route('admin.laporan.excel') }}"
                    class="group relative overflow-hidden rounded-2xl border border-orange-100 bg-gradient-to-br from-orange-50 to-orange-100/60 p-5 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-orange-200">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-500 shadow-sm shadow-orange-200">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <svg class="h-4 w-4 text-orange-300 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-orange-500/70">Lihat</p>
                    <p class="text-lg font-bold text-orange-800">Laporan</p>
                    <p class="mt-1 text-xs text-orange-400">Lihat laporan aktivitas perpustakaan</p>
                </a>

            </div>
        </div>

        {{-- ===== RECENT PEMINJAMAN ===== --}}
        <div class="mb-3 flex items-center gap-2">
            <div class="h-5 w-1 rounded-full bg-[#004236]"></div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Peminjaman Terbaru</h3>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50 text-left">
                            <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Anggota</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Email</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Tgl Pinjam</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Tgl Kembali</th>
                            <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($latestPeminjaman as $row)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-gray-800">{{ $row->pengguna->nama_pengguna ?? 'Guest' }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm text-gray-600 truncate max-w-[200px]">{{ $row->pengguna->email ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm text-gray-600 whitespace-nowrap">{{ $row->tgl_pinjam }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm text-gray-600 whitespace-nowrap">{{ $row->tgl_kembali ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <x-status-badge :type="$row->status_transaksi" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                                            <svg class="h-6 w-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-400">Belum ada peminjaman</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection