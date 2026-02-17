@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Header Section -->
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Data Peminjaman
            </h2>
            <a href="{{ route('admin.peminjaman.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-brand-primary px-6 py-3 font-medium text-white hover:bg-opacity-90">
                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 4.16666V15.8333" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M4.16669 10H15.8334" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Tambah Peminjaman
            </a>
        </div>

        <!-- Search & Filter -->
        <div
            class="rounded-[20px] border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 xl:pb-1">
            <form method="GET" action="{{ route('admin.peminjaman.index') }}"
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
                        placeholder="Cari Nama Peminjam atau Judul Buku..."
                        class="w-full rounded-lg border border-stroke bg-transparent pl-12 pr-4 py-2 font-medium outline-none focus:border-primary dark:border-strokedark dark:text-white" />
                </div>

                <!-- Filter Status -->
                <div class="relative w-full sm:w-48">
                    <select name="status" onchange="this.form.submit()"
                        class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                        <option value="" class="text-gray-500">Semua Status</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z" fill="currentColor"/>
                        </svg>
                    </div>
                </div>

                <!-- Sort Filter -->
                <div class="relative w-full sm:w-48">
                    <select name="sort" onchange="this.form.submit()"
                        class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A-Z (Peminjam)</option>
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z" fill="currentColor"/>
                        </svg>
                    </div>
                </div>
            </form>

            <!-- Table Section with Responsive Scroll -->
            <div class="flex flex-col overflow-x-auto">
                <div class="min-w-[1000px]">
                    <div class="grid grid-cols-6 rounded-sm bg-gray-50 dark:bg-gray-800 sm:grid-cols-6">
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Nama Peminjam</h5>
                        </div>
                        <div class="p-2.5 xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Judul Buku</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Tgl Pinjam</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Deadline</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Status</h5>
                        </div>
                        <div class="p-2.5 text-center xl:p-5">
                            <h5 class="text-sm font-medium uppercase xsm:text-base dark:text-gray-300">Aksi</h5>
                        </div>
                    </div>

                    @foreach($peminjaman as $item)
                        <div
                            class="grid grid-cols-6 border-b border-stroke dark:border-strokedark hover:bg-gray-50 dark:hover:bg-white/5 sm:grid-cols-6">
                            <!-- Nama Peminjam -->
                            <div class="flex items-center p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">
                                    {{ $item->pengguna->anggota->nama_lengkap ?? $item->pengguna->nama_pengguna ?? 'Unknown' }}
                                </p>
                            </div>

                            <!-- Judul Buku -->
                            <div class="flex items-center p-2.5 xl:p-5">
                                @if($item->id_buku)
                                    <p class="text-black dark:text-white">{{ $item->buku->judul_buku ?? '-' }}</p>
                                @elseif($item->detail && $item->detail->count() > 0)
                                    <div class="flex flex-col">
                                        @foreach($item->detail->take(2) as $detail)
                                            <span
                                                class="text-sm text-black dark:text-white">{{ $detail->buku->judul_buku ?? '-' }}</span>
                                        @endforeach
                                        @if($item->detail->count() > 2)
                                            <span class="text-xs text-gray-500">+{{ $item->detail->count() - 2 }} lainnya</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-black dark:text-white">-</span>
                                @endif
                            </div>

                            <!-- Tgl Pinjam -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">{{ $item->tgl_pinjam }}</p>
                            </div>

                            <!-- Deadline -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <p class="text-black dark:text-white">{{ $item->tgl_kembali }}</p>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center justify-center p-2.5 xl:p-5">
                                <x-status-badge :type="$item->status_transaksi" />
                            </div>

                            <!-- Aksi -->
                            <div class="flex items-center justify-center gap-2 p-2.5 xl:p-5">
                                <a href="{{ route('admin.peminjaman.show', $item->id_peminjaman) }}"
                                    class="inline-flex items-center justify-center rounded-md border border-primary px-3 py-1 text-center font-medium text-primary hover:bg-opacity-90 dark:text-white">
                                    Detail
                                </a>
                                @if($item->status_transaksi == 'terlambat')
                                    <button @click="$dispatch('open-denda-modal', {
                                                                    id: '{{ $item->id_peminjaman }}',
                                                                    nama: '{{ $item->pengguna->anggota->nama_lengkap ?? $item->pengguna->nama_pengguna }}',
                                                                    tgl_kembali: '{{ $item->tgl_kembali }}'
                                                                })"
                                        class="inline-flex items-center justify-center rounded-md border border-red-500 px-3 py-1 text-center font-medium text-red-500 hover:border-red-700 hover:text-red-700 hover:bg-red-50 transition-colors dark:hover:bg-red-900/20">
                                        Denda
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 px-4 pb-4 sm:px-7.5">
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>

    <!-- Denda Modal -->
    <div x-data="dendaModal()" x-show="isOpen" @open-denda-modal.window="openModal($event.detail)" style="display: none;"
        class="fixed inset-0 z-999999 overflow-y-auto bg-black/90">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div @click.outside="closeModal()"
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md dark:bg-boxdark">
                <div class="px-6 py-8 md:px-8">
                    <h3 class="mb-4 text-xl font-bold text-black dark:text-white">Detail Denda</h3>

                    <div class="mb-6 space-y-3 text-black dark:text-white">
                        <p><strong>Peminjam:</strong> <span x-text="data.nama"></span></p>
                        <p><strong>Batas Kembali:</strong> <span x-text="data.tgl_kembali"></span></p>
                        <p><strong>Terlambat:</strong> <span x-text="data.terlambat + ' Hari'"></span></p>
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-meta-4 rounded-lg text-center">
                            <p class="text-sm text-gray-500">Total Denda</p>
                            <p class="text-3xl font-bold text-danger" x-text="formatRupiah(data.total_denda)"></p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <p class="text-sm font-medium text-gray-500 mb-2">Peringatan (AI Automation - Coming Soon)</p>
                        <div class="grid grid-cols-2 gap-3">
                            <button disabled
                                class="flex items-center justify-center gap-2 rounded bg-[#25D366] px-4 py-2 font-medium text-white hover:bg-opacity-90 opacity-70 cursor-not-allowed">
                                <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.0044 2C6.54696 2 2.09315 6.40263 2.08889 11.7828C2.08676 13.5186 2.64629 15.1768 3.70582 16.5921L2 22.6842L8.35121 21.0421C9.71266 21.7763 11.2339 22.1642 12.7831 22.1642H12.7874C18.2427 22.1642 22.6944 17.7637 22.7008 12.3835C22.7029 9.61099 21.6105 7.00676 19.6231 5.04467C17.6358 3.08259 14.9926 2.00213 12.0044 2ZM12.7853 20.4678C11.4079 20.4678 10.0573 20.1011 8.87739 19.4087L8.59837 19.2445L5.75949 19.9763L6.52002 17.2307L6.33682 16.9423C5.5658 15.7291 5.15897 14.3059 5.1611 12.8428C5.16536 8.66539 8.61966 5.25996 12.8556 5.25996C14.8961 5.25996 16.8153 6.04677 18.2574 7.47211C19.7017 8.89745 20.4941 10.7954 20.492 12.8428C20.4856 17.0223 17.0292 20.4678 12.7853 20.4678Z"
                                        fill="white" />
                                </svg>
                                WhatsApp
                            </button>
                            <button disabled
                                class="flex items-center justify-center gap-2 rounded bg-primary px-4 py-2 font-medium text-white hover:bg-opacity-90 opacity-70 cursor-not-allowed">
                                <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 4H4C2.9 4 2.01 4.9 2.01 6L2 18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4ZM20 8L12 13L4 8V6L12 11L20 6V8Z"
                                        fill="white" />
                                </svg>
                                Email
                            </button>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="button" @click="closeModal()"
                            class="rounded border border-stroke px-6 py-2 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function dendaModal() {
            return {
                isOpen: false,
                data: {
                    id: '',
                    nama: '',
                    tgl_kembali: '',
                    terlambat: 0,
                    total_denda: 0
                },
                openModal(detail) {
                    this.data.id = detail.id;
                    this.data.nama = detail.nama;
                    this.data.tgl_kembali = detail.tgl_kembali;

                    // Simple logic to calculate fine (Example: 1000 per day)
                    // In real app, this should probably come from backend or config
                    const tglKembali = new Date(detail.tgl_kembali);
                    const today = new Date();
                    const diffTime = Math.abs(today - tglKembali);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    // If today is after due date
                    if (today > tglKembali) {
                        this.data.terlambat = diffDays;
                        this.data.total_denda = diffDays * 1000; // Asumsi denda 1000 per hari
                    } else {
                        this.data.terlambat = 0;
                        this.data.total_denda = 0;
                    }

                    this.isOpen = true;
                },
                closeModal() {
                    this.isOpen = false;
                },
                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
                }
            }
        }
    </script>
@endsection