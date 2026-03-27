@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Header -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-title-md2 font-bold text-black dark:text-white">Kelola Series Buku</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelompokkan buku-buku yang merupakan bagian dari
                    satu series</p>
            </div>
            <button @click="$dispatch('open-add-series-modal')"
                class="inline-flex items-center justify-center gap-2.5 rounded-xl bg-brand-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-8">
                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 4.16666V15.8333" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M4.16669 10H15.8334" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Tambah Series
            </button>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                class="mb-4 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-3 text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400">
                <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Search -->
        <div
            class="rounded-[20px] border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 xl:pb-1">
            <form method="GET" action="{{ route('admin.series.index') }}" class="mb-6 flex gap-4">
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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama series..."
                        class="w-full rounded-lg border border-stroke bg-transparent pl-12 pr-4 py-2 font-medium outline-none focus:border-primary dark:border-strokedark dark:text-white" />
                </div>
            </form>

            <!-- Grid Series Cards -->
            @if($series->isEmpty())
                <div class="py-16 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <svg class="h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p class="text-lg font-semibold text-gray-400">Belum ada series</p>
                        <p class="text-sm text-gray-400">Klik "Tambah Series" untuk membuat series buku pertama.</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
                    @foreach($series as $s)
                        <div
                            class="group relative flex flex-col rounded-2xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                            <!-- Cover Series -->
                            <div class="relative h-40 bg-linear-to-br from-indigo-500 via-purple-500 to-pink-500">
                                @if($s->sampul_series)
                                    <img src="{{ Storage::url($s->sampul_series) }}" alt="{{ $s->nama_series }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center">
                                        <svg class="h-16 w-16 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif
                                <!-- Volume badge -->
                                <div
                                    class="absolute top-3 right-3 rounded-full bg-black/60 backdrop-blur-sm px-3 py-1 text-xs font-bold text-white">
                                    {{ $s->buku_count }} vol
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="flex flex-col flex-1 p-4">
                                <h3 class="font-bold text-black dark:text-white text-base leading-tight mb-1 line-clamp-2">
                                    {{ $s->nama_series }}</h3>
                                @if($s->deskripsi)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mb-3">{{ $s->deskripsi }}</p>
                                @else
                                    <p class="text-xs text-gray-400 italic mb-3">Tidak ada deskripsi</p>
                                @endif

                                <!-- Actions -->
                                <div class="mt-auto flex items-center gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                                    <a href="{{ route('admin.series.show', $s->id_series) }}"
                                        class="flex-1 rounded-lg bg-brand-primary/10 px-3 py-1.5 text-center text-xs font-semibold text-brand-primary hover:bg-brand-primary hover:text-white transition-colors">
                                        Lihat Detail
                                    </a>
                                    <button @click="$dispatch('open-edit-series-modal', {
                                                id: '{{ $s->id_series }}',
                                                nama: '{{ addslashes($s->nama_series) }}',
                                                deskripsi: '{{ addslashes($s->deskripsi ?? '') }}'
                                            })"
                                        class="rounded-lg border border-stroke dark:border-strokedark p-1.5 hover:text-primary text-gray-500 dark:text-gray-400 transition-colors">
                                        <svg class="fill-current" width="16" height="16" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.15 1.5c-.25 0-.5.1-.7.3l-1.3 1.3 2.7 2.7 1.3-1.3c.4-.4.4-1 0-1.4l-1.3-1.3c-.2-.2-.4-.3-.7-.3zm-2.7 2.7l-9.4 9.4v2.7h2.7l9.4-9.4-2.7-2.7z"
                                                fill="currentColor" />
                                        </svg>
                                    </button>
                                    <button type="button" @click="$dispatch('open-delete-modal', {
                                                action: '{{ route('admin.series.destroy', $s->id_series) }}',
                                                title: 'Hapus Series?',
                                                message: 'Yakin ingin menghapus series \" {{ addslashes($s->nama_series) }}\"?
                                        Buku-buku yang ada dalam series ini akan dilepas dari series, tapi tidak dihapus.' })"
                                        class="rounded-lg border border-stroke dark:border-strokedark p-1.5 hover:text-danger text-gray-500 dark:text-gray-400 transition-colors">
                                        <svg class="fill-current" width="16" height="16" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.16877V14.5406C3.62852 15.75 4.6129 16.7344 5.82227 16.7344H12.1504C13.3598 16.7344 14.3441 15.75 14.3441 14.5406V6.16877C14.8785 5.9344 15.2441 5.42815 15.2441 4.8094V3.96565C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.041C10.1816 1.74377 10.2941 1.85627 10.2941 1.9969V2.47502H7.67852V1.9969ZM13.0504 14.5406C13.0504 15.0188 12.6566 15.4125 12.1785 15.4125H5.85039C5.37227 15.4125 4.97852 15.0188 4.97852 14.5406V6.45002H13.0504V14.5406ZM13.9504 4.8094C13.9504 4.9219 13.866 5.00627 13.7535 5.00627H4.21914C4.10664 5.00627 4.02227 4.9219 4.02227 4.8094V3.96565C4.02227 3.85315 4.10664 3.76877 4.21914 3.76877H13.7535C13.866 3.76877 13.9504 3.85315 13.9504 4.8094V4.8094Z"
                                                fill="currentColor" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $series->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Series Modal -->
    <div x-data="seriesModal()" x-show="isOpen" @open-add-series-modal.window="openAddModal()"
        @open-edit-series-modal.window="openEditModal($event.detail)" style="display: none;"
        class="fixed inset-0 z-999999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-5 overflow-y-auto">
        <div @click.outside="closeModal()" class="w-full max-w-lg rounded-2xl bg-white dark:bg-boxdark shadow-xl">
            <div class="px-8 py-8">
                <h3 class="mb-6 text-xl font-bold text-black dark:text-white"
                    x-text="isEdit ? 'Edit Series' : 'Tambah Series Baru'"></h3>

                <form :action="actionUrl" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                    <div class="space-y-4">
                        <div>
                            <label class="mb-2.5 block font-medium text-black dark:text-white">Nama Series <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_series" x-model="form.nama" required
                                placeholder="Contoh: Harry Potter, Bumi Manusia, dll."
                                class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                        </div>

                        <div>
                            <label class="mb-2.5 block font-medium text-black dark:text-white">Deskripsi</label>
                            <textarea name="deskripsi" x-model="form.deskripsi" rows="4"
                                placeholder="Deskripsi singkat tentang series ini..."
                                class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white resize-none"></textarea>
                        </div>

                        <div>
                            <label class="mb-2.5 block font-medium text-black dark:text-white">Sampul Series
                                (Opsional)</label>
                            <input type="file" name="sampul_series" accept="image/*"
                                class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:px-5 file:py-3 file:hover:bg-brand-primary file:hover:bg-opacity-10 focus:border-brand-primary dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white" />
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB</p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <button type="button" @click="closeModal()"
                            class="rounded border border-stroke px-6 py-2 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded bg-brand-primary px-6 py-2 font-medium text-white hover:bg-opacity-90 hover:shadow-1">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
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
                    class="flex-1 rounded-lg border border-stroke px-6 py-3 font-medium text-black hover:bg-gray-100 dark:border-strokedark dark:text-white dark:hover:bg-white/5 transition-colors">Batal</button>
                <button type="submit"
                    class="flex-1 rounded-lg bg-red-600 px-6 py-3 font-medium text-white hover:bg-red-700 shadow-md transition-colors">Ya,
                    Hapus</button>
            </form>
        </div>
    </div>

    <script>
        function seriesModal() {
            return {
                isOpen: false,
                isEdit: false,
                actionUrl: '{{ route("admin.series.store") }}',
                form: { nama: '', deskripsi: '' },

                openAddModal() {
                    this.form = { nama: '', deskripsi: '' };
                    this.isEdit = false;
                    this.actionUrl = '{{ route("admin.series.store") }}';
                    this.isOpen = true;
                },

                openEditModal(data) {
                    this.form = { nama: data.nama, deskripsi: data.deskripsi };
                    this.isEdit = true;
                    this.actionUrl = `{{ route("admin.series.update", ":id") }}`.replace(':id', data.id);
                    this.isOpen = true;
                },

                closeModal() {
                    this.isOpen = false;
                }
            }
        }

        function deleteModal() {
            return {
                isOpen: false,
                actionUrl: '',
                title: 'Hapus?',
                message: 'Yakin ingin menghapus data ini?',
                openModal(data) {
                    this.actionUrl = data.action;
                    this.title = data.title || 'Hapus?';
                    this.message = data.message || 'Yakin?';
                    this.isOpen = true;
                },
                closeModal() { this.isOpen = false; }
            }
        }
    </script>
@endsection