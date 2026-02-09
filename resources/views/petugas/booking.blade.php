@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-10">
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Validasi Booking
                </h3>
            </div>

            <div class="p-6.5">
                <!-- Search -->
                <div class="mb-6">
                    <form action="#" method="GET" class="relative">
                        <input type="text" placeholder="Cari Kode Booking..."
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
                                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                                    Kode Booking
                                </th>
                                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                                    Member
                                </th>
                                <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white">
                                    Buku
                                </th>
                                <th class="py-4 px-4 font-medium text-black dark:text-white">
                                    Tgl Booking
                                </th>
                                <th class="py-4 px-4 font-medium text-black dark:text-white">
                                    Expired
                                </th>
                                <th class="py-4 px-4 font-medium text-black dark:text-white">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Mock Data -->
                            <tr>
                                <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 class="font-bold text-black dark:text-white">BK-231088</h5>
                                </td>
                                <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p class="text-black dark:text-white">Siti Aminah</p>
                                </td>
                                <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p class="text-black dark:text-white">Algoritma Pemrograman</p>
                                </td>
                                <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p class="text-black dark:text-white">09 Feb 2026</p>
                                </td>
                                <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <p class="text-warning">14:00 (1 Jam lagi)</p>
                                </td>
                                <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                    <div class="flex items-center space-x-3.5">
                                        <button
                                            class="inline-flex items-center justify-center rounded-md bg-meta-3 py-2 px-4 text-center font-medium text-white hover:bg-opacity-90 lg:px-4 xl:px-4">
                                            Validasi & Serahkan
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
@endsection