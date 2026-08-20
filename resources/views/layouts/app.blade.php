<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        

    
    <!-- Overlay Loader Centré -->
    <div id="global-loader" style="position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center; background-color: #ffffff; transition: opacity 0.4s ease, visibility 0.4s ease;">
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px;">

            <!-- 1. Icône Croix Verte (SVG) -->
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 4V20M4 12H20" stroke="#10B981" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <!-- 2. Spinner animé -->
            <div class="custom-spinner"></div>

        </div>
    </div>
<style>
        /* Style du spinner tournant */
        .custom-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #E5E7EB;
            border-top-color: #10B981;
            /* Vert assorti à la croix */
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Masquage fluide */
        .loader-hidden {
            opacity: 0 !important;
            visibility: hidden !important;
        }
    </style>

    
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
            <script>
        (function() {
            const loader = document.getElementById('global-loader');

            function hideLoader() {
                if (loader && !loader.classList.contains('loader-hidden')) {
                    loader.classList.add('loader-hidden');
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 400);
                }
            }

            // Fermeture automatique au chargement de la page (ou après 3s de sécurité)
            window.addEventListener('load', hideLoader);
            setTimeout(hideLoader, 3000);
        })();
    </script>

    </body>
</html>
