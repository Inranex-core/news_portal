<x-app-layout>
    <div class="min-h-screen bg-slate-50">

        {{-- ============== WELCOME BANNER ============== --}}
        <div class="bg-slate-900 rounded-3xl mb-8 overflow-hidden mx-4 sm:mx-6 lg:mx-8 mt-4 sm:mt-6">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex-1 min-w-0">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-600/20 text-blue-300 rounded-full text-xs font-bold mb-4">
                            <x-icon name="user" class="w-3.5 h-3.5" />
                            {{ __('Reader Profile') }}
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight flex items-center gap-4">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-slate-800 border-2 border-slate-700 flex items-center justify-center text-xl sm:text-2xl font-bold text-white shrink-0 shadow-inner">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                {{ __('Welcome back,') }} <br class="sm:hidden" />
                                <span class="text-blue-400">{{ auth()->user()->name }}</span>
                            </div>
                        </h1>
                        <p class="mt-3 text-slate-400 text-sm sm:text-base flex items-center gap-2">
                            <x-icon name="mail" class="w-4 h-4" />
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="/"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-red-600/25 transition active:scale-95">
                            <x-icon name="newspaper" class="w-4 h-4" />
                            {{ __('Browse News') }}
                        </a>
                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white font-bold text-sm rounded-xl transition">
                            <x-icon name="cog" class="w-4 h-4" />
                            {{ __('Account Settings') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

            {{-- ============== METRIC GRID ============== --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">

                {{-- Saved Articles --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center group-hover:scale-110 transition">
                            <x-icon name="bookmark" class="w-6 h-6" />
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __('Saved') }}</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-1">{{ __('Saved Articles') }}</h3>
                    <p class="text-sm text-slate-500">{{ __('Articles you saved for later.') }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="#" class="text-xs font-bold text-red-600 hover:text-red-700 inline-flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ __('View Collection') }}
                            <x-icon name="arrow-right" class="w-3 h-3" />
                        </a>
                    </div>
                </div>

                {{-- Reading History --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition">
                            <x-icon name="clock" class="w-6 h-6" />
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600">{{ __('Recent') }}</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-1">{{ __('Reading History') }}</h3>
                    <p class="text-sm text-slate-500">{{ __('See the news articles you recently viewed.') }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ __('View History') }}
                            <x-icon name="arrow-right" class="w-3 h-3" />
                        </a>
                    </div>
                </div>

                {{-- Profile --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition">
                            <x-icon name="user" class="w-6 h-6" />
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __('Settings') }}</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-1">{{ __('My Profile') }}</h3>
                    <p class="text-sm text-slate-500">{{ __('Manage your account information and preferences.') }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('profile.edit') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ __('Edit Profile') }}
                            <x-icon name="arrow-right" class="w-3 h-3" />
                        </a>
                    </div>
                </div>

            </div>

            {{-- ============== DISCOVER SECTION ============== --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 sm:p-12 text-center overflow-hidden relative">

                <div class="relative z-10">
                    <div class="w-20 h-20 mx-auto rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mb-6 shadow-inner border border-slate-100">
                        <x-icon name="rss" class="w-10 h-10" />
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mb-3 tracking-tight">
                        {{ __('Discover the latest news') }}
                    </h2>

                    <p class="text-slate-500 max-w-lg mx-auto mb-8 leading-relaxed">
                        {{ __('Explore Bangladesh, Politics, Sports, Technology, Business and World news from our trusted journalists.') }}
                    </p>

                    <a href="/"
                       class="inline-flex items-center gap-2 px-8 py-3.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-600/25 transition active:scale-95">
                        <x-icon name="search" class="w-5 h-5" />
                        {{ __('Explore All News') }}
                    </a>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>