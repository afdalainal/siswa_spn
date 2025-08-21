// Konfigurasi
const CACHE_NAME = 'e-nimen-cache-v1';
const OFFLINE_URL = '/offline';

// Install service worker
self.addEventListener('install', event => {
    console.log('[Service Worker] Installing Service Worker...');

    event.waitUntil(
        (async () => {
            // Ambil daftar asset dari build manifest
            const buildAssets = await getBuildAssets();

            const cache = await caches.open(CACHE_NAME);

            // URL yang perlu di-cache
            const urlsToCache = [
                '/',
                '/login',
                '/dashboard',
                OFFLINE_URL,
                '/assets/logo.png',
                ...buildAssets
            ];

            console.log('[Service Worker] Pre-caching assets:', urlsToCache);
            await cache.addAll(urlsToCache);

            console.log('[Service Worker] Skip waiting on install');
            return self.skipWaiting();
        })()
    );
});

// Aktifkan service worker
self.addEventListener('activate', event => {
    console.log('[Service Worker] Activating Service Worker...');
    event.waitUntil(
        caches.keys().then(keyList => {
            return Promise.all(keyList.map(key => {
                if (key !== CACHE_NAME) {
                    console.log('[Service Worker] Removing old cache', key);
                    return caches.delete(key);
                }
            }));
        })
    );
    console.log('[Service Worker] Claiming clients for version', CACHE_NAME);
    return self.clients.claim();
});

// Intercept fetch requests
self.addEventListener('fetch', event => {
    // Skip cross-origin requests
    if (!event.request.url.startsWith(self.location.origin)) {
        return;
    }

    // Untuk API requests, selalu gunakan network first
    if (event.request.url.includes('/api/')) {
        event.respondWith(
            fetch(event.request)
                .catch(error => {
                    console.log('[Service Worker] Network request failed. Returning offline page', error);
                    return caches.match(OFFLINE_URL);
                })
        );
        return;
    }

    // Untuk halaman lainnya, gunakan cache dengan fallback ke network
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response;
                }

                return fetch(event.request)
                    .then(response => {
                        // Check if we received a valid response
                        if (!response || response.status !== 200 || response.type !== 'basic') {
                            return response;
                        }

                        // Clone the response
                        const responseToCache = response.clone();

                        caches.open(CACHE_NAME)
                            .then(cache => {
                                cache.put(event.request, responseToCache);
                            });

                        return response;
                    })
                    .catch(error => {
                        console.log('[Service Worker] Fetch failed; returning offline page instead.', error);
                        // Jika request halaman, tampilkan halaman offline
                        if (event.request.headers.get('accept').includes('text/html')) {
                            return caches.match(OFFLINE_URL);
                        }
                    });
            })
    );
});

// Helper function untuk mendapatkan asset dari build manifest
async function getBuildAssets() {
    try {
        const response = await fetch('/build/manifest.json');
        const manifest = await response.json();

        const assets = [];
        for (const key in manifest) {
            // Ambil semua file assets kecuali config PWA
            if (key !== 'pwa' && manifest[key].file) {
                assets.push('/build/' + manifest[key].file);
            }

            // Tambahkan juga source files jika ada
            if (manifest[key].src && !manifest[key].src.startsWith('http')) {
                assets.push('/' + manifest[key].src);
            }
        }

        return assets;
    } catch (error) {
        console.error('[Service Worker] Failed to load build manifest:', error);
        return [];
    }
}