<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CoUJA News Portal') }} - Admin Control Center</title>

        <link rel="icon" href="{{ asset('images/couja-logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900 min-h-screen flex flex-col justify-between">
        <div>
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm border-b border-slate-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- ================= ADMIN SYSTEM FOOTER ================= --}}
        <footer class="bg-slate-950 text-white border-t border-slate-800 mt-20">
            <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    
                    {{-- Left Branding & Status --}}
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/couja-logo.png') }}" alt="CoUJA Logo" class="h-10 w-10 object-contain bg-white rounded-full p-1 shadow-sm">
                        <div>
                            <span class="font-black text-sm text-white block">
                                {{ __('Comilla University Journalist Association') }}
                            </span>
                            <span class="text-xs text-slate-400 flex items-center gap-1.5 mt-0.5 font-medium">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>{{ __('System Operational') }}</span>
                                <span>•</span>
                                <span>{{ __('Administrative Console 2026') }}</span>
                            </span>
                        </div>
                    </div>

                    {{-- Quick Nav Links --}}
                    <div class="flex flex-wrap items-center gap-4 text-xs font-bold text-slate-400">
                        <a href="{{ route('dashboard') }}" class="hover:text-white transition">
                            {{ __('Dashboard') }}
                        </a>
                        @if(auth()->user()?->role === 'journalist')
                            <span>•</span>
                            <a href="{{ route('journalist.articles.index') }}" class="hover:text-white transition">
                                {{ __('My Articles') }}
                            </a>
                            <span>•</span>
                            <a href="{{ route('journalist.articles.create') }}" class="hover:text-white transition">
                                {{ __('Write Article') }}
                            </a>
                            <span>•</span>
                            <a href="{{ route('journalist.profile.edit') }}" class="hover:text-white transition">
                                {{ __('Profile Setup') }}
                            </a>
                        @elseif(auth()->user()?->role === 'admin')
                            <span>•</span>
                            <a href="{{ route('admin.journalists.index') }}" class="hover:text-white transition">
                                {{ __('Journalists') }}
                            </a>
                            <span>•</span>
                            <a href="{{ route('admin.email.create') }}" class="hover:text-white transition">
                                {{ __('Email Journalist') }}
                            </a>
                            <span>•</span>
                            <a href="{{ route('admin.advertisements.index') }}" class="hover:text-white transition">
                                {{ __('Advertisements') }}
                            </a>
                            <span>•</span>
                            <a href="{{ route('admin.articles.index') }}" class="hover:text-white transition">
                                {{ __('Articles') }}
                            </a>
                        @endif
                        <span>•</span>
                        <a href="{{ route('home') }}" target="_blank" class="text-red-400 hover:text-red-300 transition inline-flex items-center gap-1.5">
                            <x-icon name="globe" class="w-3.5 h-3.5" />
                            {{ __('Live Portal') }}
                        </a>
                    </div>

                </div>

                <div class="mt-6 pt-6 border-t border-slate-900 text-center text-[11px] text-slate-500 font-medium">
                    {{ __('All rights reserved © Comilla University Journalist Association (CoUJA). Built with Laravel.') }}
                </div>
            </div>
        </footer>

    </body>
</html>
