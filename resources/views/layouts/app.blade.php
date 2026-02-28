<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | TailAdmin - Laravel Tailwind CSS Admin Dashboard Template</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    {{--
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <!-- Theme Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                // Initialize based on screen size
                isExpanded: window.innerWidth >= 1280, // true for desktop, false for mobile
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    // When toggling desktop sidebar, ensure mobile menu is closed
                    this.isMobileOpen = false;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                    // Don't modify isExpanded when toggling mobile menu
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },

                setHovered(val) {
                    // Only allow hover effects on desktop when sidebar is collapsed
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
        });
    </script>

    <!-- Apply light mode only -->
    <script>
        localStorage.setItem('theme', 'light');
        document.documentElement.classList.remove('dark');
        document.body.classList.remove('dark', 'bg-slate-950');
    </script>

</head>

<body x-data="{ 'loaded': true}" x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
    const checkMobile = () => {
        if (window.innerWidth < 1280) {
            $store.sidebar.setMobileOpen(false);
            $store.sidebar.isExpanded = false;
        } else {
            $store.sidebar.isMobileOpen = false;
            $store.sidebar.isExpanded = true;
        }
    };
    window.addEventListener('resize', checkMobile);" class="dark:bg-slate-950">

    {{-- preloader --}}
    <x-common.preloader />
    {{-- preloader end --}}

    <div class="min-h-screen xl:flex">
        @include('layouts.backdrop')
        @include('layouts.sidebar')

        <div class="flex-1 transition-all duration-300 ease-in-out" :class="{
                'xl:ml-[270px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            <!-- app header start -->
            @include('layouts.app-header')
            <!-- app header end -->
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6 mt-[70px]">
                @yield('content')
            </div>
        </div>

    </div>

    <!-- Global Success Notification Modal -->
    @if(session('success') && !Str::contains(strtolower(session('success')), ['hapus', 'delete']))
        <div x-data="{ show: true }" x-show="show" style="display: none;"
            class="fixed inset-0 z-999999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-5 overflow-y-auto">
            <div @click.outside="show = false"
                class="w-full max-w-sm rounded-lg bg-white px-8 py-10 dark:bg-boxdark text-center shadow-2xl transform transition-all animate-fade-in-up">
                <div
                    class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                    <svg class="h-10 w-10 text-[#10B981]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-bold text-black dark:text-white">Berhasil!</h3>
                <p class="mb-8 text-gray-500 dark:text-gray-400">{{ session('success') }}</p>

                <button @click="show = false"
                    class="w-full rounded-lg bg-[#10B981] py-3 px-6 font-medium text-white hover:bg-[#059669] shadow-md transition-colors border-none cursor-pointer">
                    Selesai
                </button>
            </div>
        </div>

        <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fadeInUp 0.3s ease-out;
            }
        </style>
    @elseif(session('success'))
        <!-- Red warning toast for deletions -->
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-10"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-10"
            class="fixed bottom-10 right-10 z-999999 flex items-center gap-4 rounded-xl bg-red-600 px-6 py-4 text-white shadow-2xl border-l-4 border-red-800">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white/20">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold">Dihapus!</h4>
                <p class="text-sm text-red-100">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="ml-2 hover:text-red-200 transition-colors">
                <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13.725 4.275a.75.75 0 00-1.05 0L9 7.95 5.325 4.275a.75.75 0 00-1.05 1.05L7.95 9l-3.675 3.675a.75.75 0 001.05 1.05L9 10.05l3.675 3.675a.75.75 0 001.05-1.05L10.05 9l3.675-3.675a.75.75 0 000-1.05z"
                        fill="currentColor" />
                </svg>
            </button>
        </div>
    @endif

    <x-chatbot-widget />
</body>

@stack('scripts')

</html>