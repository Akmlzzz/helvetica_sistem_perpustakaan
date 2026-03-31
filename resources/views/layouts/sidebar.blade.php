@php
    use App\Helpers\MenuHelper;
    $menuGroups = MenuHelper::getMenuGroups();
    $currentPath = request()->path();
@endphp

{{-- Sidebar: collapsed = 48px (icon only), expanded = 240px (icon + label) --}}
<aside id="sidebar"
    class="fixed top-[47px] left-0 flex flex-col h-[calc(100vh-47px)] bg-white dark:bg-[#052e25] border-r border-gray-200 dark:border-[#052e25] overflow-hidden transition-[width] duration-250 ease-in-out z-998"
    :class="{
        'w-[240px]': $store.sidebar.isExpanded || $store.sidebar.isMobileOpen || $store.sidebar.isHovered,
        'w-[48px]':  !$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen,
        'translate-x-0':        $store.sidebar.isMobileOpen,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
    }"
    @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)">

    {{-- ── Nav Menu ── --}}
    <div class="flex flex-col flex-1 overflow-y-auto overflow-x-hidden py-2 no-scrollbar"
        x-data="{
            openSubmenus: {},
            currentPath: '{{ $currentPath }}',
            init() { this.initActiveMenus(); },
            initActiveMenus() {
                @foreach ($menuGroups as $gi => $group)
                    @foreach ($group['items'] as $ii => $item)
                        @if(isset($item['subItems']))
                            @foreach ($item['subItems'] as $sub)
                                if (window.location.pathname === '{{ $sub['path'] }}' ||
                                    this.currentPath === '{{ ltrim($sub['path'], '/') }}') {
                                    this.openSubmenus['{{ $gi }}-{{ $ii }}'] = true;
                                }
                            @endforeach
                        @endif
                    @endforeach
                @endforeach
            },
            toggle(gi, ii) { const k = gi+'-'+ii; this.openSubmenus[k] = !this.openSubmenus[k]; },
            isOpen(gi, ii)  { return !!this.openSubmenus[gi+'-'+ii]; },
            isActive(path)  { return window.location.pathname === path || this.currentPath === path.replace(/^\//, ''); },
            isGroupActive(subs) {
                return subs.some(s => window.location.pathname === s.path || this.currentPath === s.path.replace(/^\//, ''));
            }
        }">

        <nav>
            @foreach ($menuGroups as $gi => $group)
                {{-- No horizontal padding on ul — let items control their own padding --}}
                <ul class="flex flex-col mb-1">
                    @foreach ($group['items'] as $ii => $item)
                        <li class="px-2">
                            @if(isset($item['subItems']))
                                {{-- ── Submenu Parent ── --}}
                                <div x-data="{ open: false }" x-effect="open = isOpen('{{ $gi }}', {{ $ii }})">
                                    <button @click.prevent="toggle('{{ $gi }}', {{ $ii }})"
                                        class="w-full flex items-center h-[40px] rounded-md transition-colors duration-150 whitespace-nowrap group relative"
                                        :class="isGroupActive({{ json_encode($item['subItems']) }})
                                            ? 'bg-[#F3F7EB] text-[#004236] font-semibold dark:bg-[#004236]/30 dark:text-white'
                                            : 'text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800'">

                                        {{-- Icon: always fixed at same X — no dynamic class so icon NEVER moves --}}
                                        <span class="flex items-center justify-center shrink-0 w-[32px] h-[32px]">
                                            {!! str_replace(['size-6', 'class="'], ['w-[18px] h-[18px]', 'class="'], MenuHelper::getIconSvg($item['icon'])) !!}
                                        </span>

                                        {{-- Label --}}
                                        <span class="flex-1 text-sm truncate text-left ml-2"
                                            x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                            x-transition:enter="transition-opacity duration-[150ms] delay-[80ms]"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition-opacity duration-[80ms]"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0">
                                            {{ $item['name'] }}
                                        </span>

                                        {{-- Chevron --}}
                                        <svg class="w-3.5 h-3.5 mr-2 shrink-0 transition-transform duration-150"
                                            :class="{ 'rotate-180': open }"
                                            x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>

                                    {{-- Submenu items --}}
                                    <div x-show="open && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="opacity-0 -translate-y-1"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        class="mt-0.5 ml-[34px] border-l-2 border-gray-200 dark:border-gray-700 pl-2">
                                        @foreach ($item['subItems'] as $sub)
                                            <a href="{{ url($sub['path']) }}"
                                                class="flex items-center h-[34px] px-2 text-[13px] font-medium rounded-md transition-colors whitespace-nowrap mt-0.5"
                                                :class="isActive('{{ $sub['path'] }}')
                                                    ? 'text-[#004236] font-semibold bg-[#F3F7EB] dark:text-white dark:bg-[#004236]/30'
                                                    : 'text-gray-500 hover:text-[#004236] hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800'">
                                                {{ $sub['name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                            @else
                                {{-- ── Simple Item ── --}}
                                <a href="{{ url($item['path']) }}"
                                    class="w-full flex items-center h-[40px] rounded-md transition-colors duration-150 whitespace-nowrap group relative"
                                    :class="isActive('{{ $item['path'] }}')
                                        ? 'bg-[#F3F7EB] text-[#004236] font-semibold dark:bg-[#004236]/30 dark:text-white'
                                        : 'text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800'">

                                    {{-- Icon: always fixed at same X — no dynamic class so icon NEVER moves --}}
                                    <span class="flex items-center justify-center shrink-0 w-[32px] h-[32px] relative">
                                        {!! str_replace(['size-6', 'class="'], ['w-[18px] h-[18px]', 'class="'], MenuHelper::getIconSvg($item['icon'])) !!}
                                        {{-- Badge dot (collapsed only) --}}
                                        @if(!empty($item['badge']))
                                            <span class="absolute -top-0.5 -right-0.5 w-[7px] h-[7px] rounded-full bg-red-500 ring-1 ring-white"
                                                x-show="!($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)"></span>
                                        @endif
                                    </span>

                                    {{-- Label --}}
                                    <span class="flex-1 text-sm truncate ml-2"
                                        x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                        x-transition:enter="transition-opacity duration-[150ms] delay-[80ms]"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition-opacity duration-[80ms]"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0">
                                        {{ $item['name'] }}
                                    </span>

                                    {{-- Badge pill (expanded only) --}}
                                    @if(!empty($item['badge']))
                                        <span class="mr-2 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-500 px-1.5 text-[10px] font-bold text-white shrink-0"
                                            x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                                            {{ $item['badge'] > 99 ? '99+' : $item['badge'] }}
                                        </span>
                                    @endif
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </nav>
    </div>

    {{-- ── Log Out ── --}}
    <div class="px-2 pb-3 shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center h-[40px] rounded-md bg-[#004236] hover:bg-[#00362b] text-white transition-colors duration-150 shadow-sm overflow-hidden">
                {{-- Icon: fixed, same X position always --}}
                <span class="flex items-center justify-center shrink-0 w-[32px] h-[32px]">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
                <span class="text-sm font-semibold whitespace-nowrap ml-2"
                    x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                    x-transition:enter="transition-opacity duration-[150ms] delay-[80ms]"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-[80ms]"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    Log Out
                </span>
            </button>
        </form>
    </div>
</aside>