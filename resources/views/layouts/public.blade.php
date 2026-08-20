<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', __('Comilla University Journalist Association') . ' - ' . __('Trusted News, Every Day'))
    </title>

    <link rel="icon" href="{{ asset('images/couja-logo.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col justify-between">

    {{-- ================= HEADER ================= --}}
    <header class="border-b border-slate-200 bg-white sticky top-0 z-50 shadow-sm">

        {{-- Top Bar (Motto & Date) --}}
        <div class="bg-slate-900 text-white text-[11px] font-semibold py-1.5 px-4">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-2 text-rose-300 font-bold">
                    <span>📌</span>
                    <span>{{ __('Unwavering on the Path of Truth & Justice') }}</span>
                    <span class="text-slate-500 font-normal">|</span>
                    <span class="text-slate-300 font-normal">{{ __('Established 2013') }}</span>
                </div>
                <div class="hidden sm:block text-slate-300">
                    {{ app()->getLocale() === 'bn' ? \Carbon\Carbon::now()->locale('bn')->isoFormat('dddd, D MMMM, YYYY') : \Carbon\Carbon::now()->format('l, F d, Y') }}
                </div>
            </div>
        </div>

        {{-- Main Header --}}
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">

            {{-- CoUJA Official Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img
                    src="{{ asset('images/couja-logo.png') }}"
                    alt="CoUJA Logo"
                    class="h-14 w-14 object-contain group-hover:scale-105 transition duration-300 drop-shadow-sm"
                />

                <div>
                    <div class="text-base sm:text-xl font-black tracking-tight text-slate-900 group-hover:text-red-600 transition leading-tight">
                        {{ __('Comilla University Journalist Association') }}
                    </div>

                    <div class="text-xs text-red-600 font-bold tracking-wide mt-0.5 flex items-center gap-1.5">
                        <span>{{ __('CoUJA') }}</span>
                        <span>•</span>
                        <span class="text-slate-500 font-medium">{{ __('Trusted News, Every Day') }}</span>
                    </div>
                </div>
            </a>


            {{-- Search Bar --}}
            <div class="hidden md:flex flex-1 max-w-md mx-8">
                <form action="{{ route('home') }}" method="GET" class="w-full relative flex items-center">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="{{ __('Search news, topics, keywords...') }}"
                        class="w-full rounded-full border border-slate-200 bg-slate-50 px-4 py-2 pl-4 pr-12 text-sm text-slate-800 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-red-500 transition shadow-inner"
                    />
                    <button
                        type="submit"
                        class="absolute right-1.5 p-1.5 rounded-full bg-red-600 text-white hover:bg-red-700 transition focus:outline-none focus:ring-2 focus:ring-red-500 flex items-center justify-center shadow-sm"
                        title="{{ __('Search') }}"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </form>
            </div>


            {{-- Right Side: Language Switcher + Authentication --}}
            <div class="flex items-center gap-4">

                {{-- Language Switcher Pill --}}
                <div style="display: inline-flex; align-items: center; background-color: #f1f5f9; padding: 3px; border-radius: 9999px; border: 1px solid #cbd5e1; gap: 2px;">
                    <a
                        href="{{ route('lang.switch', 'bn') }}"
                        style="padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; {{ app()->getLocale() === 'bn' ? 'background-color: #dc2626; color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2);' : 'color: #475569;' }}"
                        title="বাংলায় পড়ুন"
                    >
                        🇧🇩 বাংলা
                    </a>
                    <a
                        href="{{ route('lang.switch', 'en') }}"
                        style="padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; {{ app()->getLocale() === 'en' ? 'background-color: #dc2626; color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2);' : 'color: #475569;' }}"
                        title="Read in English"
                    >
                        🇬🇧 English
                    </a>
                </div>

                {{-- Authentication & Navigation --}}
                @guest
                    <a
                        href="{{ route('login') }}"
                        class="text-sm font-bold text-slate-700 transition hover:text-red-600 px-2 py-1"
                    >
                        {{ __('Login') }}
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-700 shadow-sm"
                    >
                        {{ __('Register') }}
                    </a>
                @else
                    {{-- Logged-in User Links --}}
                    <div class="flex items-center gap-3">
                        <a
                            href="{{ route('dashboard') }}"
                            class="rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-700 shadow-sm flex items-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </a>
                    </div>
                @endguest

            </div>

        </div>


        {{-- Navigation Bar / Category Tabs --}}
        <nav class="border-t border-slate-100 bg-slate-50 shadow-inner">
            <div class="mx-auto flex max-w-7xl items-center overflow-x-auto px-4 py-2 sm:px-6 lg:px-8 space-x-1 sm:space-x-2 text-xs sm:text-sm font-bold no-scrollbar">

                <a
                    href="{{ route('home') }}"
                    class="rounded-lg px-3 py-1.5 whitespace-nowrap transition {{ !request('category') ? 'bg-red-600 text-white shadow-sm' : 'text-slate-700 hover:bg-red-50 hover:text-red-600' }}"
                >
                    {{ __('Home') }}
                </a>

                @foreach(($categories ?? \App\Models\Category::where('status', true)->get()) as $navCat)
                    <a
                        href="{{ route('categories.show', $navCat->slug) }}"
                        class="rounded-lg px-3 py-1.5 whitespace-nowrap transition {{ request('category') === $navCat->slug || (isset($category) && $category->id === $navCat->id) ? 'bg-red-600 text-white shadow-sm' : 'text-slate-700 hover:bg-red-50 hover:text-red-600' }}"
                    >
                        {{ $navCat->display_name }}
                    </a>
                @endforeach

                <a
                    href="{{ route('journalists.index') }}"
                    class="rounded-lg px-3 py-1.5 whitespace-nowrap transition text-red-600 bg-red-50 hover:bg-red-600 hover:text-white ml-auto"
                >
                    👥 {{ __('Journalists Directory') }}
                </a>

            </div>
        </nav>

    </header>


    {{-- ================= PAGE CONTENT ================= --}}
    <main class="flex-grow">
        @yield('content')
    </main>


    {{-- ================= FOOTER ================= --}}
    <footer class="mt-16 bg-slate-950 text-white">

        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-8">

            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/couja-logo.png') }}" alt="CoUJA Logo" class="h-12 w-12 object-contain bg-white rounded-full p-1 shadow">
                    <span class="text-base font-black leading-snug">
                        {{ __('Comilla University Journalist Association') }}
                    </span>
                </div>
                <p class="mt-4 leading-relaxed text-slate-400 text-xs">
                    {{ __('Your trusted news source bringing you independent journalism, verified reporting, and live breaking updates.') }}
                </p>
            </div>


            {{-- Categories --}}
            <div>
                <h3 class="text-lg font-black">
                    {{ __('News Categories') }}
                </h3>

                <div class="mt-5 space-y-2.5 text-sm text-slate-400">
                    @foreach(($categories ?? \App\Models\Category::where('status', true)->get())->take(6) as $footCat)
                        <a href="{{ route('categories.show', $footCat->slug) }}" class="block hover:text-white transition">
                            {{ $footCat->display_name }}
                        </a>
                    @endforeach
                </div>
            </div>


            {{-- Quick Links --}}
            <div>
                <h3 class="text-lg font-black">
                    {{ __('Quick Links') }}
                </h3>

                <div class="mt-5 space-y-2.5 text-sm text-slate-400">
                    <a href="{{ route('home') }}" class="block hover:text-white transition">
                        {{ __('Home') }}
                    </a>
                    <a href="{{ route('journalists.index') }}" class="block hover:text-white transition">
                        {{ __('Journalists Directory') }}
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="block hover:text-white transition">
                            {{ __('Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block hover:text-white transition">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}" class="block hover:text-white transition">
                            {{ __('Register') }}
                        </a>
                    @endauth
                </div>
            </div>


            {{-- Social & Info --}}
            <div>
                <h3 class="text-lg font-black">
                    {{ __('Follow Us') }}
                </h3>

                <div class="mt-5 flex gap-3">
                    <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-sm font-bold transition hover:bg-red-600">
                        f
                    </a>
                    <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-sm font-bold transition hover:bg-red-600">
                        X
                    </a>
                    <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-sm font-bold transition hover:bg-red-600">
                        in
                    </a>
                </div>
            </div>

        </div>


        {{-- Copyright --}}
        <div class="border-t border-slate-800">
            <div class="mx-auto max-w-7xl px-4 py-6 text-center text-xs text-slate-500 sm:px-6 lg:px-8">
                {{ __('All rights reserved. Built with Laravel.') }}
            </div>
        </div>

    </footer>

</body>

</html>