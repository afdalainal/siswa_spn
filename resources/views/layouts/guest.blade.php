<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#212121" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="E-NIMEN">
    <meta name="mobile-web-web-app-capable" content="yes">
    <meta name="application-name" content="E-NIMEN">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo.png') }}">
    <link rel="icon" sizes="192x192" href="{{ asset('assets/logo.png') }}">
    <link rel="icon" sizes="512x512" href="{{ asset('assets/logo.png') }}">
    <link rel="manifest" href="{{ url('manifest.json') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    .pwa-install-container {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
        width: 100%;
    }

    #installButton {
        background: linear-gradient(120deg, rgb(235, 247, 255), rgb(185, 220, 255));
        color: black;
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(141, 141, 141, 0.4);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        min-width: 160px;
        backdrop-filter: blur(6px);
        position: relative;
        overflow: hidden;
    }

    /* Teks di atas */
    .button-top-text {
        font-size: 0.75rem;
        line-height: 1;
        opacity: 0.9;
        font-weight: 400;
    }

    /* Container untuk ikon dan teks Install Now */
    .button-bottom-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    #installButton::before {
        content: "";
        position: absolute;
        top: 0;
        left: -75%;
        width: 150%;
        height: 100%;
        background: linear-gradient(120deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
        transform: skewX(-20deg);
        transition: all 0.5s ease;
        z-index: 0;
    }

    #installButton:hover::before {
        left: 100%;
    }

    #installButton:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(121, 121, 121, 0.5);
    }

    #installButton:active {
        transform: translateY(0);
    }

    /* Responsiveness */
    @media (max-width: 640px) {
        .pwa-install-container {
            margin-top: 1.25rem;
            padding: 0 1rem;
        }

        #installButton {
            width: 100%;
            max-width: 220px;
        }

        .button-top-text {
            font-size: 0.7rem;
        }

        .button-bottom-content {
            font-size: 0.85rem;
        }
    }

    /* Loading Indicator Styles - Baru Ditambahkan */
    .global-loading-indicator {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: transparent;
        z-index: 999999;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .global-loading-indicator.active {
        opacity: 1;
    }

    .global-loading-indicator::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 50%;
        background: linear-gradient(90deg, #4f46e5, #3b82f6, #4f46e5);
        animation: loadingAnimation 1.2s infinite;
        box-shadow: 0 0 10px rgba(79, 70, 229, 0.7);
    }

    @keyframes loadingAnimation {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(200%);
        }
    }

    /* Untuk mencegah interaksi saat loading */
    body.loading {
        pointer-events: none;
        cursor: wait;
    }

    body.loading * {
        pointer-events: none !important;
    }
    </style>

