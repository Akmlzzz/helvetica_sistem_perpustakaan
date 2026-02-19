@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <!-- Active Booking Widget -->
        @if(session('success') || count($bookings) > 0)
            @foreach($bookings as $booking)
                <div class="rounded-sm border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark mb-4">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div>
                            <h4 class="text-xl font-bold text-black dark:text-white mb-1">Booking Aktif!</h4>
                            <p class="text-sm text-gray-500">
                                Buku: {{ $booking->detail->first()?->buku?->judul_buku ?? 'Judul tidak tersedia' }}
                                <br>
                                Tunjukkan kode ini kepada petugas untuk mengambil buku.
                            </p>
                        </div>
                        <div class="bg-gray-100 dark:bg-meta-4 rounded-lg px-6 py-3 text-center border-l-4 border-primary">
                            <span class="block text-xs uppercase tracking-wide text-gray-500">Kode Booking</span>
                            <span class="block text-2xl font-black text-primary">{{ $booking->kode_booking }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Tabel Pinjaman Aktif -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                <h3 class="font-medium text-black dark:text-white">
                    Pinjaman Saya
                </h3>
            </div>
            <div class="p-6.5">
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                                    Buku
                                </th>
                                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                                    Tgl Pinjam
                                </th>
                                <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                                    Batas Kembali
                                </th>
                                <th class="py-4 px-4 font-medium text-black dark:text-white">
                                    Sisa Hari
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeLoans as $loan)
                                @foreach($loan->detail as $detail)
                                    @php
                                        $tglKembali = \Carbon\Carbon::parse($loan->tgl_kembali);
                                        $sisaHari = now()->diffInDays($tglKembali, false);
                                        // Fix diffInDays logic:
                                        // if now > tglKembali, diff is negative. (Late)
                                        // if now < tglKembali, diff is positive.
                                        $sisaHari = (int) ceil($sisaHari);
                                        
                                        // logic badge
                                        // terlambat (merah) < 0
                                        // <= 1 (kuning)
                                        // > 1 (hijau)
                                    @endphp
                                    <tr>
                                        <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                            <h5 class="font-medium text-black dark:text-white">{{ $detail->buku->judul_buku ?? 'Judul Tidak Diketahui' }}</h5>
                                            <p class="text-xs text-gray-500">{{ $detail->buku->penulis ?? '-' }}</p>
                                        </td>
                                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                            <p class="text-black dark:text-white">{{ \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d M Y') }}</p>
                                        </td>
                                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                            <p class="{{ $sisaHari < 0 ? 'text-danger' : 'text-black dark:text-white' }}">
                                                {{ $tglKembali->format('d M Y') }}
                                            </p>
                                        </td>
                                        <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                            @if($sisaHari < 0)
                                                <span class="inline-flex rounded-full bg-danger bg-opacity-10 py-1 px-3 text-sm font-medium text-danger">
                                                    Terlambat {{ abs($sisaHari) }} Hari
                                                </span>
                                            @elseif($sisaHari <= 1)
                                                <span class="inline-flex rounded-full bg-warning bg-opacity-10 py-1 px-3 text-sm font-medium text-warning">
                                                    {{ $sisaHari == 0 ? 'Hari Ini' : $sisaHari . ' Hari' }}
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-success bg-opacity-10 py-1 px-3 text-sm font-medium text-success">
                                                    {{ $sisaHari }} Hari
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">Belum ada pinjaman aktif.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection