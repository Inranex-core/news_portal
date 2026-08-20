<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome Banner --}}
            <div class="bg-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-red-600 text-white rounded-full text-xs font-black uppercase tracking-widest shadow-sm">
                            🛡️ {{ __('ADMIN CONTROL CENTER') }}
                        </span>
                        <span class="text-xs text-slate-300 font-medium">
                            {{ app()->getLocale() === 'bn' ? \Carbon\Carbon::now()->locale('bn')->isoFormat('dddd, D MMMM, YYYY') : \Carbon\Carbon::now()->format('l, F d, Y') }}
                        </span>
                    </div>
                    <h1 class="text-3xl font-black mt-3 tracking-tight text-white">
                        {{ __('Welcome back,') }} {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-sm text-slate-300 mt-1 max-w-2xl leading-relaxed font-normal">
                        {{ __('Overview of CoUJA News Portal operations, article approvals, journalist verification, reader engagement, and direct communications.') }}
                    </p>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('admin.email.create') }}" class="px-5 py-3 rounded-2xl bg-red-600 hover:bg-red-700 text-white font-bold text-sm transition shadow-md flex items-center gap-2">
                        <span>✉️</span>
                        <span>{{ __('Email Journalist') }}</span>
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="px-5 py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-sm transition border border-slate-700 flex items-center gap-2">
                        <span>🌐</span>
                        <span>{{ __('Visit Portal') }}</span>
                    </a>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-sm font-bold flex items-center gap-2 shadow-sm">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Overview Statistics Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Registered Users --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ __('Registered Users') }}
                            </p>
                            <h2 class="text-3xl font-black text-slate-900 mt-2">
                                {{ number_format($totalUsers) }}
                            </h2>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition">
                            👥
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>{{ __('Active Readers & Staff') }}</span>
                        <span class="text-blue-600 font-bold">100% {{ __('Active') }}</span>
                    </div>
                </div>

                {{-- Correspondents --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ __('Correspondents') }}
                            </p>
                            <h2 class="text-3xl font-black text-slate-900 mt-2">
                                {{ number_format($totalJournalists) }}
                            </h2>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition">
                            📰
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>{{ $verifiedJournalists }} {{ __('Verified') }}</span>
                        <a href="{{ route('admin.journalists.index') }}" class="text-red-600 font-bold hover:underline">
                            {{ __('Manage') }} →
                        </a>
                    </div>
                </div>

                {{-- Total News Reports --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ __('Total News Reports') }}
                            </p>
                            <h2 class="text-3xl font-black text-slate-900 mt-2">
                                {{ number_format($totalArticles) }}
                            </h2>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition">
                            📄
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>{{ $publishedArticles }} {{ __('Published') }}</span>
                        <a href="{{ route('admin.articles.index') }}" class="text-emerald-600 font-bold hover:underline">
                            {{ __('View All') }} →
                        </a>
                    </div>
                </div>

                {{-- Pending Approvals --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                {{ __('Pending Approvals') }}
                            </p>
                            <h2 class="text-3xl font-black text-amber-600 mt-2">
                                {{ number_format($pendingArticles) }}
                            </h2>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition">
                            ⏳
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span>{{ __('Awaiting Review') }}</span>
                        <a href="{{ route('admin.articles.pending') }}" class="text-amber-600 font-bold hover:underline">
                            {{ __('Review Now') }} →
                        </a>
                    </div>
                </div>

            </div>

            {{-- Action & Management Control Hub Cards --}}
            <div class="space-y-4">
                <h2 class="text-xl font-black text-slate-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                    {{ __('Administrative Control Hub') }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    {{-- Manage Journalists Card --}}
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:border-red-300 transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg mb-4">
                                👥
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">
                                {{ __('Manage Journalists') }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                {{ __('Verify reporters, update credentials, review experience, and send direct emails.') }}
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100 flex gap-2">
                            <a href="{{ route('admin.journalists.index') }}" class="flex-1 text-center bg-red-600 hover:bg-red-700 text-white font-bold text-xs py-2.5 rounded-xl transition">
                                {{ __('Journalists List') }}
                            </a>
                            <a href="{{ route('admin.email.create') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs px-3 py-2.5 rounded-xl transition" title="{{ __('Email Journalist') }}">
                                ✉️
                            </a>
                        </div>
                    </div>

                    {{-- Article Management Card --}}
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:border-emerald-300 transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg mb-4">
                                📰
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">
                                {{ __('News Article Portal') }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                {{ __('Review all submitted reports, approve breaking news, or edit published articles.') }}
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100 flex gap-2">
                            <a href="{{ route('admin.articles.index') }}" class="flex-1 text-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2.5 rounded-xl transition">
                                {{ __('All Articles') }}
                            </a>
                            <a href="{{ route('admin.articles.pending') }}" class="bg-amber-100 hover:bg-amber-200 text-amber-800 font-bold text-xs px-3 py-2.5 rounded-xl transition" title="{{ __('Pending Review') }}">
                                ⏳ {{ $pendingArticles }}
                            </a>
                        </div>
                    </div>

                    {{-- Advertisements Card --}}
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:border-amber-300 transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg mb-4">
                                📢
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">
                                {{ __('Advertisement Banners') }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                {{ __('Create and manage sponsor banners, placement locations, and active campaigns.') }}
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <a href="{{ route('admin.advertisements.index') }}" class="block text-center bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs py-2.5 rounded-xl transition">
                                {{ __('Manage Ads') }} →
                            </a>
                        </div>
                    </div>

                    {{-- Email Communication Card --}}
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:border-blue-300 transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg mb-4">
                                ✉️
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">
                                {{ __('Email Journalist') }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                {{ __('Send official internal memos, instructions, or article feedback directly to reporters.') }}
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <a href="{{ route('admin.email.create') }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-2.5 rounded-xl transition">
                                {{ __('Compose Email') }} →
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Recent Activity & Articles Table --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Recent News Articles --}}
                <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-100">
                        <h3 class="text-lg font-black text-slate-900 flex items-center gap-2">
                            📰 {{ __('Recent News Articles') }}
                        </h3>
                        <a href="{{ route('admin.articles.index') }}" class="text-xs font-bold text-red-600 hover:underline">
                            {{ __('View All') }} →
                        </a>
                    </div>

                    @if($recentArticles->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentArticles as $art)
                                <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition gap-4">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-red-600 bg-red-50 px-2 py-0.5 rounded">
                                                {{ $art->category->display_name }}
                                            </span>
                                            <span class="text-xs text-slate-400">
                                                {{ \Carbon\Carbon::parse($art->published_at ?? $art->created_at)->locale(app()->getLocale())->diffForHumans() }}
                                            </span>
                                        </div>
                                        <h4 class="font-bold text-slate-900 text-sm truncate">
                                            <a href="{{ route('articles.show', $art->slug) }}" target="_blank" class="hover:text-red-600 transition">
                                                {{ $art->display_title }}
                                            </a>
                                        </h4>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            {{ __('By:') }} {{ $art->journalistProfile->user->name ?? __('Unknown') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $art->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $art->status === 'published' ? __('Published') : __('Pending') }}
                                        </span>
                                        <a href="{{ route('admin.articles.show', $art) }}" class="px-3 py-1.5 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold text-xs transition">
                                            {{ __('Review') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-slate-400 text-sm py-8">
                            {{ __('No news articles available yet.') }}
                        </p>
                    @endif
                </div>

                {{-- Verified Correspondents Sidebar --}}
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <h3 class="text-lg font-black text-slate-900 flex items-center gap-2">
                            👥 {{ __('Correspondents') }}
                        </h3>
                        <a href="{{ route('admin.journalists.index') }}" class="text-xs font-bold text-red-600 hover:underline">
                            {{ __('All') }} →
                        </a>
                    </div>

                    <div class="space-y-4">
                        @foreach($recentJournalists as $j)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden shrink-0 flex items-center justify-center font-bold text-slate-600 text-xs">
                                        @if($j->profile_image)
                                            <img src="{{ asset('storage/' . $j->profile_image) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($j->user->name ?? 'J', 0, 2)) }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-900 text-xs truncate flex items-center gap-1">
                                            {{ $j->user->name }}
                                            @if($j->is_verified)
                                                <span class="text-blue-500">✓</span>
                                            @endif
                                        </h4>
                                        <p class="text-[11px] text-slate-500 truncate">
                                            {{ $j->display_designation }}
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.email.create', $j) }}" class="px-2.5 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold transition shrink-0" title="{{ __('Send Email') }}">
                                    ✉️
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

    </div>

</x-app-layout>