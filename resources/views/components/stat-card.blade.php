@props(['title', 'value', 'icon'])

<div class="rounded-[20px] bg-white p-6 shadow-sm border border-gray-100 dark:border-gray-800 dark:bg-gray-900">
    <!-- Mobile: Horizontal Layout (Icon Left, Content Right) -->
    <div class="flex md:flex-col gap-4">
        <!-- Icon -->
        <div
            class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-[#D1FAE5] dark:bg-green-900/30">
            <span class="text-[#004236] dark:text-green-400">
                {!! $icon !!}
            </span>
        </div>

        <!-- Content -->
        <div class="flex flex-col justify-center md:justify-start">
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                {{ $value }}
            </h4>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</span>
        </div>
    </div>
</div>