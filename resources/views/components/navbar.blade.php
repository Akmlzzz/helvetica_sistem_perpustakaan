<div class="sticky top-0 z-50 w-full bg-white shadow-md">
    <nav class="container mx-auto px-6 py-4" x-data="{ isOpen: false }">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/Logo.svg') }}" alt="Biblio Logo" class="h-8 w-auto">
            </div>

            <!-- Menu Items (Desktop) -->
            <div class="hidden items-center gap-8 md:flex">
                <a href="#beranda"
                    class="nav-link text-sm font-medium text-gray-500 hover:text-brand-primary transition-colors">Beranda</a>
                <a href="#fitur"
                    class="nav-link text-sm font-medium text-gray-500 hover:text-brand-primary transition-colors">Fitur</a>
                <a href="#cara-pinjam"
                    class="nav-link text-sm font-medium text-gray-500 hover:text-brand-primary transition-colors">Cara
                    pinjam</a>
                <a href="#katalog"
                    class="nav-link text-sm font-medium text-gray-500 hover:text-brand-primary transition-colors">Katalog
                    buku</a>

                <a href="#layanan"
                    class="nav-link text-sm font-medium text-gray-500 hover:text-brand-primary transition-colors">Layanan</a>
                <a href="#tentang-kami"
                    class="nav-link text-sm font-medium text-gray-500 hover:text-brand-primary transition-colors">Tentang
                    kami</a>
            </div>

            <!-- Desktop Auth/CTA -->
            @auth
                <div class="hidden items-center gap-4 md:flex">
                    <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : (auth()->user()->isPetugas() ? route('petugas.dashboard') : route('anggota.dashboard')) }}"
                        class="text-sm font-bold text-brand-primary hover:text-[#084734] transition-colors">
                        Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="rounded-full border border-red-200 bg-white px-6 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">
                            Keluar
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="hidden rounded-full border border-gray-200 bg-white px-6 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 md:inline-flex">
                    Masuk
                </a>
            @endauth

            <!-- Hamburger Button (Mobile) -->
            <button @click="isOpen = !isOpen" class="flex md:hidden text-gray-700 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="isOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="absolute left-0 right-0 top-full z-50 flex w-full flex-col gap-4 border-t border-gray-100 bg-white p-4 shadow-lg md:hidden">
            <a href="#beranda"
                class="nav-link text-sm font-medium text-gray-900 hover:text-brand-primary transition-colors">Beranda</a>
            <a href="#fitur"
                class="nav-link text-sm font-medium text-gray-500 hover:text-brand-primary transition-colors">Fitur</a>
            <a href="#cara-pinjam"
                class="nav-link text-sm font-medium text-gray-500 hover:text-brand-primary transition-colors">Cara
                pinjam</a>
            <a href="#katalog"
                class="nav-link text-sm font-medium text-gray-500 hover:text-brand-primary transition-colors">Katalog
                buku</a>
            <a href="#layanan"
                class="nav-link text-sm font-medium text-gray-500 hover:text-brand-primary transition-colors">Layanan</a>
            <a href="#tentang-kami"
                class="nav-link text-sm font-medium text-gray-500 hover:text-brand-primary transition-colors">Tentang
                kami</a>
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : (auth()->user()->isPetugas() ? route('petugas.dashboard') : route('anggota.dashboard')) }}"
                    class="nav-link text-sm font-bold text-brand-primary transition-colors">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full text-center rounded-full border border-red-200 bg-white px-6 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="w-full text-center rounded-full border border-gray-200 bg-white px-6 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                    Masuk
                </a>
            @endauth
        </div>
    </nav>
</div>