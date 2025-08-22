<!DOCTYPE html>
<html>

<head>
    <title>PWA Debug - E-NIMEN</title>
    <style>
    .status {
        padding: 10px;
        margin: 5px;
        border-radius: 5px;
    }

    .success {
        background: #d4edda;
        color: #155724;
    }

    .warning {
        background: #fff3cd;
        color: #856404;
    }

    .error {
        background: #f8d7da;
        color: #721c24;
    }

    .info {
        background: #d1ecf1;
        color: #0c5460;
    }
    </style>
</head>

<body>
    <h1>PWA Debug Information - E-NIMEN</h1>
    <div id="debugInfo"></div>
    <button onclick="checkPWA()">Refresh Status</button>
    <button onclick="clearDismissal()">Clear Prompt Dismissal</button>
    <button onclick="triggerInstall()" id="manualInstall" class="d-none">Trigger Install Manual</button>

    <script>
    let deferredPrompt = null;

    function checkPWA() {
        const debugInfo = document.getElementById('debugInfo');
        let html = '';

        // Check Service Worker
        if ('serviceWorker' in navigator) {
            html += `<div class="status success">Service Worker: Supported</div>`;

            // Check registration
            navigator.serviceWorker.getRegistration().then(reg => {
                if (reg) {
                    html += `<div class="status success">Service Worker: Registered (${reg.scope})</div>`;
                } else {
                    html += `<div class="status warning">Service Worker: Not Registered</div>`;
                }
                debugInfo.innerHTML = html;
            });
        } else {
            html += `<div class="status error">Service Worker: Not Supported</div>`;
        }

        // Check BeforeInstallPrompt
        if (deferredPrompt) {
            html += `<div class="status success">BeforeInstallPrompt: Available</div>`;
        } else {
            html += `<div class="status warning">BeforeInstallPrompt: Not Available (event not fired yet)</div>`;
        }

        // Check Display Mode
        if (window.matchMedia('(display-mode: standalone)').matches) {
            html += `<div class="status success">Display Mode: Standalone (Installed)</div>`;
        } else if (window.matchMedia('(display-mode: minimal-ui)').matches) {
            html += `<div class="status info">Display Mode: Minimal UI</div>`;
        } else if (window.navigator.standalone) {
            html += `<div class="status success">Display Mode: iOS Standalone</div>`;
        } else {
            html += `<div class="status">Display Mode: Browser</div>`;
        }

        // Check Local Storage
        if (typeof(Storage) !== "undefined") {
            html += `<div class="status success">Local Storage: Supported</div>`;

            // Check if prompt was dismissed
            const lastDismissed = localStorage.getItem('installPromptDismissed');
            if (lastDismissed) {
                const dismissedDate = new Date(parseInt(lastDismissed));
                const now = new Date();
                const diffTime = Math.abs(now - dismissedDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                html += `<div class="status info">Install Prompt dismissed: ${diffDays} days ago</div>`;
            } else {
                html += `<div class="status info">Install Prompt: Never dismissed</div>`;
            }
        } else {
            html += `<div class="status error">Local Storage: Not Supported</div>`;
        }

        // Check if app is installed using other methods
        if (window.matchMedia('(display-mode: standalone)').matches ||
            window.navigator.standalone ||
            document.referrer.includes('android-app://')) {
            html += `<div class="status success">App Installed: Yes</div>`;
        } else {
            html += `<div class="status">App Installed: No</div>`;
        }

        debugInfo.innerHTML = html;
    }

    function clearDismissal() {
        localStorage.removeItem('installPromptDismissed');
        alert('Install prompt dismissal cleared. Prompt will show again if conditions are met.');
        checkPWA();
    }

    // Listen for beforeinstallprompt
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        console.log('BeforeInstallPrompt event captured');
        checkPWA();
    });

    // Initialize
    checkPWA();

    // Register service worker for debug page too
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
                checkPWA();
            })
            .catch(function(error) {
                console.log('ServiceWorker registration failed: ', error);
                checkPWA();
            });
    }

    function triggerInstall() {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted install');
                } else {
                    console.log('User dismissed install');
                }
                deferredPrompt = null;
            });
        }
    }

    // Auto-show manual button setelah 5 detik
    setTimeout(() => {
        if (deferredPrompt) {
            document.getElementById('manualInstall').classList.remove('d-none');
        }
    }, 5000);
    </script>


</body>

</html>