@extends('layouts.public')

@section('title', $article->display_title . ' - ' . __('News Portal'))

@section('content')
<div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8 py-6 sm:py-8">

    {{-- Breadcrumb Navigation --}}
    <nav class="flex flex-wrap text-xs sm:text-sm font-medium text-slate-500 mb-4 sm:mb-6 gap-1.5 sm:gap-2 items-center">
        <a href="{{ route('home') }}" class="hover:text-red-600 transition">{{ __('Home') }}</a>
        <span>/</span>
        <a href="{{ route('categories.show', $article->category->slug) }}" class="hover:text-red-600 transition">
            {{ $article->category->display_name }}
        </a>
        <span>/</span>
        <span class="text-slate-800 line-clamp-1 max-w-full sm:max-w-xs">{{ $article->display_title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10">

        {{-- Main Article Content --}}
        <div class="lg:col-span-8 space-y-8">

            <article class="bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">

                {{-- Category & Date Meta --}}
                <div class="flex items-center gap-2 sm:gap-3 mb-4 flex-wrap">
                    <a href="{{ route('categories.show', $article->category->slug) }}" class="rounded-full bg-red-100 text-red-600 font-bold px-3 sm:px-3.5 py-1 text-xs uppercase tracking-wide hover:bg-red-200 transition">
                        {{ $article->category->display_name }}
                    </a>
                    <span class="text-xs text-slate-400 font-medium">
                        {{ __('Published on') }} {{ app()->getLocale() === 'bn' ? \Carbon\Carbon::parse($article->published_at)->locale('bn')->isoFormat('D MMMM, YYYY - hh:mm A') : \Carbon\Carbon::parse($article->published_at)->format('F d, Y - h:i A') }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium flex items-center gap-1 ml-auto">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ number_format($article->views) }} {{ __('views') }}
                    </span>
                </div>

                {{-- Article Title --}}
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 leading-tight mb-6 break-words-safe">
                    {{ $article->display_title }}
                </h1>

                {{-- Journalist / Author Meta Box --}}
                @if($article->journalistProfile)
                    <div class="flex items-center gap-4 py-4 px-5 bg-slate-50 rounded-xl mb-8 border border-slate-100">
                        <div class="h-12 w-12 rounded-full overflow-hidden bg-slate-200 shrink-0">
                            @if($article->journalistProfile->profile_image)
                                <img src="{{ asset('storage/' . $article->journalistProfile->profile_image) }}" alt="{{ $article->journalistProfile->user->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full flex items-center justify-center font-bold text-slate-600 bg-slate-200">
                                    {{ strtoupper(substr($article->journalistProfile->user->name ?? 'J', 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('journalists.show', $article->journalistProfile->slug) }}" class="font-bold text-slate-900 hover:text-red-600 transition flex items-center gap-1.5">
                                {{ $article->journalistProfile->user->name ?? __('Journalist') }}
                                @if($article->journalistProfile->is_verified)
                                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 007.23-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </a>
                            <p class="text-xs text-slate-500 font-medium">
                                {{ $article->journalistProfile->display_designation }}
                                @if($article->journalistProfile->display_organization)
                                    • {{ $article->journalistProfile->display_organization }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Excerpt Highlight --}}
                @if($article->display_excerpt)
                    <div class="text-lg font-medium text-slate-700 leading-relaxed italic border-l-4 border-red-600 pl-4 py-1 mb-8 bg-red-50/50 rounded-r-lg">
                        "{{ $article->display_excerpt }}"
                    </div>
                @endif

                {{-- Featured Image --}}
                @if($article->image)
                    <div class="rounded-xl overflow-hidden mb-6 sm:mb-8 shadow-sm">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->display_title }}" class="w-full max-h-72 sm:max-h-[480px] object-cover">
                    </div>
                @endif

                {{-- Main Body Content --}}
                <div class="prose prose-slate max-w-none text-slate-800 leading-relaxed space-y-4 text-sm sm:text-base break-words-safe">
                    {!! nl2br(e($article->display_content)) !!}
                </div>

            </article>

            {{-- ================= COMMENTS SECTION ================= --}}
            <section class="bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">

                <div class="flex items-center justify-between mb-8 pb-3 border-b border-slate-100">
                    <h3 class="text-xl font-black text-slate-900 flex items-center gap-2">
                        <x-icon name="chat" class="w-5 h-5" />
                        {{ __('Reader Comments') }}
                        <span class="text-sm font-bold text-red-600 bg-red-50 px-3 py-0.5 rounded-full">
                            {{ $comments->count() }}
                        </span>
                    </h3>
                </div>

                {{-- Success Flash Message --}}
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm font-bold flex items-center gap-2">
                        <x-icon name="check" class="w-4 h-4 text-emerald-600" />
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Comment Form --}}
                <form action="{{ route('articles.comments.store', $article->slug) }}" method="POST" class="mb-8 sm:mb-10 bg-slate-50 p-4 sm:p-6 rounded-2xl border border-slate-200 space-y-4">
                    @csrf

                    @guest
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">
                                    {{ __('Your Name') }} *
                                </label>
                                <input
                                    type="text"
                                    name="author_name"
                                    required
                                    placeholder="{{ __('Enter your name') }}"
                                    class="w-full text-sm rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                                    value="{{ old('author_name') }}"
                                >
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">
                                    {{ __('Email Address') }} ({{ __('Optional') }})
                                </label>
                                <input
                                    type="email"
                                    name="author_email"
                                    placeholder="name@example.com"
                                    class="w-full text-sm rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                                    value="{{ old('author_email') }}"
                                >
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                            <div class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center text-[10px]">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span>{{ __('Commenting as') }} {{ auth()->user()->name }}</span>
                        </div>
                    @endguest

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            {{ __('Write your comment...') }} *
                        </label>
                        <textarea
                            name="comment"
                            rows="4"
                            required
                            placeholder="{{ __('Share your thoughts on this story...') }}"
                            class="w-full text-sm rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                        >{{ old('comment') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">
                            {{ __('Submit Comment') }}
                        </button>
                    </div>
                </form>

                {{-- Comments List --}}
                @if($comments->count() > 0)
                    <div class="space-y-6">
                        @foreach($comments as $cmt)
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-700 shrink-0">
                                    {{ strtoupper(substr($cmt->author_name, 0, 1)) }}
                                </div>
                                <div class="flex-grow">
                                    <div class="flex items-center justify-between mb-1">
                                        <h4 class="font-bold text-slate-900 text-sm">
                                            {{ $cmt->author_name }}
                                        </h4>
                                        <span class="text-xs text-slate-400">
                                            {{ $cmt->created_at->locale(app()->getLocale())->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-slate-700 text-sm leading-relaxed">
                                        {{ $cmt->comment }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-slate-400 text-sm py-4">
                        {{ __('No comments yet. Be the first to share your thoughts!') }}
                    </p>
                @endif

            </section>

        </div>

        {{-- Sidebar: Related Articles & Categories --}}
        <aside class="lg:col-span-4 space-y-6 lg:space-y-8">

            {{-- Related News --}}
            @if($relatedArticles->count() > 0)
                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h3 class="text-base sm:text-lg font-black text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                        {{ __('Related News') }}
                    </h3>

                    <div class="space-y-4">
                        @foreach($relatedArticles as $rel)
                            <a href="{{ route('articles.show', $rel->slug) }}" class="group block space-y-1">
                                <span class="text-xs text-red-600 font-bold uppercase tracking-wider">
                                    {{ $rel->category->display_name }}
                                </span>
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-red-600 transition leading-snug line-clamp-2 break-words-safe">
                                    {{ $rel->display_title }}
                                </h4>
                                <span class="text-xs text-slate-400 font-medium">
                                    {{ \Carbon\Carbon::parse($rel->published_at)->locale(app()->getLocale())->diffForHumans() }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Category Filter Card --}}
            <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-base sm:text-lg font-black text-slate-900 mb-4 pb-2 border-b border-slate-100">
                    {{ __('Explore Categories') }}
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $cat)
                        <a href="{{ route('categories.show', $cat->slug) }}" class="rounded-xl bg-slate-100 px-3 sm:px-3.5 py-1.5 sm:py-2 text-xs font-bold text-slate-700 transition hover:bg-red-600 hover:text-white">
                            {{ $cat->display_name }}
                        </a>
                    @endforeach
                </div>
            </div>

        </aside>

    </div>
</div>
@endsection
