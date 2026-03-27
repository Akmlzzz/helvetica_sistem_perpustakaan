<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    | Dapatkan Server Key & Client Key dari:
    | Dashboard Midtrans > Settings > Access Keys
    | Sandbox: https://dashboard.sandbox.midtrans.com/
    | Production: https://dashboard.midtrans.com/
    */

    'server_key'    => env('MIDTRANS_SERVER_KEY', ''),
    'client_key'    => env('MIDTRANS_CLIENT_KEY', ''),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized'  => true,
    'is_3ds'        => true,
];
