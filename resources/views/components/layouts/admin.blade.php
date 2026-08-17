<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — La Gloire Divine</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-tint">
    <div class="lg:flex min-h-screen">
        <x-admin-sidebar />

        <main class="flex-1 min-w-0 p-5 md:p-8 max-w-6xl mx-auto w-full">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
