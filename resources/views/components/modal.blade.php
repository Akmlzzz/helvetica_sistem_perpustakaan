@props([
    'show' => false,
    'title' => 'Modal Title',
    'size' => 'md', // sm, md, lg, xl
    'showCloseButton' => true,
    'closeOnBackdrop' => true,
    'backdropBlur' => true
])

@php
    $sizeClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md', 
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        'full' => 'max-w-full mx-4'
    ];
    
    $containerClass = $sizeClasses[$size] ?? 'max-w-md';
@endphp

<div x-data="{ 
    isOpen: @js($show),
    close() {
        this.isOpen = false;
        this.$dispatch('modal-closed');
    },
    open() {
        this.isOpen = true;
        this.$dispatch('modal-opened');
    }
}" 
     x-show="isOpen" 
     @if($closeOnBackdrop) @click.outside="close()" @endif
     class="fixed inset-0 z-[999999] overflow-y-auto {{ $backdropBlur ? 'bg-black/50 backdrop-blur-sm' : 'bg-black/50' }}"
     style="display: none;">
     
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div @click.stop 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
             x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
             class="relative {{ $containerClass }} w-full transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all dark:bg-gray-800">
            
            <!-- Header -->
            @if($title || $showCloseButton)
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    @if($title)
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
                    @endif
                    
                    @if($showCloseButton)
                        <button @click="close()" 
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            @endif
            
            <!-- Body -->
            <div class="@if($title || $showCloseButton) px-6 py-4 @else px-6 py-6">
                {{ $slot }}
            </div>
            
            <!-- Footer (if provided) -->
            @if(isset($footer))
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Trigger Events -->
<script>
document.addEventListener('livewire:init', () => {
    // Auto-close modal on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('[x-data*="isOpen"]');
            modals.forEach(modal => {
                if (modal.__x && modal.__x.$data.isOpen) {
                    modal.__x.$data.close();
                }
            });
        }
    });
});
</script>
