<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - E-NIMEN</title>
    <style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f3f4f6;
        margin: 0;
        padding: 20px;
    }

    .offline-container {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
    }

    .offline-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #6b7280;
    }

    h1 {
        color: #374151;
        margin-bottom: 0.5rem;
    }

    p {
        color: #6b7280;
        margin-bottom: 1.5rem;
    }

    button {
        background-color: #212121;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        cursor: pointer;
        font-weight: 500;
    }

    button:hover {
        background-color: #2563eb;
    }
    </style>
</head>

<body>
    <div class="offline-container">
        <div class="offline-icon">📶</div>
        <h1>Anda sedang offline</h1>
        <p>Aplikasi E-NIMEN membutuhkan koneksi internet untuk dapat berfungsi dengan baik.</p>
        <button onclick="window.location.reload()">Coba Lagi</button>
    </div>
</body>

</html>