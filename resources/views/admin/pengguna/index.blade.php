@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Header Section -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Kelola Pengguna
            </h2>
            <div class="flex items-center gap-3">
                <button @click="$dispatch('open-user-modal')"
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
                    Tambah Pengguna
                </button>
            </div>
        </div>

        <!-- Alert Messages -->

        @if($errors->any())
            <div
                class="mb-4 flex w-full border-l-6 border-meta-1 bg-meta-1 bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1b1b24] dark:bg-opacity-30 md:p-9">
                <div class="w-full">
                    <h5 class="mb-3 text-lg font-bold text-meta-1">Terjadi Kesalahan!</h5>
                    <ul class="list-disc list-inside text-base leading-relaxed text-body">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Search & Filter -->
        <div
            class="rounded-[20px] border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 xl:pb-1">
            <form method="GET" action="{{ route('admin.pengguna.index') }}"
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
                        placeholder="Cari Nama Pengguna, Email, atau Nama Lengkap..."
                        class="w-full rounded-lg border border-stroke bg-transparent pl-12 pr-4 py-2 font-medium outline-none focus:border-primary dark:border-strokedark dark:text-white" />
                </div>

                <!-- Role Filter -->
                <div class="relative w-full sm:w-48">
                    <select name="role" onchange="this.form.submit()"
                        class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                        <option value="" class="text-gray-500">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="anggota" {{ request('role') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z"
                                fill="currentColor" />
                        </svg>
                    </div>
                </div>

                <!-- Sort Filter -->
                <div class="relative w-full sm:w-48">
                    <select name="sort" onchange="this.form.submit()"
                        class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A-Z (Username)</option>
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z"
                                fill="currentColor" />
                        </svg>
                    </div>
                </div>
            </form>

            <div class="flex flex-col overflow-x-auto">
                <div class="min-w-[1000px]">
                    <div class="grid grid-cols-5 rounded-sm bg-gray-50 dark:bg-gray-800">
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Pengguna
                            </h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Email
                            </h5>
                        </div>
                        <div class="p-2.5 xl:p-5 text-center">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Level
                            </h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Nama
                                Lengkap</h5>
                        </div>
                        <div class="p-2.5 xl:p-5 text-center">
                            <h5 class="text-sm font-bold uppercase xsm:text-base text-gray-500 dark:text-gray-400">Aksi</h5>
                        </div>
                    </div>

                    @forelse($users as $user)
                        <div
                            class="grid grid-cols-5 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                            <div class="flex items-center p-2.5 xl:p-5">
                                <p class="font-bold text-black dark:text-white">{{ $user->nama_pengguna }}</p>
                            </div>
                            <div class="flex items-center p-2.5 xl:p-5">
                                <p class="text-sm text-black dark:text-white">{{ $user->email }}</p>
                            </div>
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <x-status-badge :type="$user->level_akses" />
                            </div>
                            <div class="flex items-center p-2.5 xl:p-5">
                                <p class="text-sm text-black dark:text-white">{{ $user->anggota->nama_lengkap ?? '-' }}</p>
                            </div>
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <div class="flex items-center space-x-3.5">
                                    <button
                                        @click="$dispatch('open-user-modal', { 
                                                                                                                                                                                                        id: '{{ $user->id_pengguna }}',
                                                                                                                                                                                                        nama_pengguna: '{{ $user->nama_pengguna }}',
                                                                                                                                                                                                        email: '{{ $user->email }}',
                                                                                                                                                                                                        level_akses: '{{ $user->level_akses }}',
                                                                                                                                                                                                        nama_lengkap: '{{ addslashes($user->anggota->nama_lengkap ?? '') }}',
                                                                                                                                                                                                        alamat: '{{ addslashes($user->anggota->alamat ?? '') }}',
                                                                                                                                                                                                        nomor_telepon: '{{ $user->anggota->nomor_telepon ?? '' }}'
                                                                                                                                                                                                    })"
                                        class="hover:text-primary text-gray-500 dark:text-gray-400 border border-stroke dark:border-strokedark rounded-md p-1.5 transition-colors">
                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.15 1.5c-.25 0-.5.1-.7.3l-1.3 1.3 2.7 2.7 1.3-1.3c.4-.4.4-1 0-1.4l-1.3-1.3c-.2-.2-.4-.3-.7-.3zm-2.7 2.7l-9.4 9.4v2.7h2.7l9.4-9.4-2.7-2.7z"
                                                fill="currentColor" />
                                        </svg>
                                    </button>
                                    @if(auth()->id() != $user->id_pengguna)
                                        <button type="button"
                                            @click="$dispatch('open-delete-modal', { action: '{{ route('admin.pengguna.destroy', $user->id_pengguna) }}' })"
                                            class="hover:text-danger text-gray-500 dark:text-gray-400 border border-stroke dark:border-strokedark rounded-md p-1.5 transition-colors">
                                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.16877V14.5406C3.62852 15.75 4.6129 16.7344 5.82227 16.7344H12.1504C13.3598 16.7344 14.3441 15.75 14.3441 14.5406V6.16877C14.8785 5.9344 15.2441 5.42815 15.2441 4.8094V3.96565C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.041C10.1816 1.74377 10.2941 1.85627 10.2941 1.9969V2.47502H7.67852V1.9969ZM13.0504 14.5406C13.0504 15.0188 12.6566 15.4125 12.1785 15.4125H5.85039C5.37227 15.4125 4.97852 15.0188 4.97852 14.5406V6.45002H13.0504V14.5406ZM13.9504 4.8094C13.9504 4.9219 13.866 5.00627 13.7535 5.00627H4.21914C4.10664 5.00627 4.02227 4.9219 4.02227 4.8094V3.96565C4.02227 3.85315 4.10664 3.76877 4.21914 3.76877H13.7535C13.866 3.76877 13.9504 3.85315 13.9504 3.96565V4.8094Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-5 p-10 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                <p class="text-gray-500 font-medium">Pengguna tidak ditemukan.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4 px-4 pb-4 sm:px-7.5">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit User -->
    <div x-data="userModal()" x-show="isOpen" @open-user-modal.window="openModal($event.detail)" style="display: none;"
        class="fixed inset-0 z-999999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-5 overflow-y-auto">
        <div @click.outside="closeModal()"
            class="w-full max-w-2xl rounded-lg bg-white px-8 py-10 dark:bg-boxdark md:px-12 md:py-10 my-10">
            <h3 class="mb-6 text-2xl font-bold text-black dark:text-white"
                x-text="isEdit ? 'Edit Pengguna' : 'Tambah Pengguna Baru'"></h3>

            <form :action="actionUrl" method="POST">
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Nama Pengguna <span
                                class="text-meta-1">*</span></label>
                        <input type="text" name="nama_pengguna" x-model="form.nama_pengguna" required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Email <span
                                class="text-meta-1">*</span></label>
                        <input type="email" name="email" x-model="form.email" required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Level Akses <span
                                class="text-meta-1">*</span></label>
                        <select name="level_akses" x-model="form.level_akses" required
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white">
                            <option value="anggota">Anggota</option>
                            <option value="petugas">Petugas</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Kata Sandi <span x-show="!isEdit"
                                class="text-meta-1">*</span></label>
                        <input type="password" name="kata_sandi" :required="!isEdit"
                            :placeholder="isEdit ? 'Kosongkan jika tidak ingin mengubah' : ''"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                    </div>
                </div>

                <!-- Member Specific Fields -->
                <div x-show="form.level_akses === 'anggota'"
                    class="border-t border-stroke dark:border-strokedark pt-4 mt-4">
                    <h4 class="mb-4 text-lg font-semibold text-black dark:text-white">Data Profil Anggota</h4>
                    <div class="mb-4">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Nama Lengkap <span
                                class="text-meta-1">*</span></label>
                        <input type="text" name="nama_lengkap" x-model="form.nama_lengkap"
                            :required="form.level_akses === 'anggota'"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="mb-2.5 block font-medium text-black dark:text-white">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon" x-model="form.nomor_telepon"
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                        </div>
                        <div>
                            <label class="mb-2.5 block font-medium text-black dark:text-white">Alamat</label>
                            <input type="text" name="alamat" x-model="form.alamat"
                                class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" @click="closeModal()"
                        class="rounded border border-stroke px-6 py-2 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">Batal</button>
                    <button type="submit"
                        class="rounded bg-brand-primary px-6 py-2 font-medium text-white hover:shadow-1">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Delete Confirmation Modal -->
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
            <h3 class="mb-4 text-xl font-bold text-black dark:text-white">Hapus Pengguna?</h3>
            <p class="mb-10 text-gray-500 dark:text-gray-400">Yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat
                dibatalkan.</p>

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
        function userModal() {
            return {
                isOpen: false,
                isEdit: false,
                actionUrl: '',
                form: {
                    nama_pengguna: '',
                    email: '',
                    level_akses: 'anggota',
                    nama_lengkap: '',
                    alamat: '',
                    nomor_telepon: ''
                },
                openModal(data) {
                    if (data && data.id) {
                        this.isEdit = true;
                        this.actionUrl = "{{ route('admin.pengguna.index') }}/" + data.id;
                        this.form = {
                            nama_pengguna: data.nama_pengguna,
                            email: data.email,
                            level_akses: data.level_akses,
                            nama_lengkap: data.nama_lengkap,
                            alamat: data.alamat,
                            nomor_telepon: data.nomor_telepon
                        };
                    } else {
                        this.isEdit = false;
                        this.actionUrl = "{{ route('admin.pengguna.store') }}";
                        this.resetForm();
                    }
                    this.isOpen = true;
                },
                closeModal() {
                    this.isOpen = false;
                },
                resetForm() {
                    this.form = {
                        nama_pengguna: '',
                        email: '',
                        level_akses: 'anggota',
                        nama_lengkap: '',
                        alamat: '',
                        nomor_telepon: ''
                    };
                }
            }
        }

        function deleteModal() {
            return {
                isOpen: false,
                actionUrl: '',
                openModal(data) {
                    this.actionUrl = data.action;
                    this.isOpen = true;
                },
                closeModal() {
                    this.isOpen = false;
                }
            }
        }
    </script>
@endsection