@extends('layouts.public')

@section('title', __('News Portal') . ' - ' . __('Trusted News, Every Day'))

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 space-y-10">

    {{-- Search / Filter Result Indicator --}}
    @if(request('search') || request('category'))
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-slate-700">
                <span class="font-bold">{{ __('Filtered Results:') }}</span>
                @if(request('search'))
                    <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-bold">{{ __('Keyword:') }} "{{ request('search') }}"</span>
                @endif
                @if(request('category'))
                    <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-bold">{{ __('Category:') }} "{{ request('category') }}"</span>
                @endif
            </div>
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-500 hover:text-red-600 underline">
                {{ __('Clear Filters') }}
            </a>
        </div>
    @endif

    {{-- Hero / Breaking News Section (Only show on default homepage) --}}
    @if(!request('search') && !request('category') && $featuredArticles->count() > 0)
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Main Featured Hero Article --}}
            @php $mainHero = $featuredArticles->first(); @endphp
            <div class="lg:col-span-8 bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm flex flex-col group hover:shadow-md transition">
                @if($mainHero->image)
                    <div class="h-72 sm:h-96 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $mainHero->image) }}" alt="{{ $mainHero->display_title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-4 left-4 bg-red-600 text-white text-xs font-black uppercase px-3 py-1 rounded-full shadow">
                            {{ __('Breaking News') }}
                        </div>
                    </div>
                @endif
                <div class="p-6 sm:p-8 flex-grow flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 text-xs text-slate-400 font-medium mb-3">
                            <span class="text-red-600 font-bold uppercase tracking-wider bg-red-50 px-2.5 py-0.5 rounded-full">
                                {{ $mainHero->category->display_name }}
                            </span>
                            <span>•</span>
                            <span>{{ app()->getLocale() === 'bn' ? \Carbon\Carbon::parse($mainHero->published_at)->locale('bn')->isoFormat('D MMMM, YYYY') : \Carbon\Carbon::parse($mainHero->published_at)->format('M d, Y') }}</span>
                            <span>•</span>
                            <span>{{ number_format($mainHero->views) }} {{ __('views') }}</span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight mb-4 group-hover:text-red-600 transition">
                            <a href="{{ route('articles.show', $mainHero->slug) }}">
                                {{ $mainHero->display_title }}
                            </a>
                        </h1>

                        <p class="text-slate-600 text-sm leading-relaxed line-clamp-3 mb-6">
                            {{ $mainHero->display_excerpt ?? Str::limit(strip_tags($mainHero->display_content), 200) }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        @if($mainHero->journalistProfile)
                            <a href="{{ route('journalists.show', $mainHero->journalistProfile->slug) }}" class="flex items-center gap-2 text-xs font-bold text-slate-700 hover:text-red-600 transition">
                                <div class="w-7 h-7 rounded-full bg-slate-200 flex items-center justify-center text-slate-600">
                                    {{ strtoupper(substr($mainHero->journalistProfile->user->name ?? 'J', 0, 1)) }}
                                </div>
                                {{ $mainHero->journalistProfile->user->name ?? __('Reporter') }}
                            </a>
                        @endif

                        <a href="{{ route('articles.show', $mainHero->slug) }}" class="text-xs font-bold text-red-600 hover:underline">
                            {{ __('Read Full Story →') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Secondary Featured Articles Column --}}
            <div class="lg:col-span-4 space-y-6 flex flex-col">
                <div class="bg-slate-900 text-white p-4 rounded-xl flex items-center justify-between shadow-sm">
                    <span class="text-xs font-black uppercase tracking-widest text-red-500 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                        {{ __('Top Trending Stories') }}
                    </span>
                </div>

                @foreach($featuredArticles->skip(1) as $sideHero)
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between hover:border-red-300 transition group">
                        <div>
                            <span class="text-xs font-bold text-red-600 uppercase tracking-wider">
                                {{ $sideHero->category->display_name }}
                            </span>
                            <h3 class="text-base font-bold text-slate-900 mt-1 mb-2 group-hover:text-red-600 transition line-clamp-2 leading-snug">
                                <a href="{{ route('articles.show', $sideHero->slug) }}">
                                    {{ $sideHero->display_title }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $sideHero->display_excerpt ?? Str::limit(strip_tags($sideHero->display_content), 90) }}
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span>{{ \Carbon\Carbon::parse($sideHero->published_at)->locale(app()->getLocale())->diffForHumans() }}</span>
                            <a href="{{ route('articles.show', $sideHero->slug) }}" class="font-bold text-red-600 hover:underline">
                                {{ __('Read →') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Main News Grid Section --}}
    <section>
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-200">
            <h2 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-red-600"></span>
                {{ __('Latest News & Reports') }}
            </h2>

            <div class="hidden sm:flex gap-2">
                @foreach($categories->take(5) as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" class="text-xs font-bold px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-red-600 hover:text-white transition">
                        {{ $cat->display_name }}
                    </a>
                @endforeach
            </div>
        </div>

        @if($latestArticles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($latestArticles as $article)
                    <article class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm flex flex-col hover:shadow-md transition group">
                        @if($article->image)
                            <a href="{{ route('articles.show', $article->slug) }}" class="h-48 overflow-hidden relative block">
                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->display_title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </a>
                        @else
                            <a href="{{ route('articles.show', $article->slug) }}" class="h-48 bg-slate-100 flex items-center justify-center text-slate-400 font-bold">
                                {{ $article->category->display_name }}
                            </a>
                        @endif

                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between text-xs text-slate-400 font-medium mb-3">
                                    <a href="{{ route('categories.show', $article->category->slug) }}" class="text-red-600 font-bold uppercase tracking-wider hover:underline">
                                        {{ $article->category->display_name }}
                                    </a>
                                    <span>{{ app()->getLocale() === 'bn' ? \Carbon\Carbon::parse($article->published_at)->locale('bn')->isoFormat('D MMMM, YYYY') : \Carbon\Carbon::parse($article->published_at)->format('M d, Y') }}</span>
                                </div>

                                <h3 class="text-base font-bold text-slate-900 leading-snug mb-3 group-hover:text-red-600 transition line-clamp-2">
                                    <a href="{{ route('articles.show', $article->slug) }}">
                                        {{ $article->display_title }}
                                    </a>
                                </h3>

                                <p class="text-slate-600 text-xs leading-relaxed line-clamp-3 mb-4">
                                    {{ $article->display_excerpt ?? Str::limit(strip_tags($article->display_content), 110) }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                @if($article->journalistProfile)
                                    <a href="{{ route('journalists.show', $article->journalistProfile->slug) }}" class="text-xs font-bold text-slate-700 hover:text-red-600 transition flex items-center gap-1.5">
                                        <div class="w-5 h-5 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600">
                                            {{ strtoupper(substr($article->journalistProfile->user->name ?? 'J', 0, 1)) }}
                                        </div>
                                        {{ $article->journalistProfile->user->name ?? __('Reporter') }}
                                    </a>
                                @endif

                                <a href="{{ route('articles.show', $article->slug) }}" class="text-xs font-bold text-red-600 hover:underline">
                                    {{ __('Read →') }}
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination Links --}}
            <div class="mt-10">
                {{ $latestArticles->links() }}
            </div>
        @else
            <div class="bg-white p-12 text-center rounded-2xl border border-slate-200">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <h3 class="text-lg font-bold text-slate-700">{{ __('No published news found.') }}</h3>
                <p class="text-sm text-slate-400 mt-1">{{ __('Try clearing your search query or check back later.') }}</p>
            </div>
        @endif
    </section>

    {{-- Journalist Highlights Banner --}}
    @if($journalists->count() > 0)
        <section class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-100">
                <div>
                    <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('Journalists Directory') }}</span>
                    <h3 class="text-xl font-black text-slate-900 mt-0.5">
                        {{ __('Meet Featured Reporters') }}
                    </h3>
                </div>
                <a href="{{ route('journalists.index') }}" class="text-xs font-bold text-red-600 hover:underline">
                    {{ __('View All Correspondents →') }}
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($journalists as $journalist)
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 flex items-center gap-4 hover:border-red-200 transition">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-slate-200 shrink-0 border border-slate-300">
                            @if($journalist->profile_image)
                                <img src="{{ asset('storage/' . $journalist->profile_image) }}" alt="{{ $journalist->user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center font-bold text-slate-600">
                                    {{ strtoupper(substr($journalist->user->name ?? 'J', 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div class="overflow-hidden">
                            <a href="{{ route('journalists.show', $journalist->slug) }}" class="font-bold text-slate-900 text-sm hover:text-red-600 transition truncate block">
                                {{ $journalist->user->name ?? __('Journalist') }}
                            </a>
                            <p class="text-xs text-slate-500 truncate">
                                {{ $journalist->display_designation }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection
