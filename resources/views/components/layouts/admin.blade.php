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
    <x-page-loader storage-key="lgd_admin_loaded" />
    

    <div class="min-h-screen lg:flex">
        <x-admin-sidebar />

        <main class="flex-1 w-full max-w-6xl min-w-0 p-5 mx-auto md:p-8">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
