<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ app()->getLocale() === 'fr'
        ? 'La Gloire Divine — Centre de santé à Douala. Humanisation des soins de qualité pour une médecine de proximité.'
        : 'La Gloire Divine — Health center in Douala. Humanizing quality care for community-focused medicine.' }}">

    <title>{{ $title ?? 'La Gloire Divine' }} — La Gloire Divine</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon-180.png') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- hreflang : indique à Google les deux versions linguistiques --}}
    <link rel="alternate" hreflang="fr" href="{{ \App\Http\Middleware\SetLocale::urlForLocale('fr') }}">
    <link rel="alternate" hreflang="en" href="{{ \App\Http\Middleware\SetLocale::urlForLocale('en') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="flex flex-col min-h-screen bg-bg text-ink">
    <x-page-loader />

    <x-site-navbar />

    <main class="flex-1">
        {{ $slot }}
    </main>

    <x-site-footer />

    <x-floating-contact-buttons />

    @livewireScripts
</body>
</html>
