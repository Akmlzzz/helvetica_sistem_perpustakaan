<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMenuGroups()
    {
        return [
            'menu' => [
                'title' => 'MENU',
                'items' => [
                    [
                        'name' => 'Dashboard',
                        'icon' => 'dashboard',
                        'path' => '/dashboard',
                    ],
                    // Example of other menu items
                    /*
                    [
                        'name' => 'Peminjaman',
                        'icon' => 'calendar', // reusable icon key
                        'path' => '/peminjaman',
                    ],
                     [
                        'name' => 'Katalog Buku',
                        'icon' => 'table',
                        'path' => '/buku',
                    ],
                    */
                ],
            ],
            // Example of another group
            /*
            'settings' => [
                'title' => 'SETTINGS',
                'items' => [
                    [
                        'name' => 'Profile',
                        'icon' => 'settings',
                        'path' => '/profile',
                    ],
                ]
            ]
            */
        ];
    }

    public static function getIconSvg($iconName)
    {
        $icons = [
            'dashboard' => '<svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.56875 16.0312H12.4312C14.7375 16.0312 16.0312 14.7375 16.0312 12.4312V5.56872C16.0312 3.26247 14.7375 1.96872 12.4312 1.96872H5.56875C3.2625 1.96872 1.96875 3.26247 1.96875 5.56872V12.4312C1.96875 14.7375 3.2625 16.0312 5.56875 16.0312ZM6.975 8.04372H5.34375C5.00625 8.04372 4.725 7.76247 4.725 7.42497V5.79372C4.725 5.45622 5.00625 5.17497 5.34375 5.17497H6.975C7.3125 5.17497 7.59375 5.45622 7.59375 5.79372V7.42497C7.59375 7.76247 7.3125 8.04372 6.975 8.04372ZM12.6562 8.04372H11.025C10.6875 8.04372 10.4062 7.76247 10.4062 7.42497V5.79372C10.4062 5.45622 10.6875 5.17497 11.025 5.17497H12.6562C12.9937 5.17497 13.275 5.45622 13.275 5.79372V7.42497C13.275 7.76247 12.9937 8.04372 12.6562 8.04372ZM6.975 13.725H5.34375C5.00625 13.725 4.725 13.4437 4.725 13.1062V11.475C4.725 11.1375 5.00625 10.8562 5.34375 10.8562H6.975C7.3125 10.8562 7.59375 11.1375 7.59375 11.475V13.1062C7.59375 13.4437 7.3125 13.725 6.975 13.725ZM12.6562 13.725H11.025C10.6875 13.725 10.4062 13.4437 10.4062 13.1062V11.475C10.4062 11.1375 10.6875 10.8562 11.025 10.8562H12.6562C12.9937 10.8562 13.275 11.1375 13.275 11.475V13.1062C13.275 13.4437 12.9937 13.725 12.6562 13.725Z" fill=""/>
                            </svg>',
            // Add other icons as needed
        ];

        return $icons[$iconName] ?? '';
    }
}
