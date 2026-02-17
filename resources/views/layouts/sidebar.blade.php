@php
    use App\Helpers\MenuHelper;
    $menuGroups = MenuHelper::getMenuGroups();

    // Get current path
    $currentPath = request()->path();
@endphp

<aside id="sidebar"
    class="fixed flex flex-col mt-0 top-0 px-5 left-0 bg-white dark:bg-[#052e25] dark:border-[#052e25] text-gray-900 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-gray-200"
    class="fixed flex flex-col mt-0 top-0 px-5 left-0 bg-white dark:bg-[#052e25] dark:border-[#052e25] text-gray-900 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-gray-200"
    :class="{
        'w-[270px]': $store.sidebar.isExpanded || $store.sidebar.isMobileOpen || $store.sidebar.isHovered,
        'w-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
        'translate-x-0': $store.sidebar.isMobileOpen,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
    }" @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)">

    <!-- Logo Section -->
    <div class="pt-8 pb-7 flex items-center gap-3"
        :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'xl:justify-center' : 'justify-start'">
        <a href="/" class="flex items-center gap-2">
            <!-- Full Logo (when expanded) -->
            <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                <!-- Light Theme Logo -->
                <img src="{{ asset('img/logo.svg') }}" alt="Biblio" class="h-8 w-auto dark:hidden">
                <!-- Dark Theme Logo -->
                <img src="{{ asset('img/Logo - light.svg') }}" alt="Biblio" class="hidden h-8 w-auto dark:block">
            </div>
            <span class="text-2xl"
                x-show="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen">📚</span>
        </a>
    </div>

    <!-- Navigation Menu -->
    <div class="flex flex-col grow overflow-y-auto duration-300 ease-linear no-scrollbar mt-5" x-data="{
            openSubmenus: {},
            currentPath: '{{ $currentPath }}',
            init() {
                this.initializeActiveMenus();
            },
            initializeActiveMenus() {
                @foreach ($menuGroups as $groupIndex => $menuGroup)
                    @foreach ($menuGroup['items'] as $itemIndex => $item)
                        @if (isset($item['subItems']))
                            @foreach ($item['subItems'] as $subItem)
                                if (this.currentPath === '{{ ltrim($subItem['path'], '/') }}' ||
                                    window.location.pathname === '{{ $subItem['path'] }}') {
                                    this.openSubmenus['{{ $groupIndex }}-{{ $itemIndex }}'] = true;
                            } @endforeach
                        @endif
                    @endforeach
                @endforeach
            },
            toggleSubmenu(groupIndex, itemIndex) {
                const key = groupIndex + '-' + itemIndex;
                this.openSubmenus[key] = !this.openSubmenus[key];
            },
            isSubmenuOpen(groupIndex, itemIndex) {
                return this.openSubmenus[groupIndex + '-' + itemIndex] === true;
            },
            isActive(path) {
                return window.location.pathname === path || this.currentPath === path.replace(/^\//, '');
            },
            isGroupActive(subItems) {
                const pathname = window.location.pathname;
                return subItems.some(subItem => 
                    pathname === subItem.path || this.currentPath === subItem.path.replace(/^\//, '')
                );
            }
         }">
        <nav class="mb-6">
            <div class="flex flex-col gap-2">
                @foreach ($menuGroups as $groupIndex => $menuGroup)
                    <div>
                        <ul class="flex flex-col gap-1.5">
                            @foreach ($menuGroup['items'] as $itemIndex => $item)
                                <li>
                                    @if (isset($item['subItems']))
                                        <!-- Menu Item with Submenu -->
                                        <div x-data="{ expanded: false }"
                                            x-effect="expanded = isSubmenuOpen('{{ $groupIndex }}', {{ $itemIndex }})">
                                            <button @click.prevent="toggleSubmenu('{{ $groupIndex }}', {{ $itemIndex }})"
                                                class="menu-item group w-full flex items-center justify-between px-3 py-2 font-medium transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
                                                :class="isGroupActive({{ json_encode($item['subItems']) }}) ? 'text-[#004236] font-bold dark:text-white' : 'text-gray-900 dark:text-gray-400'">

                                                <div class="flex items-center gap-3">
                                                    <!-- Icon LEFT -->
                                                    <span
                                                        :class="isGroupActive({{ json_encode($item['subItems']) }}) ? 'text-[#004236] dark:text-white' : 'text-gray-500'">
                                                        {!! MenuHelper::getIconSvg($item['icon']) !!}
                                                    </span>
                                                    <!-- Text Right of Icon -->
                                                    <span
                                                        x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                                                        {{ $item['name'] }}
                                                    </span>
                                                </div>

                                                <div class="flex items-center gap-2"
                                                    x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                                                    <!-- Chevron -->
                                                    <svg class="w-4 h-4 transition-transform duration-200"
                                                        :class="{ 'rotate-180': expanded }" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </div>
                                            </button>

                                            <!-- Submenu -->
                                            <div x-show="expanded && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100" class="pl-4 mt-1">
                                                <ul
                                                    class="flex flex-col gap-1 border-l-2 border-gray-100 dark:border-gray-800 pl-3">
                                                    @foreach ($item['subItems'] as $subItem)
                                                        <li>
                                                            <a href="{{ url($subItem['path']) }}"
                                                                class="block px-3 py-1.5 text-sm font-medium rounded-lg transition-colors hover:text-[#004236] dark:hover:text-white"
                                                                :class="isActive('{{ $subItem['path'] }}') ? 'text-[#004236] font-bold dark:text-white' : 'text-gray-500 dark:text-gray-400'">
                                                                {{ $subItem['name'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Simple Menu Item -->
                                        <a href="{{ url($item['path']) }}"
                                            class="menu-item group w-full flex items-center justify-between px-3 py-2 font-medium transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"
                                            :class="isActive('{{ $item['path'] }}') ? 'text-[#004236] font-bold dark:text-white' : 'text-gray-900 dark:text-gray-400'">

                                            <div class="flex items-center gap-3">
                                                <span
                                                    :class="isActive('{{ $item['path'] }}') ? 'text-[#004236] dark:text-white' : 'text-gray-500'">
                                                    {!! MenuHelper::getIconSvg($item['icon']) !!}
                                                </span>
                                                <!-- Text Right of Icon -->
                                                <span
                                                    x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                                                    {{ $item['name'] }}
                                                </span>
                                            </div>
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </nav>
    </div>

    <!-- Sign Out Button -->
    <div class="mb-8 px-0"
        x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center justify-center w-full gap-2 px-4 py-3 text-sm font-bold text-white transition-all bg-[#004236] rounded-xl hover:bg-[#00362b] shadow-lg hover:shadow-xl">
                Log Out
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
            </button>
        </form>
    </div>
</aside>