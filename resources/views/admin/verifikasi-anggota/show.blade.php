@extends('layouts.app')

@section('title', 'Detail Anggota - Verifikasi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.verifikasi-anggota.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Anggota</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Verifikasi pendaftaran anggota baru</p>
            </div>
        </div>
    </div>

    <!-- Member Info Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="h-16 w-16 bg-white/20 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-white">
                            {{ strtoupper(substr($member->nama_pengguna, 0, 2)) }}
                        </span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $member->nama_pengguna }}</h2>
                        <p class="text-green-100">{{ $member->email }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        Menunggu Verifikasi
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Akun -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Akun</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Username</label>
                            <p class="text-gray-900 dark:text-white">{{ $member->nama_pengguna }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                            <p class="text-gray-900 dark:text-white">{{ $member->email }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Level Akses</label>
                            <p class="text-gray-900 dark:text-white">{{ ucfirst($member->level_akses) }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Daftar</label>
                            <p class="text-gray-900 dark:text-white">{{ $member->dibuat_pada->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pribadi -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Pribadi</h3>
                    
                    @if($member->anggota)
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</label>
                                <p class="text-gray-900 dark:text-white">{{ $member->anggota->nama_lengkap }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Telepon</label>
                                <p class="text-gray-900 dark:text-white">{{ $member->anggota->nomor_telepon }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</label>
                                <p class="text-gray-900 dark:text-white">{{ $member->anggota->alamat }}</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">Data anggota belum lengkap</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row gap-3">
                    <form action="{{ route('admin.verifikasi-anggota.approve', $member->id_pengguna) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Setujui Pendaftaran
                        </button>
                    </form>

                    <button onclick="showRejectModal()" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Tolak Pendaftaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tolak Pendaftaran</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Masukkan alasan penolakan untuk memberi tahu calon anggota.</p>
            
            <form action="{{ route('admin.verifikasi-anggota.reject', $member->id_pengguna) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alasan Penolakan</label>
                    <textarea name="alasan_penolakan" rows="4" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white" required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideRejectModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('rejectModal');
    if (event.target == modal) {
        hideRejectModal();
    }
}
</script>
@endsection
