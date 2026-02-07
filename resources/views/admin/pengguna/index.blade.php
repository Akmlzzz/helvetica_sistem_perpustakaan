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
            class="rounded-[20px] border border-stroke bg-white px-5 pb-5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            <form method="GET" action="{{ route('admin.pengguna.index') }}"
                class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center">
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
                        placeholder="Cari Nama Pengguna, Email, atau Nama Lengkap..."
                        class="w-full rounded-lg border border-stroke bg-transparent pl-12 pr-4 py-2 font-medium outline-none focus:border-primary dark:border-strokedark xl:w-125" />
                </div>

                <div class="w-full sm:w-1/4">
                    <select name="role" onchange="this.form.submit()"
                        class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-2 pl-4 pr-10 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                        <option value="">Semua Level</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="anggota" {{ request('role') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                    </select>
                </div>
            </form>

            <div class="flex flex-col overflow-x-auto">
                <div class="min-w-[1000px]">
                    <div class="grid grid-cols-5 rounded-sm bg-gray-2 dark:bg-meta-4">
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base">Pengguna</h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base">Email</h5>
                        </div>
                        <div class="p-2.5 xl:p-5 text-center">
                            <h5 class="text-sm font-medium uppercase xsm:text-base">Level</h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base">Nama Lengkap</h5>
                        </div>
                        <div class="p-2.5 xl:p-5 text-center">
                            <h5 class="text-sm font-medium uppercase xsm:text-base">Aksi</h5>
                        </div>
                    </div>

                    @foreach($users as $user)
                        <div class="grid grid-cols-5 border-b border-stroke dark:border-strokedark">
                            <div class="flex items-center p-2.5 xl:p-5">
                                <p class="font-bold text-black dark:text-white">{{ $user->nama_pengguna }}</p>
                            </div>
                            <div class="flex items-center p-2.5 xl:p-5">
                                <p class="text-sm text-black dark:text-white">{{ $user->email }}</p>
                            </div>
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <span
                                    class="inline-flex rounded-full bg-opacity-10 px-3 py-1 text-sm font-medium @if($user->level_akses == 'admin') bg-danger text-danger @elseif($user->level_akses == 'petugas') bg-warning text-warning @else bg-success text-success @endif">
                                    {{ ucfirst($user->level_akses) }}
                                </span>
                            </div>
                            <div class="flex items-center p-2.5 xl:p-5">
                                <p class="text-sm text-black dark:text-white">{{ $user->anggota->nama_lengkap ?? '-' }}</p>
                            </div>
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <div class="flex items-center space-x-3.5">
                                    <button @click="$dispatch('open-user-modal', { 
                                                        id: '{{ $user->id_pengguna }}',
                                                        nama_pengguna: '{{ $user->nama_pengguna }}',
                                                        email: '{{ $user->email }}',
                                                        level_akses: '{{ $user->level_akses }}',
                                                        nama_lengkap: '{{ addslashes($user->anggota->nama_lengkap ?? '') }}',
                                                        alamat: '{{ addslashes($user->anggota->alamat ?? '') }}',
                                                        nomor_telepon: '{{ $user->anggota->nomor_telepon ?? '' }}'
                                                    })"
                                        class="hover:text-primary border border-stroke dark:border-strokedark rounded-md p-1.5">
                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.15 1.5c-.25 0-.5.1-.7.3l-1.3 1.3 2.7 2.7 1.3-1.3c.4-.4.4-1 0-1.4l-1.3-1.3c-.2-.2-.4-.3-.7-.3zm-2.7 2.7l-9.4 9.4v2.7h2.7l9.4-9.4-2.7-2.7z"
                                                fill="currentColor" />
                                        </svg>
                                    </button>
                                    @if(auth()->id() != $user->id_pengguna)
                                        <form action="{{ route('admin.pengguna.destroy', $user->id_pengguna) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="hover:text-primary border border-stroke dark:border-strokedark rounded-md p-1.5 text-danger">
                                                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.16877V14.5406C3.62852 15.75 4.6129 16.7344 5.82227 16.7344H12.1504C13.3598 16.7344 14.3441 15.75 14.3441 14.5406V6.16877C14.8785 5.9344 15.2441 5.42815 15.2441 4.8094V3.96565C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.041C10.1816 1.74377 10.2941 1.85627 10.2941 1.9969V2.47502H7.67852V1.9969ZM13.0504 14.5406C13.0504 15.0188 12.6566 15.4125 12.1785 15.4125H5.85039C5.37227 15.4125 4.97852 15.0188 4.97852 14.5406V6.45002H13.0504V14.5406ZM13.9504 4.8094C13.9504 4.9219 13.866 5.00627 13.7535 5.00627H4.21914C4.10664 5.00627 4.02227 4.9219 4.02227 4.8094V3.96565C4.02227 3.85315 4.10664 3.76877 4.21914 3.76877H13.7535C13.866 3.76877 13.9504 3.85315 13.9504 3.96565V4.8094Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit User -->
    <div x-data="userModal()" x-show="isOpen" @open-user-modal.window="openModal($event.detail)" style="display: none;"
        class="fixed inset-0 z-999999 flex items-center justify-center bg-black/90 px-4 py-5 overflow-y-auto">
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
                        class="rounded bg-primary px-6 py-2 font-medium text-gray hover:shadow-1">Simpan</button>
                </div>
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
    </script>
@endsection