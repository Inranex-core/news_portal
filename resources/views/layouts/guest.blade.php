<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('Comilla University Journalist Association') }} (CoUJA)</title>
        <link rel="icon" href="{{ asset('images/couja-logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-100 px-3 sm:px-0">
            <div class="flex flex-col items-center text-center px-2">
                <a href="/">
                    <img src="{{ asset('images/couja-logo.png') }}" alt="CoUJA Logo" class="w-20 h-20 sm:w-24 sm:h-24 object-contain shadow-md rounded-full bg-white p-1">
                </a>
                <h1 class="text-base sm:text-lg font-black text-slate-900 mt-3">
                    {{ __('Comilla University Journalist Association') }}
                </h1>
                <p class="text-[11px] sm:text-xs font-bold text-red-600 mt-0.5">
                    {{ __('Unwavering on the Path of Truth & Justice') }} • {{ __('Estd. 2013') }}
                </p>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-4 sm:px-6 py-6 bg-white shadow-lg overflow-hidden sm:rounded-2xl border border-slate-200">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
