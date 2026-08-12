<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <title>@yield('title', 'SUAM — Sistema Universitario de Aprendizaje para Adultos Mayores')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CDN Config -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @stack('styles')
</head>

<body class="min-h-screen flex flex-col bg-gray-50 text-navy">

    <!-- Header / Navbar Parcial -->
    @include('partials.header')

    <!-- Contenido Principal -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 py-6 sm:py-8">
        @yield('content')
    </main>

    <!-- Footer Parcial -->

    @include('partials.footer')
</body>
@livewireScripts
@stack('scripts')

</html>
