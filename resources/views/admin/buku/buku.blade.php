@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Header Section -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Kelola Data Buku
            </h2>
            <div class="flex items-center gap-3">
                <button @click="$dispatch('open-add-book-modal')"
                    class="inline-flex items-center justify-center gap-2.5 rounded-xl bg-brand-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-8">
                    <span>
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 4.16666V15.8333" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M4.16669 10H15.8334" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </span>
                    Tambah Buku
                </button>
            </div>
        </div>

        <!-- Alert Messages -->
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
                    <h5 class="mb-3 text-lg font-bold text-black dark:text-[#34D399]">Berhasil!</h5>
                    <p class="text-base leading-relaxed text-body">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Search & Filter -->
        <div
            class="rounded-[20px] border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 xl:pb-1">
            <form method="GET" action="{{ route('admin.buku.index') }}"
                class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center">

                <!-- Search Bar -->
                <div class="relative w-full sm:w-1/2">
                    <button class="absolute left-4 top-1/2 -translate-y-1/2">
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
                        placeholder="Cari Judul, Penulis, atau ISBN..."
                        class="w-full rounded-lg border border-stroke bg-transparent pl-12 pr-4 py-2 font-medium outline-none focus:border-primary dark:border-strokedark dark:text-white xl:w-125" />
                </div>

                <!-- Filter Categories -->
                <div class="w-full sm:w-1/4">
                    <select name="kategori" onchange="this.form.submit()"
                        class="relative z-20 w-full appearance-none rounded border py-2 pl-4 pr-10 outline-none transition {{ request('kategori') ? 'border-brand-primary bg-brand-primary/5 dark:bg-brand-primary/10' : 'border-stroke bg-transparent' }} focus:border-brand-primary active:border-brand-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">
                        <option value="" class="text-gray-700 dark:text-white dark:bg-gray-800">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }} class="text-gray-700 dark:text-white dark:bg-gray-800">
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            <!-- Table Section with Responsive Scroll -->
            <div class="flex flex-col overflow-x-auto">
                <div class="min-w-[1000px]">
                    <div class="grid grid-cols-6 rounded-sm bg-gray-50 dark:bg-gray-800 sm:grid-cols-6">
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Sampul
                            </h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Judul &
                                ISBN</h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Penulis
                            </h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Stok</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Lokasi
                            </h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Aksi</h5>
                        </div>
                    </div>

                    @foreach($buku as $item)
                        <div
                            class="grid grid-cols-6 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors sm:grid-cols-6">
                            <!-- Sampul -->
                            <div class="flex items-center p-2.5 xl:p-5">
                                <div class="h-15 w-10 overflow-hidden rounded-md bg-gray-200">
                                    @if($item->sampul)
                                        <img src="{{ Storage::url($item->sampul) }}" alt="Sampul"
                                            class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-xs text-gray-500">No Image
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Judul & ISBN -->
                            <div class="flex flex-col justify-center p-2.5 xl:p-5">
                                <p class="font-bold text-black dark:text-white">{{ $item->judul_buku }}</p>
                                <p class="text-xs text-gray-500">ISBN: {{ $item->isbn ?? '-' }}</p>
                                @if($item->kategori)
                                    <span
                                        class="mt-1 inline-block rounded bg-gray-200 px-2 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                        {{ $item->kategori->nama_kategori }}
                                    </span>
                                @endif
                            </div>

                            <!-- Penulis -->
                            <div class="flex items-center p-2.5 xl:p-5">
                                <div>
                                    <p class="text-sm text-black dark:text-white">{{ $item->penulis ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->penerbit ?? '' }}</p>
                                </div>
                            </div>

                            <!-- Stok -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <span
                                    class="inline-flex rounded-full bg-opacity-10 px-3 py-1 text-sm font-medium {{ $item->stok > 0 ? 'bg-success text-success dark:text-green-400' : 'bg-danger text-danger dark:text-red-400' }}">
                                    {{ $item->stok }}
                                </span>
                            </div>

                            <!-- Lokasi -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="text-sm text-black dark:text-white">{{ $item->lokasi_rak ?? '-' }}</p>
                            </div>

                            <!-- Aksi -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <div class="flex items-center space-x-3.5" x-data="{ editOpen: false }">
                                    <button @click="$dispatch('open-edit-book-modal', { 
                                                                                                id: '{{ $item->id_buku }}',
                                                                                                judul: '{{ addslashes($item->judul_buku) }}',
                                                                                                isbn: '{{ $item->isbn }}',
                                                                                                penulis: '{{ addslashes($item->penulis) }}',
                                                                                                penerbit: '{{ addslashes($item->penerbit) }}',
                                                                                                stok: '{{ $item->stok }}',
                                                                                                kategori: '{{ $item->id_kategori }}',
                                                                                                lokasi: '{{ addslashes($item->lokasi_rak) }}'
                                                                                             })"
                                        class="hover:text-primary text-gray-500 dark:text-gray-400 border border-stroke dark:border-strokedark rounded-md p-1.5 transition-colors">
                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.15 1.5c-.25 0-.5.1-.7.3l-1.3 1.3 2.7 2.7 1.3-1.3c.4-.4.4-1 0-1.4l-1.3-1.3c-.2-.2-.4-.3-.7-.3zm-2.7 2.7l-9.4 9.4v2.7h2.7l9.4-9.4-2.7-2.7z"
                                                fill="currentColor" />
                                        </svg>
                                    </button>
                                    <a href="#"
                                        class="hover:text-primary text-gray-500 dark:text-gray-400 border border-stroke dark:border-strokedark rounded-md p-1.5 transition-colors"
                                        title="Cetak Barcode">
                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3 7V5a2 2 0 012-2h2m10 0h2a2 2 0 012 2v2m0 10v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M7 9v6M10 9v6M14 9v6M17 9v6" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.buku.destroy', $item->id_buku) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
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

            <div class="mt-4">
                {{ $buku->links() }}
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit Book -->
    <div x-data="bookModal()" x-show="isOpen" @open-add-book-modal.window="openAddModal()"
        @open-edit-book-modal.window="openEditModal($event.detail)" style="display: none;"
        class="fixed inset-0 z-999999 flex items-center justify-center bg-black/90 px-4 py-5">
        <div @click.outside="closeModal()"
            class="w-full max-w-lg rounded-lg bg-white px-8 py-12 dark:bg-boxdark md:px-17.5 md:py-15">
            <h3 class="mb-4 text-xl font-bold text-black dark:text-white"
                x-text="isEdit ? 'Edit Data Buku' : 'Tambah Buku Baru'"></h3>

            <form :action="actionUrl" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                <div class="mb-4">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Judul Buku <span
                            class="text-meta-1">*</span></label>
                    <input type="text" name="judul_buku" x-model="form.judul" required
                        class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary" />
                </div>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2.5 block font-medium text-black dark:text-white">ISBN</label>
                        <input type="text" name="isbn" x-model="form.isbn"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Kategori</label>
                        <select name="id_kategori" x-model="form.kategori"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Penulis</label>
                        <input type="text" name="penulis" x-model="form.penulis"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Penerbit</label>
                        <input type="text" name="penerbit" x-model="form.penerbit"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                    </div>
                </div>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Stok <span
                                class="text-meta-1">*</span></label>
                        <input type="number" name="stok" x-model="form.stok" required min="0"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Lokasi Rak</label>
                        <input type="text" name="lokasi_rak" x-model="form.lokasi"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                    </div>
                </div>

                <div class="mb-6">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Sampul Buku</label>
                    <input type="file" name="sampul"
                        class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:px-5 file:py-3 file:hover:bg-brand-primary file:hover:bg-opacity-10 focus:border-brand-primary active:border-brand-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-brand-primary" />
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" @click="closeModal()"
                        class="rounded border border-stroke px-6 py-2 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                        Batal
                    </button>
                    <button type="submit" class="rounded bg-brand-primary px-6 py-2 font-medium text-white hover:shadow-1">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function bookModal() {
            return {
                isOpen: false,
                isEdit: false,
                actionUrl: '',
                form: {
                    judul: '',
                    isbn: '',
                    penulis: '',
                    penerbit: '',
                    stok: '',
                    kategori: '',
                    lokasi: ''
                },
                openAddModal() {
                    this.isEdit = false;
                    this.actionUrl = "{{ route('admin.buku.store') }}";
                    this.resetForm();
                    this.isOpen = true;
                },
                openEditModal(data) {
                    this.isEdit = true;
                    this.actionUrl = "{{ route('admin.buku.index') }}/" + data.id;
                    this.form = {
                        judul: data.judul,
                        isbn: data.isbn,
                        penulis: data.penulis,
                        penerbit: data.penerbit,
                        stok: data.stok,
                        kategori: data.kategori,
                        lokasi: data.lokasi
                    };
                    this.isOpen = true;
                },
                closeModal() {
                    this.isOpen = false;
                },
                resetForm() {
                    this.form = {
                        judul: '',
                        isbn: '',
                        penulis: '',
                        penerbit: '',
                        stok: '',
                        kategori: '',
                        lokasi: ''
                    };
                }
            }
        }
    </script>

@endsection