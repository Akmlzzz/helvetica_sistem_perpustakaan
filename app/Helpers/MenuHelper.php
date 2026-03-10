<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMenuGroups()
    {
        /** @var \App\Models\Pengguna|null $user */
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
                    'name' => 'Proses Booking',
                    'icon' => 'icon-booking',
                    'path' => '/petugas/booking',
                ],
                [
                    'name' => 'Pengembalian Buku',
                    'icon' => 'icon-pengembalian',
                    'path' => '/petugas/pengembalian',
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
                $fiturTambahan[] = ['name' => 'Series Buku', 'path' => '/series', 'new' => false];
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
                            'name' => 'Koleksi Saya',
                            'icon' => 'icon-koleksi',
                            'path' => '/anggota/koleksi',
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
                        [
                            'name' => 'Kartu Anggota',
                            'icon' => 'shield',
                            'path' => '/anggota/kartu-anggota',
                        ],
                    ],
                ],
            ];
        }

        // ─────────────────────────────────────
        // MENU ADMIN (default)
        // ─────────────────────────────────────
        $unreadPengajuan = \App\Models\PengajuanBuku::where('sudah_dibaca', false)->count();
        $pendingAnggota = \App\Models\Pengguna::where('level_akses', 'anggota')->where('status', 'pending')->count();

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
                            ['name' => 'Series Buku', 'path' => '/series', 'new' => true],
                            ['name' => 'Peminjaman', 'path' => '/peminjaman', 'new' => false],
                            ['name' => 'Denda', 'path' => '/denda', 'new' => false],
                            ['name' => 'Hero Banner', 'path' => '/hero-banners', 'new' => false],
                            ['name' => 'Musik Player', 'path' => '/admin/musik', 'new' => false],
                        ],
                    ],
                    [
                        'name' => 'Pengajuan Buku',
                        'icon' => 'inbox',
                        'path' => '/pengajuan-buku',
                        'badge' => $unreadPengajuan > 0 ? $unreadPengajuan : null,
                    ],
                    [
                        'name' => 'Verifikasi Anggota',
                        'icon' => 'shield',
                        'path' => '/verifikasi-anggota',
                        'badge' => $pendingAnggota > 0 ? $pendingAnggota : null,
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>',
            'database' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>',
            'users' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>',
            'report' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>',
            'book' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                       </svg>',
            'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                          </svg>',
            'money' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75m0 5.25v.75m0 5.25v.75m15-12v.75m0 5.25v.75m0 5.25v.75m-15-10.5h15c.621 0 1.125.504 1.125 1.125v10.5c0 .621-.504 1.125-1.125 1.125h-15a1.125 1.125 0 0 1-1.125-1.125v-10.5c0-.621.504-1.125 1.125-1.125Zm1.5 0v10.5m12-10.5v10.5m-10.5-8.25h3m-3 2.25h3m-3 2.25h3m3.75-6.75h3m-3 2.25h3m-3 2.25h3" />
                        </svg>',
            'inbox' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H4.5a1.5 1.5 0 0 1-1.5-1.5v-8.25m18 0a1.5 1.5 0 0 0-1.5-1.5H4.5a1.5 1.5 0 0 0-1.5 1.5m18 0l-9 6.75-9-6.75" />
                        </svg>',
            'shield' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                        </svg>',
            'icon-katalog' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-3.75h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.75m-.75 3h.75m-.75 3h.75" />
                               </svg>',
            'icon-pinjaman' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                               </svg>',
            'icon-koleksi' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                               </svg>',
            'icon-pengajuan' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                               </svg>',
            'icon-booking' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .407.16.785.42 1.066.249.27.4.63.4 1.024 0 .828-.672 1.5-1.5 1.5s-1.5-.672-1.5-1.5c0-.393.151-.754.4-1.024.26-.281.42-.659.42-1.066 0-.231-.035-.454-.1-.664m-5.8 0A2.251 2.251 0 0 1 5.625 3h12.75c1.057 0 1.912.727 2.125 1.706M3 7.5a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 .75.75v12a.75.75 0 0 1-.75.75H3.75a.75.75 0 0 1-.75-.75v-12Zm9 4.5H9v3.75h3V12Zm6 0h-3v3.75h3V12Zm-6 6H9v3.75h3V18Zm6 0h-3v3.75h3V18Z" />
                               </svg>',
            'icon-pengembalian' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                               </svg>',
        ];

        return $icons[$iconName] ?? '';
    }
}
