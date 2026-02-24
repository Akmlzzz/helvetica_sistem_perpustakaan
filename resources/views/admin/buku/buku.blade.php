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

        <!-- Search & Filter -->
        <div
            class="rounded-[20px] border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 xl:pb-1">
            <form method="GET" action="{{ route('admin.buku.index') }}"
                class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center">

                <!-- Search Bar -->
                <div class="relative flex-1">
                    <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2">
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
                        placeholder="Cari Judul, Penulis, Sinopsis, atau ISBN..."
                        class="w-full rounded-lg border border-stroke bg-transparent pl-12 pr-4 py-2 font-medium outline-none focus:border-primary dark:border-strokedark dark:text-white" />
                </div>

                <!-- Filter Categories -->
                <div class="relative w-full sm:w-48">
                    <select name="kategori" onchange="this.form.submit()"
                        class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                        <option value="" class="text-gray-500">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort Filter -->
                <div class="relative w-full sm:w-48">
                    <select name="sort" onchange="this.form.submit()"
                        class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A-Z</option>
                    </select>
                </div>
            </form>

            <!-- Table Section with Responsive Scroll -->
            <div class="flex flex-col overflow-x-auto">
                <div class="min-w-[1200px]">
                    <div class="grid grid-cols-8 rounded-sm bg-gray-50 dark:bg-gray-800 sm:grid-cols-8">
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Sampul</h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Judul & ISBN</h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Penulis</h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Sinopsis</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Halaman</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Stok</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Lokasi</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Aksi</h5>
                        </div>
                    </div>

                    @forelse($buku as $item)
                        <div class="grid grid-cols-8 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors sm:grid-cols-8">
                            <!-- Sampul -->
                            <div class="flex items-center p-2.5 xl:p-5">
                                <div class="h-15 w-10 overflow-hidden rounded-md bg-gray-200">
                                    @if($item->sampul)
                                        <img src="{{ Storage::url($item->sampul) }}" alt="Sampul"
                                            class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-xs text-gray-500">No Image</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Judul & ISBN -->
                            <div class="flex flex-col justify-center p-2.5 xl:p-5">
                                <p class="font-bold text-black dark:text-white">{{ $item->judul_buku }}</p>
                                <p class="text-xs text-gray-500">ISBN: {{ $item->isbn ?? '-' }}</p>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($item->kategori as $kat)
                                        <span class="inline-block rounded bg-gray-200 px-2 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                            {{ $kat->nama_kategori }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Penulis -->
                            <div class="flex items-center p-2.5 xl:p-5">
                                <div>
                                    <p class="text-sm text-black dark:text-white">{{ $item->penulis ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->penerbit ?? '' }}</p>
                                </div>
                            </div>

                            <!-- Sinopsis -->
                            <div class="flex items-center p-2.5 xl:p-5">
                                <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-3">
                                    {{ $item->sinopsis_preview ?? '-' }}
                                </p>
                            </div>

                            <!-- Halaman -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="text-sm text-black dark:text-white">{{ $item->jumlah_halaman ?? '-' }}</p>
                            </div>

                            <!-- Stok -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <span class="inline-flex rounded-full bg-opacity-10 px-3 py-1 text-sm font-medium {{ $item->stok > 0 ? 'bg-success text-success dark:text-green-400' : 'bg-danger text-danger dark:text-red-400' }}">
                                    {{ $item->stok }}
                                </span>
                            </div>

                            <!-- Lokasi -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="text-sm text-black dark:text-white">{{ $item->lokasi_rak ?? '-' }}</p>
                            </div>

                            <!-- Aksi -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <div class="flex items-center space-x-3.5">
                                    <button @click="$dispatch('open-edit-book-modal', { 
                                        id: '{{ $item->id_buku }}',
                                        judul: '{{ addslashes($item->judul_buku) }}',
                                        isbn: '{{ $item->isbn }}',
                                        penulis: '{{ addslashes($item->penulis) }}',
                                        penerbit: '{{ addslashes($item->penerbit) }}',
                                        stok: '{{ $item->stok }}',
                                        sinopsis: '{{ addslashes($item->sinopsis ?? '') }}',
                                        jumlah_halaman: '{{ $item->jumlah_halaman ?? '' }}',
                                        tahun_terbit: '{{ $item->tahun_terbit ?? '' }}',
                                        bahasa: '{{ $item->bahasa ?? '' }}',
                                        kategori: {{ $item->kategori->pluck('id_kategori') }},
                                        lokasi: '{{ addslashes($item->lokasi_rak) }}'
                                    })" class="hover:text-primary text-gray-500 dark:text-gray-400 border border-stroke dark:border-strokedark rounded-md p-1.5 transition-colors">
                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.15 1.5c-.25 0-.5.1-.7.3l-1.3 1.3 2.7 2.7 1.3-1.3c.4-.4.4-1 0-1.4l-1.3-1.3c-.2-.2-.4-.3-.7-.3zm-2.7 2.7l-9.4 9.4v2.7h2.7l9.4-9.4-2.7-2.7z" fill="currentColor" />
                                        </svg>
                                    </button>
                                    <a href="{{ route('admin.buku.show', $item->id_buku) }}" class="hover:text-primary text-gray-500 dark:text-gray-400 border border-stroke dark:border-strokedark rounded-md p-1.5 transition-colors" title="Detail">
                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                    <button type="button" @click="$dispatch('open-delete-modal', { action: '{{ route('admin.buku.destroy', $item->id_buku) }}', title: 'Hapus Buku?', message: 'Yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.' })" class="hover:text-danger text-gray-500 dark:text-gray-400 border border-stroke dark:border-strokedark rounded-md p-1.5 transition-colors">
                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.16877V14.5406C3.62852 15.75 4.6129 16.7344 5.82227 16.7344H12.1504C13.3598 16.7344 14.3441 15.75 14.3441 14.5406V6.16877C14.8785 5.9344 15.2441 5.42815 15.2441 4.8094V3.96565C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.041C10.1816 1.74377 10.2941 1.85627 10.2941 1.9969V2.47502H7.67852V1.9969ZM13.0504 14.5406C13.0504 15.0188 12.6566 15.4125 12.1785 15.4125H5.85039C5.37227 15.4125 4.97852 15.0188 4.97852 14.5406V6.45002H13.0504V14.5406ZM13.9504 4.8094C13.9504 4.9219 13.866 5.00627 13.7535 5.00627H4.21914C4.10664 5.00627 4.02227 4.9219 4.02227 4.8094V3.96565C4.02227 3.85315 4.10664 3.76877 4.21914 3.76877H13.7535C13.866 3.76877 13.9504 3.85315 13.9504 4.8094V4.8094Z" fill="currentColor" />
                                            <path d="M6.16875 13.1625C6.42188 13.1625 6.61875 12.9656 6.61875 12.7125V8.29687C6.61875 8.04375 6.42188 7.84688 6.16875 7.84688C5.91563 7.84688 5.71875 8.04375 5.71875 8.29687V12.7125C5.71875 12.9656 5.91563 13.1625 6.16875 13.1625Z" fill="currentColor" />
                                            <path d="M8.97187 13.1625C9.225 13.1625 9.42188 12.9656 9.42188 12.7125V8.29687C9.42188 8.04375 9.225 7.84688 8.97187 7.84688C8.71875 7.84688 8.52188 8.04375 8.52188 8.29687V12.7125C8.52188 12.9656 8.71875 13.1625 8.97187 13.1625Z" fill="currentColor" />
                                            <path d="M11.7844 13.1625C12.0375 13.1625 12.2344 12.9656 12.2344 12.7125V8.29687C12.2344 8.04375 12.0375 7.84688 11.7844 7.84688C11.5312 7.84688 11.3344 8.04375 11.3344 8.29687V12.7125C11.3344 12.9656 11.5312 13.1625 11.7844 13.1625Z" fill="currentColor" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-8 p-10 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <p class="text-gray-500 font-medium">Buku tidak ditemukan.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4">
                {{ $buku->links() }}
            </div>
        </div>
    </div>

    <!-- Include Modal and Scripts -->
    @include('admin.buku.partials.modal')

    <!-- Modal Konfirmasi Hapus -->
    <div x-data="deleteModal()" x-show="isOpen" @open-delete-modal.window="openModal($event.detail)" style="display: none;"
        class="fixed inset-0 z-999999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-5 overflow-y-auto">
        <div @click.outside="closeModal()"
            class="w-full max-w-md rounded-lg bg-white px-8 py-10 dark:bg-boxdark md:px-10 md:py-12 text-center">
            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                <svg class="h-10 w-10 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <h3 class="mb-4 text-xl font-bold text-black dark:text-white" x-text="title"></h3>
            <p class="mb-10 text-gray-500 dark:text-gray-400" x-text="message"></p>

            <form :action="actionUrl" method="POST" class="flex items-center justify-center gap-4">
                @csrf
                @method('DELETE')
                <button type="button" @click="closeModal()"
                    class="flex-1 rounded-lg border border-stroke px-6 py-3 font-medium text-black hover:bg-gray-100 dark:border-strokedark dark:text-white dark:hover:bg-white/5 transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 rounded-lg bg-red-600 px-6 py-3 font-medium text-white hover:bg-red-700 shadow-md transition-colors">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    <script>
        function deleteModal() {
            return {
                isOpen: false,
                actionUrl: '',
                title: 'Hapus?',
                message: 'Yakin ingin menghapus data ini?',
                openModal(data) {
                    this.actionUrl = data.action;
                    this.title = data.title || 'Hapus Buku?';
                    this.message = data.message || 'Yakin ingin menghapus buku ini?';
                    this.isOpen = true;
                },
                closeModal() {
                    this.isOpen = false;
                }
            }
        }
    </script>
@endsection
