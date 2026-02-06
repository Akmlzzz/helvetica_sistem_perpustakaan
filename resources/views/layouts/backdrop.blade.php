<div x-show="$store.sidebar.isMobileOpen" class="fixed inset-0 z-30 bg-transparent lg:hidden"
  x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
  x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
  x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
  @click="$store.sidebar.setMobileOpen(false)"></div>