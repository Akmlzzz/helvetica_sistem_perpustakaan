@props(['type' => 'default'])

@php
    $type = $type ?? 'default';
    $classes = match ($type) {
        'dikembalikan', 'lunas', 'anggota' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'telat', 'terlambat', 'admin' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        'dipinjam', 'belum_bayar', 'petugas' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
    };
@endphp

<span class="{{ $classes }} px-3 py-1 rounded-full text-xs font-medium">
    {{ ucfirst($type) }}
</span>