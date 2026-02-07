<header
    class="fixed top-0 z-998 flex w-full bg-white drop-shadow-1 dark:bg-slate-900 dark:drop-shadow-none min-h-[70px] transition-all duration-300"
    :class="{
        'xl:left-[270px] xl:w-[calc(100%-270px)]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
        'xl:left-[90px] xl:w-[calc(100%-90px)]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
        'left-0 w-full': !($store.sidebar.isExpanded || $store.sidebar.isHovered)
    }">
    <div class="flex grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">
        <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
            <!-- Hamburger Toggle BTN -->
            <button
                class="z-99999 block rounded-sm border border-gray-200 bg-white p-1.5 shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:hidden"
                @click.stop="$store.sidebar.toggleMobileOpen()">
                <svg class="h-6 w-6 stroke-current text-brand-primary dark:text-gray-200" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
            <!-- Hamburger Toggle BTN -->

            <a class="block shrink-0 lg:hidden" href="{{ route('dashboard') }}">
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
            <!-- Dark Mode Toggler -->
            <button type="button" @click="$store.theme.toggle()"
                class="flex h-10 w-10 items-center justify-center rounded-full text-brand-primary bg-gray-50 hover:text-brand-primary hover:bg-gray-100 dark:bg-slate-800 dark:text-gray-400 dark:hover:text-white">
                <span class="sr-only">Toggle dark mode</span>
                <!-- Sun Icon -->
                <svg x-show="$store.theme.theme === 'light'" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
                <!-- Moon Icon -->
                <svg x-show="$store.theme.theme === 'dark'" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
            </button>
            <!-- Dark Mode Toggler -->

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
                            <a href="#"
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