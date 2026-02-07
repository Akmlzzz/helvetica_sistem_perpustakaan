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
            class="mb-8 rounded-[20px] border border-stroke bg-white px-5 pt-6 pb-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Mulai Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2.5 block font-medium text-black dark:text-white">Jenis Laporan</label>
                    <select name="type"
                        class="w-full rounded border border-stroke bg-gray py-3 px-4.5 text-black focus:border-primary dark:border-strokedark dark:bg-meta-4 dark:text-white">
                        <option value="peminjaman" {{ $type == 'peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                        <option value="buku" {{ $type == 'buku' ? 'selected' : '' }}>Data Buku</option>
                        <option value="anggota" {{ $type == 'anggota' ? 'selected' : '' }}>Data Anggota</option>
                        <option value="denda" {{ $type == 'denda' ? 'selected' : '' }}>Denda</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 rounded bg-primary py-3 px-6 font-medium text-gray hover:bg-opacity-90">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Action Buttons -->
        <div class="mb-6 flex flex-wrap gap-4">
            <a href="{{ route('admin.laporan.pdf', request()->all()) }}" target="_blank"
                class="inline-flex items-center justify-center gap-2.5 rounded-md bg-meta-1 py-3 px-6 font-medium text-white hover:bg-opacity-90">
                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M16.6667 2.5H3.33333C2.8731 2.5 2.5 2.8731 2.5 3.33333V16.6667C2.5 17.1269 2.8731 17.5 3.33333 17.5H16.6667C17.1269 17.5 17.5 17.1269 17.5 16.6667V3.33333C17.5 2.8731 17.1269 2.5 16.6667 2.5ZM15.8333 15.8333H4.16667V4.16667H15.8333V15.8333Z"
                        fill="currentColor" />
                </svg>
                Download PDF
            </a>
            <a href="{{ route('admin.laporan.excel', request()->all()) }}"
                class="inline-flex items-center justify-center gap-2.5 rounded-md bg-success py-3 px-6 font-medium text-white hover:bg-opacity-90">
                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M16.6667 2.5H3.33333C2.8731 2.5 2.5 2.8731 2.5 3.33333V16.6667C2.5 17.1269 2.8731 17.5 3.33333 17.5H16.6667C17.1269 17.5 17.5 17.1269 17.5 16.6667V3.33333C17.5 2.8731 17.1269 2.5 16.6667 2.5ZM13.3333 12.5L10 15.8333L6.66667 12.5H9.16667V7.5H10.8333V12.5H13.3333Z"
                        fill="currentColor" />
                </svg>
                Export Excel
            </a>
            <button onclick="window.print()"
                class="inline-flex items-center justify-center gap-2.5 rounded-md bg-warning py-3 px-6 font-medium text-white hover:bg-opacity-90">
                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.8333 5H4.16667V1.66667H15.8333V5ZM15.8333 14.1667H4.16667V12.5H15.8333V14.1667ZM18.3333 6.66667H1.66667V13.3333H4.16667V16.6667H15.8333V13.3333H18.3333V6.66667Z"
                        fill="currentColor" />
                </svg>
                Print
            </button>
        </div>

        <!-- Preview Area -->
        <div
            class="rounded-[20px] border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark overflow-hidden">
            <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Pratinjau Laporan ({{ ucfirst($type) }})
                </h3>
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
                            <div class="grid grid-cols-5 border-b border-stroke dark:border-strokedark">
                                <div class="p-2.5 xl:p-4">{{ $row->id_buku }}</div>
                                <div class="p-2.5 xl:p-4 font-bold">{{ $row->judul_buku }}</div>
                                <div class="p-2.5 xl:p-4">{{ $row->penulis }}</div>
                                <div class="p-2.5 xl:p-4">{{ $row->kategori->nama_kategori ?? '-' }}</div>
                                <div class="p-2.5 xl:p-4 text-center">{{ $row->stok }}</div>
                            </div>
                        @endforeach

                    @elseif($type == 'anggota')
                        <div class="grid grid-cols-4 rounded-sm bg-gray-2 dark:bg-meta-4">
                            <div class="p-2.5 xl:p-4">ID</div>
                            <div class="p-2.5 xl:p-4">Nama Pengguna</div>
                            <div class="p-2.5 xl:p-4">Email</div>
                            <div class="p-2.5 xl:p-4 text-center">Tgl Registrasi</div>
                        </div>
                        @foreach($data as $row)
                            <div class="grid grid-cols-4 border-b border-stroke dark:border-strokedark">
                                <div class="p-2.5 xl:p-4">{{ $row->id_pengguna }}</div>
                                <div class="p-2.5 xl:p-4 font-bold">{{ $row->nama_pengguna }}</div>
                                <div class="p-2.5 xl:p-4">{{ $row->email }}</div>
                                <div class="p-2.5 xl:p-4 text-center">{{ $row->created_at->format('Y-m-d') }}</div>
                            </div>
                        @endforeach

                    @elseif($type == 'peminjaman')
                        <div class="grid grid-cols-5 rounded-sm bg-gray-2 dark:bg-meta-4">
                            <div class="p-2.5 xl:p-4">Peminjam</div>
                            <div class="p-2.5 xl:p-4">Buku</div>
                            <div class="p-2.5 xl:p-4 text-center">Tgl Pinjam</div>
                            <div class="p-2.5 xl:p-4 text-center">Tgl Kembali</div>
                            <div class="p-2.5 xl:p-4 text-center">Status</div>
                        </div>
                        @foreach($data as $row)
                            <div class="grid grid-cols-5 border-b border-stroke dark:border-strokedark text-sm">
                                <div class="p-2.5 xl:p-4">{{ $row->pengguna->nama_pengguna }}</div>
                                <div class="p-2.5 xl:p-4">
                                    @foreach($row->detail as $dtl)
                                        <div>• {{ $dtl->buku->judul_buku ?? 'Buku Tidak Ditemukan' }}</div>
                                    @endforeach
                                </div>
                                <div class="p-2.5 xl:p-4 text-center">{{ $row->tgl_pinjam }}</div>
                                <div class="p-2.5 xl:p-4 text-center">{{ $row->tgl_kembali ?? '-' }}</div>
                                <div class="p-2.5 xl:p-4 text-center">{{ ucfirst($row->status_transaksi) }}</div>
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