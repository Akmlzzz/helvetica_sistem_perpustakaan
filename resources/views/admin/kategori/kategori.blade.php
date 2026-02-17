@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Kelola Kategori
            </h2>

        </div>

        @if(session('success'))
            <div
                class="mb-4 flex w-full border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1b1b24] dark:bg-opacity-30 md:p-9">
                <div class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg bg-[#34D399]">
                    <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.2984 0.826822L15.2868 0.811827L15.2741 0.797751C14.9173 0.401867 14.3238 0.400754 13.9657 0.794406L5.91818 9.54222L2.4148 5.78758L2.05284 5.41959C1.69293 5.04375 1.10842 5.0436 0.748513 5.41959C0.387113 5.79558 0.387113 6.40228 0.748513 6.77827L0.763482 6.79389L0.778451 6.80951L4.69345 10.9835L4.70842 10.9991L4.72339 10.9147C5.08323 11.2905 5.66774 11.2907 6.02758 10.9147L15.2984 0.826822Z"
                            fill="white" stroke="white"></path>
                    </svg>
                </div>
                <div class="w-full">
                    <h5 class="mb-3 text-lg font-bold text-black dark:text-[#34D399]">
                        Berhasil!
                    </h5>
                    <p class="text-base leading-relaxed text-body">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div
                class="mb-4 flex w-full border-l-6 border-[#F87171] bg-[#F87171] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1b1b24] dark:bg-opacity-30 md:p-9">
                <div class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg bg-[#F87171]">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.25 0.75H3.75C2.09315 0.75 0.75 2.09315 0.75 3.75V11.25C0.75 12.9069 2.09315 14.25 3.75 14.25H11.25C12.9069 14.25 14.25 12.9069 14.25 11.25V3.75C14.25 2.09315 12.9069 0.75 11.25 0.75ZM11.25 12.75H3.75C2.92157 12.75 2.25 12.0784 2.25 11.25V3.75C2.25 2.92157 2.92157 2.25 3.75 2.25H11.25C12.0784 2.25 12.75 2.92157 12.75 3.75V11.25C12.75 12.0784 12.0784 12.75 11.25 12.75ZM7.5 7.5L9.5 5.5L7.5 7.5ZM5.5 9.5L7.5 7.5L5.5 9.5ZM7.5 7.5L5.5 5.5L7.5 7.5ZM9.5 9.5L7.5 7.5L9.5 9.5Z"
                            fill="white" stroke="white" />
                        <path d="M5.5 5.5L9.5 9.5M9.5 5.5L5.5 9.5" stroke="white" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="w-full">
                    <h5 class="mb-3 text-lg font-bold text-black dark:text-[#F87171]">
                        Gagal!
                    </h5>
                    <p class="text-base leading-relaxed text-body">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-9 xl:grid-cols-2">
            <!-- Add Category Form -->
            <div class="flex flex-col gap-9">
                <div
                    class="rounded-[20px] border border-stroke bg-white shadow-default dark:border-gray-800 dark:bg-gray-900">
                    <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                        <h3 class="font-medium text-black dark:text-white">
                            Tambah Kategori Baru
                        </h3>
                    </div>
                    <form action="{{ route('admin.kategori.store') }}" method="POST">
                        @csrf
                        <div class="p-6.5">
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Nama Kategori <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" name="nama_kategori" placeholder="Masukkan nama kategori"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                                    required />
                                @error('nama_kategori')
                                    <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit"
                                class="flex w-full justify-center rounded-xl bg-brand-primary p-3 font-medium text-white">
                                Tambah Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Category List -->
            <div class="rounded-[20px] border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                    <h3 class="font-medium text-black dark:text-white">
                        Daftar Kategori
                    </h3>
                </div>
                <!-- Search & Filter Bar -->
                <div class="px-6.5 py-4 border-b border-stroke dark:border-strokedark">
                    <form action="{{ route('admin.kategori.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                        <div class="relative flex-1">
                            <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2">
                                <svg class="fill-current text-black dark:text-white hover:text-primary transition-colors"
                                    width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                                        fill="currentColor" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                                        fill="currentColor" />
                                </svg>
                            </button>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari Nama Kategori..."
                                class="w-full rounded-lg border border-stroke bg-transparent pl-12 pr-4 py-2 font-medium outline-none focus:border-primary dark:border-strokedark dark:text-white" />
                        </div>

                        <!-- Sort Dropdown -->
                        <div class="relative w-full sm:w-48">
                            <select name="sort" onchange="this.form.submit()"
                                class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A-Z</option>
                            </select>
                            <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                                <svg width="10" height="6" viewBox="0 0 10 6" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z"
                                        fill="currentColor" />
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="flex flex-col overflow-x-auto">
                    <div class="min-w-[600px]">
                        <div class="grid grid-cols-4 rounded-sm bg-gray-50 dark:bg-gray-800 sm:grid-cols-4">
                            <div class="p-2.5 xl:p-5">
                                <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">ID
                                </h5>
                            </div>
                            <div class="p-2.5 xl:p-5">
                                <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Nama
                                    Kategori
                                </h5>
                            </div>
                            <div class="p-2.5 text-center xl:p-5">
                                <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">
                                    Jumlah Buku</h5>
                            </div>
                            <div class="p-2.5 text-center xl:p-5">
                                <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Aksi
                                </h5>
                            </div>
                        </div>

                        @foreach($kategori as $item)
                            <div
                                class="grid grid-cols-4 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors sm:grid-cols-4">
                                <div class="flex items-center gap-3 p-2.5 xl:p-5">
                                    <p class="text-black dark:text-white">#{{ $item->id_kategori }}</p>
                                </div>

                                <div class="flex items-center justify-start p-2.5 xl:p-5">
                                    <p class="text-black dark:text-white">{{ $item->nama_kategori }}</p>
                                </div>

                                <div class="flex items-center justify-center p-2.5 xl:p-5">
                                    <span
                                        class="bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success dark:text-green-400 rounded-full">
                                        {{ $item->buku_count }} Buku
                                    </span>
                                </div>

                                <div class="flex items-center justify-center p-2.5 xl:p-5">
                                    <div class="flex items-center space-x-3.5" x-data="{ editOpen: false }">
                                        <!-- Edit Button (Triggers Modal/Inline Edit) -->
                                        <button @click="editOpen = !editOpen"
                                            class="hover:text-primary text-gray-500 dark:text-gray-400 border border-stroke dark:border-strokedark rounded-md p-1.5 transition-colors">
                                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M15.15 1.5c-.25 0-.5.1-.7.3l-1.3 1.3 2.7 2.7 1.3-1.3c.4-.4.4-1 0-1.4l-1.3-1.3c-.2-.2-.4-.3-.7-.3zm-2.7 2.7l-9.4 9.4v2.7h2.7l9.4-9.4-2.7-2.7z"
                                                    fill="currentColor" />
                                            </svg>
                                        </button>
                                        <!-- Simple Edit Modal/Form can be put here or use separate page. For now, just show name in input -->
                                        <div x-show="editOpen" @click.outside="editOpen = false"
                                            class="absolute z-50 mt-8 w-60 rounded border border-stroke bg-white p-4 shadow-default dark:border-gray-800 dark:bg-gray-900">
                                            <form action="{{ route('admin.kategori.update', $item->id_kategori) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <label class="mb-2 block text-sm font-medium text-black dark:text-white">Edit
                                                    Nama</label>
                                                <input type="text" name="nama_kategori" value="{{ $item->nama_kategori }}"
                                                    class="mb-2 w-full rounded border border-stroke px-2 py-1 outline-none dark:border-strokedark dark:bg-form-input dark:text-white">
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" @click="editOpen = false"
                                                        class="text-xs text-gray-500">Batal</button>
                                                    <button type="submit" class="text-xs text-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>

                                        <form action="{{ route('admin.kategori.destroy', $item->id_kategori) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="hover:text-danger text-gray-500 dark:text-gray-400 border border-stroke dark:border-strokedark rounded-md p-1.5 transition-colors">
                                                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.16877V14.5406C3.62852 15.75 4.6129 16.7344 5.82227 16.7344H12.1504C13.3598 16.7344 14.3441 15.75 14.3441 14.5406V6.16877C14.8785 5.9344 15.2441 5.42815 15.2441 4.8094V3.96565C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.041C10.1816 1.74377 10.2941 1.85627 10.2941 1.9969V2.47502H7.67852V1.9969ZM13.0504 14.5406C13.0504 15.0188 12.6566 15.4125 12.1785 15.4125H5.85039C5.37227 15.4125 4.97852 15.0188 4.97852 14.5406V6.45002H13.0504V14.5406ZM13.9504 4.8094C13.9504 4.9219 13.866 5.00627 13.7535 5.00627H4.21914C4.10664 5.00627 4.02227 4.9219 4.02227 4.8094V3.96565C4.02227 3.85315 4.10664 3.76877 4.21914 3.76877H13.7535C13.866 3.76877 13.9504 3.85315 13.9504 3.96565V4.8094Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M6.16875 13.1625C6.42188 13.1625 6.61875 12.9656 6.61875 12.7125V8.29687C6.61875 8.04375 6.42188 7.84688 6.16875 7.84688C5.91563 7.84688 5.71875 8.04375 5.71875 8.29687V12.7125C5.71875 12.9656 5.91563 13.1625 6.16875 13.1625Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M8.97187 13.1625C9.225 13.1625 9.42188 12.9656 9.42188 12.7125V8.29687C9.42188 8.04375 9.225 7.84688 8.97187 7.84688C8.71875 7.84688 8.52188 8.04375 8.52188 8.29687V12.7125C8.52188 12.9656 8.71875 13.1625 8.97187 13.1625Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M11.7844 13.1625C12.0375 13.1625 12.2344 12.9656 12.2344 12.7125V8.29687C12.2344 8.04375 12.0375 7.84688 11.7844 7.84688C11.5312 7.84688 11.3344 8.04375 11.3344 8.29687V12.7125C11.3344 12.9656 11.5312 13.1625 11.7844 13.1625Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection