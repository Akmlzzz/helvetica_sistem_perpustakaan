<header
    class="fixed top-0 z-998 flex w-full bg-white drop-shadow-1 dark:bg-slate-900 dark:drop-shadow-none min-h-[70px] transition-all duration-300"
    :class="{
        'xl:left-[270px] xl:w-[calc(100%-270px)]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
        'xl:left-[90px] xl:w-[calc(100%-90px)]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
        'left-0 w-full': !($store.sidebar.isExpanded || $store.sidebar.isHovered)
    }">
    <div class="flex grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">
        <div class="flex items-center gap-2 sm:gap-4 xl:hidden">
            <!-- Hamburger Toggle BTN -->
            <button
                class="z-99999 block rounded-sm border border-gray-200 bg-white p-1.5 shadow-sm dark:border-slate-800 dark:bg-slate-900 xl:hidden"
                @click.stop="$store.sidebar.toggleMobileOpen()">
                <svg class="h-6 w-6 stroke-current text-brand-primary dark:text-gray-200" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
            <!-- Hamburger Toggle BTN -->

            <a class="block shrink-0 xl:hidden" href="{{ route('dashboard') }}">
                <!-- Light Mode Logo -->
                <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="h-8 w-auto dark:hidden">
                <!-- Dark Mode Logo -->
                <img src="{{ asset('img/Logo - light.svg') }}" alt="Logo" class="hidden h-8 w-auto dark:block">
            </a>
        </div>

        <div class="hidden sm:block">
            <h1 class="text-xl font-bold text-brand-primary dark:text-white">Dashboard</h1>
        </div>

        <div class="flex items-center gap-3 2xl:gap-7">

            <!-- ===== PENDING MEMBER NOTIFICATION (ANGGOTA ONLY) ===== -->
            @if(Auth::user() && Auth::user()->isAnggota() && Auth::user()->isPending())
                <div class="relative" x-data="{ pendingOpen: false }" @click.outside="pendingOpen = false">
                    <button class="relative flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 hover:bg-yellow-200 transition-colors duration-200 focus:outline-none"
                            @click.stop="pendingOpen = !pendingOpen" title="Status Verifikasi">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-yellow-500 rounded-full animate-pulse">!</span>
                    </button>

                    <!-- Pending Notification Dropdown -->
                    <div x-show="pendingOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                        class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-yellow-200 z-50 overflow-hidden"
                        style="display: none;">

                        <!-- Header -->
                        <div class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-white">Menunggu Verifikasi</h3>
                                <p class="text-xs text-yellow-100">Akun Anda sedang diverifikasi</p>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 mb-1">Akun Anda Menunggu Verifikasi</p>
                                        <p class="text-xs text-gray-600 mb-3">Mohon menunggu, admin akan memverifikasi akun Anda segera. Anda akan mendapatkan notifikasi ketika akun telah disetujui.</p>
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>Daftar: {{ Auth::user()->dibuat_pada->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- ===== NOTIFICATION BELL ===== -->
            @php
                $notifCount = \App\Models\Notifikasi::where('id_pengguna', Auth::id())
                    ->where('sudah_dibaca', false)
                    ->count();
                $notifList = \App\Models\Notifikasi::where('id_pengguna', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->take(8)
                    ->get();
                
                // Tambahkan count untuk anggota pending (admin only)
                $pendingAnggotaCount = 0;
                if (Auth::user() && Auth::user()->isAdmin()) {
                    $pendingAnggotaCount = \App\Models\Pengguna::where('level_akses', 'anggota')
                        ->where('status', 'pending')
                        ->count();
                }
            @endphp

            <div class="relative" x-data="{ notifOpen: false }" @click.outside="notifOpen = false">
                <button id="notif-bell-btn"
                    class="relative flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors duration-200 focus:outline-none"
                    @click.stop="notifOpen = !notifOpen" title="Notifikasi">
                    <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if($notifCount > 0 || $pendingAnggotaCount > 0)
                        <span id="notif-badge"
                            class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">
                            {{ ($notifCount + $pendingAnggotaCount) > 9 ? '9+' : ($notifCount + $pendingAnggotaCount) }}
                        </span>
                    @endif
                </button>

                <!-- Notification Dropdown -->
                <div x-show="notifOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                    class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden"
                    style="display: none;">

                    <!-- Header -->
                    <div
                        class="flex items-center justify-between px-4 py-3 bg-linear-to-r from-brand-primary to-blue-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <h3 class="text-sm font-semibold text-white">Notifikasi</h3>
                            @if($notifCount > 0)
                                <span
                                    class="px-2 py-0.5 text-xs font-bold bg-white/30 text-white rounded-full">{{ $notifCount }}
                                    baru</span>
                            @endif
                        </div>
                        @if($notifCount > 0)
                            <form method="POST" action="{{ route('notifikasi.baca-semua') }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="text-xs text-white/80 hover:text-white transition-colors underline">
                                    Tandai semua dibaca
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- List Notifikasi -->
                    <div class="max-h-80 overflow-y-auto divide-y divide-gray-50" id="notif-list">
                        <!-- Pending Members Notification (Admin Only) -->
                        @if(Auth::user() && Auth::user()->isAdmin() && $pendingAnggotaCount > 0)
                            <div class="px-4 py-3 bg-yellow-50 border-b border-yellow-200">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Anggota Menunggu Verifikasi</p>
                                            <p class="text-xs text-yellow-600">{{ $pendingAnggotaCount }} anggota baru</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.verifikasi-anggota.index') }}" 
                                       class="text-xs text-yellow-600 hover:text-yellow-700 font-medium">
                                        Verifikasi Sekarang →
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        @forelse($notifList as $notif)
                            <a href="{{ route('notifikasi.buka', $notif->id_notifikasi) }}"
                                class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors duration-150 {{ !$notif->sudah_dibaca ? 'bg-blue-50/50' : '' }} block relative group">
                                <!-- Icon -->
                                <div class="shrink-0 mt-0.5">
                                    @if($notif->tipe === 'pengajuan_baru')
                                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                    @elseif(str_contains($notif->pesan, 'disetujui'))
                                        <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-1">
                                        <p class="text-xs font-semibold text-gray-800 leading-tight">
                                            {{ $notif->judul }}
                                            @if(!$notif->sudah_dibaca)
                                                <span
                                                    class="inline-block w-2 h-2 rounded-full bg-blue-500 ml-1 align-middle"></span>
                                            @endif
                                        </p>
                                        <!-- Hapus -->
                                        <form method="POST" action="{{ route('notifikasi.hapus', $notif->id_notifikasi) }}"
                                            class="shrink-0" @click.stop>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-300 hover:text-red-400 transition-colors p-0.5 rounded"
                                                title="Hapus notifikasi">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-0.5 leading-snug line-clamp-2">{{ $notif->pesan }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="flex flex-col items-center justify-center py-10 text-center">
                                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-400">Tidak ada notifikasi</p>
                                <p class="text-xs text-gray-300 mt-1">Semua sudah dibaca</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Footer -->
                    @if($notifList->count() > 0)
                        <div class="px-4 py-2.5 border-t border-gray-100 bg-gray-50/50 text-center">
                            <p class="text-xs text-gray-400">Menampilkan {{ $notifList->count() }} notifikasi terbaru</p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- ===== END NOTIFICATION BELL ===== -->

            <!-- User Area -->
            <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                <a class="flex items-center gap-4" href="#" @click.prevent="dropdownOpen = ! dropdownOpen">
                    <span class="hidden text-right lg:block">
                        <span
                            class="block text-sm font-medium text-brand-primary dark:text-white">{{ Auth::user()->nama_pengguna ?? 'User' }}</span>
                        <span
                            class="block text-xs text-gray-500 dark:text-white">{{ ucfirst(Auth::user()->level_akses ?? 'Anggota') }}</span>
                    </span>

                    <span
                        class="h-12 w-12 rounded-full overflow-hidden bg-gray-200 border-2 border-white drop-shadow-sm flex items-center justify-center text-xl font-bold text-brand-primary">
                        {{ substr(Auth::user()->nama_pengguna ?? 'U', 0, 1) }}
                    </span>

                    <svg class="hidden fill-current sm:block" width="12" height="8" viewBox="0 0 12 8" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.410765 0.910734C0.736202 0.585297 1.26384 0.585297 1.58928 0.910734L6.00002 5.32148L10.4108 0.910734C10.7362 0.585297 11.2638 0.585297 11.5893 0.910734C11.9147 1.23617 11.9147 1.76381 11.5893 2.08924L6.58928 7.08924C6.26384 7.41468 5.7362 7.41468 5.41077 7.08924L0.410765 2.08924C0.0853277 1.76381 0.0853277 1.23617 0.410765 0.910734Z"
                            fill="" />
                    </svg>
                </a>

                <!-- Dropdown Start -->
                <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-4 flex w-62.5 flex-col rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-slate-800 z-50 min-w-[200px]"
                    style="display: none;">

                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <span
                            class="block text-sm font-medium text-brand-primary dark:text-white">{{ Auth::user()->nama_pengguna }}</span>
                        <span class="block text-xs text-gray-500">{{ Auth::user()->email }}</span>
                    </div>

                    <ul class="flex flex-col gap-1 border-b border-stroke px-4 py-3 dark:border-strokedark">
                        <li>
                            <a href="{{ Auth::user()->isAnggota() ? route('anggota.profile') : '#' }}"
                                class="flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-brand-primary lg:text-base py-1">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                My Profile
                            </a>
                        </li>
                    </ul>
                    <div class="px-4 py-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-brand-primary lg:text-base text-red-500">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Dropdown End -->
            </div>
            <!-- User Area -->
        </div>
    </div>
</header>