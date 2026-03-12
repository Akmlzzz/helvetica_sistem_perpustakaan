@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-270">
        <div class="grid grid-cols-1 gap-9">
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                    <h3 class="font-medium text-black dark:text-white">
                        Profil Saya
                    </h3>
                </div>
                <form action="{{ route('anggota.profile.update') }}" method="POST" x-data="{ showModal: false }" enctype="multipart/form-data"
                    @submit.prevent="showModal = true">
                    @csrf
                    @method('PUT')
                    <div class="p-6.5">
                        
                        <!-- Profile Image Section -->
                        <div class="mb-4.5" x-data="profileCropper()">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                                <div class="h-24 w-24 rounded-full overflow-hidden border border-stroke bg-gray-100 shrink-0 relative">
                                    <img x-show="previewUrl" :src="previewUrl" class="h-full w-full object-cover relative z-10" style="display: none;">
                                    @if($user->foto_profil)
                                        <img x-show="!previewUrl" src="{{ Storage::url($user->foto_profil) }}" alt="Profile" class="h-full w-full object-cover">
                                    @else
                                        <svg x-show="!previewUrl" class="h-full w-full text-gray-400 p-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <label class="mb-2.5 block text-black dark:text-white font-medium">Foto Profil</label>
                                    <input type="file" x-ref="fileInput" @change="fileChosen" name="foto_profil" accept="image/*" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 font-medium outline-none transition file:mr-4 file:rounded file:border-0 file:bg-[#004236] file:py-2 file:px-4 file:text-sm file:font-semibold file:text-white hover:file:bg-[#00362b] focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                                    <input type="hidden" name="cropped_foto" x-model="croppedData">
                                    @error('foto_profil')
                                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Crop Modal -->
                            <div x-show="showCropper" class="fixed inset-0 z-999999 flex items-center justify-center bg-black/80 backdrop-blur-sm px-4 py-5" style="display: none;">
                                <div @click.outside="cancelCrop" class="w-full max-w-150 rounded-lg bg-white p-6 dark:bg-boxdark shadow-2xl">
                                    <div class="mb-4 flex justify-between items-center">
                                        <h3 class="text-xl font-bold text-black dark:text-white">Sesuaikan Foto</h3>
                                        <button @click="cancelCrop" type="button" class="text-gray-500 hover:text-black dark:hover:text-white">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <div class="w-full h-[50vh] sm:h-96 md:h-115 bg-gray-100 flex items-center justify-center overflow-hidden rounded">
                                        <img x-ref="imageToCrop" :src="imageUrl" class="max-h-full max-w-full block">
                                    </div>
                                    <div class="mt-6 flex justify-end gap-3">
                                        <button @click="cancelCrop" type="button" class="rounded px-6 py-2 border border-stroke text-black transition hover:bg-gray-100 dark:border-strokedark dark:text-white dark:hover:bg-meta-4">Batal</button>
                                        <button @click="saveCrop" type="button" class="rounded bg-[#004236] px-6 py-2 text-white transition hover:bg-opacity-90">Terapkan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    ID Anggota <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" value="{{ $anggota->id_anggota }}" disabled
                                    class="w-full rounded border-[1.5px] border-stroke bg-gray py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                            </div>

                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Nama Lengkap
                                </label>
                                <input type="text" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $anggota->nama_lengkap) }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                @error('nama_lengkap')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Alamat
                            </label>
                            <textarea rows="3" name="alamat"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('alamat', $anggota->alamat) }}</textarea>
                            @error('alamat')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Email
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                @error('email')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Username
                                </label>
                                <input type="text" name="nama_pengguna"
                                    value="{{ old('nama_pengguna', $user->nama_pengguna) }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                @error('nama_pengguna')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Password <span class="text-meta-1 text-sm">(Kosongkan jika tidak ingin mengubah)</span>
                            </label>
                            <input type="password" name="password" placeholder="Masukkan password baru"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                            @error('password')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="flex w-full justify-center rounded-xl bg-[#004236] p-3 text-sm font-bold text-white transition-all hover:bg-[#00362b] shadow-lg hover:shadow-xl">
                            Simpan Perubahan
                        </button>
                    </div>

                    <!-- Modal Confirmation -->
                    <div x-show="showModal" x-transition.opacity
                        class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-5"
                        style="display: none;">
                        <div @click.outside="showModal = false"
                            class="w-full max-w-125 rounded-lg bg-white py-12 px-8 text-center dark:bg-boxdark md:py-15 md:px-17.5">
                            <span class="mx-auto inline-block">
                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.1" width="60" height="60" rx="30" fill="#004236" />
                                    <path
                                        d="M30 20V30M30 40H30.01M30 10C18.9543 10 10 18.9543 10 30C10 41.0457 18.9543 50 30 50C41.0457 50 50 41.0457 50 30C50 18.9543 41.0457 10 30 10Z"
                                        stroke="#004236" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <h3 class="mt-5.5 pb-2 text-xl font-bold text-black dark:text-white sm:text-2xl">
                                Konfirmasi Perubahan
                            </h3>
                            <p class="mb-10 text-gray-500">
                                Apakah Anda yakin ingin menyimpan perubahan pada profil Anda?
                            </p>
                            <div class="flex flex-wrap items-center justify-center gap-4">
                                <button @click="showModal = false" type="button"
                                    class="w-full rounded border border-stroke bg-gray p-3 font-medium text-black transition hover:border-meta-1 hover:bg-meta-1 hover:text-white dark:border-strokedark dark:bg-meta-4 dark:text-white dark:hover:border-meta-1 dark:hover:bg-meta-1 sm:w-auto px-6">
                                    Batal
                                </button>
                                <button @click="$el.closest('form').submit()" type="button"
                                    class="w-full rounded bg-[#004236] p-3 font-medium text-white transition hover:bg-opacity-90 sm:w-auto px-6">
                                    Ya, Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Popup -->
    @if (session('success'))
        <div x-data="{ showSuccess: true }" x-show="showSuccess" x-init="setTimeout(() => showSuccess = false, 3000)"
            x-transition.opacity
            class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-5">
            <div @click.outside="showSuccess = false"
                class="w-full max-w-125 rounded-lg bg-white py-12 px-8 text-center dark:bg-boxdark md:py-15 md:px-17.5">
                <div
                    class="mx-auto mb-6 inline-flex h-20 w-20 items-center justify-center rounded-full bg-success/10 text-success">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-bold text-black dark:text-white sm:text-2xl">
                    Berhasil!
                </h3>
                <p class="mb-10 text-gray-500">
                    {{ session('success') }}
                </p>
                <button @click="showSuccess = false"
                    class="w-full rounded bg-success p-3 font-medium text-white transition hover:bg-opacity-90 sm:w-auto px-10">
                    Tutup
                </button>
        </div>
    @endif
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
<style>
    .cropper-view-box,
    .cropper-face {
        border-radius: 50%;
    }
    .cropper-view-box {
        outline: 0;
        box-shadow: 0 0 0 1px #39f;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
    function profileCropper() {
        return {
            showCropper: false,
            imageUrl: '',
            previewUrl: '',
            croppedData: '',
            cropper: null,
            fileChosen(event) {
                const file = event.target.files[0];
                if (!file) return;

                if (!file.type.match('image.*')) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imageUrl = e.target.result;
                    this.showCropper = true;
                    
                    this.$nextTick(() => {
                        if (this.cropper) {
                            this.cropper.destroy();
                        }
                        this.cropper = new Cropper(this.$refs.imageToCrop, {
                            aspectRatio: 1,
                            viewMode: 1,
                            dragMode: 'move',
                            guides: false,
                            center: true,
                            highlight: false,
                            background: true,
                            autoCropArea: 0.9,
                            cropBoxMovable: true,
                            cropBoxResizable: true,
                        });
                    });
                };
                reader.readAsDataURL(file);
            },
            cancelCrop() {
                this.showCropper = false;
                if (this.cropper) {
                    this.cropper.destroy();
                    this.cropper = null;
                }
                this.$refs.fileInput.value = '';
                this.previewUrl = '';
                this.croppedData = '';
            },
            saveCrop() {
                if (!this.cropper) return;
                const canvas = this.cropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });
                
                this.previewUrl = canvas.toDataURL('image/png');
                this.croppedData = this.previewUrl;
                
                this.showCropper = false;
                if (this.cropper) {
                    this.cropper.destroy();
                    this.cropper = null;
                }
            }
        };
    }
</script>
@endpush