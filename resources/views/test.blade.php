<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test PWA - E-NIMEN</title>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#212121" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="E-NIMEN">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/simple-datatables/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/chartjs/Chart.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Test PWA E-NIMEN</h1>
        <p>Halaman ini untuk testing fitur PWA pada aplikasi E-NIMEN.</p>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Status PWA</h5>
            </div>
            <div class="card-body">
                <div id="pwaStatus">
                    <p>Loading status...</p>
                </div>
                <button id="checkPwa" class="btn btn-primary mt-3">Check PWA Status</button>
            </div>
        </div>
    </div>

    <!-- Install Prompt -->
    <div id="installPrompt" class="d-none position-fixed bottom-0 end-0 m-3">
        <div class="card shadow-lg">
            <div class="card-body">
                <h5 class="card-title">Aplikasi E-NIMEN</h5>
                <p class="card-text">Ingin install aplikasi sekarang?</p>
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

    <!-- PWA Script -->
    <script>
    // Debug info
    console.log('E-NIMEN PWA Initializing...');

    // Function to update PWA status
    function updatePwaStatus() {
        const statusDiv = document.getElementById('pwaStatus');
        let html = `
        <p><strong>Service Worker:</strong> ${'serviceWorker' in navigator ? 'Supported' : 'Not supported'}</p>
        <p><strong>BeforeInstallPrompt:</strong> ${deferredPrompt ? 'Event captured' : 'No event'}</p>
        <p><strong>Display Mode:</strong> ${window.matchMedia('(display-mode: standalone)').matches ? 'Standalone' : 'Browser'}</p>
        <p><strong>Local Storage:</strong> ${typeof(Storage) !== "undefined" ? 'Supported' : 'Not supported'}</p>
      `;
        statusDiv.innerHTML = html;
    }

    // Register Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('{{ asset("sw.js") }}')
                .then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    updatePwaStatus();
                })
                .catch(function(error) {
                    console.log('ServiceWorker registration failed: ', error);
                    updatePwaStatus();
                });
        });
    }

    // PWA Installation
    let deferredPrompt;
    const installButton = document.getElementById('installButton');
    const installPrompt = document.getElementById('installPrompt');
    const closeInstallPrompt = document.getElementById('closeInstallPrompt');

    window.addEventListener('beforeinstallprompt', (e) => {
        console.log('beforeinstallprompt event fired');
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later
        deferredPrompt = e;
        updatePwaStatus();

        // Show install prompt (but only if not already installed)
        if (!window.matchMedia('(display-mode: standalone)').matches) {
            setTimeout(() => {
                installPrompt.classList.remove('d-none');
            }, 3000);
        }
    });

    // Handle install button click
    if (installButton) {
        installButton.addEventListener('click', (e) => {
            if (!deferredPrompt) {
                return;
            }

            // Show the install prompt
            deferredPrompt.prompt();

            // Wait for the user to respond to the prompt
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                } else {
                    console.log('User dismissed the A2HS prompt');
                }
                // Hide the install prompt
                installPrompt.classList.add('d-none');
                // We've used the prompt, and can't use it again, throw it away
                deferredPrompt = null;
                updatePwaStatus();
            });
        });
    }

    // Close install prompt
    if (closeInstallPrompt) {
        closeInstallPrompt.addEventListener('click', () => {
            installPrompt.classList.add('d-none');
        });
    }

    // Listen for app installation
    window.addEventListener('appinstalled', (evt) => {
        console.log('E-NIMEN was successfully installed');
        // Hide the install prompt if it's visible
        installPrompt.classList.add('d-none');
        updatePwaStatus();
    });

    // Check if the app is already installed
    if (window.matchMedia('(display-mode: standalone)').matches) {
        console.log('App is running in standalone mode');
        if (installPrompt) installPrompt.classList.add('d-none');
    }

    // Check PWA status button
    document.getElementById('checkPwa').addEventListener('click', updatePwaStatus);

    // Initial status update
    updatePwaStatus();

    // Debug info
    console.log('PWA Support:');
    console.log('- Service Worker: ', 'serviceWorker' in navigator ? 'Supported' : 'Not supported');
    console.log('- BeforeInstallPrompt: ', deferredPrompt ? 'Event captured' : 'No event');
    console.log('- Display Mode: ', window.matchMedia('(display-mode: standalone)').matches ? 'Standalone' : 'Browser');
    </script>
</body>

</html>