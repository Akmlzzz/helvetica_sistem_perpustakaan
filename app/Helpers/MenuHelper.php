<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMenuGroups()
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // ─────────────────────────────────────
        // MENU PETUGAS — dinamis sesuai hak akses
        // ─────────────────────────────────────
        if ($user && $user->level_akses == 'petugas') {

            // Load hakAkses jika belum
            $user->loadMissing('hakAkses');
            $fiturAkses = $user->daftarFiturAkses(); // Collection of fitur names

            // Menu dasar petugas (selalu muncul)
            $items = [
                [
                    'name' => 'Layanan Sirkulasi',
                    'icon' => 'dashboard',
                    'path' => '/petugas/dashboard',
                ],
                [
                    'name' => 'Daftar Booking',
                    'icon' => 'calendar',
                    'path' => '/petugas/booking',
                ],
                [
                    'name' => 'Katalog Buku',
                    'icon' => 'book',
                    'path' => '/petugas/katalog',
                ],
            ];

            // Fitur tambahan berdasarkan hak akses
            $fiturTambahan = [];

            if ($fiturAkses->contains('kategori')) {
                $fiturTambahan[] = ['name' => 'Kategori', 'path' => '/kategori', 'new' => false];
            }
            if ($fiturAkses->contains('buku')) {
                $fiturTambahan[] = ['name' => 'Data Buku', 'path' => '/buku', 'new' => false];
            }
            if ($fiturAkses->contains('peminjaman')) {
                $fiturTambahan[] = ['name' => 'Peminjaman', 'path' => '/peminjaman', 'new' => false];
            }
            if ($fiturAkses->contains('denda')) {
                $fiturTambahan[] = ['name' => 'Denda', 'path' => '/denda', 'new' => false];
            }
            if ($fiturAkses->contains('laporan')) {
                $fiturTambahan[] = ['name' => 'Laporan', 'path' => '/laporan', 'new' => false];
            }

            // Jika ada fitur tambahan, tampilkan sebagai submenu "Kelola Data"
            if (!empty($fiturTambahan)) {
                $items[] = [
                    'name' => 'Kelola Data',
                    'icon' => 'database',
                    'subItems' => $fiturTambahan,
                ];
            }

            return [
                'menu' => [
                    'title' => 'MENU UTAMA',
                    'items' => $items,
                ],
            ];
        }

        // ─────────────────────────────────────
        // MENU ANGGOTA
        // ─────────────────────────────────────
        if ($user && $user->level_akses == 'anggota') {
            return [
                'menu' => [
                    'title' => 'MENU ANGGOTA',
                    'items' => [
                        [
                            'name' => 'Katalog Buku',
                            'icon' => 'icon-katalog',
                            'path' => '/anggota/dashboard',
                        ],
                        [
                            'name' => 'Pinjaman Saya',
                            'icon' => 'icon-pinjaman',
                            'path' => '/anggota/pinjaman',
                        ],
                        [
                            'name' => 'Riwayat & Denda',
                            'icon' => 'report',
                            'path' => '/anggota/riwayat',
                        ],
                        [
                            'name' => 'Pengajuan Saya',
                            'icon' => 'icon-pengajuan',
                            'path' => '/anggota/pengajuan-saya',
                        ],
                        [
                            'name' => 'Usulkan Buku',
                            'icon' => 'inbox',
                            'path' => '/ajukan-buku',
                        ],
                    ],
                ],
            ];
        }

        // ─────────────────────────────────────
        // MENU ADMIN (default)
        // ─────────────────────────────────────
        $unreadPengajuan = \App\Models\PengajuanBuku::where('sudah_dibaca', false)->count();

        return [
            'menu' => [
                'title' => 'MENU UTAMA',
                'items' => [
                    [
                        'name' => 'Dashboard',
                        'icon' => 'dashboard',
                        'path' => '/dashboard',
                    ],
                    [
                        'name' => 'Kelola Data',
                        'icon' => 'database',
                        'subItems' => [
                            ['name' => 'Kategori', 'path' => '/kategori', 'new' => false],
                            ['name' => 'Data Buku', 'path' => '/buku', 'new' => false],
                            ['name' => 'Peminjaman', 'path' => '/peminjaman', 'new' => false],
                            ['name' => 'Denda', 'path' => '/denda', 'new' => false],
                        ],
                    ],
                    [
                        'name' => 'Pengajuan Buku',
                        'icon' => 'inbox',
                        'path' => '/pengajuan-buku',
                        'badge' => $unreadPengajuan > 0 ? $unreadPengajuan : null,
                    ],
                    [
                        'name' => 'Kelola Pengguna',
                        'icon' => 'users',
                        'subItems' => [
                            ['name' => 'Data Pengguna', 'path' => '/pengguna', 'new' => false],
                            ['name' => 'Hak Akses', 'path' => '/hak-akses', 'new' => false],
                        ],
                    ],
                    [
                        'name' => 'Laporan',
                        'icon' => 'report',
                        'path' => '/laporan',
                    ],
                ],
            ],
        ];
    }

    public static function getIconSvg($iconName)
    {
        $icons = [
            'dashboard' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>',
            'database' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                           </svg>',
            'users' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>',
            'report' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                        </svg>',
            'book' => '<svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 17V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM5 19V5h14v12h-2V7H7v10H5z" fill="" />
                       </svg>',
            'calendar' => '<svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                          </svg>',
            'money' => '<svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="12" y1="1" x2="12" y2="23" />
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>',
            'shield' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                        </svg>',
            'icon-katalog' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                               </svg>',
            'icon-pinjaman' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                               </svg>',
            'inbox' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h1.166a2.25 2.25 0 0 0 1.608-.67l1.114-1.114a2.25 2.25 0 0 1 1.608-.67h3.096m-12 7.208V19.5a2.25 2.25 0 0 1 2.25-2.25h10.5A2.25 2.25 0 0 1 21 19.5v2.958M3 13.5V4.875C3 3.839 3.84 3 4.875 3h14.25C20.16 3 21 3.84 21 4.875V13.5m-9-4.5h.008v.008H12V9Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>',
            'icon-pengajuan' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>',
        ];

        return $icons[$iconName] ?? '';
    }
}
