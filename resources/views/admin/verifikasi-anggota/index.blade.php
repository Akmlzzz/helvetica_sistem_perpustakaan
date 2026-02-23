@extends('layouts.app')

@section('title', 'Verifikasi Anggota')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Verifikasi Anggota</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola pendaftaran anggota baru yang menunggu verifikasi</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.verifikasi-anggota.all') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Semua Anggota
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 dark:bg-yellow-900 rounded-lg p-3">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingMembers->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 dark:bg-green-900 rounded-lg p-3">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ App\Models\Pengguna::where('level_akses', 'anggota')->where('status', 'active')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 dark:bg-red-900 rounded-lg p-3">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l2-2m-2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ditolak</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ App\Models\Pengguna::where('level_akses', 'anggota')->where('status', 'rejected')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="rounded-[20px] border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 xl:pb-1">
        <form method="GET" action="{{ route('admin.verifikasi-anggota.index') }}"
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
                    placeholder="Cari Nama, Email, atau Telepon..."
                    class="w-full rounded-lg border border-stroke bg-transparent pl-12 pr-4 py-2 font-medium outline-none focus:border-primary dark:border-strokedark dark:text-white" />
            </div>

            <!-- Filter Tanggal Daftar -->
            <div class="relative w-full sm:w-48">
                <select name="tanggal_daftar" onchange="this.form.submit()"
                    class="w-full appearance-none rounded-lg border border-stroke bg-transparent px-4 py-2 pr-10 font-medium outline-none focus:border-primary dark:border-strokedark dark:bg-form-input dark:text-white">
                    <option value="" class="text-gray-500">Semua Tanggal</option>
                    <option value="hari_ini" {{ request('tanggal_daftar') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="minggu_ini" {{ request('tanggal_daftar') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="bulan_ini" {{ request('tanggal_daftar') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="tahun_ini" {{ request('tanggal_daftar') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
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
                    <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="nama_za" {{ request('sort') == 'nama_za' ? 'selected' : '' }}>Nama (Z-A)</option>
                </select>
                <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.47072 1.08816C0.47072 1.02932 0.50072 0.97048 0.559553 0.911642C0.677219 0.793976 0.912552 0.793976 1.03022 0.911642L4.99988 4.8813L8.96954 0.911642C9.0872 0.793976 9.32254 0.793976 9.44021 0.911642C9.55787 1.02931 9.55787 1.26464 9.44021 1.38231L5.23522 5.5873C5.11756 5.70497 4.88222 5.70497 4.76456 5.5873L0.559553 1.38231C0.50072 1.32348 0.47072 1.26464 0.47072 1.08816Z" fill="currentColor"/>
                    </svg>
                </div>
            </div>
        </form>

        <!-- Clear Filters -->
        @if(request()->hasAny(['search', 'tanggal_daftar', 'sort']))
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Menampilkan {{ $pendingMembers->count() }} dari {{ $pendingMembers->total() }} anggota
                </p>
                <a href="{{ route('admin.verifikasi-anggota.index') }}" 
                   class="text-sm text-primary hover:text-primary/80 font-medium">
                    Hapus Filter
                </a>
            </div>
        @endif
    </div>

    <!-- Pending Members Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Menunggu Verifikasi</h2>
        </div>

        @if($pendingMembers->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Anggota</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Daftar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($pendingMembers as $member)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="shrink-0 h-10 w-10 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                                {{ strtoupper(substr($member->nama_pengguna, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $member->nama_pengguna }}</div>
                                            @if($member->anggota)
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $member->anggota->nama_lengkap }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $member->email }}</div>
                                    @if($member->anggota)
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $member->anggota->nomor_telepon }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $member->dibuat_pada->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Pending
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <!-- View Button -->
                                        <a href="{{ route('admin.verifikasi-anggota.show', $member->id_pengguna) }}" 
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 text-gray-700 rounded-lg bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-gray-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7z"></path>
                                            </svg>
                                            Detail
                                        </a>
                                        
                                        <!-- Approve Button -->
                                        <button @click="openApproveModal({{ $member->id_pengguna }}, '{{ $member->nama_pengguna }}')"
                                                class="inline-flex items-center px-3 py-2 border border-green-300 text-green-700 rounded-lg bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-gray-800 dark:border-green-600 dark:text-green-400 dark:hover:bg-green-700 dark:focus:ring-green-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Verifikasi
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $pendingMembers->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada anggota menunggu verifikasi</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Semua anggota sudah diverifikasi</p>
            </div>
        @endif
    </div>
</div>

<!-- Approve Confirmation Modal -->
<div x-data="approveModal()" 
     x-show="isOpen" 
     @open-approve-modal.window="openModal($event.detail)"
     style="display: none;"
     class="fixed inset-0 z-999999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-6">
     
    <div @click.stop 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="relative w-full max-w-md transform overflow-hidden rounded-lg bg-white text-left shadow-xl dark:bg-gray-800">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Verifikasi Anggota</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Setujui pendaftaran anggota baru</p>
                </div>
            </div>
        </div>
        
        <!-- Body -->
        <div class="px-6 py-4">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center mr-3">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300"
                              x-text="memberName ? memberName.substring(0, 2).toUpperCase() : ''">
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="memberName"></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Username anggota</p>
                    </div>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                    Apakah Anda yakin ingin menyetujui anggota ini? Setelah disetujui, anggota akan mendapatkan nomor anggota dan dapat mengakses semua fitur perpustakaan.
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <div class="flex justify-end space-x-3">
                <button @click="closeModal()" 
                        class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </button>
                <form :action="actionUrl" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="rounded-lg border border-transparent bg-green-600 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Ya, Setujui
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function approveModal() {
    return {
        isOpen: false,
        memberId: null,
        memberName: '',
        actionUrl: '',
        openModal(data) {
            this.memberId = data.id;
            this.memberName = data.name;
            this.actionUrl = `/verifikasi-anggota/${data.id}/approve`;
            this.isOpen = true;
        },
        closeModal() {
            this.isOpen = false;
        }
    }
}
</script>
@endsection
