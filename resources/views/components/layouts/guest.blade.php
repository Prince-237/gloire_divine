<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? (app()->getLocale() === 'fr' ? 'Connexion' : 'Login') }} — La Gloire Divine</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon-180.png') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="flex items-center justify-center min-h-screen px-6 py-12 bg-tint">
    <div class="w-full max-w-md">
        <a href="{{ route('home') }}" class="flex flex-col items-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="La Gloire Divine" class="w-16 h-16 mb-3 rounded-full">
            <span class="text-xl font-semibold font-display text-primary-dark">La Gloire Divine</span>
        </a>

        <div class="p-6 border shadow-sm bg-surface rounded-2xl border-border sm:p-8">
            {{ $slot }}
        </div>

        <p class="mt-6 text-xs text-center text-ink-soft/70">
            © {{ date('Y') }} La Gloire Divine
        </p>
    </div>

    @livewireScripts
</body>
</html>
