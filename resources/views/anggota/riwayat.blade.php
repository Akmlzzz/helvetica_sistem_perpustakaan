@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 gap-9 xl:grid-cols-3">
        <!-- Main Content: Table History -->
        <div class="xl:col-span-2 flex flex-col gap-9">
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                    <h3 class="font-medium text-black dark:text-white">
                        Riwayat Peminjaman
                    </h3>
                </div>
                <div class="p-6.5">
                    <div class="max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                    <th class="min-w-[200px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                                        Buku
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Tgl Pinjam
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Kembali
                                    </th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $loan)
                                    @foreach($loan->detail as $detail)
                                        <tr>
                                            <td class="border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                                                <h5 class="font-medium text-black dark:text-white">
                                                    {{ $detail->buku->judul_buku ?? 'Judul Tidak Diketahui' }}</h5>
                                            </td>
                                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                                <p class="text-black dark:text-white">
                                                    {{ \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d M Y') }}</p>
                                            </td>
                                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                                <p class="text-black dark:text-white">
                                                    {{ \Carbon\Carbon::parse($loan->tgl_kembali)->format('d M Y') }}</p>
                                            </td>
                                            <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                                                <span
                                                    class="inline-flex rounded-full bg-success bg-opacity-10 py-1 px-3 text-sm font-medium text-success">
                                                    Selesai
                                                </span>
                                                @if($loan->denda)
                                                    <span
                                                        class="inline-flex rounded-full bg-danger bg-opacity-10 py-1 px-3 text-sm font-medium text-danger ml-2">
                                                        Denda: Rp {{ number_format($loan->denda->jumlah_denda, 0, ',', '.') }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">Belum ada riwayat peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Denda Widget -->
        <div class="flex flex-col gap-9">
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                    <h3 class="font-medium text-black dark:text-white">
                        Tagihan Denda
                    </h3>
                </div>
                <div class="p-6.5">
                    <div class="flex flex-col gap-4">
                        @php $totalDenda = 0; @endphp
                        @forelse($tagihanDenda as $denda)
                            @php $totalDenda += $denda->jumlah_denda; @endphp
                            <!-- Item Denda -->
                            <div class="flex items-start justify-between rounded bg-gray-50 p-3 dark:bg-meta-4">
                                <div>
                                    <h5 class="text-sm font-bold text-black dark:text-white">
                                        {{ $denda->peminjaman->detail->first()->buku->judul_buku ?? 'Buku' }}
                                    </h5>
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($denda->peminjaman->tgl_kembali)->format('d M Y') }}</p>
                                </div>
                                <span class="text-sm font-bold text-danger">Rp
                                    {{ number_format($denda->jumlah_denda, 0, ',', '.') }}</span>
                            </div>
                        @empty
                            <p class="text-center text-sm text-gray-500 py-4">Tidak ada tagihan denda.</p>
                        @endforelse

                        <div class="border-t border-stroke pt-4 dark:border-strokedark flex justify-between items-center">
                            <span class="font-medium">Total Denda</span>
                            <span class="text-lg font-bold text-danger">Rp
                                {{ number_format($totalDenda, 0, ',', '.') }}</span>
                        </div>

                        @if($totalDenda > 0)
                            <button
                                class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90">
                                Bayar Sekarang
                            </button>
                            <p class="text-xs text-center text-gray-500">Pembayaran dapat dilakukan di meja petugas.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection