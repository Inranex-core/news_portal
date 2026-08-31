@extends('layouts.public')

@section('title', $category->display_name . ' - ' . __('News Portal'))

@section('content')
<div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8 py-6 sm:py-8">

    {{-- Category Header --}}
    <div class="bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 mb-6 sm:mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('News Categories') }}</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1 break-words-safe">
                {{ $category->display_name }}
            </h1>
            @if($category->description)
                <p class="text-sm text-slate-500 mt-2">
                    {{ $category->description }}
                </p>
            @endif
        </div>
        <div class="self-start md:self-auto text-xs sm:text-sm font-semibold text-slate-500 bg-slate-100 px-3 sm:px-4 py-2 rounded-xl whitespace-nowrap">
            {{ number_format($articles->total()) }} {{ __('Published News') }}
        </div>
    </div>

    {{-- News Articles Grid --}}
    @if($articles->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($articles as $article)
                <article class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm flex flex-col hover:shadow-md transition">
                    @if($article->image)
                        <a href="{{ route('articles.show', $article->slug) }}" class="h-44 sm:h-48 overflow-hidden relative block">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->display_title }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        </a>
                    @else
                        <a href="{{ route('articles.show', $article->slug) }}" class="h-44 sm:h-48 bg-slate-100 flex items-center justify-center text-slate-400 font-bold">
                            {{ $article->category->display_name }}
                        </a>
                    @endif

                    <div class="p-4 sm:p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 text-xs text-slate-400 font-medium mb-3">
                                <span class="truncate">{{ app()->getLocale() === 'bn' ? \Carbon\Carbon::parse($article->published_at)->locale('bn')->isoFormat('D MMMM, YYYY') : \Carbon\Carbon::parse($article->published_at)->format('M d, Y') }}</span>
                                <span class="shrink-0">{{ number_format($article->views) }} {{ __('views') }}</span>
                            </div>

                            <h2 class="text-base sm:text-lg font-bold text-slate-900 leading-snug mb-3 hover:text-red-600 transition break-words-safe line-clamp-2">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    {{ $article->display_title }}
                                </a>
                            </h2>

                            <p class="text-slate-600 text-xs leading-relaxed line-clamp-3 mb-4">
                                {{ $article->display_excerpt ?? Str::limit(strip_tags($article->display_content), 120) }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
                            @if($article->journalistProfile)
                                <a href="{{ route('journalists.show', $article->journalistProfile->slug) }}" class="text-xs font-bold text-slate-700 hover:text-red-600 transition truncate min-w-0">
                                    {{ __('By') }} {{ $article->journalistProfile->user->name ?? __('Reporter') }}
                                </a>
                            @endif

                            <a href="{{ route('articles.show', $article->slug) }}" class="text-xs font-bold text-red-600 hover:underline whitespace-nowrap">
                                {{ __('Read Full →') }}
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $articles->links() }}
        </div>
    @else
        <div class="bg-white p-8 sm:p-12 text-center rounded-2xl border border-slate-200">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <h3 class="text-lg font-bold text-slate-700">{{ __('No articles published in this category yet.') }}</h3>
            <p class="text-sm text-slate-400 mt-1">{{ __('Check back later for new updates.') }}</p>
            <a href="{{ route('home') }}" class="inline-block mt-4 rounded-xl bg-red-600 px-5 py-2.5 text-xs font-bold text-white transition hover:bg-red-700">
                {{ __('Back to Homepage') }}
            </a>
        </div>
    @endif

</div>
@endsection
