@extends('layouts.public')

@section('title', $category->display_name . ' - ' . __('News Portal'))

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    {{-- Category Header --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('News Categories') }}</span>
            <h1 class="text-3xl font-black text-slate-900 mt-1">
                {{ $category->display_name }}
            </h1>
            @if($category->description)
                <p class="text-sm text-slate-500 mt-2">
                    {{ $category->description }}
                </p>
            @endif
        </div>
        <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-4 py-2 rounded-xl">
            {{ number_format($articles->total()) }} {{ __('Published News') }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Main Category Articles Feed --}}
        <div class="lg:col-span-8">
            @if($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($articles as $article)
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
                                        <span>{{ app()->getLocale() === 'bn' ? \Carbon\Carbon::parse($article->published_at)->locale('bn')->isoFormat('D MMMM, YYYY') : \Carbon\Carbon::parse($article->published_at)->format('M d, Y') }}</span>
                                        <span>{{ number_format($article->views) }} {{ __('views') }}</span>
                                    </div>

                                    <h2 class="text-base font-bold text-slate-900 leading-snug mb-3 group-hover:text-red-600 transition line-clamp-2">
                                        <a href="{{ route('articles.show', $article->slug) }}">
                                            {{ $article->display_title }}
                                        </a>
                                    </h2>

                                    <p class="text-slate-600 text-xs leading-relaxed line-clamp-3 mb-4">
                                        {{ $article->display_excerpt ?? Str::limit(strip_tags($article->display_content), 110) }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                    @if($article->journalistProfile)
                                        <a href="{{ route('journalists.show', $article->journalistProfile->slug) }}" class="text-xs font-bold text-slate-700 hover:text-red-600 transition">
                                            {{ __('By') }} {{ $article->journalistProfile->user->name ?? __('Reporter') }}
                                        </a>
                                    @endif

                                    <a href="{{ route('articles.show', $article->slug) }}" class="text-xs font-bold text-red-600 hover:underline">
                                        {{ __('Read Full →') }}
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="bg-white p-12 text-center rounded-2xl border border-slate-200">
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

        {{-- Category Page Sidebar --}}
        <aside class="lg:col-span-4 space-y-6">
            {{-- Category Navigation Card --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-black text-slate-900 mb-4 pb-2 border-b border-slate-100">
                    {{ __('Explore Other Categories') }}
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(($categories ?? \App\Models\Category::all()) as $c)
                        <a href="{{ route('categories.show', $c->slug) }}" class="rounded-xl px-3 py-1.5 text-xs font-bold transition {{ $c->id === $category->id ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-red-50 hover:text-red-600' }}">
                            {{ $c->display_name }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Sidebar Photocard Carousel --}}
            <x-ad-carousel :ads="$portalAds['sidebar'] ?? collect()" layout="sidebar" />
        </aside>
    </div>

</div>
@endsection
