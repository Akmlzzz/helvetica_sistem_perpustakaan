@props(['status'])

@php
    $statusClasses = [
        'Dipinjam' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500 border border-yellow-200 dark:border-yellow-900',
        'Dikembalikan' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-500 border border-green-200 dark:border-green-900',
        'Telat' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-500 border border-red-200 dark:border-red-900',
    ];

    $classes = $statusClasses[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-500 border border-gray-200 dark:border-gray-900';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-full px-2 sm:px-4 py-0.5 sm:py-1 text-xs sm:text-sm font-medium ' . $classes]) }}>
    {{ $status }}
</span>