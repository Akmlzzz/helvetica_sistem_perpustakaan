<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblio - Sistem Perpustakaan Digital</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        html {
            scroll-behavior: smooth;
        }

        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .delay-100 {
            transition-delay: 0.1s;
        }

        .delay-200 {
            transition-delay: 0.2s;
        }

        .delay-300 {
            transition-delay: 0.3s;
        }

        .delay-400 {
            transition-delay: 0.4s;
        }

        .delay-500 {
            transition-delay: 0.5s;
        }
    </style>
</head>

<body class="font-sans antialiased text-[#3F3D56] bg-[#E6E6E6]">
    <x-navbar />
    <x-hero />

    <!-- Seksi Fitur (Smart Dashboard) -->
    <section id="fitur" class="py-16 md:py-24 bg-white relative overflow-hidden">
        <div class="container mx-auto px-6">
            <!-- Top Header (Badge & Tagline) -->
            <div
                class="reveal-on-scroll flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div class="px-8 py-2 rounded-full bg-[#084734] text-white font-medium text-sm">
                    Fitur
                </div>
                <p class="text-[#3F3D56] font-semibold text-sm md:text-base">
                    Semua yang Kamu Butuhin, Tanpa Drama.
                </p>
            </div>

            <!-- Headline & Description -->
            <div class="reveal-on-scroll delay-100 max-w-4xl mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight mb-6 text-[#3F3D56]">
                    Pantau <span class="text-[#87D800]">hobi bacamu dalam satu dasbor cerdas.</span> Lupakan
                    cara lama tanya petugas secara manual.
                </h2>
                <p class="text-gray-600 text-lg md:text-xl leading-relaxed">
                    Dengan fitur manajemen otomatis, fokusmu kini hanya satu: temukan
                    buku favorit dan nikmati setiap lembarnya.
                </p>
            </div>

            <!-- Content Grid (Cards Left, Image Right) -->
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Left: 2x2 Grid Cards -->
                <div class="w-full lg:w-1/2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Card 1 -->
                    <div
                        class="reveal-on-scroll delay-200 bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-[#87D800] transition group min-h-[220px] flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-[#084734] mb-1">Booking Fisik</h3>
                            <h3 class="text-lg font-bold text-[#87D800] mb-4">Real-Time</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Amankan stok buku incaran kamu langsung dari HP. Status stok selalu update 24/7.
                            </p>
                        </div>
                        <div class="w-full h-0.5 bg-[#87D800] rounded-full mt-4"></div>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="reveal-on-scroll delay-300 bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-[#87D800] transition group min-h-[220px] flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-[#3F3D56] mb-4">Kartu Anggota<br>Digital</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Gak perlu ribet bawa kartu fisik. Tunjukkan QR Code kamu di lobi, dan langsung ambil
                                bukunya.
                            </p>
                        </div>
                        <div class="w-full h-0.5 bg-[#87D800] mt-4"></div>
                    </div>

                    <!-- Card 3 -->
                    <div
                        class="reveal-on-scroll delay-400 bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-[#87D800] transition group min-h-[220px] flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-[#3F3D56] mb-4">Smart Fine<br>Tracker</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Pantau masa pinjam secara transparan. Dapat notifikasi sebelum jatuh tempo biar bebas
                                dari denda.
                            </p>
                        </div>
                        <div class="w-full h-0.5 bg-[#87D800] mt-4"></div>
                    </div>

                    <!-- Card 4 -->
                    <div
                        class="reveal-on-scroll delay-500 bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-[#87D800] transition group min-h-[220px] flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-[#87D800] mb-4">Dashboard<br>Personal</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Lihat progres bacaan, genre favorit, dan koleksi wishlist dalam satu tampilan aesthetic.
                            </p>
                        </div>
                        <div class="w-full h-0.5 bg-[#87D800] mt-4"></div>
                    </div>
                </div>

                <!-- Right: Image -->
                <div class="w-full lg:w-1/2 flex justify-center lg:justify-end">
                    <img src="{{ asset('img/fitur-vector.svg') }}" alt="Ilustrasi Fitur"
                        class="reveal-on-scroll delay-300 w-full max-w-lg object-contain">
                </div>
            </div>
        </div>
    </section>

    <!-- Seksi Cara Kerja (3 Step) -->
    <section id="cara-pinjam" class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-6">
            <!-- Header -->
            <div class="reveal-on-scroll text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#084734] mb-3">Cara Pinjam</h2>
                <p class="text-xl text-[#3F3D56] font-medium">Hanya 3 Langkah Menuju Rak Buku Kamu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Step 1: Full Width -->
                <div
                    class="reveal-on-scroll delay-100 md:col-span-2 bg-[#F9FCF8] border border-[#E4F5E0] rounded-[2.5rem] p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-12 group hover:shadow-lg transition-all duration-300">
                    <div class="md:w-1/2 flex flex-col items-start text-left">
                        <span
                            class="inline-block px-6 py-2 rounded-full border border-gray-300 text-gray-500 text-sm font-medium mb-6 bg-white group-hover:border-[#87D800] group-hover:text-[#084734] transition-colors">
                            Langkah 1
                        </span>
                        <h3 class="text-2xl md:text-3xl font-bold text-[#084734] mb-4">Registrasi & Verifikasi</h3>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            Daftar online dan unggah ID kamu. Tim kami akan aktivasi akun kamu dalam waktu singkat.
                        </p>
                    </div>
                    <div class="md:w-1/2 flex justify-center md:justify-end">
                        <img src="{{ asset('img/cara-pinjam-1.svg') }}" alt="Registrasi"
                            class="h-[250px] w-auto object-contain">
                    </div>
                </div>

                <!-- Step 2 -->
                <div
                    class="reveal-on-scroll delay-200 bg-[#F9FCF8] border border-[#E4F5E0] rounded-[2.5rem] p-8 md:p-12 flex flex-col items-start h-full group hover:shadow-lg transition-all duration-300">
                    <span
                        class="inline-block px-6 py-2 rounded-full border border-gray-300 text-gray-500 text-sm font-medium mb-6 bg-white group-hover:border-[#87D800] group-hover:text-[#084734] transition-colors">
                        Langkah 2
                    </span>
                    <h3 class="text-2xl font-bold text-[#084734] mb-4">Pilih & Booking</h3>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        Cari buku di katalog, klik 'Pinjam', dan sistem otomatis mengunci stok buku itu hanya untuk
                        kamu.
                    </p>
                    <div class="w-full flex justify-center mt-auto">
                        <img src="{{ asset('img/cara-pinjam-2.svg') }}" alt="Booking"
                            class="h-[220px] w-auto object-contain">
                    </div>
                </div>

                <!-- Step 3 -->
                <div
                    class="reveal-on-scroll delay-300 bg-[#F9FCF8] border border-[#E4F5E0] rounded-[2.5rem] p-8 md:p-12 flex flex-col items-start h-full group hover:shadow-lg transition-all duration-300">
                    <span
                        class="inline-block px-6 py-2 rounded-full border border-gray-300 text-gray-500 text-sm font-medium mb-6 bg-white group-hover:border-[#87D800] group-hover:text-[#084734] transition-colors">
                        Langkah 3
                    </span>
                    <h3 class="text-2xl font-bold text-[#084734] mb-4">Ambil & Baca</h3>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        Datang ke perpustakaan, scan QR Code di petugas, dan bawa pulang petualangan barumu.
                    </p>
                    <div class="w-full flex justify-center mt-auto">
                        <img src="{{ asset('img/cara-pinjam-3.svg') }}" alt="Pick Up"
                            class="h-[220px] w-auto object-contain">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seksi Eksplorasi & Katalog -->
    <section id="katalog" class="py-16 md:py-24 bg-[#084734] text-white overflow-hidden relative">
        <!-- Background Elements -->
        <div
            class="absolute -top-20 -right-20 w-96 h-96 bg-[#87D800] rounded-full mix-blend-multiply filter blur-3xl opacity-20">
        </div>
        <div
            class="absolute -bottom-20 -left-20 w-96 h-96 bg-[#CEF17B] rounded-full mix-blend-multiply filter blur-3xl opacity-20">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <!-- Header & Search -->
            <div class="reveal-on-scroll text-center max-w-4xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-4">Apa yang ingin Anda jelajahi hari ini?</h2>
                <p class="text-[#CEF17B]/80 text-lg mb-10">Cari judul, penulis, atau buku yang sedang menghantui
                    pikiranmu.</p>

                <!-- Search component -->
                <div class="bg-white p-2 rounded-full shadow-2xl flex items-center max-w-2xl mx-auto">
                    <!-- Category Dropdown -->
                    <div class="relative group">
                        <button
                            class="flex items-center gap-2 px-6 py-3 text-gray-700 font-medium hover:bg-gray-50 rounded-full transition-colors">
                            <span>Kategori</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>

                    <div class="h-8 w-px bg-gray-200 mx-2"></div>

                    <!-- Search Input -->
                    <div class="flex-1 flex items-center px-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" placeholder="Cari Judul/penulis...."
                            class="w-full py-2 text-gray-700 focus:outline-none placeholder-gray-400 bg-transparent">
                    </div>
                </div>
            </div>

            <!-- Featured Cards (3 Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">
                <!-- Card 1: Baru Di Tambahkan -->
                <div
                    class="reveal-on-scroll delay-100 bg-[#CEF17B] rounded-3xl p-6 relative overflow-hidden h-64 md:h-72 flex items-center group">
                    <div class="relative z-10 w-1/2 flex flex-col items-start justify-center h-full">
                        <h3 class="text-2xl font-bold text-[#084734] mb-1 leading-tight">Baru Di<br>Tambahkan.</h3>
                        <button
                            class="mt-6 px-5 py-2.5 bg-[#8FA75B] text-white text-xs font-bold rounded-lg hover:bg-[#7d924d] transition shadow-lg">
                            Pinjam Sekarang
                        </button>
                    </div>
                    <div class="absolute right-4 top-4 bottom-4 w-1/2 flex items-center justify-center">
                        <img src="{{ asset('img/buku-1.jfif') }}" alt="Buku Baru"
                            class="h-full object-cover rounded-md shadow-2xl transform group-hover:scale-105 transition-transform duration-500 rotate-3 group-hover:rotate-0">
                    </div>
                </div>

                <!-- Card 2: Sedang Populer -->
                <div
                    class="reveal-on-scroll delay-200 bg-[#87D800] rounded-3xl p-6 relative overflow-hidden h-64 md:h-72 flex items-center group">
                    <div class="relative z-10 w-1/2 flex flex-col items-start justify-center h-full">
                        <h3 class="text-2xl font-bold text-[#084734] mb-1 leading-tight">Sedang<br>Populer.</h3>
                        <button
                            class="mt-6 px-5 py-2.5 bg-[#4F7F00] text-white text-xs font-bold rounded-lg hover:bg-[#3d6300] transition shadow-lg">
                            Pinjam Sekarang
                        </button>
                    </div>
                    <div class="absolute right-4 top-4 bottom-4 w-1/2 flex items-center justify-center">
                        <img src="{{ asset('img/buku-2.jfif') }}" alt="Buku Populer"
                            class="h-full object-cover rounded-md shadow-2xl transform group-hover:scale-105 transition-transform duration-500 -rotate-3 group-hover:rotate-0">
                    </div>
                </div>

                <!-- Card 3: Rekomendasi -->
                <div
                    class="reveal-on-scroll delay-300 bg-brand-600 rounded-3xl p-6 relative overflow-hidden h-64 md:h-72 flex items-center group border border-[#87D800]/20">
                    <div class="relative z-10 w-1/2 flex flex-col items-start justify-center h-full">
                        <h3 class="text-2xl font-bold text-white mb-1 leading-tight">Rekomendasi</h3>
                        <button
                            class="mt-6 px-5 py-2.5 bg-[#CEF17B] text-[#084734] text-xs font-bold rounded-lg hover:bg-[#b8d96b] transition shadow-lg">
                            Pinjam Sekarang
                        </button>
                    </div>
                    <div class="absolute right-4 top-4 bottom-4 w-1/2 flex items-center justify-center">
                        <img src="{{ asset('img/buku-3.jfif') }}" alt="Buku Rekomendasi"
                            class="h-full object-cover rounded-md shadow-2xl transform group-hover:scale-105 transition-transform duration-500 rotate-6 group-hover:rotate-0">
                    </div>
                </div>
            </div>

            <!-- Bottom Banner -->
            <div
                class="reveal-on-scroll delay-400 bg-[#FAFFF3] border border-[#ECEDF0] rounded-[2.5rem] p-8 md:p-12 flex flex-col md:flex-row items-center gap-12 text-[#084734]">
                <div class="w-full md:w-1/3 flex justify-center md:justify-start">
                    <!-- Using existing illustration -->
                    <img src="{{ asset('img/katalog-buku-1.svg') }}" alt="Illustration"
                        class="h-48 md:h-64 object-contain">
                </div>
                <div class="w-full md:w-2/3 text-center">
                    <p class="text-gray-600 font-medium mb-4">Gabung bareng 5.000+ pembaca lainnya yang udah
                        hidup<br>lebih produktif bareng sistem perpustakaan digital kami.</p>
                    <h2 class="text-3xl md:text-4xl font-bold mb-8 leading-tight">
                        Pendaftaran 100% gratis dan proses<br>verifikasinya tidak lama.
                    </h2>
                    <div class="flex justify-center">
                        <button
                            class="bg-[#084734] text-white px-8 py-3 rounded-lg font-bold hover:bg-brand-600 transition shadow-lg">
                            Pinjam Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seksi Layanan Kami -->
    <section id="layanan" class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-6">
            <!-- Header -->
            <div class="reveal-on-scroll flex flex-col md:flex-row justify-between items-start mb-16 gap-4">
                <h2 class="text-3xl md:text-5xl font-bold text-[#084734]">Layanan Kami</h2>
                <p class="text-xl text-[#3F3D56] font-medium">Lebih Dari Sekadar Peminjaman.</p>
            </div>

            <!-- Layanan Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1: Request Buku -->
                <div
                    class="reveal-on-scroll delay-100 bg-white border-2 border-[#87D800] rounded-[2.5rem] p-8 flex flex-col items-center text-center h-full group hover:shadow-xl transition-all duration-300">
                    <h3 class="text-2xl font-bold text-[#3F3D56] mb-2">Request Buku</h3>
                    <div class="w-16 h-1 bg-[#87D800] rounded-full mb-6"></div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-auto">
                        Buku incaran belum ada? Usulkan judul favorit kamu ke tim kami, biar kami prioritaskan untuk
                        koleksi selanjutnya.
                    </p>
                    <div class="mt-8 h-48 w-full flex items-end justify-center">
                        <img src="{{ asset('img/layanan-1.svg') }}" alt="Request Buku"
                            class="h-40 w-auto object-contain">
                    </div>
                </div>

                <!-- Card 2: Loket Mandiri -->
                <div
                    class="reveal-on-scroll delay-200 bg-[#084734] rounded-[2.5rem] p-8 flex flex-col items-center text-center h-full hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                    <h3 class="text-2xl font-bold text-white mb-2">Loket Mandiri</h3>
                    <div class="w-16 h-1 bg-white/20 rounded-full mb-6"></div>
                    <p class="text-white/80 text-sm leading-relaxed mb-auto">
                        Ambil buku yang sudah kamu booking lewat loket otomatis tanpa perlu antre di meja petugas. Cepat
                        dan praktis!
                    </p>
                    <div class="mt-8 h-48 w-full flex items-end justify-center">
                        <img src="{{ asset('img/layanan-2.svg') }}" alt="Loket Mandiri"
                            class="h-40 w-auto object-contain brightness-0 invert">
                    </div>
                </div>

                <!-- Card 3: Ruang Baca & Coworking -->
                <div
                    class="reveal-on-scroll delay-300 bg-white border-2 border-[#87D800] rounded-[2.5rem] p-8 flex flex-col items-center text-center h-full group hover:shadow-xl transition-all duration-300">
                    <h3 class="text-2xl font-bold text-[#3F3D56] mb-2">Ruang Baca & Coworking</h3>
                    <div class="w-16 h-1 bg-[#87D800] rounded-full mb-6"></div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-auto">
                        Akses fasilitas WiFi kencang, area baca yang estetik, dan ruang diskusi privat buat dukung
                        produktivitas kamu.
                    </p>
                    <div class="mt-8 h-48 w-full flex items-end justify-center">
                        <img src="{{ asset('img/layanan-3.svg') }}" alt="Ruang Baca" class="h-40 w-auto object-contain">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seksi Tentang Kami & Tim -->
    <section id="tentang-kami" class="py-16 md:py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-6">
            <!-- Bagian 1: Tentang Kami -->
            <div class="reveal-on-scroll flex flex-col md:flex-row items-center gap-12 mb-32">
                <!-- Text Content -->
                <div class="w-full md:w-1/2">
                    <h2 class="text-3xl md:text-5xl font-bold text-[#084734] mb-6">
                        Tentang <span class="text-[#87D800]">Kami</span>
                    </h2>
                    <h3 class="text-xl md:text-2xl font-bold text-[#3F3D56] mb-4">
                        Modernisasi Literasi untuk Masa Depan.
                    </h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Mentransformasi perpustakaan konvensional menjadi <span
                            class="text-[#87D800] font-bold">ekosistem digital yang relevan</span> dengan kebutuhan
                        zaman.
                        Melalui inovasi teknologi, kami memastikan akses informasi menjadi lebih mudah, cepat, dan
                        terpercaya bagi seluruh lapisan masyarakat.
                    </p>
                </div>
                <!-- Illustration -->
                <div class="w-full md:w-1/2 flex justify-center md:justify-end relative">
                    <!-- Decorative background element -->
                    <div class="absolute -bottom-4 right-10 w-3/4 h-4 bg-gray-100 rounded-full blur-sm"></div>
                    <img src="{{ asset('img/tentang-kami.svg') }}" alt="Tentang Kami Library"
                        class="max-w-md w-full object-contain relative z-10">
                </div>
            </div>

            <!-- Bagian 2: Tim Profesional -->
            <div class="reveal-on-scroll delay-200 text-center mb-16 relative">
                <!-- Decorative Asterisk/Flower -->
                <div class="absolute left-[10%] -top-10 hidden md:block animate-spin-slow"
                    style="animation-duration: 10s;">
                    <img src="{{ asset('img/tim-bintang.svg') }}" alt="Star Decoration" class="w-20 h-20">
                </div>

                <h2 class="text-2xl md:text-4xl font-bold text-[#3F3D56]">
                    <span class="text-[#87D800]">Tim Profesional</span> di Balik Inovasi <span
                        class="bg-[#CEF17B] px-2 py-1 rotate-2 inline-block text-[#084734]">Biblio.</span>
                </h2>
            </div>

            <!-- Team Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Card 1: Akmal Irsyad -->
                <div class="reveal-on-scroll delay-300 flex flex-col items-center group">
                    <div
                        class="w-full bg-gray-200 rounded-t-xl rounded-b-xl overflow-hidden shadow-lg relative aspect-3/4 mb-6">
                        <img src="{{ asset('img/tim-1.jfif') }}" alt="Akmal Irsyad" class="w-full h-full object-cover">
                        <!-- Name Bar -->
                        <div class="absolute bottom-0 left-0 w-full bg-[#CEF17B] py-3 text-center">
                            <h4 class="font-bold text-[#084734] text-lg">Akmal Irsyad</h4>
                        </div>
                    </div>
                    <!-- Role Pill -->
                    <div class="px-6 py-2 rounded-full border border-gray-300 text-center w-full max-w-[280px]">
                        <p class="font-bold text-[#3F3D56] text-sm">
                            <span class="block font-extrabold text-[#084734]">CTO</span>
                            <span class="text-gray-500 font-normal text-xs">Chief Technology Officer</span>
                        </p>
                    </div>
                </div>

                <!-- Card 2: Rista Aneu Febriyanti -->
                <div class="reveal-on-scroll delay-400 flex flex-col items-center group">
                    <div
                        class="w-full bg-gray-200 rounded-t-xl rounded-b-xl overflow-hidden shadow-lg relative aspect-3/4 mb-6">
                        <img src="{{ asset('img/tim-2.jfif') }}" alt="Rista Aneu Febriyanti"
                            class="w-full h-full object-cover">
                        <!-- Name Bar -->
                        <div class="absolute bottom-0 left-0 w-full bg-[#084734] py-3 text-center">
                            <h4 class="font-bold text-white text-lg">Rista Aneu Febriyanti</h4>
                        </div>
                    </div>
                    <!-- Role Pill -->
                    <div class="px-6 py-2 rounded-full border border-gray-300 text-center w-full max-w-[280px]">
                        <p class="font-bold text-[#3F3D56] text-sm">
                            <span class="block font-extrabold text-[#084734]">UIUX & FE</span>
                            <span class="text-gray-500 font-normal text-xs">UIUX | Front End developer</span>
                        </p>
                    </div>
                </div>

                <!-- Card 3: Moch Rihenza Adam -->
                <div class="reveal-on-scroll delay-500 flex flex-col items-center group">
                    <div
                        class="w-full bg-gray-200 rounded-t-xl rounded-b-xl overflow-hidden shadow-lg relative aspect-3/4 mb-6">
                        <img src="{{ asset('img/tim-3.jfif') }}" alt="Moch Rihenza Adam"
                            class="w-full h-full object-cover">
                        <!-- Name Bar -->
                        <div class="absolute bottom-0 left-0 w-full bg-[#CEF17B] py-3 text-center">
                            <h4 class="font-bold text-[#084734] text-lg">Moch Rihenza Adam</h4>
                        </div>
                    </div>
                    <!-- Role Pill -->
                    <div class="px-6 py-2 rounded-full border border-gray-300 text-center w-full max-w-[280px]">
                        <p class="font-bold text-[#3F3D56] text-sm">
                            <span class="block font-extrabold text-[#084734]">BE</span>
                            <span class="text-gray-500 font-normal text-xs">Back End Developer</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seksi CTA -->
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-6">
            <div
                class="reveal-on-scroll bg-[#87D800] rounded-[3rem] p-8 md:p-16 relative overflow-hidden flex flex-col md:flex-row items-center">
                <!-- Left Content -->
                <div class="w-full md:w-1/2 relative z-10 text-left mb-10 md:mb-0">
                    <h2 class="text-3xl md:text-5xl font-bold text-[#084734] mb-6 leading-tight">
                        Gak perlu mikir dua kali buat jadi lebih pintar.
                    </h2>
                    <p class="text-[#084734]/80 text-lg md:text-xl font-medium mb-10 max-w-lg leading-relaxed">
                        Mulai perjalanan literasi kamu sekarang secara gratis, verifikasi akun, dan langsung
                        booking buku favorit kamu.
                    </p>
                    <a href="{{ route('register') }}"
                        class="inline-block bg-[#084734] text-white px-8 py-4 rounded-xl font-bold hover:bg-brand-600 transition shadow-lg text-lg">
                        Daftar Sekarang
                    </a>
                </div>

                <!-- Right Image (Slanted Dashboard) -->
                <div
                    class="w-full md:w-1/2 relative h-64 md:absolute md:top-0 md:bottom-0 md:-right-32 flex items-center justify-center md:h-full mt-4 md:mt-0">
                    <img src="{{ asset('img/dashboard-cta.png') }}" alt="Dashboard Preview"
                        class="w-full h-full object-contain object-center md:object-right transform md:rotate-[-8deg] md:translate-y-0 scale-100 md:scale-110">
                </div>
            </div>
        </div>
    </section>



    <!-- Footer -->
    <footer class="bg-white pt-20 pb-10 border-t border-gray-100">
        <div class="container mx-auto px-6">
            <!-- Partners -->
            <div
                class="flex flex-wrap justify-center items-center gap-16 md:gap-24 mb-20 grayscale hover:grayscale-0 transition-all duration-500 opacity-60 hover:opacity-100">
                <img src="{{ asset('img/Gramedia_wordmark.svg') }}" alt="Gramedia" class="h-8 md:h-12 w-auto">
                <img src="{{ asset('img/Penguin Random House New 2024.svg') }}" alt="Penguin Random House"
                    class="h-10 md:h-16 w-auto">
                <img src="{{ asset('img/WLF-logo.png') }}" alt="WLF" class="h-10 md:h-14 w-auto">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <img src="{{ asset('img/Logo.svg') }}" alt="Biblio" class="h-8 w-auto">
                    </div>
                    <p class="text-gray-500 mb-8 text-sm leading-relaxed">Akses literasi digital untuk semua. Membaca
                        jadi lebih mudah, seru,
                        dan terjangkau.</p>
                    <div class="flex gap-4">
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-[#F5F5F5] flex items-center justify-center text-[#084734] hover:bg-[#87D800] transition">
                            <span class="sr-only">Facebook</span>
                            <svg fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/biblio.official/?hl=en"
                            class="w-10 h-10 rounded-full bg-[#F5F5F5] flex items-center justify-center text-[#084734] hover:bg-[#87D800] transition">
                            <span class="sr-only">Instagram</span>
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-[#F5F5F5] flex items-center justify-center text-[#084734] hover:bg-[#87D800] transition">
                            <span class="sr-only">Twitter</span>
                            <svg fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                                <path
                                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Links 1 -->
                <div>
                    <h4 class="font-bold text-[#084734] mb-6">Platform</h4>
                    <ul class="space-y-4 text-gray-500 text-sm font-medium">
                        <li><a href="#" class="hover:text-[#87D800] transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-[#87D800] transition">Fitur & Layanan</a></li>
                        <li><a href="#" class="hover:text-[#87D800] transition">Koleksi Buku</a></li>
                        <li><a href="#" class="hover:text-[#87D800] transition">Harga & Paket</a></li>
                    </ul>
                </div>

                <!-- Links 2 -->
                <div>
                    <h4 class="font-bold text-[#084734] mb-6">Bantuan</h4>
                    <ul class="space-y-4 text-gray-500 text-sm font-medium">
                        <li><a href="#" class="hover:text-[#87D800] transition">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-[#87D800] transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-[#87D800] transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-[#87D800] transition">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-[#084734] mb-6">Hubungi Kami</h4>
                    <ul class="space-y-5 text-gray-500 text-sm font-medium">
                        <li class="flex gap-4">
                            <span class="text-[#87D800] text-lg">📍</span>
                            <span>Gedung Literasi Modern, .<br>Jl. Raya Ciwidey No. 123, Ciwidey, Kab. Bandung,
                                40973</span>
                        </li>
                        <li class="flex gap-4">
                            <span class="text-[#87D800] text-lg">📧</span>
                            <span>biblio@biblio.id</span>
                        </li>
                        <li class="flex gap-4">
                            <span class="text-[#87D800] text-lg">📞</span>
                            <span>+62 xxx xxxx xxxx</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} The Helvetica Group. All Rights Reserved.
                </p>
                <div class="flex items-center gap-4 opacity-50">
                    <img src="{{ asset('img/laravel-logolockup-rgb-red.png') }}" alt="Laravel" class="h-5 grayscale">
                    <img src="{{ asset('img/tailwindcss-logotype.svg') }}" alt="Tailwind" class="h-3 grayscale">
                </div>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal-on-scroll').forEach((section) => {
                observer.observe(section);
            });

            // Active Link Highlighting
            const sections = document.querySelectorAll('section[id], div[id="beranda"]');
            const navLinks = document.querySelectorAll('.nav-link');

            function highlightNavLink() {
                let current = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    // Offset for sticky header (approx 150px)
                    if (window.scrollY >= (sectionTop - 150)) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    // Reset to inactive state
                    link.classList.remove('text-gray-900', 'font-bold');
                    link.classList.add('text-gray-500', 'font-medium');

                    // Add active state if matches
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.remove('text-gray-500', 'font-medium');
                        link.classList.add('text-gray-900', 'font-bold');
                    }
                });
            }

            window.addEventListener('scroll', highlightNavLink);
            // Call once on load to set initial state
            highlightNavLink();

        });
    </script>
</body>

</html>