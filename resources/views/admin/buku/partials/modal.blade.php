<!-- Modal for Add/Edit Book -->
<div x-data="bookModal()" x-show="isOpen" @open-add-book-modal.window="openAddModal()"
    @open-edit-book-modal.window="openEditModal($event.detail)" style="display: none;"
    class="fixed inset-0 z-999999 overflow-y-auto bg-black/50 backdrop-blur-sm">
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div @click.outside="closeModal()"
            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-5xl dark:bg-boxdark">
            <div class="px-6 py-8 md:px-10 md:py-10">

                <h3 class="mb-6 text-xl font-bold text-black dark:text-white"
                    x-text="isEdit ? 'Edit Data Buku' : 'Tambah Buku Baru'"></h3>

                <form :action="actionUrl" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column: Basic Info -->
                        <div class="lg:col-span-2 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-2.5 block font-medium text-black dark:text-white">Judul Buku <span class="text-meta-1">*</span></label>
                                    <input type="text" name="judul_buku" x-model="form.judul" required
                                        class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary" />
                                </div>

                                <div>
                                    <label class="mb-2.5 block font-medium text-black dark:text-white">ISBN</label>
                                    <input type="text" name="isbn" x-model="form.isbn" placeholder="978-0-123456-78-9"
                                        class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="mb-2.5 block font-medium text-black dark:text-white">Stok <span class="text-meta-1">*</span></label>
                                    <input type="number" name="stok" x-model="form.stok" required min="0"
                                        class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                                </div>

                                <div>
                                    <label class="mb-2.5 block font-medium text-black dark:text-white">Jumlah Halaman</label>
                                    <input type="number" name="jumlah_halaman" x-model="form.jumlah_halaman" min="1" max="10000"
                                        class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                                </div>

                                <div>
                                    <label class="mb-2.5 block font-medium text-black dark:text-white">Tahun Terbit</label>
                                    <input type="number" name="tahun_terbit" x-model="form.tahun_terbit" min="1900" max="{{ date('Y') }}"
                                        class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                                </div>
                            </div>

                            <div>
                                <label class="mb-2.5 block font-medium text-black dark:text-white">Bahasa</label>
                                <select name="bahasa" x-model="form.bahasa"
                                    class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white">
                                    <option value="">Pilih Bahasa</option>
                                    <option value="id">Indonesia</option>
                                    <option value="en">English</option>
                                    <option value="ar">Arabic</option>
                                    <option value="zh">Chinese</option>
                                    <option value="fr">French</option>
                                    <option value="de">German</option>
                                    <option value="ja">Japanese</option>
                                    <option value="ko">Korean</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2.5 block font-medium text-black dark:text-white">Sinopsis</label>
                                <div id="editor" x-ref="quillEditor" class="bg-white dark:bg-gray-800 rounded-lg border border-stroke dark:border-strokedark" style="min-height: 200px;"></div>
                                <input type="hidden" name="sinopsis" x-model="form.sinopsis">
                                <p class="text-xs text-gray-500 mt-2">Tulis sinopsis buku secara detail untuk membantu pembeli memahami konten buku.</p>
                            </div>

                            <div>
                                <label class="mb-2.5 block font-medium text-black dark:text-white">Lokasi Rak</label>
                                <input type="text" name="lokasi_rak" x-model="form.lokasi"
                                    class="w-full rounded border border-stroke bg-gray py-3 px-4 text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                            </div>
                        </div>

                        <!-- Right Column: Categories & Cover -->
                        <div class="space-y-4">
                            <div>
                                <label class="mb-2.5 block font-medium text-black dark:text-white">Kategori</label>
                                <div class="flex flex-wrap gap-2 rounded border border-stroke bg-gray p-3 dark:border-strokedark dark:bg-meta-4 max-h-[200px] overflow-y-auto">
                                    @foreach($kategori as $kat)
                                        <div @click="toggleKategori({{ $kat->id_kategori }})"
                                            class="cursor-pointer select-none rounded border px-3 py-1 text-sm font-medium transition-colors"
                                            :class="form.kategori.includes({{ $kat->id_kategori }}) 
                                                        ? 'bg-brand-primary border-brand-primary text-white' 
                                                        : 'bg-white border-stroke text-gray-600 hover:border-brand-primary dark:bg-boxdark dark:border-strokedark dark:text-gray-300'">
                                            {{ $kat->nama_kategori }}
                                            <span x-show="form.kategori.includes({{ $kat->id_kategori }})" class="ml-1 inline-block">✓</span>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Hidden inputs for form submission -->
                                <template x-for="id in form.kategori" :key="id">
                                    <input type="hidden" name="kategori[]" :value="id">
                                </template>
                                <p class="text-xs text-gray-500 mt-2">Klik untuk memilih kategori.</p>
                            </div>

                            <div>
                                <label class="mb-2.5 block font-medium text-black dark:text-white">Sampul Buku</label>
                                <input type="file" name="sampul" accept="image/*"
                                    class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:px-5 file:py-3 file:hover:bg-brand-primary file:hover:bg-opacity-10 focus:border-brand-primary active:border-brand-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-brand-primary" />
                                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, Max: 2MB</p>
                            </div>

                            <!-- Preview Cover -->
                            <div x-show="isEdit && form.coverPreview" class="mt-4">
                                <label class="mb-2.5 block font-medium text-black dark:text-white">Cover Saat Ini</label>
                                <div class="relative">
                                    <img :src="form.coverPreview" alt="Cover Preview" class="w-full h-48 object-cover rounded-lg border border-stroke dark:border-strokedark">
                                    <div class="absolute top-2 right-2 bg-black/50 text-white px-2 py-1 rounded text-xs">
                                        Cover Lama
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <button type="button" @click="closeModal()"
                            class="rounded border border-stroke px-6 py-2 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded bg-brand-primary px-6 py-2 font-medium text-white hover:shadow-1">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Quill.js CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Quill.js and Alpine.js Script -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
