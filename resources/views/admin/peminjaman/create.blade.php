@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Header Section -->
        <div class="mb-6 flex items-center justify-between gap-3">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Tambah Peminjaman Baru
            </h2>
            <a href="{{ route('admin.peminjaman.index') }}"
                class="inline-flex items-center justify-center rounded-md border border-stroke px-6 py-2 text-center font-medium text-black hover:bg-opacity-90 dark:border-gray-700 dark:text-white">
                Kembali
            </a>
        </div>

        <!-- Alert Messages -->
        @if($errors->any())
            <div
                class="mb-4 flex w-full border-l-6 border-[#F87171] bg-[#F87171] bg-opacity-[15%] px-7 py-8 shadow-md dark:bg-[#1b1b24] dark:bg-opacity-30 md:p-9">
                <div class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg bg-[#F87171]">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.4917 7.65579L11.106 12.2645C11.2545 12.4128 11.4715 12.5 11.6738 12.5C11.8762 12.5 12.0931 12.4128 12.2416 12.2645C12.5621 11.9445 12.5623 11.4317 12.2423 11.1114L7.65686 6.50351L12.2423 1.89526C12.5623 1.57503 12.5623 1.06226 12.2423 0.742033C11.9223 0.421802 11.4095 0.421802 11.0895 0.742033L6.4917 5.35028L1.89386 0.742033C1.57364 0.421802 1.06087 0.421802 0.740639 0.742033C0.420408 1.06226 0.420408 1.57503 0.740639 1.89526L5.35654 6.50351L0.740639 11.1114C0.420408 11.4317 0.420408 11.9445 0.740639 12.2645C0.901176 12.4128 1.11818 12.5 1.32054 12.5C1.52291 12.5 1.73991 12.4128 1.88845 12.2645L6.4917 7.65579Z"
                            fill="white"></path>
                    </svg>
                </div>
                <div class="w-full">
                    <h5 class="mb-3 text-lg font-bold text-[#B45454]">Terjadi Kesalahan!</h5>
                    <ul class="list-disc list-inside text-base leading-relaxed text-[#CD5D5D]">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.peminjaman.store') }}" method="POST" id="peminjamanForm">
            @csrf
            <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
                <!-- Left Column: Informasi Peminjam -->
                <div class="flex flex-col gap-9">
                    <div
                        class="rounded-[20px] border border-stroke bg-white shadow-default dark:border-gray-800 dark:bg-gray-900">
                        <div class="border-b border-stroke px-6.5 py-4 dark:border-gray-800">
                            <h3 class="font-medium text-black dark:text-white">
                                Informasi Peminjam
                            </h3>
                        </div>
                        <div class="p-6.5">
                            <!-- Kode Booking (Auto-generated) -->
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Kode Booking <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" name="kode_booking" value="{{ $kodeBooking }}" readonly
                                    class="w-full rounded border border-stroke bg-gray-100 py-3 px-5 text-black dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kode booking otomatis dibuat oleh
                                    sistem</p>
                            </div>

                            <!-- Select Anggota -->
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Pilih Anggota <span class="text-meta-1">*</span>
                                </label>
                                <select name="id_pengguna" id="selectAnggota" required
                                    class="w-full rounded border border-stroke bg-white py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    <option value="">Pilih Anggota</option>
                                    @foreach($anggota as $user)
                                        <option value="{{ $user->id_pengguna }}">
                                            {{ $user->nama_pengguna }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tanggal Pinjam -->
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Tanggal Pinjam <span class="text-meta-1">*</span>
                                </label>
                                <input type="date" name="tgl_pinjam" value="{{ date('Y-m-d') }}" required
                                    class="w-full rounded border border-stroke bg-white py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
                            </div>

                            <!-- Tanggal Kembali (Deadline) -->
                            <div class="mb-4.5">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Deadline Pengembalian <span class="text-meta-1">*</span>
                                </label>
                                <input type="date" name="tgl_kembali" value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                    required
                                    class="w-full rounded border border-stroke bg-white py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Default: 7 hari dari tanggal pinjam
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Pilih Buku -->
                <div class="flex flex-col gap-9">
                    <div
                        class="rounded-[20px] border border-stroke bg-white shadow-default dark:border-gray-800 dark:bg-gray-900">
                        <div class="border-b border-stroke px-6.5 py-4 dark:border-gray-800">
                            <h3 class="font-medium text-black dark:text-white">
                                Pilih Buku
                            </h3>
                        </div>
                        <div class="p-6.5">
                            <!-- Search Buku -->
                            <div class="mb-4">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Cari Buku <span class="text-meta-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="searchBuku" placeholder="Ketik judul buku atau ISBN..."
                                        class="w-full rounded border border-stroke bg-white py-3 pl-5 pr-10 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2">
                                        <svg class="fill-current text-gray-400" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                                                fill="currentColor" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                                <!-- Search Results Dropdown -->
                                <div id="searchResults"
                                    class="hidden mt-2 max-h-60 overflow-y-auto rounded border border-stroke bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                                    <!-- Results will be populated here via JavaScript -->
                                </div>
                            </div>

                            <!-- Selected Books List -->
                            <div class="mb-4">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Buku yang Dipilih
                                </label>
                                <div id="selectedBooks"
                                    class="space-y-2 min-h-[100px] rounded border border-dashed border-stroke p-4 dark:border-gray-700">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center" id="emptyMessage">
                                        Belum ada buku dipilih
                                    </p>
                                </div>
                            </div>

                            <div
                                class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300">Informasi</h4>
                                        <p class="mt-1 text-xs text-blue-700 dark:text-blue-400">
                                            Anda dapat memilih beberapa buku sekaligus dalam satu transaksi peminjaman.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex justify-end gap-4">
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-stroke px-6 py-3 text-center font-medium text-black hover:shadow-1 dark:border-gray-700 dark:text-white">
                    Batal
                </a>
                <button type="submit" id="submitBtn"
                    class="inline-flex items-center justify-center rounded-md bg-brand-primary px-6 py-3 text-center font-medium text-white hover:bg-opacity-90">
                    <span id="submitText">Simpan Peminjaman</span>
                    <span id="submitLoading" class="hidden">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            let selectedBooks = [];
            const searchInput = document.getElementById('searchBuku');
            const searchResults = document.getElementById('searchResults');
            const selectedBooksContainer = document.getElementById('selectedBooks');
            const emptyMessage = document.getElementById('emptyMessage');
            const form = document.getElementById('peminjamanForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');

            // Debounce function
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Search books
            const searchBooks = debounce(async function (query) {
                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }

                try {
                    const response = await fetch(`/api/buku/search?q=${encodeURIComponent(query)}`);
                    const books = await response.json();

                    if (books.length === 0) {
                        searchResults.innerHTML = '<p class="p-4 text-sm text-gray-500 dark:text-gray-400">Tidak ada buku ditemukan</p>';
                    } else {
                        searchResults.innerHTML = books.map(book => `
                                                        <div class="p-3 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer border-b border-stroke dark:border-gray-700 last:border-0" 
                                                             onclick="addBook(${book.id_buku}, '${book.judul_buku.replace(/'/g, "\\'")}', '${book.isbn || '-'}', ${book.stok})">
                                                            <div class="flex justify-between items-start">
                                                                <div class="flex-1">
                                                                    <p class="font-medium text-black dark:text-white">${book.judul_buku}</p>
                                                                    <p class="text-xs text-gray-500 dark:text-gray-400">ISBN: ${book.isbn || '-'}</p>
                                                                </div>
                                                                <span class="ml-2 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${book.stok > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'}">
                                                                    Stok: ${book.stok}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    `).join('');
                    }
                    searchResults.classList.remove('hidden');
                } catch (error) {
                    console.error('Error searching books:', error);
                }
            }, 300);

            searchInput.addEventListener('input', (e) => {
                searchBooks(e.target.value);
            });

            // Add book to selection
            window.addBook = function (id, title, isbn, stok) {
                // Check if already selected
                if (selectedBooks.find(b => b.id === id)) {
                    alert('Buku sudah dipilih!');
                    return;
                }

                // Check stock
                if (stok <= 0) {
                    alert('Stok buku tidak tersedia!');
                    return;
                }

                selectedBooks.push({ id, title, isbn, stok });
                renderSelectedBooks();
                searchInput.value = '';
                searchResults.classList.add('hidden');
            };

            // Remove book from selection
            window.removeBook = function (id) {
                selectedBooks = selectedBooks.filter(b => b.id !== id);
                renderSelectedBooks();
            };

            // Render selected books
            function renderSelectedBooks() {
                if (selectedBooks.length === 0) {
                    emptyMessage.classList.remove('hidden');
                    selectedBooksContainer.querySelectorAll('.book-item').forEach(el => el.remove());
                    return;
                }

                emptyMessage.classList.add('hidden');
                selectedBooksContainer.innerHTML = selectedBooks.map(book => `
                                                <div class="book-item flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-stroke dark:border-gray-700">
                                                    <div class="flex-1">
                                                        <p class="font-medium text-black dark:text-white">${book.title}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">ISBN: ${book.isbn} | Stok: ${book.stok}</p>
                                                    </div>
                                                    <button type="button" onclick="removeBook(${book.id})" 
                                                        class="ml-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="hidden" name="buku_ids[]" value="${book.id}">
                                                </div>
                                            `).join('');
            }

            // Form submission
            form.addEventListener('submit', function (e) {
                if (selectedBooks.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal 1 buku untuk dipinjam!');
                    return;
                }

                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                submitLoading.classList.remove('hidden');
            });

            // Close search results when clicking outside
            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });
        </script>
    @endpush
@endsection