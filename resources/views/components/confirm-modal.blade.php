@props([
    'show' => false,
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin?',
    'confirmText' => 'Ya',
    'cancelText' => 'Batal',
    'confirmColor' => 'primary', // primary, danger, warning, success
    'icon' => null
])

@php
    $colorClasses = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        'warning' => 'bg-yellow-600 hover:bg-yellow-700 text-white',
        'success' => 'bg-green-600 hover:bg-green-700 text-white'
    ];
    
    $iconColorClasses = [
        'primary' => 'text-blue-600 bg-blue-100',
        'danger' => 'text-red-600 bg-red-100',
        'warning' => 'text-yellow-600 bg-yellow-100',
        'success' => 'text-green-600 bg-green-100'
    ];
    
    $confirmButtonClass = $colorClasses[$confirmColor] ?? $colorClasses['primary'];
    $iconClass = $iconColorClasses[$confirmColor] ?? $iconColorClasses['primary'];
@endphp

<div x-data="{ 
    isOpen: @js($show),
    close() {
        this.isOpen = false;
        this.$dispatch('confirmation-closed');
    },
    open() {
        this.isOpen = true;
        this.$dispatch('confirmation-opened');
    },
    confirm() {
        this.$dispatch('confirmation-confirmed');
        this.close();
    }
}" 
     x-show="isOpen" 
     class="fixed inset-0 z-[999999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-6"
     style="display: none;">
     
    <div @click.stop 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="relative w-full max-w-md transform overflow-hidden rounded-lg bg-white text-left shadow-xl dark:bg-gray-800">
        
        <!-- Body -->
        <div class="px-6 py-6 text-center">
            <!-- Icon -->
            @if($icon)
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full {{ $iconClass }}">
                    {!! $icon !!}
                </div>
            @endif
            
            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                {{ $title }}
            </h3>
            
            <!-- Message -->
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                {{ $message }}
            </p>
            
            <!-- Buttons -->
            <div class="flex justify-center gap-3">
                <button @click="close()" 
                        class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    {{ $cancelText }}
                </button>
                <button @click="confirm()" 
                        class="rounded-lg {{ $confirmButtonClass }} px-6 py-2.5 text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2">
                    {{ $confirmText }}
                </button>
            </div>
        </div>
    </div>
</div>
