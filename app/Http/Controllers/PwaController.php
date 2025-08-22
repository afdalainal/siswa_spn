<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class PwaController extends Controller
{
    /**
     * Generate dynamic manifest.json
     */
    public function manifest()
    {
        $isProduction = App::isProduction();
        $appUrl = config('app.url');
        $assetUrl = config('pwa.asset_url', $appUrl);
        
        $manifest = [
            'name' => config('app.name', 'E-NIMEN'),
            'short_name' => config('app.name', 'E-NIMEN'),
            'description' => 'Aplikasi E-NIMEN - Sistem Penilaian Siswa Sekolah Polisi Negara Sumatera Barat',
            'start_url' => $this->getStartUrl(),
            'display' => 'standalone',
            'background_color' => '#ffffff',
            'theme_color' => '#212121',
            'orientation' => 'any',
            'icons' => $this->getIcons($assetUrl),
            'categories' => ['productivity', 'education', 'utilities'],
            'screenshots' => $this->getScreenshots($assetUrl),
            'prefer_related_applications' => false
        ];

        // Cache control berbeda antara production dan development
        $cacheControl = $isProduction ? 'public, max-age=3600' : 'no-cache, max-age=0';
        
        return response()->json($manifest)
            ->header('Content-Type', 'application/json')
            ->header('Cache-Control', $cacheControl);
    }

    /**
     * Serve service worker dengan header yang tepat
     */
    public function serviceWorker()
    {
        $swContent = @file_get_contents(public_path('sw.js'));
        
        if ($swContent === false) {
            abort(404, 'Service Worker not found');
        }

        // Replace placeholders
        $swContent = str_replace(
            ['{{CACHE_VERSION}}', '{{APP_URL}}', '{{APP_NAME}}'],
            [config('app.version', '1.0.0'), config('app.url'), config('app.name', 'E-NIMEN')],
            $swContent
        );

        $isProduction = App::isProduction();
        $cacheControl = $isProduction ? 'public, max-age=0' : 'no-cache, max-age=0';

        return response($swContent)
            ->header('Content-Type', 'application/javascript')
            ->header('Service-Worker-Allowed', '/')
            ->header('Cache-Control', $cacheControl);
    }

    /**
     * Tampilkan halaman offline
     */
    public function offline()
    {
        return response()->view('offline')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    /**
     * Get dynamic start URL berdasarkan environment
     */
    private function getStartUrl()
    {
        $startUrl = '/';
        
        // Tambahkan parameter untuk tracking PWA
        if (App::isProduction()) {
            $startUrl .= '?source=pwa&utm_source=pwa&utm_medium=pwa';
        } else {
            $startUrl .= '?source=pwa';
        }
        
        return $startUrl;
    }

    /**
     * Get icons dengan URL absolute
     */
    private function getIcons($baseUrl)
    {
        $baseUrl = rtrim($baseUrl, '/');
        $logoPath = asset('assets/logo.png');
        
        return [
            [
                'src' => $logoPath,
                'sizes' => '72x72',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => $logoPath,
                'sizes' => '96x96',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => $logoPath,
                'sizes' => '128x128',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => $logoPath,
                'sizes' => '144x144',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => $logoPath,
                'sizes' => '152x152',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => $logoPath,
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => $logoPath,
                'sizes' => '384x384',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ],
            [
                'src' => $logoPath,
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ]
        ];
    }

    /**
     * Get screenshots untuk store listing (opsional)
     */
    private function getScreenshots($baseUrl)
    {
        if (!App::isProduction()) {
            return [];
        }

        $baseUrl = rtrim($baseUrl, '/');
        
        return [
            [
                'src' => $baseUrl . '/assets/screenshots/dashboard.png',
                'sizes' => '1280x720',
                'type' => 'image/png',
                'label' => 'Dashboard E-NIMEN'
            ],
            [
                'src' => $baseUrl . '/assets/screenshots/penilaian.png',
                'sizes' => '1280x720',
                'type' => 'image/png',
                'label' => 'Halaman Penilaian'
            ]
        ];
    }
}