function bookModal() {
    return {
        isOpen: false,
        isEdit: false,
        actionUrl: '{{ route("admin.buku.store") }}',
        quill: null,
        form: {
            id: '',
            judul: '',
            isbn: '',
            penulis: '',
            penerbit: '',
            stok: '',
            sinopsis: '',
            jumlah_halaman: '',
            tahun_terbit: '',
            bahasa: '',
            kategori: [],
            lokasi: '',
            coverPreview: ''
        },

        init() {
            // Initialize Quill editor
            this.quill = new Quill(this.$refs.quillEditor, {
                theme: 'snow',
                placeholder: 'Tulis sinopsis buku di sini...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['clean']
                    ]
                }
            });

            // Update form.sinopsis when Quill content changes
            this.quill.on('text-change', () => {
                this.form.sinopsis = this.quill.root.innerHTML;
            });
        },

        openAddModal() {
            this.resetForm();
            this.isEdit = false;
            this.actionUrl = '{{ route("admin.buku.store") }}';
            this.isOpen = true;
            this.$nextTick(() => {
                this.quill.setText('');
            });
        },

        openEditModal(data) {
            this.form = {
                id: data.id,
                judul: data.judul,
                isbn: data.isbn || '',
                penulis: data.penulis || '',
                penerbit: data.penerbit || '',
                stok: data.stok,
                sinopsis: data.sinopsis || '',
                jumlah_halaman: data.jumlah_halaman || '',
                tahun_terbit: data.tahun_terbit || '',
                bahasa: data.bahasa || '',
                kategori: Array.isArray(data.kategori) ? data.kategori : [],
                lokasi: data.lokasi || '',
                coverPreview: data.coverPreview || ''
            };
            this.isEdit = true;
            this.actionUrl = `{{ route("admin.buku.update", ":id") }}`.replace(':id', data.id);
            this.isOpen = true;
            
            this.$nextTick(() => {
                if (data.sinopsis) {
                    this.quill.root.innerHTML = data.sinopsis;
                } else {
                    this.quill.setText('');
                }
            });
        },

        closeModal() {
            this.isOpen = false;
            this.resetForm();
        },

        resetForm() {
            this.form = {
                id: '',
                judul: '',
                isbn: '',
                penulis: '',
                penerbit: '',
                stok: '',
                sinopsis: '',
                jumlah_halaman: '',
                tahun_terbit: '',
                bahasa: '',
                kategori: [],
                lokasi: '',
                coverPreview: ''
            };
        },

        toggleKategori(id) {
            const index = this.form.kategori.indexOf(id);
            if (index > -1) {
                this.form.kategori.splice(index, 1);
            } else {
                this.form.kategori.push(id);
            }
        }
    }
}
</script>
