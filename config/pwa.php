<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PWA Asset URL
    |--------------------------------------------------------------------------
    |
    | This URL is used to generate absolute URLs for PWA assets like icons
    | and screenshots. You should set this to the root of your application.
    |
    */

    'asset_url' => env('PWA_ASSET_URL', env('APP_URL')),
    
    /*
    |--------------------------------------------------------------------------
    | PWA Manifest Settings
    |--------------------------------------------------------------------------
    |
    | These settings are used to generate the web app manifest.
    |
    */
    
    'name' => env('APP_NAME', 'Laravel PWA'),
    'short_name' => env('APP_NAME', 'Laravel PWA'),
    'description' => 'Aplikasi E-NIMEN - Sistem Penilaian Siswa Sekolah Polisi Negara Sumatera Barat',
    'theme_color' => '#212121',
    'background_color' => '#ffffff',
    
    /*
    |--------------------------------------------------------------------------
    | PWA Icons
    |--------------------------------------------------------------------------
    |
    | These settings define the icons for your PWA.
    |
    */
    
    'icons' => [
        [
            'src' => '/assets/logo.png',
            'sizes' => '72x72',
            'type' => 'image/png',
            'purpose' => 'any maskable'
        ],
        [
            'src' => '/assets/logo.png',
            'sizes' => '192x192',
            'type' => 'image/png',
            'purpose' => 'any maskable'
        ],
        [
            'src' => '/assets/logo.png',
            'sizes' => '512x512',
            'type' => 'image/png',
            'purpose' => 'any maskable'
        ],
        // ... tambahkan ukuran lainnya sesuai kebutuhan
    ],
];