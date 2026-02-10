<div class="relative w-full min-h-screen overflow-hidden bg-white bg-cover bg-center bg-no-repeat flex flex-col"
    style="background-image: url('{{ asset('img/Bg-hero.png') }}');">
    <!-- Navbar -->
    <div class="sticky top-0 z-50 w-full bg-white shadow-md">
        <nav class="container mx-auto px-6 py-4" x-data="{ isOpen: false }">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <img src="{{ asset('img/Logo.svg') }}" alt="Biblio Logo" class="h-8 w-auto">
                </div>

                <!-- Menu Items (Desktop) -->
                <div class="hidden items-center gap-8 md:flex">
                    <a href="#" class="text-sm font-medium text-gray-900 hover:text-brand-primary">Beranda</a>
                    <a href="#" class="text-sm font-medium text-gray-500 hover:text-brand-primary">Fitur</a>
                    <a href="#" class="text-sm font-medium text-gray-500 hover:text-brand-primary">Katalog buku</a>
                    <a href="#" class="text-sm font-medium text-gray-500 hover:text-brand-primary">Cara pinjam</a>
                    <a href="#" class="text-sm font-medium text-gray-500 hover:text-brand-primary">Layanan</a>
                    <a href="#" class="text-sm font-medium text-gray-500 hover:text-brand-primary">Tentang kami</a>
                </div>

                <!-- CTA Button (Desktop) -->
                <a href="{{ route('login') }}"
                    class="hidden rounded-full border border-gray-200 bg-white px-6 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 md:inline-flex">
                    Masuk
                </a>

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
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="absolute left-0 right-0 top-full z-50 flex w-full flex-col gap-4 border-t border-gray-100 bg-white p-4 shadow-lg md:hidden">
                <a href="#" class="text-sm font-medium text-gray-900 hover:text-brand-primary">Beranda</a>
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-brand-primary">Fitur</a>
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-brand-primary">Katalog buku</a>
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-brand-primary">Cara pinjam</a>
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-brand-primary">Layanan</a>
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-brand-primary">Tentang kami</a>
                <a href="{{ route('login') }}"
                    class="w-full text-center rounded-full border border-gray-200 bg-white px-6 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                    Masuk
                </a>
            </div>
        </nav>
    </div>

    <!-- Hero Content -->
    <div
        class="container mx-auto flex flex-grow flex-col-reverse items-center justify-center px-6 py-8 pb-24 md:flex-row md:py-0">
        <!-- Left Column: Content -->
        <div
            class="z-10 mt-12 flex w-full flex-col items-center text-center md:items-start md:text-left md:mt-0 md:w-1/2">
            <div class="mb-6 inline-flex items-center rounded-full border border-brand-primary/20 bg-brand-secondary/30 px-4 py-1.5 animate-fade-in-up"
                style="animation-delay: 0.2s; opacity: 0; animation-fill-mode: forwards;">
                <span class="text-sm font-medium text-brand-primary">Digitalisasi Pengelolaan Buku Pintar</span>
            </div>

            <h1 class="mb-6 text-4xl font-bold leading-tight text-gray-900 md:text-5xl lg:text-6xl animate-fade-in-up"
                style="animation-delay: 0.4s; opacity: 0; animation-fill-mode: forwards;">
                Akses Literasi Jadi<br>
                Lebih <span class="text-[#87D800]">Sat-set dan</span><br>
                <span class="text-[#87D800]">Anti Ribet.</span>
            </h1>

            <p class="mb-8 max-w-lg text-lg text-gray-600 animate-fade-in-up"
                style="animation-delay: 0.6s; opacity: 0; animation-fill-mode: forwards;">
                Kartu fisik tertinggal? Tidak masalah. Tunjukkan kartu digitalmu dari HP, ambil bukumu, dan mulai
                berpetualang.
            </p>

            <div class="flex flex-col gap-3 sm:flex-row animate-fade-in-up"
                style="animation-delay: 0.8s; opacity: 0; animation-fill-mode: forwards;">
                <a href="{{ route('register') }}"
                    class="group inline-flex items-center justify-center gap-2 rounded-full bg-[#064e3b] px-8 py-3.5 text-base font-semibold text-white transition hover:bg-[#064e3b]/90">
                    Coba Biblio Sekarang Gratis
                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <p class="mt-4 text-sm text-gray-500">Tidak perlu instalasi manual, langsung akses via web.</p>
        </div>

        <!-- Right Column: Images & Decorations -->
        <div class="relative hidden w-full justify-center md:flex md:h-[600px] md:w-1/2 animate-fade-in-up"
            style="animation-delay: 1s; opacity: 0; animation-fill-mode: forwards;">
            <!-- Floating Cards Container with Centered Decoration -->
            <div class="relative flex h-[350px] w-full max-w-[550px] items-center justify-center md:h-full">
                <!-- Background Decoration Circle (Centered) -->
                <div class="absolute inset-0 z-0 flex items-center justify-center opacity-20">
                    <img src="{{ asset('img/Linkaran.png') }}" alt="Decoration"
                        class="h-[300px] w-[300px] md:h-[600px] md:w-[600px] object-contain">
                </div>

                <!-- Card 1: Statistik (Top Left - White) -->
                <div class="animate-float absolute left-2 top-4 z-30 w-44 md:left-0 md:top-24 md:w-[400px]"
                    style="animation-delay: 0s;">
                    <img src="{{ asset('img/Card-statistik.png') }}" alt="Statistik Card"
                        class="h-auto w-full drop-shadow-xl">
                </div>

                <!-- Card 2: Anggota (Bottom Right - Bright Green) -->
                <div class="animate-float absolute bottom-8 -right-2 z-20 w-48 md:-right-16 md:bottom-24 md:w-[450px]"
                    style="animation-delay: 0.8s;">
                    <img src="{{ asset('img/Card-Anggota.png') }}" alt="Anggota Card"
                        class="h-auto w-full drop-shadow-2xl">
                </div>

                <!-- Card 3: Verify (Bottom Left - Dark Green) -->
                <div class="animate-float absolute bottom-2 left-0 z-10 w-48 md:bottom-16 md:left-4 md:w-96"
                    style="animation-delay: 1.5s;">
                    <img src="{{ asset('img/Card-Verify.png') }}" alt="Verify Card"
                        class="h-auto w-full drop-shadow-xl">
                </div>
            </div>
        </div>
    </div>
</div>