// Konfigurasi
const CACHE_NAME = 'E-NIMEN-cache-v1.0.0';
const OFFLINE_URL = '/offline';
const DYNAMIC_CACHE = 'E-NIMEN-dynamic-v1.0.0';
const APP_URL = 'http://127.0.0.1:8000';

// Daftar asset yang akan di-cache
const STATIC_ASSETS = [
    '/',
    '/login',
    '/dashboard',
    OFFLINE_URL,
    '/assets/logo.png',
    '/assets/css/app.css',
    '/assets/css/bootstrap.css',
    '/assets/vendors/simple-datatables/style.css',
    '/assets/vendors/chartjs/Chart.min.css',
    '/assets/vendors/perfect-scrollbar/perfect-scrollbar.css',
    '/assets/vendors/choices.js/choices.min.css',
    '/assets/js/app.js',
    '/assets/js/feather-icons/feather.min.js',
    '/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js',
    '/assets/vendors/chartjs/Chart.min.js',
    '/assets/vendors/apexcharts/apexcharts.min.js',
    '/assets/js/pages/dashboard.js',
    '/assets/js/main.js',
    '/assets/vendors/simple-datatables/simple-datatables.js',
    '/assets/js/vendors.js',
    '/assets/vendors/choices.js/choices.min.js',
    '/manifest.json'
];

// Install service worker
self.addEventListener('install', event => {
    console.log('[Service Worker] Installing Service Worker...');

    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('[Service Worker] Pre-caching app shell');
                return cache.addAll(STATIC_ASSETS)
                    .then(() => {
                        console.log('[Service Worker] All assets cached');
                        return self.skipWaiting();
                    })
                    .catch(err => {
                        console.log('[Service Worker] Failed to cache some assets:', err);
                        return self.skipWaiting();
                    });
            })
    );
});

// Aktifkan service worker
self.addEventListener('activate', event => {
    console.log('[Service Worker] Activating Service Worker...');

    event.waitUntil(
        caches.keys().then(keyList => {
            return Promise.all(keyList.map(key => {
                if (key !== CACHE_NAME && key !== DYNAMIC_CACHE) {
                    console.log('[Service Worker] Removing old cache', key);
                    return caches.delete(key);
                }
            }));
        }).then(() => {
            console.log('[Service Worker] Claiming clients');
            return self.clients.claim();
        })
    );
});

// Intercept fetch requests
self.addEventListener('fetch', event => {
    // Skip non-GET requests dan cross-origin requests
    if (event.request.method !== 'GET' || !event.request.url.startsWith(self.location.origin)) {
        return;
    }

    // Untuk API requests, gunakan network first
    if (event.request.url.includes('/api/')) {
        event.respondWith(
            fetch(event.request)
                .then(response => {
                    // Cache response API untuk penggunaan offline
                    const responseClone = response.clone();
                    caches.open(DYNAMIC_CACHE)
                        .then(cache => {
                            cache.put(event.request, responseClone);
                        });
                    return response;
                })
                .catch(error => {
                    console.log('[Service Worker] API request failed, trying cache:', error);
                    return caches.match(event.request)
                        .then(cachedResponse => {
                            if (cachedResponse) {
                                return cachedResponse;
                            }
                            return new Response(JSON.stringify({ error: 'Network error' }), {
                                status: 503,
                                headers: { 'Content-Type': 'application/json' }
                            });
                        });
                })
        );
        return;
    }

    // Untuk halaman HTML, gunakan network first
    if (event.request.headers.get('accept').includes('text/html')) {
        event.respondWith(
            fetch(event.request)
                .then(response => {
                    // Cache halaman HTML
                    const responseClone = response.clone();
                    caches.open(DYNAMIC_CACHE)
                        .then(cache => {
                            cache.put(event.request, responseClone);
                        });
                    return response;
                })
                .catch(error => {
                    console.log('[Service Worker] Fetch failed, returning cached version:', error);
                    return caches.match(event.request)
                        .then(cachedResponse => {
                            return cachedResponse || caches.match(OFFLINE_URL);
                        });
                })
        );
        return;
    }

    // Untuk assets lainnya (CSS, JS, images), gunakan cache first
    event.respondWith(
        caches.match(event.request)
            .then(cachedResponse => {
                if (cachedResponse) {
                    return cachedResponse;
                }

                return fetch(event.request)
                    .then(response => {
                        // Check jika response valid
                        if (!response || response.status !== 200 || response.type !== 'basic') {
                            return response;
                        }

                        // Clone the response untuk caching
                        const responseToCache = response.clone();
                        caches.open(DYNAMIC_CACHE)
                            .then(cache => {
                                cache.put(event.request, responseToCache);
                            });

                        return response;
                    })
                    .catch(error => {
                        console.log('[Service Worker] Fetch failed:', error);
                        // Fallback untuk images
                        if (event.request.destination === 'image') {
                            return caches.match('/assets/logo.png');
                        }
                    });
            })
    );
});

// Handle push notifications
self.addEventListener('push', event => {
    console.log('[Service Worker] Push Received.');

    let data = {};
    try {
        data = event.data.json();
    } catch (e) {
        data = { title: 'E-NIMEN', body: event.data.text() };
    }

    const title = data.title || 'E-NIMEN';
    const options = {
        body: data.body || 'Notifikasi baru dari E-NIMEN',
        icon: '/assets/logo.png',
        badge: '/assets/logo.png',
        data: data.url || '/'
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

// Handle notification click
self.addEventListener('notificationclick', event => {
    console.log('[Service Worker] Notification click Received.');
    event.notification.close();

    event.waitUntil(
        clients.matchAll({ type: 'window' }).then(clientList => {
            // Jika ada window yang terbuka, focus ke window tersebut
            for (const client of clientList) {
                if (client.url === event.notification.data && 'focus' in client) {
                    return client.focus();
                }
            }

            // Jika tidak ada, buka window baru
            if (clients.openWindow) {
                return clients.openWindow(event.notification.data || '/');
            }
        })
    );
});