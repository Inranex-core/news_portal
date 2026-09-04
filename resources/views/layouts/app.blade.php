<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CoUJA News Portal') }} - Control Console</title>

        <link rel="icon" href="{{ asset('images/couja-logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // Automatic Scroll Position Restoration for smooth back navigation
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'auto';
            }
            document.addEventListener("DOMContentLoaded", function () {
                const savedScroll = sessionStorage.getItem("page_scroll_pos_" + window.location.pathname);
                if (savedScroll && (performance.getEntriesByType("navigation")[0]?.type === "back_forward" || document.referrer)) {
                    window.scrollTo({ top: parseInt(savedScroll, 10), behavior: 'instant' });
                }
                window.addEventListener("beforeunload", function () {
                    sessionStorage.setItem("page_scroll_pos_" + window.location.pathname, window.scrollY);
                });
            });
        </script>
    </head>
    <body class="font-sans antialiased bg-slate-100 text-slate-900 min-h-screen">

        <div 
            class="min-h-screen relative" 
            x-data="{ 
                sidebarOpen: window.innerWidth >= 768,
                isDesktop: window.innerWidth >= 768
            }"
            x-init="
                window.addEventListener('resize', () => {
                    isDesktop = window.innerWidth >= 768;
                });
            "
        >

            {{-- Mobile Backdrop Overlay (ONLY on mobile screens < 768px) --}}
            <div 
                x-show="sidebarOpen && !isDesktop" 
                @click="sidebarOpen = false" 
                class="fixed inset-0 bg-slate-950/60 z-40 md:hidden backdrop-blur-xs"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                style="display: none;"
            ></div>

            {{-- ================= 1. FIXED VIEWPORT SIDEBAR ================= --}}
            <aside 
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white flex flex-col justify-between transition-transform duration-300 ease-in-out border-r border-slate-800 h-full shadow-2xl"
            >
                <div>
                    {{-- Top Sidebar Branding & Cross (Close) Button --}}
                    <div class="h-16 px-4 flex items-center justify-between border-b border-slate-800 bg-slate-950/80 shrink-0">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group min-w-0">
                            <img src="{{ asset('images/couja-logo.png') }}" alt="CoUJA Logo" class="h-8 w-8 object-contain bg-white rounded-full p-0.5 shadow-xs group-hover:scale-105 transition shrink-0">
                            <div class="min-w-0">
                                <span class="font-black text-white tracking-tight text-xs block leading-tight truncate">
                                    {{ __('CoUJA Portal') }}
                                </span>
                                <span class="text-[9px] font-bold text-red-400 uppercase tracking-widest block truncate">
                                    {{ auth()->user()?->role === 'admin' ? __('ADMIN CONTROL') : __('JOURNALIST DESK') }}
                                </span>
                            </div>
                        </a>

                        {{-- Cross (Close) Button --}}
                        <button 
                            type="button"
                            @click.stop="sidebarOpen = false" 
                            class="p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 transition shrink-0 ml-1 cursor-pointer focus:outline-none"
                            title="{{ __('Close Sidebar') }}"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Navigation Menu Links (Scrollable independently inside sidebar) --}}
                    <nav class="px-3 py-4 space-y-1 overflow-y-auto text-xs font-bold max-h-[calc(100vh-7.5rem)]">

                        {{-- Dashboard --}}
                        <a 
                            href="{{ route('dashboard') }}" 
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        >
                            <span class="text-sm shrink-0">📊</span>
                            <span class="truncate">{{ __('Dashboard') }}</span>
                        </a>

                        @if(auth()->user()?->role === 'admin')
                            {{-- Admin Menu Items --}}
                            <div class="pt-3 pb-1 px-3 text-[10px] uppercase tracking-wider font-black text-slate-400">
                                {{ __('ADMIN MANAGEMENT') }}
                            </div>

                            <a 
                                href="{{ route('admin.articles.pending') }}" 
                                class="flex items-center justify-between px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.articles.pending') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                            >
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="text-sm shrink-0">⏳</span>
                                    <span class="truncate">{{ __('Pending Articles') }}</span>
                                </div>
                                @php $pendingCount = \App\Models\Article::where('status', 'pending')->count(); @endphp
                                @if($pendingCount > 0)
                                    <span class="bg-amber-400 text-slate-950 text-[10px] font-black px-2 py-0.5 rounded-full shrink-0 shadow-2xs">
                                        {{ $pendingCount }}
                                    </span>
                                @endif
                            </a>

                            <a 
                                href="{{ route('admin.articles.index') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.articles.index') || request()->routeIs('admin.articles.show') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                            >
                                <span class="text-sm shrink-0">📰</span>
                                <span class="truncate">{{ __('All Articles') }}</span>
                            </a>

                            <a 
                                href="{{ route('admin.journalists.index') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.journalists.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                            >
                                <span class="text-sm shrink-0">👥</span>
                                <span class="truncate">{{ __('Journalists') }}</span>
                            </a>

                            <a 
                                href="{{ route('admin.email.create') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.email.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                            >
                                <span class="text-sm shrink-0">✉️</span>
                                <span class="truncate">{{ __('Send Email') }}</span>
                            </a>

                            <a 
                                href="{{ route('admin.advertisements.index') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.advertisements.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                            >
                                <span class="text-sm shrink-0">📢</span>
                                <span class="truncate">{{ __('Advertisements') }}</span>
                            </a>
                        @endif

                        @if(auth()->user()?->role === 'journalist')
                            {{-- Journalist Menu Items --}}
                            <div class="pt-3 pb-1 px-3 text-[10px] uppercase tracking-wider font-black text-slate-400">
                                {{ __('JOURNALIST DESK') }}
                            </div>

                            @if(auth()->user()->isApproved())
                                <a 
                                    href="{{ route('journalist.articles.create') }}" 
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('journalist.articles.create') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                                >
                                    <span class="text-sm shrink-0">✍️</span>
                                    <span class="truncate">{{ __('Write Article') }}</span>
                                </a>
                            @else
                                <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 bg-slate-800/40 cursor-not-allowed opacity-60" title="{{ __('Pending Admin Approval') }}">
                                    <span class="text-sm shrink-0">🔒 ✍️</span>
                                    <span class="truncate">{{ __('Write Article') }}</span>
                                </div>
                            @endif

                            <a 
                                href="{{ route('journalist.articles.index') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('journalist.articles.index') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                            >
                                <span class="text-sm shrink-0">📰</span>
                                <span class="truncate">{{ __('My Articles') }}</span>
                            </a>

                            <a 
                                href="{{ route('journalist.profile.edit') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('journalist.profile.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                            >
                                <span class="text-sm shrink-0">👤</span>
                                <span class="truncate">{{ __('Profile Setup') }}</span>
                            </a>

                            <a 
                                href="{{ route('journalist.experience.index') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('journalist.experience.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                            >
                                <span class="text-sm shrink-0">💼</span>
                                <span class="truncate">{{ __('Experience') }}</span>
                            </a>

                            <a 
                                href="{{ route('journalist.education.index') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('journalist.education.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                            >
                                <span class="text-sm shrink-0">🎓</span>
                                <span class="truncate">{{ __('Education') }}</span>
                            </a>

                            <a 
                                href="{{ route('journalist.award.index') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('journalist.award.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                            >
                                <span class="text-sm shrink-0">🏆</span>
                                <span class="truncate">{{ __('Awards') }}</span>
                            </a>

                            <a 
                                href="{{ route('journalist.expertise.index') }}" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('journalist.expertise.*') ? 'bg-red-600 text-white shadow-md shadow-red-600/30 font-black' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                            >
                                <span class="text-sm shrink-0">🎯</span>
                                <span class="truncate">{{ __('Expertise') }}</span>
                            </a>
                        @endif

                    </nav>
                </div>

                {{-- Bottom Sidebar Footer Actions --}}
                <div class="p-3 border-t border-slate-800 bg-slate-950/80 shrink-0">
                    <a 
                        href="{{ route('home') }}" 
                        target="_blank" 
                        class="flex items-center justify-center gap-2 w-full py-2.5 px-3 rounded-xl bg-red-600/20 text-red-300 hover:bg-red-600 hover:text-white font-extrabold text-xs transition border border-red-500/30 shadow-xs"
                    >
                        <span>🌐</span>
                        <span class="truncate">{{ __('Visit Live Portal') }}</span>
                    </a>
                </div>
            </aside>

            {{-- ================= 2. MAIN DASHBOARD CONTENT WRAPPER ================= --}}
            <div 
                :class="sidebarOpen && isDesktop ? 'md:pl-64 pl-64' : 'pl-0'"
                class="transition-[padding] duration-300 ease-in-out min-h-screen flex flex-col w-full min-w-0"
            >
                
                {{-- Top Navigation Header Bar --}}
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow-xs border-b border-slate-200/80">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-grow">
                    {{ $slot }}
                </main>

                {{-- ================= ADMIN SYSTEM FOOTER ================= --}}
                <footer class="bg-slate-950 text-white border-t border-slate-800 mt-16">
                    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                            
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
                                @elseif(auth()->user()?->role === 'admin')
                                    <span>•</span>
                                    <a href="{{ route('admin.journalists.index') }}" class="hover:text-white transition">
                                        {{ __('Journalists') }}
                                    </a>
                                    <span>•</span>
                                    <a href="{{ route('admin.articles.index') }}" class="hover:text-white transition">
                                        {{ __('Articles') }}
                                    </a>
                                @endif
                                <span>•</span>
                                <a href="{{ route('home') }}" target="_blank" class="text-red-400 hover:text-red-300 transition">
                                    🌐 {{ __('Live Portal') }}
                                </a>
                            </div>

                        </div>

                        <div class="mt-6 pt-6 border-t border-slate-900 text-center text-[11px] text-slate-500 font-medium flex flex-col sm:flex-row items-center justify-between gap-2">
                            <span>{{ __('All rights reserved © Comilla University Journalist Association (CoUJA). Built with Laravel.') }}</span>
                            <span class="text-slate-400 font-bold">
                                {{ __('Developed by') }} <span class="text-red-500">Infr@nex</span>
                            </span>
                        </div>
                    </div>
                </footer>
            </div>

        </div>

    </body>
</html>
