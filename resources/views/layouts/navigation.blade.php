<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                        <img src="{{ asset('images/couja-logo.png') }}" alt="CoUJA Logo" class="h-10 w-10 object-contain group-hover:scale-105 transition">
                        <div>
                            <span class="font-black text-slate-900 tracking-tight text-sm block leading-tight">
                                {{ __('CoUJA') }}
                            </span>
                            <span class="text-[10px] font-bold text-red-600 uppercase tracking-widest block">
                                {{ auth()->user()?->role === 'admin' ? __('ADMIN PANEL') : __('JOURNALIST DESK') }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:flex items-center text-xs font-bold">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                        📊 {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(auth()->user()?->role === 'journalist')
                        <x-nav-link :href="route('journalist.articles.create')" :active="request()->routeIs('journalist.articles.create')">
                            ✍️ {{ __('Write Article') }}
                        </x-nav-link>

                        <x-nav-link :href="route('journalist.articles.index')" :active="request()->routeIs('journalist.articles.index')">
                            📰 {{ __('My Articles') }}
                        </x-nav-link>

                        <x-nav-link :href="route('journalist.profile.edit')" :active="request()->routeIs('journalist.profile.*')">
                            👤 {{ __('Profile Setup') }}
                        </x-nav-link>
                    @endif

                    @if(auth()->user()?->role === 'admin')
                        <x-nav-link :href="route('admin.articles.pending')" :active="request()->routeIs('admin.articles.pending')">
                            ⏳ {{ __('Pending') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.index')">
                            📰 {{ __('Articles') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.journalists.index')" :active="request()->routeIs('admin.journalists.*')">
                            👥 {{ __('Journalists') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.email.create')" :active="request()->routeIs('admin.email.*')">
                            ✉️ {{ __('Email') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.advertisements.index')" :active="request()->routeIs('admin.advertisements.*')">
                            📢 {{ __('Ads') }}
                        </x-nav-link>
                    @endif

                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-600 hover:text-white px-3 py-1.5 rounded-full transition ml-2 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        {{ __('Visit Portal') }}
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown + Language Switcher -->
            <div class="hidden sm:flex sm:items-center sm:gap-4">

                {{-- Language Switcher Pill --}}
                <div style="display: inline-flex; align-items: center; background-color: #f1f5f9; padding: 3px; border-radius: 9999px; border: 1px solid #cbd5e1; gap: 2px;">
                    <a href="{{ route('lang.switch', 'bn') }}" style="padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; {{ app()->getLocale() === 'bn' ? 'background-color: #dc2626; color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2);' : 'color: #475569;' }}">
                        🇧🇩 বাংলা
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" style="padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; {{ app()->getLocale() === 'en' ? 'background-color: #dc2626; color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2);' : 'color: #475569;' }}">
                        🇬🇧 English
                    </a>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-1.5 border border-slate-200 text-sm font-bold rounded-xl text-slate-700 bg-white hover:text-slate-900 focus:outline-none transition shadow-sm gap-2">
                            <span class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center text-xs font-black">
                                {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
                            </span>
                            <div>{{ Auth::user()?->name ?? 'User' }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            ⚙️ {{ __('Account Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                🚪 {{ __('Logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                📊 {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(auth()->user()?->role === 'journalist')
                <x-responsive-nav-link :href="route('journalist.articles.create')" :active="request()->routeIs('journalist.articles.create')">
                    ✍️ {{ __('Write Article') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('journalist.articles.index')" :active="request()->routeIs('journalist.articles.index')">
                    📰 {{ __('My Articles') }}
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()?->role === 'admin')
                <x-responsive-nav-link :href="route('admin.articles.pending')" :active="request()->routeIs('admin.articles.pending')">
                    ⏳ {{ __('Pending Articles') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.index')">
                    📰 {{ __('All Articles') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.journalists.index')" :active="request()->routeIs('admin.journalists.*')">
                    👥 {{ __('Journalists') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.email.create')" :active="request()->routeIs('admin.email.*')">
                    ✉️ {{ __('Email Journalist') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.advertisements.index')" :active="request()->routeIs('admin.advertisements.*')">
                    📢 {{ __('Advertisements') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('home')">
                🌐 {{ __('Visit Website') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="px-4 mb-3 flex items-center justify-between">
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()?->name ?? 'Guest' }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()?->email ?? '' }}</div>
                </div>
                {{-- Language Switcher --}}
                <div class="flex items-center rounded-full bg-slate-100 p-0.5 border text-xs font-bold">
                    <a href="{{ route('lang.switch', 'bn') }}" class="px-2 py-0.5 rounded-full {{ app()->getLocale() === 'bn' ? 'bg-red-600 text-white' : 'text-slate-600' }}">🇧🇩</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-0.5 rounded-full {{ app()->getLocale() === 'en' ? 'bg-red-600 text-white' : 'text-slate-600' }}">🇬🇧</a>
                </div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    ⚙️ {{ __('Account Settings') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        🚪 {{ __('Logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
