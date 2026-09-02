<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0f172a">

    <title>
        @yield('title', __('Comilla University Journalist Association') . ' - ' . __('Trusted News, Every Day'))
    </title>

    <link rel="icon" href="{{ asset('images/couja-logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    x-data="{ mobileNav: false, mobileSearch: false, langMenu: false }"
    class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col justify-between"
>

    {{-- ================= HEADER ================= --}}
    <header class="border-b border-slate-200 bg-white sticky top-0 z-50 shadow-sm">

        {{-- Top Bar (Motto & Date) --}}
        <div class="bg-slate-900 text-white text-[11px] font-semibold py-1.5 px-3 sm:px-4">
            <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
                <div class="flex items-center gap-1.5 sm:gap-2 text-rose-300 font-bold min-w-0">
                    <span class="shrink-0 inline-flex items-center justify-center">
                        <x-icon name="pin" class="w-3.5 h-3.5" />
                    </span>
                    <span class="truncate">{{ __('সত্য ও ন্যায়ের পথে অবিচল') }}</span>
                    <span class="hidden md:inline text-slate-500 font-normal">|</span>
                    <span class="hidden md:inline text-slate-300 font-normal">{{ __('প্রতিষ্ঠিত ২০১৩') }}</span>
                </div>
                <div class="hidden sm:block text-slate-300 shrink-0">
                    {{ \Carbon\Carbon::now()->locale('bn')->isoFormat('dddd, D MMMM, YYYY') }}
                </div>
            </div>
        </div>

        {{-- Main Header --}}
        <div class="mx-auto flex flex-wrap sm:flex-nowrap max-w-7xl items-center justify-between gap-y-3 gap-x-2 px-3 py-3 sm:px-6 lg:px-8">

            {{-- CoUJA Official Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 group min-w-0 flex-1 sm:flex-initial">
                <img
                    src="{{ asset('images/couja-logo.png') }}"
                    alt="CoUJA Logo"
                    class="h-12 w-12 sm:h-14 sm:w-14 object-contain group-hover:scale-105 transition duration-300 drop-shadow-sm shrink-0"
                />

                <div class="min-w-0">
                    <div class="text-sm sm:text-base md:text-xl font-black tracking-tight text-slate-900 group-hover:text-red-600 transition leading-tight break-words-safe">
                        {{ __('Comilla University Journalist Association') }}
                    </div>

                    <div class="text-[10px] sm:text-xs text-red-600 font-bold tracking-wide mt-0.5 flex items-center gap-1 sm:gap-1.5">
                        <span>{{ __('CoUJA') }}</span>
                        <span>•</span>
                        <span class="text-slate-500 font-medium truncate">{{ __('Trusted News, Every Day') }}</span>
                    </div>
                </div>
            </a>


            {{-- Desktop Search Bar --}}
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


            {{-- Right Side: Actions --}}
            <div class="flex items-center gap-1.5 sm:gap-3 shrink-0 ml-auto">

                {{-- Mobile Search Toggle --}}
                <button
                    type="button"
                    @click="mobileSearch = !mobileSearch"
                    class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded-full text-slate-700 hover:bg-slate-100 transition"
                    aria-label="{{ __('Search') }}"
                    :aria-expanded="mobileSearch"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>



                {{-- Authentication & Navigation (Desktop) --}}
                <div class="hidden sm:flex items-center gap-3">
                    @guest
                        <a
                            href="{{ route('login') }}"
                            class="text-sm font-bold text-slate-700 transition hover:text-red-600 px-2 py-1"
                        >
                            {{ __('Login') }}
                        </a>

                        <a
                            href="{{ route('register') }}"
                            class="rounded-xl bg-red-600 px-3 py-2 sm:px-4 text-sm font-bold text-white transition hover:bg-red-700 shadow-sm whitespace-nowrap"
                        >
                            {{ __('Register') }}
                        </a>
                    @else
                        <a
                            href="{{ route('dashboard') }}"
                            class="rounded-xl bg-red-600 px-3 py-2 sm:px-4 text-sm font-bold text-white transition hover:bg-red-700 shadow-sm flex items-center gap-2 whitespace-nowrap"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="hidden md:inline">{{ __('Dashboard') }}</span>
                        </a>
                    @endguest
                </div>

                {{-- Mobile Hamburger --}}
                <button
                    type="button"
                    @click="mobileNav = !mobileNav"
                    class="sm:hidden inline-flex items-center justify-center w-9 h-9 rounded-md text-slate-700 hover:bg-slate-100 transition"
                    aria-label="{{ __('Menu') }}"
                    :aria-expanded="mobileNav"
                >
                    <svg x-show="!mobileNav" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileNav" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

            </div>

        </div>

        {{-- Mobile Search Bar (collapsible) --}}
        <div
            x-show="mobileSearch"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="md:hidden border-t border-slate-200 px-3 py-2.5 bg-white"
        >
            <form action="{{ route('home') }}" method="GET" class="w-full relative flex items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('Search news, topics, keywords...') }}"
                    class="w-full rounded-full border border-slate-200 bg-slate-50 px-4 py-2 pl-4 pr-12 text-sm text-slate-800 focus:border-red-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-red-500 transition"
                />
                <button
                    type="submit"
                    class="absolute right-1.5 p-1.5 rounded-full bg-red-600 text-white hover:bg-red-700 transition flex items-center justify-center shadow-sm"
                    title="{{ __('Search') }}"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </form>
        </div>


        {{-- Navigation Bar / Category Tabs --}}
        <nav class="border-t border-slate-100 bg-slate-50 shadow-inner">
            <div class="mx-auto flex max-w-7xl items-center overflow-x-auto px-3 py-2 sm:px-6 lg:px-8 space-x-1 sm:space-x-2 text-xs sm:text-sm font-bold no-scrollbar scroll-snap-x">

                @php
                    $currentArticle = $article ?? null;
                    $isActiveCategory = function($slug) use ($currentArticle) {
                        if (request('category') === $slug) return true;
                        if (request()->routeIs('categories.show') && request()->route('slug') === $slug) return true;
                        if (request()->routeIs('articles.show') && $currentArticle && $currentArticle->category->slug === $slug) return true;
                        return false;
                    };
                    $isHomeActive = request()->routeIs('home') && !request('category');
                @endphp

                <a
                    href="{{ route('home') }}"
                    class="relative rounded-lg px-3 py-1.5 whitespace-nowrap transition group {{ $isHomeActive ? 'bg-red-600 text-white shadow-sm pointer-events-none' : 'text-slate-700 hover:text-red-600' }}"
                >
                    {{ __('Home') }}
                    @if(!$isHomeActive)
                        <span class="absolute left-0 bottom-0 w-full h-[2px] bg-red-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left rounded-b-lg"></span>
                    @endif
                </a>

                @foreach(($categories ?? \App\Models\Category::where('status', true)->get()) as $navCat)
                    <a
                        href="{{ route('categories.show', $navCat->slug) }}"
                        class="relative rounded-lg px-3 py-1.5 whitespace-nowrap transition group {{ $isActiveCategory($navCat->slug) ? 'bg-red-600 text-white shadow-sm pointer-events-none' : 'text-slate-700 hover:text-red-600' }}"
                    >
                        {{ $navCat->display_name }}
                        @if(!$isActiveCategory($navCat->slug))
                            <span class="absolute left-0 bottom-0 w-full h-[2px] bg-red-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left rounded-b-lg"></span>
                        @endif
                    </a>
                @endforeach

                <a
                    href="{{ route('journalists.index') }}"
                    class="relative rounded-lg px-3 py-1.5 whitespace-nowrap transition group text-red-600 bg-red-50 hover:bg-red-50 hover:text-red-700 ml-auto shrink-0"
                >
                    <x-icon name="users" class="w-4 h-4 inline" />
                    <span class="hidden sm:inline">{{ __('Journalists Directory') }}</span><span class="sm:hidden">{{ __('Journalists') }}</span>
                    <span class="absolute left-0 bottom-0 w-full h-[2px] bg-red-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left rounded-b-lg"></span>
                </a>

            </div>
        </nav>

        {{-- Mobile Menu Drawer (auth + extras) --}}
        <div
            x-show="mobileNav"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="sm:hidden border-t border-slate-200 bg-white"
        >
            <div class="px-3 py-3 space-y-2">
                @guest
                    <a
                        href="{{ route('login') }}"
                        class="block text-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50 transition"
                    >
                        {{ __('Login') }}
                    </a>
                    <a
                        href="{{ route('register') }}"
                        class="block text-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-red-700 transition shadow-sm"
                    >
                        {{ __('Register') }}
                    </a>
                @else
                    <div class="px-2 mb-3">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()?->name ?? 'User' }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()?->email ?? '' }}</div>
                    </div>
                    <div class="border-t border-slate-100 pt-2 pb-1 space-y-1">
                        <a
                            href="{{ route('dashboard') }}"
                            class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50 transition"
                        >
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ __('Dashboard') }}
                        </a>
                        <a
                            href="{{ route('profile.edit') }}"
                            class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50 transition"
                        >
                            <x-icon name="cog" class="w-4 h-4 text-slate-400" />
                            {{ __('Account Settings') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-bold text-red-600 hover:bg-red-50 transition text-left"
                            >
                                <x-icon name="logout" class="w-4 h-4 text-red-400" />
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>

    </header>


    {{-- ================= PAGE CONTENT ================= --}}
    <main class="flex-grow">
        @yield('content')
    </main>


    {{-- ================= FOOTER ================= --}}
    <footer class="mt-16 bg-slate-950 text-white">

        <div class="mx-auto grid max-w-7xl gap-8 sm:gap-10 px-4 py-12 sm:py-14 sm:px-6 sm:grid-cols-2 lg:grid-cols-4 lg:px-8">

            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/couja-logo.png') }}" alt="CoUJA Logo" class="h-12 w-12 object-contain bg-white rounded-full p-1 shadow shrink-0">
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
                    <a href="#" aria-label="Facebook" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-sm font-bold transition hover:bg-red-600">
                        f
                    </a>
                    <a href="#" aria-label="X" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-sm font-bold transition hover:bg-red-600">
                        X
                    </a>
                    <a href="#" aria-label="LinkedIn" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-sm font-bold transition hover:bg-red-600">
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

    {{-- Alpine x-cloak so drawers don't flash before Alpine boots. --}}
    <style>[x-cloak]{display:none!important}</style>

</body>

</html>