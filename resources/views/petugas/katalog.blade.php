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
                            <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                <th class="min-w-[50px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                                    No
                                </th>
                                <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white">
                                    Judul Buku
                                </th>
                                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                                    ISBN
                                </th>
                                <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                                    Kategori
                                </th>
                                <th class="py-4 px-4 font-medium text-black dark:text-white">
                                    Stok
                                </th>
                                <!-- Assuming 'lokasi_rak' might be added later to DB, using mock for now or displaying generic location if field doesn't exist -->
                                <th class="py-4 px-4 font-medium text-black dark:text-white">
                                    Lokasi Rak
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($buku as $item)
                                <tr>
                                    <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                        <p class="text-black dark:text-white">
                                            {{ $loop->iteration + ($buku->currentPage() - 1) * $buku->perPage() }}
                                        </p>
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <h5 class="font-medium text-black dark:text-white">{{ $item->judul }}</h5>
                                        <p class="text-sm text-gray-500">{{ $item->penulis }}</p>
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p class="text-black dark:text-white">{{ $item->isbn }}</p>
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p
                                            class="inline-flex rounded-full bg-primary bg-opacity-10 py-1 px-3 text-sm font-medium text-primary">
                                            {{ $item->kategori->nama_kategori ?? '-' }}
                                        </p>
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p class="text-black dark:text-white">{{ $item->stok }}</p>
                                    </td>
                                    <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                        <p class="text-black dark:text-white">Rak A-01</p> <!-- Mock Data -->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">Tidak ada data buku ditemukan.</td>
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