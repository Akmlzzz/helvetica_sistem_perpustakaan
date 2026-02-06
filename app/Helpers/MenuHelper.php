<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMenuGroups()
    {
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
                        // 'path' => '#', // Optional if using submenus
                        'subItems' => [
                            [
                                'name' => 'Data Buku',
                                'path' => '/buku',
                                'new' => false,
                            ],
                            [
                                'name' => 'Peminjaman',
                                'path' => '/peminjaman',
                                'new' => false,
                            ],
                            [
                                'name' => 'Denda',
                                'path' => '/denda',
                                'new' => false,
                            ],
                        ]
                    ],
                    [
                        'name' => 'Kelola Pengguna',
                        'icon' => 'users',
                        'subItems' => [
                            [
                                'name' => 'Data Anggota',
                                'path' => '/anggota',
                                'new' => false,
                            ]
                        ]
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
            'dashboard' => '<svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.56875 16.0312H12.4312C14.7375 16.0312 16.0312 14.7375 16.0312 12.4312V5.56872C16.0312 3.26247 14.7375 1.96872 12.4312 1.96872H5.56875C3.2625 1.96872 1.96875 3.26247 1.96875 5.56872V12.4312C1.96875 14.7375 3.2625 16.0312 5.56875 16.0312ZM6.975 8.04372H5.34375C5.00625 8.04372 4.725 7.76247 4.725 7.42497V5.79372C4.725 5.45622 5.00625 5.17497 5.34375 5.17497H6.975C7.3125 5.17497 7.59375 5.45622 7.59375 5.79372V7.42497C7.59375 7.76247 7.3125 8.04372 6.975 8.04372ZM12.6562 8.04372H11.025C10.6875 8.04372 10.4062 7.76247 10.4062 7.42497V5.79372C10.4062 5.45622 10.6875 5.17497 11.025 5.17497H12.6562C12.9937 5.17497 13.275 5.45622 13.275 5.79372V7.42497C13.275 7.76247 12.9937 8.04372 12.6562 8.04372ZM6.975 13.725H5.34375C5.00625 13.725 4.725 13.4437 4.725 13.1062V11.475C4.725 11.1375 5.00625 10.8562 5.34375 10.8562H6.975C7.3125 10.8562 7.59375 11.1375 7.59375 11.475V13.1062C7.59375 13.4437 7.3125 13.725 6.975 13.725ZM12.6562 13.725H11.025C10.6875 13.725 10.4062 13.4437 10.4062 13.1062V11.475C10.4062 11.1375 10.6875 10.8562 11.025 10.8562H12.6562C12.9937 10.8562 13.275 11.1375 13.275 11.475V13.1062C13.275 13.4437 12.9937 13.725 12.6562 13.725Z" fill=""/>
                            </svg>',
            'database' => '<svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="12" cy="5" rx="9" ry="3" />
                            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
                            <path d="M3 5v14c0 1.66 4 3 9 3s 9-1.34 9-3V5" />
                           </svg>',
            'users' => '<svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="8.5" cy="7" r="4" />
                            <polyline points="17 11 19 13 23 9" />
                        </svg>',
            'report' => '<svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
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
            // Add other icons as needed
        ];

        return $icons[$iconName] ?? '';
    }
}
