<x-app-layout>
    <div class="min-h-screen bg-slate-50">

        {{-- ============== WELCOME BANNER ============== --}}
        <div class="bg-slate-900 rounded-3xl mb-8 overflow-hidden">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex-1 min-w-0">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-600/20 text-red-300 rounded-full text-xs font-bold mb-4">
                            <x-icon name="shield" class="w-3.5 h-3.5" />
                            {{ __('Journalist Desk') }}
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                            {{ __('Welcome back,') }} {{ auth()->user()->name }}
                        </h1>
                        <p class="mt-2 text-slate-400 text-sm sm:text-base">
                            {{ app()->getLocale() === 'bn' ? \Carbon\Carbon::now()->locale('bn')->isoFormat('dddd, D MMMM, YYYY') : \Carbon\Carbon::now()->format('l, F j, Y') }}
                            · {{ number_format($articlesCount ?? 0) }} {{ __('articles filed') }}
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('journalist.articles.create') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-red-600/25 transition active:scale-95">
                            <x-icon name="plus" class="w-4 h-4" />
                            {{ __('Write New Article') }}
                        </a>
                        @if($profile?->slug)
                            <a href="{{ route('journalists.show', $profile->slug) }}" target="_blank"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold text-sm rounded-xl border border-white/20 transition">
                                <x-icon name="globe" class="w-4 h-4" />
                                {{ __('View Portfolio') }}
                            </a>
                        @endif
                        <a href="{{ route('journalist.profile.edit') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white font-bold text-sm rounded-xl transition">
                            <x-icon name="cog" class="w-4 h-4" />
                            {{ __('Edit Profile') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

            {{-- ============== METRIC GRID ============== --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">

                {{-- Total Articles --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center group-hover:scale-110 transition">
                            <x-icon name="newspaper" class="w-6 h-6" />
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __('Total') }}</span>
                    </div>
                    <p class="text-3xl font-black text-slate-900 tabular-nums">{{ number_format($articlesCount ?? 0) }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <p class="text-xs text-slate-500 font-medium">{{ __('Articles filed') }}</p>
                        <a href="{{ route('journalist.articles.index') }}" class="text-xs font-bold text-red-600 hover:text-red-700 inline-flex items-center gap-1">
                            {{ __('View') }}
                            <x-icon name="arrow-right" class="w-3 h-3" />
                        </a>
                    </div>
                </div>

                {{-- Published --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition">
                            <x-icon name="check" class="w-6 h-6" />
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">{{ __('Live') }}</span>
                    </div>
                    <p class="text-3xl font-black text-slate-900 tabular-nums">{{ number_format($publishedArticlesCount ?? 0) }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <p class="text-xs text-slate-500 font-medium">{{ __('Published articles') }}</p>
                        <a href="{{ route('journalist.articles.index', ['status' => 'published']) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1">
                            {{ __('View') }}
                            <x-icon name="arrow-right" class="w-3 h-3" />
                        </a>
                    </div>
                </div>

                {{-- Pending Review --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition">
                            <x-icon name="clock" class="w-6 h-6" />
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-600">{{ __('Pending') }}</span>
                    </div>
                    <p class="text-3xl font-black text-slate-900 tabular-nums">{{ number_format($pendingArticlesCount ?? 0) }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <p class="text-xs text-slate-500 font-medium">{{ __('Awaiting review') }}</p>
                        <a href="{{ route('journalist.articles.index', ['status' => 'pending']) }}" class="text-xs font-bold text-amber-600 hover:text-amber-700 inline-flex items-center gap-1">
                            {{ __('View') }}
                            <x-icon name="arrow-right" class="w-3 h-3" />
                        </a>
                    </div>
                </div>

                {{-- Experience --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition">
                            <x-icon name="briefcase" class="w-6 h-6" />
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ __('Experience') }}</span>
                    </div>
                    <p class="text-3xl font-black text-slate-900 tabular-nums">
                        {{ number_format($profile?->experience_years ?? 0) }}<span class="text-lg text-slate-400 font-bold ml-1">{{ __('yrs') }}</span>
                    </p>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <p class="text-xs text-slate-500 font-medium">{{ __('Years in journalism') }}</p>
                        <a href="{{ route('journalist.profile.edit') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1">
                            {{ __('Edit') }}
                            <x-icon name="arrow-right" class="w-3 h-3" />
                        </a>
                    </div>
                </div>

            </div>

            {{-- ============== TWO-COLUMN LAYOUT ============== --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- LEFT (8 cols): Recent Articles + Bio --}}
                <div class="lg:col-span-8 space-y-8">

                    {{-- Recent articles --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                                    <x-icon name="newspaper" class="w-5 h-5" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-black text-slate-900">{{ __('My Recent Articles') }}</h2>
                                    <p class="text-xs text-slate-500 font-medium">{{ __('Your latest submissions and their status') }}</p>
                                </div>
                            </div>
                            @if(isset($latestArticles) && $latestArticles->count() > 0)
                                <a href="{{ route('journalist.articles.index') }}" class="text-xs font-bold text-red-600 hover:text-red-700 inline-flex items-center gap-1">
                                    {{ __('View all') }}
                                    <x-icon name="arrow-right" class="w-3 h-3" />
                                </a>
                            @endif
                        </div>

                        <div class="p-4 sm:p-6">
                            @if(isset($latestArticles) && $latestArticles->count() > 0)
                                <ul class="space-y-3">
                                    @foreach($latestArticles as $art)
                                        <li class="flex items-start sm:items-center justify-between gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 bg-red-100 text-red-700 rounded-full">
                                                        {{ $art->category->display_name ?? __('Uncategorized') }}
                                                    </span>
                                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full
                                                        @if($art->status === 'published') bg-emerald-100 text-emerald-700
                                                        @elseif($art->status === 'pending') bg-amber-100 text-amber-700
                                                        @elseif($art->status === 'rejected') bg-rose-100 text-rose-700
                                                        @else bg-slate-200 text-slate-700
                                                        @endif
                                                    ">
                                                        @if($art->status === 'published')
                                                            <x-icon name="check" class="w-3 h-3" />
                                                        @elseif($art->status === 'pending')
                                                            <x-icon name="clock" class="w-3 h-3" />
                                                        @elseif($art->status === 'rejected')
                                                            <x-icon name="x" class="w-3 h-3" />
                                                        @else
                                                            <x-icon name="pencil" class="w-3 h-3" />
                                                        @endif
                                                        {{ __(ucfirst($art->status)) }}
                                                    </span>
                                                </div>
                                                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug line-clamp-2">
                                                    {{ $art->display_title }}
                                                </h3>
                                                <p class="mt-1 text-xs text-slate-500 inline-flex items-center gap-1">
                                                    <x-icon name="calendar" class="w-3 h-3" />
                                                    {{ \Carbon\Carbon::parse($art->published_at ?? $art->created_at)->locale(app()->getLocale())->diffForHumans() }}
                                                </p>
                                            </div>
                                            <a href="{{ route('journalist.articles.edit', $art) }}" class="shrink-0 inline-flex items-center gap-1 px-3 py-2 bg-white hover:bg-slate-900 hover:text-white text-slate-700 text-xs font-bold rounded-lg border border-slate-200 transition">
                                                <x-icon name="edit" class="w-3.5 h-3.5" />
                                                <span class="hidden sm:inline">{{ __('Review') }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-10">
                                    <x-icon name="pencil" class="w-12 h-12 text-slate-300 mx-auto" />
                                    <h3 class="mt-3 text-base font-bold text-slate-700">{{ __('No articles yet') }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">{{ __('Start writing to build your portfolio.') }}</p>
                                    <a href="{{ route('journalist.articles.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl transition">
                                        <x-icon name="plus" class="w-4 h-4" />
                                        {{ __('Write Your First Article') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Biography --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                    <x-icon name="user" class="w-5 h-5" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-black text-slate-900">{{ __('Biography & Background') }}</h2>
                                    <p class="text-xs text-slate-500 font-medium">{{ __('Your public bio as seen by readers') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('journalist.profile.edit') }}" class="text-xs font-bold text-red-600 hover:text-red-700 inline-flex items-center gap-1">
                                <x-icon name="edit" class="w-3 h-3" />
                                {{ __('Edit Bio') }}
                            </a>
                        </div>
                        <div class="p-6">
                            @if($profile?->display_bio)
                                <p class="text-slate-700 leading-relaxed text-sm sm:text-base">
                                    {{ $profile->display_bio }}
                                </p>
                            @else
                                <p class="text-slate-400 italic text-sm">
                                    {{ __('No bio on file. Add one to introduce yourself to readers.') }}
                                </p>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- RIGHT (4 cols): Sidebar --}}
                <aside class="lg:col-span-4 space-y-6">

                    {{-- Quick actions --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                                <x-icon name="dashboard" class="w-5 h-5" />
                            </div>
                            <h2 class="text-lg font-black text-slate-900">{{ __('Quick Actions') }}</h2>
                        </div>
                        <div class="p-3">
                            <a href="{{ route('journalist.articles.create') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition group">
                                <span class="flex items-center gap-3">
                                    <span class="w-9 h-9 rounded-lg bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-100 transition">
                                        <x-icon name="pencil" class="w-4 h-4" />
                                    </span>
                                    <span class="text-sm font-bold text-slate-900">{{ __('Write Article') }}</span>
                                </span>
                                <x-icon name="arrow-right" class="w-4 h-4 text-slate-400 group-hover:text-red-600 transition" />
                            </a>
                            <a href="{{ route('journalist.articles.index') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition group">
                                <span class="flex items-center gap-3">
                                    <span class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-100 transition">
                                        <x-icon name="newspaper" class="w-4 h-4" />
                                    </span>
                                    <span class="text-sm font-bold text-slate-900">{{ __('Manage Articles') }}</span>
                                </span>
                                <x-icon name="arrow-right" class="w-4 h-4 text-slate-400 group-hover:text-red-600 transition" />
                            </a>
                            <a href="{{ route('journalist.profile.edit') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition group">
                                <span class="flex items-center gap-3">
                                    <span class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-100 transition">
                                        <x-icon name="user" class="w-4 h-4" />
                                    </span>
                                    <span class="text-sm font-bold text-slate-900">{{ __('Edit Profile') }}</span>
                                </span>
                                <x-icon name="arrow-right" class="w-4 h-4 text-slate-400 group-hover:text-red-600 transition" />
                            </a>
                            @if($profile?->slug)
                                <a href="{{ route('journalists.show', $profile->slug) }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition group">
                                    <span class="flex items-center gap-3">
                                        <span class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-100 transition">
                                            <x-icon name="globe" class="w-4 h-4" />
                                        </span>
                                        <span class="text-sm font-bold text-slate-900">{{ __('View Portfolio') }}</span>
                                    </span>
                                    <x-icon name="external" class="w-4 h-4 text-slate-400 group-hover:text-red-600 transition" />
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Verification status --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl {{ $profile?->is_verified ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} flex items-center justify-center">
                                @if($profile?->is_verified)
                                    <x-icon name="check" class="w-5 h-5" />
                                @else
                                    <x-icon name="clock" class="w-5 h-5" />
                                @endif
                            </div>
                            <div>
                                <h2 class="text-base font-black text-slate-900">{{ __('Verification') }}</h2>
                                <p class="text-xs text-slate-500 font-medium">{{ __('Account status') }}</p>
                            </div>
                        </div>

                        @if($profile?->is_verified)
                            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                                <p class="text-sm font-black text-emerald-900 inline-flex items-center gap-1.5">
                                    <x-icon name="check" class="w-4 h-4" />
                                    {{ __('Verified Journalist') }}
                                </p>
                                <p class="mt-1.5 text-xs text-emerald-800 leading-relaxed">
                                    {{ __('Your account is verified. The blue badge appears on your profile.') }}
                                </p>
                            </div>
                        @else
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <p class="text-sm font-black text-amber-900 inline-flex items-center gap-1.5">
                                    <x-icon name="clock" class="w-4 h-4" />
                                    {{ __('Verification Pending') }}
                                </p>
                                <p class="mt-1.5 text-xs text-amber-800 leading-relaxed">
                                    {{ __('Submit credentials and a complete profile to receive the verified badge.') }}
                                </p>
                                <a href="{{ route('journalist.profile.edit') }}" class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-amber-900 hover:text-amber-700">
                                    {{ __('Complete profile') }}
                                    <x-icon name="arrow-right" class="w-3 h-3" />
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Areas of expertise --}}
                    @if($profile?->expertises && $profile->expertises->count() > 0)
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                                    <x-icon name="tag" class="w-5 h-5" />
                                </div>
                                <div>
                                    <h2 class="text-base font-black text-slate-900">{{ __('Areas of Expertise') }}</h2>
                                    <p class="text-xs text-slate-500 font-medium">{{ __('Your reporting beats') }}</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($profile->expertises as $expertise)
                                    <span class="text-xs font-bold px-3 py-1.5 bg-red-50 text-red-700 border border-red-100 rounded-full">
                                        {{ $expertise->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </aside>

            </div>

        </div>

    </div>
</x-app-layout>
