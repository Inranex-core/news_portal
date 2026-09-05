@extends('layouts.public')

@section('title', $article->display_title . ' - ' . __('News Portal'))

@section('meta')
    <meta property="og:title" content="{{ $article->display_title }}" />
    <meta property="og:description" content="{{ $article->display_excerpt ?? Str::limit(strip_tags($article->display_content), 150) }}" />
    <meta property="og:image" content="{{ $article->image ? asset('storage/' . $article->image) : asset('images/couja-logo.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="article" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $article->display_title }}" />
    <meta name="twitter:description" content="{{ $article->display_excerpt ?? Str::limit(strip_tags($article->display_content), 150) }}" />
    <meta name="twitter:image" content="{{ $article->image ? asset('storage/' . $article->image) : asset('images/couja-logo.png') }}" />
@endsection

@section('content')
@php
    $currentUrl = url()->current();
    $encodedUrl = rawurlencode($currentUrl);
    $encodedTitle = rawurlencode($article->display_title);
@endphp
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    {{-- Breadcrumb Navigation --}}
    <nav class="flex text-sm font-medium text-slate-500 mb-6 gap-2 items-center">
        <a href="{{ route('home') }}" class="hover:text-red-600 transition">{{ __('Home') }}</a>
        <span>/</span>
        <a href="{{ route('categories.show', $article->category->slug) }}" class="hover:text-red-600 transition">
            {{ $article->category->display_name }}
        </a>
        <span>/</span>
        <span class="text-slate-800 line-clamp-1 max-w-xs">{{ $article->display_title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- Main Article Content --}}
        <div class="lg:col-span-8 space-y-8">

            <article class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">

                {{-- Category Meta & View Count --}}
                <div class="flex items-center justify-between gap-3 mb-4">
                    <a href="{{ route('categories.show', $article->category->slug) }}" class="rounded-full bg-red-100 text-red-600 font-bold px-3.5 py-1 text-xs uppercase tracking-wide hover:bg-red-200 transition">
                        {{ $article->category->display_name }}
                    </a>
                    <span class="text-xs text-slate-400 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ number_format($article->views) }} {{ __('views') }}
                    </span>
                </div>

                {{-- Article Title --}}
                <h1 class="text-3xl sm:text-4xl font-black text-slate-900 leading-tight mb-6">
                    {{ $article->display_title }}
                </h1>

                {{-- ================= PROTHOM ALO STYLE REPORTER & ACTION BAR ================= --}}
                <div class="mb-8 pt-2" x-data="{ fontSize: 16, bookmarked: false, linkCopied: false, shareModalOpen: false, scrolled: false }" x-init="scrolled = window.scrollY > 250; window.addEventListener('scroll', () => { scrolled = window.scrollY > 250 })">
                    
                    {{-- Style override to enforce article font size scaling --}}
                    <style>
                        .article-body-text, 
                        .article-body-text p, 
                        .article-body-text span, 
                        .article-body-text div {
                            font-size: var(--article-font-size, 16px) !important;
                            line-height: calc(var(--article-font-size, 16px) * 1.65) !important;
                        }
                    </style>

                    {{-- Decorative Top Line --}}
                    <div class="w-12 h-1 bg-slate-300 rounded mb-4"></div>

                    {{-- Reporter Name & Location --}}
                    <div class="mb-1.5 flex items-center gap-2">
                        <span class="text-lg font-black text-slate-900 tracking-tight">
                            @if($article->journalistProfile && $article->journalistProfile->user)
                                <a href="{{ route('journalists.show', $article->journalistProfile->slug) }}" class="hover:text-red-600 transition">
                                    {{ $article->journalistProfile->user->name }}
                                </a>
                            @else
                                {{ __('নিজস্ব প্রতিবেদক') }}
                            @endif
                        </span>
                        <span class="text-sm font-normal text-slate-400">
                            {{ $article->journalistProfile->display_organization ?? __('ঢাকা') }}
                        </span>
                    </div>

                    {{-- Updated Timestamp Line --}}
                    <div class="text-xs text-slate-500 font-medium mb-5 flex items-center gap-1.5">
                        <span>
                            {{ __('আপডেট:') }} {{ app()->getLocale() === 'bn' ? \Carbon\Carbon::parse($article->published_at)->locale('bn')->isoFormat('DD MMMM YYYY, HH:mm') : \Carbon\Carbon::parse($article->published_at)->format('d F Y, H:i') }}
                        </span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>

                    {{-- 1. Standard Circular Action Buttons Row (Inline at top of article) --}}
                    <div class="flex items-center gap-2.5 mb-6 flex-wrap">

                        {{-- 1. Facebook Button (Blue Circular) --}}
                        <a 
                            href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="w-9 h-9 rounded-full bg-[#1877F2] hover:bg-[#166fe5] text-white flex items-center justify-center transition shadow-2xs hover:scale-110 shrink-0"
                            title="{{ __('Share on Facebook') }}"
                        >
                            <svg class="w-4.5 h-4.5 fill-current" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>

                        {{-- 2. X / Twitter Button (Black Circular) --}}
                        <a 
                            href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="w-9 h-9 rounded-full bg-[#111827] hover:bg-black text-white flex items-center justify-center transition shadow-2xs hover:scale-110 shrink-0"
                            title="{{ __('Share on X') }}"
                        >
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>

                        {{-- 3. Red Arrow Share Button (Opens Share Modal) --}}
                        <button 
                            type="button" 
                            @click="shareModalOpen = true"
                            class="w-9 h-9 rounded-full bg-red-100 hover:bg-red-200 text-red-600 flex items-center justify-center transition shadow-2xs hover:scale-110 cursor-pointer border border-red-200 shrink-0 relative"
                            title="{{ __('Share Options') }}"
                        >
                            <svg class="w-4.5 h-4.5 fill-current text-red-600" viewBox="0 0 24 24">
                                <path d="M14 9V5l7 7-7 7v-4.1c-5 0-8.5 1.6-11 5.1 1-5 4-10 11-11z"/>
                            </svg>
                        </button>

                        {{-- 4. Font Size Increase Button (অ+) --}}
                        <button 
                            type="button" 
                            @click="if (fontSize < 28) fontSize += 2"
                            class="w-9 h-9 rounded-full bg-[#3B82F6] hover:bg-blue-600 text-white flex items-center justify-center font-black text-xs transition shadow-2xs hover:scale-110 cursor-pointer border border-blue-400 shrink-0 select-none"
                            title="{{ __('Increase Font Size') }}"
                        >
                            {{ __('অ+') }}
                        </button>

                        {{-- 5. Font Size Decrease Button (অ-) --}}
                        <button 
                            type="button" 
                            @click="if (fontSize > 12) fontSize -= 2"
                            class="w-9 h-9 rounded-full bg-[#3B82F6] hover:bg-blue-600 text-white flex items-center justify-center font-black text-xs transition shadow-2xs hover:scale-110 cursor-pointer border border-blue-400 shrink-0 select-none"
                            title="{{ __('Decrease Font Size') }}"
                        >
                            {{ __('অ-') }}
                        </button>

                        {{-- 6. Print Button --}}
                        <button 
                            type="button" 
                            onclick="window.print()"
                            class="w-9 h-9 rounded-full bg-[#64748B] hover:bg-slate-700 text-white flex items-center justify-center transition shadow-2xs hover:scale-110 cursor-pointer shrink-0"
                            title="{{ __('Print Article') }}"
                        >
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                        </button>

                        {{-- 7. Bookmark Button --}}
                        <button 
                            type="button" 
                            @click="bookmarked = !bookmarked"
                            class="w-9 h-9 rounded-full bg-[#E2E8F0] hover:bg-slate-300 text-slate-800 flex items-center justify-center transition shadow-2xs hover:scale-110 cursor-pointer border border-slate-300 shrink-0"
                            :title="bookmarked ? '{{ __('Bookmarked') }}' : '{{ __('Bookmark Article') }}'"
                        >
                            <svg class="w-4.5 h-4.5" :fill="bookmarked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24" :class="bookmarked ? 'text-amber-500 fill-amber-500' : 'text-slate-800'">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </button>

                    </div>

                    {{-- 2. Floating Sticky Action Bar (Pill Bar at Bottom of Screen when Scrolling Down) --}}
                    <div 
                        x-show="scrolled" 
                        x-cloak
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-200 transform"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                        class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40 bg-white/95 backdrop-blur-md px-4 py-2 rounded-full shadow-2xl border border-slate-200/90 flex items-center gap-3 shrink-0"
                    >
                        {{-- 1. Facebook Button --}}
                        <a 
                            href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="w-9 h-9 rounded-full bg-[#1877F2] hover:bg-[#166fe5] text-white flex items-center justify-center transition shadow-2xs hover:scale-110 shrink-0"
                            title="{{ __('Share on Facebook') }}"
                        >
                            <svg class="w-4.5 h-4.5 fill-current" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>

                        {{-- 2. X / Twitter Button --}}
                        <a 
                            href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="w-9 h-9 rounded-full bg-[#111827] hover:bg-black text-white flex items-center justify-center transition shadow-2xs hover:scale-110 shrink-0"
                            title="{{ __('Share on X') }}"
                        >
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>

                        {{-- 3. Red Arrow Share Button --}}
                        <button 
                            type="button" 
                            @click="shareModalOpen = true"
                            class="w-9 h-9 rounded-full bg-red-100 hover:bg-red-200 text-red-600 flex items-center justify-center transition shadow-2xs hover:scale-110 cursor-pointer border border-red-200 shrink-0 relative"
                            title="{{ __('Share Options') }}"
                        >
                            <svg class="w-4.5 h-4.5 fill-current text-red-600" viewBox="0 0 24 24">
                                <path d="M14 9V5l7 7-7 7v-4.1c-5 0-8.5 1.6-11 5.1 1-5 4-10 11-11z"/>
                            </svg>
                        </button>

                        <div class="w-px h-5 bg-slate-200"></div>

                        {{-- 4. Font Size Increase Button (অ+) --}}
                        <button 
                            type="button" 
                            @click="if (fontSize < 28) fontSize += 2"
                            class="w-9 h-9 rounded-full bg-[#3B82F6] hover:bg-blue-600 text-white flex items-center justify-center font-black text-xs transition shadow-2xs hover:scale-110 cursor-pointer border border-blue-400 shrink-0 select-none"
                            title="{{ __('Increase Font Size') }}"
                        >
                            {{ __('অ+') }}
                        </button>

                        {{-- 5. Font Size Decrease Button (অ-) --}}
                        <button 
                            type="button" 
                            @click="if (fontSize > 12) fontSize -= 2"
                            class="w-9 h-9 rounded-full bg-[#3B82F6] hover:bg-blue-600 text-white flex items-center justify-center font-black text-xs transition shadow-2xs hover:scale-110 cursor-pointer border border-blue-400 shrink-0 select-none"
                            title="{{ __('Decrease Font Size') }}"
                        >
                            {{ __('অ-') }}
                        </button>

                        <div class="w-px h-5 bg-slate-200"></div>

                        {{-- 6. Print Button --}}
                        <button 
                            type="button" 
                            onclick="window.print()"
                            class="w-9 h-9 rounded-full bg-[#64748B] hover:bg-slate-700 text-white flex items-center justify-center transition shadow-2xs hover:scale-110 cursor-pointer shrink-0"
                            title="{{ __('Print Article') }}"
                        >
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                        </button>

                        {{-- 7. Bookmark Button --}}
                        <button 
                            type="button" 
                            @click="bookmarked = !bookmarked"
                            class="w-9 h-9 rounded-full bg-[#E2E8F0] hover:bg-slate-300 text-slate-800 flex items-center justify-center transition shadow-2xs hover:scale-110 cursor-pointer border border-slate-300 shrink-0"
                            :title="bookmarked ? '{{ __('Bookmarked') }}' : '{{ __('Bookmark Article') }}'"
                        >
                            <svg class="w-4.5 h-4.5" :fill="bookmarked ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24" :class="bookmarked ? 'text-amber-500 fill-amber-500' : 'text-slate-800'">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </button>

                    </div>

                    {{-- Excerpt Highlight --}}
                    @if($article->display_excerpt)
                        <div class="text-lg font-medium text-slate-700 leading-relaxed italic border-l-4 border-red-600 pl-4 py-1 mt-6 mb-6 bg-red-50/50 rounded-r-lg">
                            "{{ $article->display_excerpt }}"
                        </div>
                    @endif

                    {{-- Featured Image --}}
                    @if($article->image)
                        <div class="rounded-xl overflow-hidden mt-6 mb-8 shadow-sm">
                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->display_title }}" class="w-full max-h-[480px] object-cover">
                        </div>
                    @endif

                    {{-- Main Body Content --}}
                    <div 
                        class="prose prose-slate max-w-none text-slate-800 space-y-4 transition-all duration-200 article-body-text"
                        :style="'--article-font-size: ' + fontSize + 'px;'"
                    >
                        {!! nl2br(e($article->display_content)) !!}
                    </div>

                    {{-- In-Article Photocard Carousel --}}
                    <x-ad-carousel :ads="$portalAds['in_article'] ?? collect()" layout="in_article" />

                    {{-- ================= SHARE MODAL POPUP ================= --}}
                    <div 
                        x-show="shareModalOpen" 
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4"
                        @click.self="shareModalOpen = false"
                        @keydown.escape.window="shareModalOpen = false"
                    >
                        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-100 relative animate-in fade-in zoom-in duration-200">
                            
                            {{-- Modal Header --}}
                            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                                <h3 class="text-2xl font-bold text-slate-800">
                                    {{ app()->getLocale() === 'bn' ? 'শেয়ার' : 'Share' }}
                                </h3>
                                <button 
                                    type="button" 
                                    @click="shareModalOpen = false"
                                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition cursor-pointer"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Share Options List --}}
                            <div class="px-6 py-2 divide-y divide-slate-100">

                                {{-- 1. Facebook --}}
                                <a 
                                    href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="flex items-center gap-4 py-3.5 group hover:bg-slate-50/80 -mx-2 px-2 rounded-xl transition"
                                    @click="shareModalOpen = false"
                                >
                                    <div class="w-10 h-10 rounded-full text-white flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition" style="background-color: #1877F2;">
                                        <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24">
                                            <path fill="#ffffff" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </div>
                                    <span class="text-base font-semibold text-slate-700 group-hover:text-red-600 transition">
                                        {{ app()->getLocale() === 'bn' ? 'ফেসবুকে শেয়ার করুন' : 'Share on Facebook' }}
                                    </span>
                                </a>

                                {{-- 2. Email --}}
                                <a 
                                    href="mailto:?subject={{ $encodedTitle }}&body={{ $encodedUrl }}" 
                                    class="flex items-center gap-4 py-3.5 group hover:bg-slate-50/80 -mx-2 px-2 rounded-xl transition"
                                    @click="shareModalOpen = false"
                                >
                                    <div class="w-10 h-10 rounded-full text-white flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition" style="background-color: #111827;">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="#ffffff" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="text-base font-semibold text-slate-700 group-hover:text-red-600 transition">
                                        {{ app()->getLocale() === 'bn' ? 'ইমেইল করুন' : 'Share via Email' }}
                                    </span>
                                </a>

                                {{-- 3. Copy Link --}}
                                <button 
                                    type="button"
                                    @click="navigator.clipboard.writeText(window.location.href); linkCopied = true; setTimeout(() => linkCopied = false, 2500);"
                                    class="w-full flex items-center gap-4 py-3.5 group hover:bg-slate-50/80 -mx-2 px-2 rounded-xl transition text-left cursor-pointer"
                                >
                                    <div class="w-10 h-10 rounded-full text-white flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition" style="background-color: #111827;">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="#ffffff" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 flex items-center justify-between">
                                        <span class="text-base font-semibold text-slate-700 group-hover:text-red-600 transition">
                                            {{ app()->getLocale() === 'bn' ? 'খবরের লিংক কপি করুন' : 'Copy news link' }}
                                        </span>
                                        <span x-show="linkCopied" x-cloak class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                                            {{ app()->getLocale() === 'bn' ? 'কপি হয়েছে!' : 'Copied!' }}
                                        </span>
                                    </div>
                                </button>

                                {{-- 4. LinkedIn --}}
                                <a 
                                    href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encodedUrl }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="flex items-center gap-4 py-3.5 group hover:bg-slate-50/80 -mx-2 px-2 rounded-xl transition"
                                    @click="shareModalOpen = false"
                                >
                                    <div class="w-10 h-10 rounded-full text-white flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition" style="background-color: #0A66C2;">
                                        <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24">
                                            <path fill="#ffffff" d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-1.2.98-2.18 2.18-2.18s2.17.98 2.17 2.18v4.93h2.79M6.46 10.9v8.37H9.25V10.9H6.46M7.86 6.54a1.62 1.62 0 1 0 0 3.24 1.62 1.62 0 0 0 0-3.24z"/>
                                        </svg>
                                    </div>
                                    <span class="text-base font-semibold text-slate-700 group-hover:text-red-600 transition">
                                        {{ app()->getLocale() === 'bn' ? 'লিংকডইনে শেয়ার করুন' : 'Share on LinkedIn' }}
                                    </span>
                                </a>

                                {{-- 5. Twitter / X --}}
                                <a 
                                    href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="flex items-center gap-4 py-3.5 group hover:bg-slate-50/80 -mx-2 px-2 rounded-xl transition"
                                    @click="shareModalOpen = false"
                                >
                                    <div class="w-10 h-10 rounded-full text-white flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition" style="background-color: #000000;">
                                        <svg class="w-4.5 h-4.5 fill-white" viewBox="0 0 24 24">
                                            <path fill="#ffffff" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                        </svg>
                                    </div>
                                    <span class="text-base font-semibold text-slate-700 group-hover:text-red-600 transition">
                                        {{ app()->getLocale() === 'bn' ? 'টুইটারে শেয়ার করুন' : 'Share on Twitter (X)' }}
                                    </span>
                                </a>

                                {{-- 6. WhatsApp --}}
                                <a 
                                    href="https://api.whatsapp.com/send?text={{ $encodedTitle }}%20{{ $encodedUrl }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="flex items-center gap-4 py-3.5 group hover:bg-slate-50/80 -mx-2 px-2 rounded-xl transition"
                                    @click="shareModalOpen = false"
                                >
                                    <div class="w-10 h-10 rounded-full text-white flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition" style="background-color: #25D366;">
                                        <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24">
                                            <path fill="#ffffff" d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                        </svg>
                                    </div>
                                    <span class="text-base font-semibold text-slate-700 group-hover:text-red-600 transition">
                                        {{ app()->getLocale() === 'bn' ? 'হোয়াটসঅ্যাপে শেয়ার করুন' : 'Share on WhatsApp' }}
                                    </span>
                                </a>

                            </div>

                        </div>
                    </div>

                </div>

            </article>

            {{-- ================= COMMENTS SECTION ================= --}}
            <section class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">

                <div class="flex items-center justify-between mb-8 pb-3 border-b border-slate-100">
                    <h3 class="text-xl font-black text-slate-900 flex items-center gap-2">
                        💬 {{ __('Reader Comments') }}
                        <span class="text-sm font-bold text-red-600 bg-red-50 px-3 py-0.5 rounded-full">
                            {{ $comments->count() }}
                        </span>
                    </h3>
                </div>

                {{-- Success Flash Message --}}
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm font-bold flex items-center gap-2">
                        <span>✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Comment Form --}}
                <form action="{{ route('articles.comments.store', $article->slug) }}" method="POST" class="mb-10 bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-4">
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
        <aside class="lg:col-span-4 space-y-8">

            {{-- Related News --}}
            @if($relatedArticles->count() > 0)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h3 class="text-lg font-black text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                        {{ __('Related News') }}
                    </h3>

                    <div class="space-y-4">
                        @foreach($relatedArticles as $rel)
                            <a href="{{ route('articles.show', $rel->slug) }}" class="group block space-y-1">
                                <span class="text-xs text-red-600 font-bold uppercase tracking-wider">
                                    {{ $rel->category->display_name }}
                                </span>
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-red-600 transition leading-snug line-clamp-2">
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
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-black text-slate-900 mb-4 pb-2 border-b border-slate-100">
                    {{ __('Explore Categories') }}
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $cat)
                        <a href="{{ route('categories.show', $cat->slug) }}" class="rounded-xl bg-slate-100 px-3.5 py-2 text-xs font-bold text-slate-700 transition hover:bg-red-600 hover:text-white">
                            {{ $cat->display_name }}
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
