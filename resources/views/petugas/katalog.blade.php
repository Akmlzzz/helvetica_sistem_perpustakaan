@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-10">
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Cek Stok & Lokasi Rak
                </h3>
            </div>
            <div class="p-6.5">
                <!-- Search -->
                <div class="mb-6">
                    <form action="{{ route('petugas.katalog') }}" method="GET" class="relative">
                        <input type="text" name="search" placeholder="Cari Judul, Penulis, atau ISBN..."
                            value="{{ request('search') }}"
                            class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent py-3 pl-12 pr-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                        <span class="absolute left-4 top-3.5">
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.7499 14.3332L21.4166 19.9999L19.9999 21.4166L14.3332 15.7499C13.0666 16.7332 11.4925 17.3332 9.74992 17.3332C5.55825 17.3332 2.16659 13.9416 2.16659 9.74992C2.16659 5.55825 5.55825 2.16659 9.74992 2.16659C13.9416 2.16659 17.3332 5.55825 17.3332 9.74992C17.3332 11.4925 16.7332 13.0666 15.7499 14.3332ZM9.74992 4.16659C6.66659 4.16659 4.16659 6.66659 4.16659 9.74992C4.16659 12.8333 6.66659 15.3333 9.74992 15.3333C12.8333 15.3333 15.3333 12.8333 15.3333 9.74992C15.3333 6.66659 12.8333 4.16659 9.74992 4.16659Z"
                                    fill="#637381" />
                            </svg>
                        </span>
                    </form>
                </div>

                <!-- Table -->
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="border-b-2 border-gray-100 text-left dark:border-strokedark">
                                <th class="w-[60px] py-3 px-5 text-sm font-semibold text-gray-600 dark:text-gray-300">
                                    No
                                </th>
                                <th class="min-w-[220px] py-3 px-5 text-sm font-semibold text-gray-600 dark:text-gray-300">
                                    Judul Buku
                                </th>
                                <th class="min-w-[150px] py-3 px-5 text-sm font-semibold text-gray-600 dark:text-gray-300">
                                    ISBN
                                </th>
                                <th class="min-w-[120px] py-3 px-5 text-sm font-semibold text-gray-600 dark:text-gray-300">
                                    Kategori
                                </th>
                                <th class="min-w-[80px] py-3 px-5 text-sm font-semibold text-gray-600 dark:text-gray-300 text-center">
                                    Stok
                                </th>
                                <th class="min-w-[120px] py-3 px-5 text-sm font-semibold text-gray-600 dark:text-gray-300 text-center">
                                    Lokasi Rak
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($buku as $item)
                                <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-meta-4">
                                    <td class="border-b border-gray-100 py-4 px-5 text-sm text-gray-600 dark:border-strokedark dark:text-white">
                                        {{ $loop->iteration + ($buku->currentPage() - 1) * $buku->perPage() }}
                                    </td>
                                    <td class="border-b border-gray-100 py-4 px-5 dark:border-strokedark">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-800 dark:text-white">{{ $item->judul_buku }}</span>
                                            <span class="text-xs text-gray-500 mt-0.5">{{ $item->penulis }}</span>
                                        </div>
                                    </td>
                                    <td class="border-b border-gray-100 py-4 px-5 text-sm text-gray-600 dark:border-strokedark dark:text-white font-mono">
                                        {{ $item->isbn ?? '-' }}
                                    </td>
                                    <td class="border-b border-gray-100 py-4 px-5 dark:border-strokedark">
                                        <span class="inline-flex items-center justify-center rounded-full bg-[#E8F3EE] px-3 py-1.5 text-xs font-bold text-[#004236] dark:bg-[#004236]/30 dark:text-emerald-300 ring-1 ring-[#004236]/10">
                                            {{ $item->kategori->first()?->nama_kategori ?? 'Tidak Ada' }}
                                        </span>
                                    </td>
                                    <td class="border-b border-gray-100 py-4 px-5 text-center dark:border-strokedark">
                                        <span class="inline-flex items-center justify-center font-bold {{ $item->stok > 0 ? 'text-gray-800 dark:text-white' : 'text-red-500' }}">
                                            {{ $item->stok }}
                                        </span>
                                    </td>
                                    <td class="border-b border-gray-100 py-4 px-5 text-center text-sm font-medium text-gray-600 dark:border-strokedark dark:text-white">
                                        {{ $item->lokasi_rak ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="h-10 w-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            Tidak ada data buku ditemukan.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $buku->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection