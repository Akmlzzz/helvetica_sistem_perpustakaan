@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Header Section -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Laporan Perpustakaan
            </h2>
        </div>

        <!-- Filter Card -->
        <div
            class="mb-8 rounded-[20px] border border-stroke bg-white px-5 pt-6 pb-6 shadow-default dark:border-gray-800 dark:bg-gray-900 sm:px-7.5">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div x-data="{
                    init() {
                        flatpickr(this.$refs.startDate, {
                            dateFormat: 'Y-m-d',
                            defaultDate: '{{ $startDate }}'
                        });
                    }
                }">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Mulai Tanggal</label>
                    <div class="relative">
                        <input x-ref="startDate" type="text" name="start_date" value="{{ $startDate }}"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                        <span class="absolute right-4 top-1/2 -translate-y-1/2">
                            <svg class="fill-current text-gray-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.75 2.25H14.25V1.5C14.25 1.0875 13.9125 0.75 13.5 0.75C13.0875 0.75 12.75 1.0875 12.75 1.5V2.25H5.25V1.5C5.25 1.0875 4.9125 0.75 4.5 0.75C4.0875 0.75 3.75 1.0875 3.75 1.5V2.25H2.25C1.4175 2.25 0.75825 2.925 0.75825 3.75L0.75 15.75C0.75 16.575 1.4175 17.25 2.25 17.25H15.75C16.575 17.25 17.25 16.575 17.25 15.75V3.75C17.25 2.925 16.575 2.25 15.75 2.25ZM15.75 15.75H2.25V7.5H15.75V15.75ZM15.75 6H2.25V3.75H3.75V4.5C3.75 4.9125 4.0875 5.25 4.5 5.25C4.9125 5.25 5.25 4.9125 5.25 4.5V3.75H12.75V4.5C12.75 4.9125 13.0875 5.25 13.5 5.25C13.9125 5.25 14.25 4.9125 14.25 4.5V3.75H15.75V6Z" fill="currentColor"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div x-data="{
                    init() {
                        flatpickr(this.$refs.endDate, {
                            dateFormat: 'Y-m-d',
                            defaultDate: '{{ $endDate }}'
                        });
                    }
                }">
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Sampai Tanggal</label>
                    <div class="relative">
                        <input x-ref="endDate" type="text" name="end_date" value="{{ $endDate }}"
                            class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                        <span class="absolute right-4 top-1/2 -translate-y-1/2">
                            <svg class="fill-current text-gray-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.75 2.25H14.25V1.5C14.25 1.0875 13.9125 0.75 13.5 0.75C13.0875 0.75 12.75 1.0875 12.75 1.5V2.25H5.25V1.5C5.25 1.0875 4.9125 0.75 4.5 0.75C4.0875 0.75 3.75 1.5V2.25H2.25C1.4175 2.25 0.75825 2.925 0.75825 3.75L0.75 15.75C0.75 16.575 1.4175 17.25 2.25 17.25H15.75C16.575 17.25 17.25 16.575 17.25 15.75V3.75C17.25 2.925 16.575 2.25 15.75 2.25ZM15.75 15.75H2.25V7.5H15.75V15.75ZM15.75 6H2.25V3.75H3.75V4.5C3.75 4.9125 4.0875 5.25 4.5 5.25C4.9125 5.25 5.25 4.9125 5.25 4.5V3.75H12.75V4.5C12.75 4.9125 13.0875 5.25 13.5 5.25C13.9125 5.25 14.25 4.9125 14.25 4.5V3.75H15.75V6Z" fill="currentColor"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div>
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Jenis Laporan</label>
                    <select name="type"
                        class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white">
                        <option value="peminjaman" {{ $type == 'peminjaman' ? 'selected' : '' }} class="dark:bg-gray-800 dark:text-white">Peminjaman</option>
                        <option value="buku" {{ $type == 'buku' ? 'selected' : '' }} class="dark:bg-gray-800 dark:text-white">Data Buku</option>
                        <option value="anggota" {{ $type == 'anggota' ? 'selected' : '' }} class="dark:bg-gray-800 dark:text-white">Data Anggota</option>
                        <option value="denda" {{ $type == 'denda' ? 'selected' : '' }} class="dark:bg-gray-800 dark:text-white">Denda</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 rounded bg-brand-primary py-3 px-6 font-medium text-white hover:bg-opacity-90">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Summary Cards (Peminjaman Only) -->
        @if($type == 'peminjaman')
            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
                <!-- Total Peminjaman -->
                <div
                    class="rounded-[20px] border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-black dark:text-white">
                                {{ $totalPeminjaman }}
                            </h4>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Peminjaman</span>
                        </div>
                        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status Terlambat -->
                <div
                    class="rounded-[20px] border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-red-600 dark:text-red-400">
                                {{ $totalTerlambat }}
                            </h4>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Status Terlambat</span>
                        </div>
                        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 text-red-600 dark:text-red-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status Dikembalikan -->
                <div
                    class="rounded-[20px] border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-end justify-between">
                        <div>
                            <h4 class="text-title-md font-bold text-green-600 dark:text-green-400">
                                {{ $totalDikembalikan }}
                            </h4>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Status Dikembalikan</span>
                        </div>
                        <div
                            class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 text-green-600 dark:text-green-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div
            class="rounded-[20px] border border-stroke bg-white shadow-default dark:border-gray-800 dark:bg-gray-900 overflow-hidden">
            <div class="border-b border-stroke px-6.5 py-4 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="font-medium text-black dark:text-white">
                    Pratinjau Laporan ({{ ucfirst($type) }})
                </h3>
                
                <!-- Export Buttons -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.laporan.pdf', request()->all()) }}" target="_blank"
                        class="inline-flex items-center justify-center gap-2 rounded-md border border-success bg-white px-4 py-2 text-sm font-medium text-success">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.6667 2.5H3.33333C2.8731 2.5 2.5 2.8731 2.5 3.33333V16.6667C2.5 17.1269 2.8731 17.5 3.33333 17.5H16.6667C17.1269 17.5 17.5 17.1269 17.5 16.6667V3.33333C17.5 2.8731 17.1269 2.5 16.6667 2.5ZM15.8333 15.8333H4.16667V4.16667H15.8333V15.8333Z"
                                fill="currentColor" />
                        </svg>
                        PDF
                    </a>
                    <a href="{{ route('admin.laporan.excel', request()->all()) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-md border border-success bg-white px-4 py-2 text-sm font-medium text-success">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.6667 2.5H3.33333C2.8731 2.5 2.5 2.8731 2.5 3.33333V16.6667C2.5 17.1269 2.8731 17.5 3.33333 17.5H16.6667C17.1269 17.5 17.5 17.1269 17.5 16.6667V3.33333C17.5 2.8731 17.1269 2.5 16.6667 2.5ZM13.3333 12.5L10 15.8333L6.66667 12.5H9.16667V7.5H10.8333V12.5H13.3333Z"
                                fill="currentColor" />
                        </svg>
                        Excel
                    </a>
                    <button onclick="window.print()"
                        class="inline-flex items-center justify-center gap-2 rounded-md border border-success bg-white px-4 py-2 text-sm font-medium text-success">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.8333 5H4.16667V1.66667H15.8333V5ZM15.8333 14.1667H4.16667V12.5H15.8333V14.1667ZM18.3333 6.66667H1.66667V13.3333H4.16667V16.6667H15.8333V13.3333H18.3333V6.66667Z"
                                fill="currentColor" />
                        </svg>
                        Print
                    </button>
                </div>
            </div>

            <div class="flex flex-col overflow-x-auto p-4 preview-print">
                <div class="min-w-[800px]">
                    @if($type == 'buku')
                        <div class="grid grid-cols-5 rounded-sm bg-gray-2 dark:bg-meta-4">
                            <div class="p-2.5 xl:p-4">ID</div>
                            <div class="p-2.5 xl:p-4">Judul</div>
                            <div class="p-2.5 xl:p-4">Penulis</div>
                            <div class="p-2.5 xl:p-4">Kategori</div>
                            <div class="p-2.5 xl:p-4 text-center">Stok</div>
                        </div>
                        @foreach($data as $row)
                            <div class="grid grid-cols-5 border-b border-stroke dark:border-strokedark items-center">
                                <div class="p-2.5 xl:p-4 text-black dark:text-white">#{{ $row->id_buku }}</div>
                                <div class="p-2.5 xl:p-4">
                                    <p class="font-bold text-black dark:text-white">{{ $row->judul_buku }}</p>
                                    <p class="text-xs text-gray-500 italic">ISBN: {{ $row->isbn ?? '-' }}</p>
                                </div>
                                <div class="p-2.5 xl:p-4 text-black dark:text-white">{{ $row->penulis }}</div>
                                <div class="p-2.5 xl:p-4">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($row->kategori as $kat)
                                            <span class="inline-block rounded bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                                {{ $kat->nama_kategori }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400">-</span>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="p-2.5 xl:p-4 text-center text-black dark:text-white">{{ $row->stok }}</div>
                            </div>
                        @endforeach

                    @elseif($type == 'anggota')
                        <div class="grid grid-cols-5 rounded-sm bg-gray-2 dark:bg-meta-4 font-bold text-black dark:text-white">
                            <div class="p-2.5 xl:p-4 text-center">ID</div>
                            <div class="p-2.5 xl:p-4">Akun</div>
                            <div class="p-2.5 xl:p-4">Nama Lengkap</div>
                            <div class="p-2.5 xl:p-4">Telepon</div>
                            <div class="p-2.5 xl:p-4 text-center">Tgl Registrasi</div>
                        </div>
                        @foreach($data as $row)
                            <div class="grid grid-cols-5 border-b border-stroke dark:border-strokedark items-center text-sm">
                                <div class="p-2.5 xl:p-4 text-black dark:text-white">#{{ $row->id_pengguna }}</div>
                                <div class="p-2.5 xl:p-4">
                                    <p class="font-bold text-black dark:text-white">{{ $row->nama_pengguna }}</p>
                                    <p class="text-xs text-gray-500">{{ $row->email }}</p>
                                </div>
                                <div class="p-2.5 xl:p-4 text-black dark:text-white">{{ $row->anggota->nama_lengkap ?? '-' }}</div>
                                <div class="p-2.5 xl:p-4 text-black dark:text-white">{{ $row->anggota->nomor_telepon ?? '-' }}</div>
                                <div class="p-2.5 xl:p-4 text-center text-black dark:text-white">{{ $row->dibuat_pada ? $row->dibuat_pada->format('d/m/Y') : '-' }}</div>
                            </div>
                        @endforeach

                    @elseif($type == 'peminjaman')
                        <div class="grid grid-cols-6 rounded-sm bg-gray-2 dark:bg-meta-4">
                            <div class="p-2.5 xl:p-4">Peminjam</div>
                            <div class="p-2.5 xl:p-4">Buku</div>
                            <div class="p-2.5 xl:p-4 text-center">Tgl Pinjam</div>
                            <div class="p-2.5 xl:p-4 text-center">Tgl Kembali</div>
                            <div class="p-2.5 xl:p-4 text-center">Status</div>
                            <div class="p-2.5 xl:p-4 text-center">Denda</div>
                        </div>
                        @foreach($data as $row)
                            <div class="grid grid-cols-6 border-b border-stroke dark:border-gray-800 text-sm">
                                <div class="p-2.5 xl:p-4 dark:text-white">{{ $row->pengguna->nama_pengguna }}</div>
                                <div class="p-2.5 xl:p-4 dark:text-white">
                                    @foreach($row->detail as $dtl)
                                        <div>• {{ $dtl->buku->judul_buku ?? 'Buku Tidak Ditemukan' }}</div>
                                    @endforeach
                                </div>
                                <div class="p-2.5 xl:p-4 text-center dark:text-white">
                                    {{ \Carbon\Carbon::parse($row->tgl_pinjam)->format('d-m-Y') }}
                                </div>
                                <div class="p-2.5 xl:p-4 text-center dark:text-white">
                                    {{ $row->tgl_kembali ? \Carbon\Carbon::parse($row->tgl_kembali)->format('d-m-Y') : '-' }}
                                </div>
                                <div class="p-2.5 xl:p-4 text-center">
                                    @if($row->status_transaksi == 'terlambat')
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                            Terlambat
                                        </span>
                                    @elseif($row->status_transaksi == 'dikembalikan')
                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                            Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            Dipinjam
                                        </span>
                                    @endif
                                </div>
                                <div class="p-2.5 xl:p-4 text-center dark:text-white">
                                    @if($row->denda)
                                        <span class="font-medium text-danger dark:text-red-400">
                                            IDR {{ number_format($row->denda->jumlah_denda, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                    @elseif($type == 'denda')
                        <div class="grid grid-cols-5 rounded-sm bg-gray-2 dark:bg-meta-4">
                            <div class="p-2.5 xl:p-4">Peminjam</div>
                            <div class="p-2.5 xl:p-4 text-center">ID Pinjam</div>
                            <div class="p-2.5 xl:p-4 text-center">Tgl Kembali</div>
                            <div class="p-2.5 xl:p-4 text-center">Jumlah Denda</div>
                            <div class="p-2.5 xl:p-4 text-center">Status</div>
                        </div>
                        @foreach($data as $row)
                            <div class="grid grid-cols-5 border-b border-stroke dark:border-strokedark">
                                <div class="p-2.5 xl:p-4">{{ $row->peminjaman->pengguna->nama_pengguna }}</div>
                                <div class="p-2.5 xl:p-4 text-center">#{{ $row->id_peminjaman }}</div>
                                <div class="p-2.5 xl:p-4 text-center">{{ $row->peminjaman->tgl_kembali }}</div>
                                <div class="p-2.5 xl:p-4 text-center font-bold text-danger">IDR
                                    {{ number_format($row->jumlah_denda, 0, ',', '.') }}
                                </div>
                                <div class="p-2.5 xl:p-4 text-center">
                                    {{ $row->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum Bayar' }}
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if($data->isEmpty())
                        <div class="p-10 text-center text-gray-500">
                            Tidak ada data untuk rentang waktu dan jenis laporan yang dipilih.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .preview-print,
            .preview-print * {
                visibility: visible;
            }

            .preview-print {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
@endsection