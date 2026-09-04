<nav class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            {{-- Left Side: Mobile Sidebar Toggle Button & Console Title --}}
            <div class="flex items-center gap-4">
                <button 
                    @click="sidebarOpen = !sidebarOpen" 
                    class="p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none transition flex items-center gap-1.5 border border-slate-200 shadow-2xs"
                    title="{{ __('Toggle Sidebar Menu') }}"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span class="text-xs font-bold text-slate-700 hidden sm:inline-block">{{ __('Menu') }}</span>
                </button>

                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    <span class="font-black text-slate-900 tracking-tight text-xs sm:text-sm truncate max-w-[180px] xs:max-w-xs sm:max-w-md">
                        {{ auth()->user()?->role === 'admin' ? __('Admin Control Center') : __('Journalist Desk Console') }}
                    </span>
                    <span class="text-[10px] font-black text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full uppercase tracking-wider shrink-0">
                        {{ auth()->user()?->role === 'admin' ? __('ADMIN') : __('JOURNALIST') }}
                    </span>
                </div>
            </div>

            {{-- Right Side: Language Switcher + User Profile Dropdown --}}
            <div class="flex items-center gap-3 sm:gap-4">

                {{-- Language Switcher Pill --}}
                <div style="display: inline-flex; align-items: center; background-color: #f1f5f9; padding: 3px; border-radius: 9999px; border: 1px solid #cbd5e1; gap: 2px;">
                    <a href="{{ route('lang.switch', 'bn') }}" style="padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; {{ app()->getLocale() === 'bn' ? 'background-color: #dc2626; color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2);' : 'color: #475569;' }}">
                        বাংলা
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" style="padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; {{ app()->getLocale() === 'en' ? 'background-color: #dc2626; color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2);' : 'color: #475569;' }}">
                        English
                    </a>
                </div>

                {{-- User Settings Dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-1.5 border border-slate-200 text-xs sm:text-sm font-bold rounded-xl text-slate-700 bg-white hover:text-slate-900 focus:outline-none transition shadow-xs gap-2">
                            <span class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center text-xs font-black">
                                {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
                            </span>
                            <span class="hidden sm:inline-block">{{ Auth::user()?->name ?? 'User' }}</span>
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

        </div>
    </div>
</nav>
