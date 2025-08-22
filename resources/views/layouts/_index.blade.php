<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#212121" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="E-NIMEN">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="E-NIMEN">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo.png') }}">
    <link rel="icon" sizes="192x192" href="{{ asset('assets/logo.png') }}">
    <link rel="icon" sizes="512x512" href="{{ asset('assets/logo.png') }}">
    <link rel="manifest" href="{{ url('manifest.json') }}">

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/simple-datatables/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/chartjs/Chart.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/logo.png')}}" type="image/x-icon">

    <link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
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

<body>
    <!-- Loading Indicator Baru Ditambahkan -->
    <div class="global-loading-indicator" id="globalLoadingIndicator"></div>

    <div id="app">
        <!-- sidebar -->
        @include('layouts._sidebar')
        <div id="main">
            <!-- navbar -->
            @include('layouts._navbar')
            <!-- main -->
            <div class="main-content container-fluid">
                @yield('content')
            </div>

            <!-- footer -->
            @include('layouts._footer')
        </div>
    </div>

    <!-- PWA Install Prompt -->
    <div id="installPrompt" class="d-none position-fixed bottom-0 end-0 m-3" style="z-index: 1050;">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title">Aplikasi E-NIMEN</h5>
                <p class="card-text">Tersedia dalam bentuk aplikasi</p>
                <div class="d-flex gap-2">
                    <button id="installButton" class="btn btn-primary btn-sm">Install</button>
                    <button id="closeInstallPrompt" class="btn btn-outline-secondary btn-sm">Nanti</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    <script src="{{asset('assets/vendors/chartjs/Chart.min.js')}}"></script>
    <script src="{{asset('assets/vendors/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/dashboard.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>

    <script src="{{asset('assets/vendors/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{asset('assets/js/vendors.js')}}"></script>

    <script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>

    <!-- Pastikan script Chart.js dimuat sebelum kode JavaScript Anda -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <!-- Loading Indicator Functionality - Baru Ditambahkan -->
    <script>
    (function() {
        const loadingIndicator = document.getElementById('globalLoadingIndicator');
        let loadingTimeout;
        let activeRequests = 0;

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

                // Periksa apakah link menggunakan metode POST (seperti logout)
                const hasPostMethod = link.hasAttribute('data-method') &&
                    link.getAttribute('data-method').toUpperCase() === 'POST';

                // Periksa apakah link menuju ke route logout
                const isLogoutLink = href.includes('logout');

                // Periksa apakah link memiliki atribut download
                const hasDownloadAttr = link.hasAttribute('download');

                // Periksa apakah link adalah anchor link (hash link)
                const isAnchorLink = link.hash && link.pathname === window.location.pathname;

                // Periksa apakah link adalah javascript: atau mailto: atau tel:
                const isSpecialProtocol = href.startsWith('javascript:') ||
                    href.startsWith('mailto:') ||
                    href.startsWith('tel:');

                // Jika link menuju ke halaman yang sama (bukan external atau download)
                // DAN bukan link dengan metode POST (seperti logout)
                // DAN bukan link download
                // DAN bukan anchor link
                // DAN bukan special protocol link
                if (isSameOrigin && !targetAttr && !e.ctrlKey && !e.metaKey && !e.shiftKey &&
                    !hasPostMethod && !isLogoutLink && !hasDownloadAttr && !isAnchorLink && !
                    isSpecialProtocol) {
                    e.preventDefault();
                    startLoading();

                    // Beri waktu minimal untuk loading indicator terlihat
                    setTimeout(() => {
                        window.location.href = href;
                    }, 50);
                }
            }
        }, true);

        // Intercept form submissions (hanya form dengan method GET)
        document.addEventListener('submit', function(e) {
            const form = e.target;
            // Hanya intercept form GET, bukan form POST
            if (form && form.method.toLowerCase() === 'get') {
                startLoading();
            }
        }, true);

        // Simpan referensi asli ke XMLHttpRequest dan fetch
        const originalXHROpen = XMLHttpRequest.prototype.open;
        const originalXHRSend = XMLHttpRequest.prototype.send;
        const originalFetch = window.fetch;

        // Monkey patch XMLHttpRequest
        XMLHttpRequest.prototype.open = function() {
            // Simpan URL untuk pengecekan nanti
            this._requestUrl = arguments[1];

            this.addEventListener('loadstart', function() {
                // Jangan tangkap request untuk file statis
                if (this._requestUrl &&
                    (this._requestUrl.includes('.css') ||
                        this._requestUrl.includes('.js') ||
                        this._requestUrl.includes('.png') ||
                        this._requestUrl.includes('.jpg') ||
                        this._requestUrl.includes('.jpeg') ||
                        this._requestUrl.includes('.gif') ||
                        this._requestUrl.includes('.ico') ||
                        this._requestUrl.includes('.svg'))) {
                    return;
                }

                if (activeRequests === 0) {
                    startLoading();
                }
                activeRequests++;
            });

            this.addEventListener('loadend', function() {
                // Jangan tangkap request untuk file statis
                if (this._requestUrl &&
                    (this._requestUrl.includes('.css') ||
                        this._requestUrl.includes('.js') ||
                        this._requestUrl.includes('.png') ||
                        this._requestUrl.includes('.jpg') ||
                        this._requestUrl.includes('.jpeg') ||
                        this._requestUrl.includes('.gif') ||
                        this._requestUrl.includes('.ico') ||
                        this._requestUrl.includes('.svg'))) {
                    return;
                }

                activeRequests--;
                if (activeRequests === 0) {
                    setTimeout(stopLoading, 100);
                }
            });

            this.addEventListener('error', function() {
                // Jangan tangkap request untuk file statis
                if (this._requestUrl &&
                    (this._requestUrl.includes('.css') ||
                        this._requestUrl.includes('.js') ||
                        this._requestUrl.includes('.png') ||
                        this._requestUrl.includes('.jpg') ||
                        this._requestUrl.includes('.jpeg') ||
                        this._requestUrl.includes('.gif') ||
                        this._requestUrl.includes('.ico') ||
                        this._requestUrl.includes('.svg'))) {
                    return;
                }

                activeRequests--;
                if (activeRequests === 0) {
                    setTimeout(stopLoading, 100);
                }
            });

            return originalXHROpen.apply(this, arguments);
        };

        XMLHttpRequest.prototype.send = function() {
            // Tambahkan header CSRF token untuk semua request AJAX yang memerlukannya
            if (document.querySelector('meta[name="csrf-token"]') &&
                this._requestUrl &&
                !this._requestUrl.includes('.css') &&
                !this._requestUrl.includes('.js') &&
                !this._requestUrl.includes('.png') &&
                !this._requestUrl.includes('.jpg') &&
                !this._requestUrl.includes('.jpeg') &&
                !this._requestUrl.includes('.gif') &&
                !this._requestUrl.includes('.ico') &&
                !this._requestUrl.includes('.svg')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                this.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            }
            return originalXHRSend.apply(this, arguments);
        };

        // Monkey patch fetch
        window.fetch = function() {
            const url = arguments[0];
            let options = arguments[1] || {};

            // Jangan tangkap request untuk file statis
            if (typeof url === 'string' &&
                (url.includes('.css') ||
                    url.includes('.js') ||
                    url.includes('.png') ||
                    url.includes('.jpg') ||
                    url.includes('.jpeg') ||
                    url.includes('.gif') ||
                    url.includes('.ico') ||
                    url.includes('.svg'))) {
                return originalFetch.apply(this, arguments);
            }

            if (activeRequests === 0) {
                startLoading();
            }
            activeRequests++;

            // Tambahkan header CSRF token untuk fetch requests yang memerlukannya
            if (document.querySelector('meta[name="csrf-token"]') &&
                typeof url === 'string' &&
                !url.includes('.css') &&
                !url.includes('.js') &&
                !url.includes('.png') &&
                !url.includes('.jpg') &&
                !url.includes('.jpeg') &&
                !url.includes('.gif') &&
                !url.includes('.ico') &&
                !url.includes('.svg')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                options.headers = {
                    ...options.headers,
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                };
            }

            return originalFetch(url, options)
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
            // Jangan tampilkan loading untuk perubahan hash saja
            setTimeout(stopLoading, 100);
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

        // Error handling untuk memastikan loading indicator selalu berhenti jika ada error
        window.addEventListener('error', function() {
            stopLoading();
        });

        // Pastikan loading indicator berhenti bahkan jika ada unhandled rejection
        window.addEventListener('unhandledrejection', function() {
            stopLoading();
        });
    })();
    </script>

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
                    installPrompt.classList.add('d-block');
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
    </script>
</body>

</html>