</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Loading Indicator Baru Ditambahkan -->
    <div class="global-loading-indicator" id="globalLoadingIndicator"></div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <img src="{{asset('assets/logo.png')}}" alt="" width="150" height="150">
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>

        <!-- PWA Install Prompt - Structure unchanged, only styling improved -->
        <div class="pwa-install-container">
            <button id="installButton">
                <span class="button-top-text">Tersedia dalam bentuk aplikasi</span>
                <span class="button-bottom-content">
                    <i class="bi bi-download"></i> Install E-NIMEN
                </span>
            </button>
        </div>
    </div>

    <!-- PWA Script -->
    <script>
    // PWA Functionality - Perbaikan
    (function() {
        console.log('E-NIMEN PWA Initializing...');

        // Elements
        const installButton = document.getElementById('installButton');
        const installPrompt = document.getElementById('installPrompt');
        const closeInstallPrompt = document.getElementById('closeInstallPrompt');

        // Variables
        let deferredPrompt = null;

        // Function to check if app is installed
        function isAppInstalled() {
            return window.matchMedia('(display-mode: standalone)').matches ||
                window.navigator.standalone ||
                document.referrer.includes('android-app://');
        }

        // Function to show install prompt
        function showInstallPrompt() {
            if (deferredPrompt && !isAppInstalled()) {
                // Check if user recently dismissed the prompt
                const lastDismissed = localStorage.getItem('installPromptDismissed');
                const oneWeekAgo = Date.now() - (7 * 24 * 60 * 60 * 1000);

                if (!lastDismissed || parseInt(lastDismissed) < oneWeekAgo) {
                    installPrompt.classList.remove('d-none');
                    console.log('Showing install prompt');
                } else {
                    console.log('Install prompt was recently dismissed');
                }
            } else {
                console.log('Cannot show prompt - deferredPrompt:', !!deferredPrompt, 'isInstalled:',
                    isAppInstalled());
            }
        }

        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                const swUrl = '{{ url("sw.js") }}';

                navigator.serviceWorker.register(swUrl)
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration
                            .scope);

                        // Check for updates
                        registration.update();

                        // Periodically check for updates (once per hour)
                        setInterval(() => {
                            registration.update();
                        }, 60 * 60 * 1000);
                    })
                    .catch(function(error) {
                        console.log('ServiceWorker registration failed: ', error);
                    });
            });
        }

        // Handle beforeinstallprompt event
        window.addEventListener('beforeinstallprompt', (e) => {
            console.log('beforeinstallprompt event fired');
            e.preventDefault();
            deferredPrompt = e;
            console.log('Deferred prompt stored');

            // Show install prompt after delay if not installed
            if (!isAppInstalled()) {
                console.log('Scheduling install prompt in 3 seconds');
                setTimeout(showInstallPrompt, 3000); // Reduced to 3 seconds
            }
        });

        // Handle install button click
        if (installButton) {
            installButton.addEventListener('click', async () => {
                if (!deferredPrompt) {
                    console.log('No deferred prompt available');
                    return;
                }

                console.log('Showing install prompt to user');
                deferredPrompt.prompt();

                const {
                    outcome
                } = await deferredPrompt.userChoice;
                console.log('User choice:', outcome);

                if (outcome === 'accepted') {
                    console.log('User accepted the install prompt');
                } else {
                    console.log('User dismissed the install prompt');
                    // Remember dismissal for 1 week
                    localStorage.setItem('installPromptDismissed', Date.now().toString());
                }

                installPrompt.classList.add('d-none');
                deferredPrompt = null;
            });
        }

        // Close install prompt
        if (closeInstallPrompt) {
            closeInstallPrompt.addEventListener('click', () => {
                installPrompt.classList.add('d-none');
                // Remember dismissal for 1 week
                localStorage.setItem('installPromptDismissed', Date.now().toString());
                console.log('Install prompt dismissed by user');
            });
        }

        // Listen for app installation
        window.addEventListener('appinstalled', () => {
            console.log('E-NIMEN was successfully installed');
            if (installPrompt) {
                installPrompt.classList.add('d-none');
            }
            deferredPrompt = null;
        });

        // Check if already installed on page load
        if (isAppInstalled()) {
            console.log('App is running in standalone mode');
            if (installPrompt) {
                installPrompt.classList.add('d-none');
            }
        }

        // Debug info
        console.log('Initial PWA Status:');
        console.log('- Service Worker: ', 'serviceWorker' in navigator ? 'Supported' : 'Not supported');
        console.log('- Display Mode: ', window.matchMedia('(display-mode: standalone)').matches ? 'Standalone' :
            'Browser');
        console.log('- Is App Installed: ', isAppInstalled() ? 'Yes' : 'No');

    })();

    // Loading Indicator Functionality - Baru Ditambahkan
    (function() {
        const loadingIndicator = document.getElementById('globalLoadingIndicator');
        let loadingTimeout;

        // Fungsi untuk memulai loading
        function startLoading() {
            // Clear timeout yang ada sebelumnya
            clearTimeout(loadingTimeout);

            // Tampilkan loading indicator
            loadingIndicator.classList.add('active');
            document.body.classList.add('loading');

            // Set timeout untuk memastikan loading indicator terlihat minimal 300ms
            // untuk menghindari flicker yang terlalu cepat
            loadingTimeout = setTimeout(() => {
                // Loading selesai, sembunyikan indicator
                loadingIndicator.classList.remove('active');
                document.body.classList.remove('loading');
            }, 300);
        }

        // Fungsi untuk menghentikan loading
        function stopLoading() {
            clearTimeout(loadingTimeout);
            loadingIndicator.classList.remove('active');
            document.body.classList.remove('loading');
        }

        // Monitor semua event yang mungkin menyebabkan loading
        const eventsThatCauseLoading = [
            'click', 'submit', 'popstate', 'hashchange',
            'beforeunload', 'pagehide', 'pageshow'
        ];

        // Deteksi ketika halaman mulai loading
        let isPageLoading = false;

        // Event sebelum halaman dimuat
        window.addEventListener('beforeunload', () => {
            isPageLoading = true;
            startLoading();
        });

        // Event ketika halaman selesai dimuat
        window.addEventListener('load', () => {
            isPageLoading = false;
            stopLoading();
        });

        // Event ketika DOM selesai dimuat
        document.addEventListener('DOMContentLoaded', () => {
            isPageLoading = false;
            stopLoading();
        });

        // Intercept semua link klik
        document.addEventListener('click', function(e) {
            const target = e.target;
            const link = target.closest('a');

            if (link && link.href && !link.hash) {
                // Cegah navigasi instan untuk memberikan waktu loading indicator muncul
                const href = link.href;
                const targetAttr = link.target;
                const isSameOrigin = href.startsWith(window.location.origin) ||
                    href.startsWith('/') ||
                    href.startsWith('./') ||
                    href.startsWith('../');

                // Jika link menuju ke halaman yang sama (bukan external atau download)
                if (isSameOrigin && !targetAttr && !e.ctrlKey && !e.metaKey && !e.shiftKey) {
                    e.preventDefault();
                    startLoading();

                    // Beri waktu minimal untuk loading indicator terlihat
                    setTimeout(() => {
                        window.location.href = href;
                    }, 50);
                }
            }
        }, true);

        // Intercept form submissions
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form && form.method === 'get') {
                startLoading();
            }
        }, true);

        // Intercept AJAX requests
        const originalXHROpen = XMLHttpRequest.prototype.open;
        const originalXHRSend = XMLHttpRequest.prototype.send;
        const originalFetch = window.fetch;

        let activeRequests = 0;

        // Monkey patch XMLHttpRequest
        XMLHttpRequest.prototype.open = function() {
            this.addEventListener('loadstart', function() {
                if (activeRequests === 0) {
                    startLoading();
                }
                activeRequests++;
            });

            this.addEventListener('loadend', function() {
                activeRequests--;
                if (activeRequests === 0) {
                    setTimeout(stopLoading, 100);
                }
            });

            this.addEventListener('error', function() {
                activeRequests--;
                if (activeRequests === 0) {
                    setTimeout(stopLoading, 100);
                }
            });

            return originalXHROpen.apply(this, arguments);
        };

        // Monkey patch fetch
        window.fetch = function() {
            if (activeRequests === 0) {
                startLoading();
            }
            activeRequests++;

            return originalFetch.apply(this, arguments)
                .then(response => {
                    activeRequests--;
                    if (activeRequests === 0) {
                        setTimeout(stopLoading, 100);
                    }
                    return response;
                })
                .catch(error => {
                    activeRequests--;
                    if (activeRequests === 0) {
                        setTimeout(stopLoading, 100);
                    }
                    throw error;
                });
        };

        // Handle popstate (back/forward navigation)
        window.addEventListener('popstate', function() {
            startLoading();
        });

        // Handle hashchange
        window.addEventListener('hashchange', function() {
            startLoading();
            setTimeout(stopLoading, 300);
        });

        // Handle pageshow event (for bfcache)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                stopLoading();
            }
        });

        // Handle pagehide event
        window.addEventListener('pagehide', function() {
            startLoading();
        });

        // Initial check - jika halaman masih loading saat script ini dijalankan
        if (document.readyState === 'loading') {
            startLoading();
        }
    })();
    </script>
</body>

</html>