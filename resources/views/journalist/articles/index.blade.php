<x-app-layout>

    <div class="min-h-screen bg-slate-100/70 py-8 sm:py-12">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER CARD --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                        <span class="inline-flex items-center gap-2">
                            <x-icon name="newspaper" class="w-7 h-7 text-slate-700" />
                            {{ __('My News') }}
                        </span>
                        <span class="text-xs font-extrabold bg-slate-100 text-slate-700 px-3 py-1 rounded-full border border-slate-200">
                            {{ $articles->count() }}
                        </span>
                    </h1>

                    <p class="text-sm text-slate-500 font-medium mt-1">
                        {{ __('Manage your news articles.') }}
                    </p>
                </div>

                <a
                    href="{{ route('journalist.articles.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-700 hover:to-rose-800 text-white font-black text-sm rounded-2xl shadow-lg shadow-red-600/25 transition active:scale-98"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>{{ __('Create News') }}</span>
                </a>
            </div>


            {{-- ALERTS --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 sm:p-5 rounded-2xl shadow-xs font-semibold text-sm flex items-center gap-3">
                    <span class="text-emerald-600 inline-flex items-center justify-center">
                        <x-icon name="check" class="w-5 h-5" />
                    </span>
                    <span>{{ __(session('success')) }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 sm:p-5 rounded-2xl shadow-xs font-semibold text-sm flex items-center gap-3">
                    <span class="text-rose-600 inline-flex items-center justify-center">
                        <x-icon name="warning" class="w-5 h-5" />
                    </span>
                    <span>{{ __(session('error')) }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 p-5 rounded-2xl shadow-xs">
                    <ul class="list-disc ml-5 space-y-1 text-xs font-semibold">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- ARTICLES CONTAINER --}}
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden divide-y divide-slate-100">

                @if($articles->count())

                    @foreach($articles as $article)
                        <div class="p-6 sm:p-8 hover:bg-slate-50/70 transition duration-200">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">

                                {{-- ARTICLE DETAILS --}}
                                <div class="flex-1 min-w-0 space-y-3">
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 leading-snug hover:text-red-600 transition">
                                            {{ $article->display_title }}
                                        </h2>
                                    </div>

                                    <div class="flex items-center gap-3 flex-wrap text-xs">
                                        {{-- Category Badge --}}
                                        @if($article->category)
                                            <span class="bg-rose-50 text-rose-700 border border-rose-100 font-extrabold px-3 py-1 rounded-full">
                                                {{ $article->category->display_name }}
                                            </span>
                                        @endif

                                        {{-- Status Badge --}}
                                        <span class="font-extrabold px-3 py-1 rounded-full border shadow-xs
                                            @if($article->status === 'draft')
                                                bg-slate-100 text-slate-700 border-slate-200
                                            @elseif($article->status === 'pending')
                                                bg-amber-50 text-amber-800 border-amber-200
                                            @elseif($article->status === 'published')
                                                bg-emerald-50 text-emerald-800 border-emerald-200
                                            @elseif($article->status === 'rejected')
                                                bg-rose-50 text-rose-800 border-rose-200
                                            @else
                                                bg-slate-100 text-slate-700 border-slate-200
                                            @endif
                                        ">
                                            @if($article->status === 'draft')
                                                {{ __('Draft') }}
                                            @elseif($article->status === 'pending')
                                                {{ __('Pending Review') }}
                                            @elseif($article->status === 'published')
                                                {{ __('Published') }}
                                            @elseif($article->status === 'rejected')
                                                {{ __('Rejected') }}
                                            @else
                                                {{ ucfirst($article->status) }}
                                            @endif
                                        </span>

                                        {{-- Date --}}
                                        @if($article->created_at)
                                            <span class="text-slate-400 font-medium flex items-center gap-1">
                                                <x-icon name="calendar" class="w-3.5 h-3.5" />
                                                {{ __('Created:') }} {{ app()->getLocale() === 'bn' ? $article->created_at->locale('bn')->isoFormat('D MMMM YYYY, hh:mm A') : $article->created_at->format('d M Y, h:i A') }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($article->excerpt)
                                        <p class="text-slate-600 text-sm leading-relaxed line-clamp-2">
                                            {{ $article->display_excerpt ?? $article->excerpt }}
                                        </p>
                                    @endif
                                </div>


                                {{-- ACTION BUTTONS --}}
                                <div class="flex flex-wrap items-center gap-2 lg:justify-end shrink-0 pt-2 lg:pt-0 border-t lg:border-t-0 border-slate-100">

                                    {{-- Edit Button --}}
                                    @if($article->status === 'draft' || $article->status === 'rejected')
                                        <a
                                            href="{{ route('journalist.articles.edit', $article) }}"
                                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-bold rounded-xl transition"
                                        >
                                            <x-icon name="edit" class="w-3.5 h-3.5" />
                                            {{ __('Edit') }}
                                        </a>
                                    @endif

                                    {{-- Submit for Review Button --}}
                                    @if($article->status === 'draft' || $article->status === 'rejected')
                                        <form
                                            method="POST"
                                            action="{{ route('journalist.articles.submit', $article) }}"
                                            onsubmit="return confirm('{{ __('Are you sure you want to submit this news for review?') }}')"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-sm"
                                            >
                                                <x-icon name="paper-airplane" class="w-3.5 h-3.5" />
                                                {{ __('Submit for Review') }}
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Delete Button --}}
                                    @if($article->status !== 'published')
                                        <form
                                            method="POST"
                                            action="{{ route('journalist.articles.destroy', $article) }}"
                                            onsubmit="return confirm('{{ __('Are you sure you want to delete this news?') }}')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold rounded-xl transition"
                                            >
                                                <x-icon name="trash" class="w-3.5 h-3.5" />
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Under Review Indicator --}}
                                    @if($article->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold rounded-xl">
                                            <x-icon name="clock" class="w-3.5 h-3.5" />
                                            {{ __('Under Review') }}
                                        </span>
                                    @endif

                                    {{-- View Live Button --}}
                                    @if($article->status === 'published')
                                        <a
                                            href="{{ route('articles.show', $article->slug) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold rounded-xl transition"
                                        >
                                            <x-icon name="eye" class="w-3.5 h-3.5" />
                                            {{ __('View Live') }}
                                        </a>
                                    @endif
                                </div>

                            </div>


                            {{-- REJECTION REASON CALLOUT --}}
                            @if($article->status === 'rejected' && $article->rejection_reason)
                                <div class="mt-4 p-4 bg-rose-50/90 border border-rose-200 rounded-2xl text-xs space-y-1">
                                    <div class="font-extrabold text-rose-900 flex items-center gap-1.5">
                                        <x-icon name="warning" class="w-4 h-4" />
                                        {{ __('This news was rejected.') }}
                                    </div>
                                    <div class="font-medium text-rose-800">
                                        {{ __("Admin's feedback:") }} "{{ $article->rejection_reason }}"
                                    </div>
                                    <div class="text-rose-700 font-semibold mt-1">
                                        {{ __('Please click Edit to fix the issues and submit it again for review.') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach

                @else
                    {{-- EMPTY STATE --}}
                    <div class="text-center py-16 px-6 space-y-4">
                        <div class="w-16 h-16 rounded-3xl bg-red-50 text-red-600 flex items-center justify-center mx-auto text-3xl font-black">
                            <x-icon name="newspaper" class="w-8 h-8" />
                        </div>
                        <h2 class="text-xl font-black text-slate-900">
                            {{ __('No news yet') }}
                        </h2>
                        <p class="text-slate-500 text-sm max-w-sm mx-auto font-medium">
                            {{ __('Start by creating your first news article.') }}
                        </p>
                        <a
                            href="{{ route('journalist.articles.create') }}"
                            class="inline-flex items-center gap-2 px-6 py-3.5 bg-red-600 hover:bg-red-700 text-white font-bold text-sm rounded-2xl transition shadow-md"
                        >
                            + {{ __('Create News') }}
                        </a>
                    </div>
                @endif

            </div>

        </div>

    </div>

</x-app-layout>