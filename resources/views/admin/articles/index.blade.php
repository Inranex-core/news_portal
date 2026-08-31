<x-app-layout>

<div class="min-h-screen bg-slate-50 py-6 sm:py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

            <div>

                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">
                    News Articles
                </h1>

                <p class="text-slate-500 mt-2">
                    Manage submitted news articles.
                </p>

            </div>


            <a
                href="{{ route('admin.articles.pending') }}"
                class="px-5 py-3 bg-yellow-500 text-white rounded-xl font-semibold hover:bg-yellow-600 text-center whitespace-nowrap"
            >
                Pending Articles
            </a>

        </div>


        {{-- Success --}}
        @if(session('success'))

            <div class="mb-6 bg-green-100 border border-green-200 text-green-800 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>

        @endif


        {{-- Error --}}
        @if(session('error'))

            <div class="mb-6 bg-red-100 border border-red-200 text-red-800 px-5 py-4 rounded-xl">
                {{ session('error') }}
            </div>

        @endif


        {{-- Articles --}}
        @if($articles->count())

            <div class="space-y-6">

                @foreach($articles as $article)

                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">

                        <div class="flex flex-col md:flex-row">


                            {{-- IMAGE --}}
                            <div class="md:w-56 lg:w-80 h-56 md:h-auto bg-slate-100 flex-shrink-0">

                                @if($article->image)

                                    <img
                                        src="{{ asset('storage/' . $article->image) }}"
                                        alt="{{ $article->title }}"
                                        class="w-full h-full object-cover"
                                    >

                                @else

                                    <div class="w-full h-full min-h-56 flex flex-col items-center justify-center text-slate-400">

                                        <div class="mb-3">
                                            <x-icon name="newspaper" class="w-12 h-12" />
                                        </div>

                                        <span class="text-sm">
                                            No image available
                                        </span>

                                    </div>

                                @endif

                            </div>


                            {{-- INFORMATION --}}
                            <div class="flex-1 p-4 sm:p-6">

                                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 lg:gap-5">

                                    <div class="flex-1 min-w-0">


                                        {{-- Category + Status --}}
                                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-3">

                                            @if($article->category)

                                                <span class="text-xs sm:text-sm font-medium text-slate-500">
                                                    {{ $article->category->name }}
                                                </span>

                                            @endif


                                            <span
                                                class="text-xs sm:text-sm px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full font-medium

                                                @if($article->status === 'draft')
                                                    bg-slate-100 text-slate-700

                                                @elseif($article->status === 'pending')
                                                    bg-yellow-100 text-yellow-700

                                                @elseif($article->status === 'published')
                                                    bg-green-100 text-green-700

                                                @elseif($article->status === 'rejected')
                                                    bg-red-100 text-red-700

                                                @else
                                                    bg-slate-100 text-slate-700
                                                @endif
                                            "
                                            >
                                                {{ ucfirst($article->status) }}
                                            </span>

                                        </div>


                                        {{-- Title --}}
                                        <h2 class="text-lg sm:text-2xl font-bold text-slate-900 break-words-safe">

                                            <a
                                                href="{{ route('admin.articles.show', $article) }}"
                                                class="hover:text-red-600 transition"
                                            >
                                                {{ $article->display_title }}
                                            </a>

                                        </h2>


                                        {{-- Excerpt --}}
                                        @if($article->display_excerpt)

                                            <p class="mt-3 text-slate-600 leading-7 text-sm sm:text-base">
                                                {{ $article->display_excerpt }}
                                            </p>

                                        @endif


                                        {{-- Rejection reason --}}
                                        @if($article->status === 'rejected' && $article->rejection_reason)

                                            <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4">

                                                <p class="text-sm font-bold text-red-800">
                                                    Rejection Reason
                                                </p>

                                                <p class="text-sm text-red-700 mt-1">
                                                    {{ $article->rejection_reason }}
                                                </p>

                                            </div>

                                        @endif


                                        {{-- Journalist --}}
                                        <div class="mt-4 sm:mt-5 flex flex-wrap items-center gap-x-5 gap-y-1 text-xs sm:text-sm text-slate-500">

                                            <div>

                                                Journalist:

                                                <strong class="text-slate-800">
                                                    {{ $article->journalist?->user?->name ?? 'Unknown' }}
                                                </strong>

                                            </div>


                                            <div>

                                                Created:

                                                <strong class="text-slate-800">
                                                    {{ $article->created_at?->format('d M Y, h:i A') }}
                                                </strong>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- ACTIONS --}}
                                    <div class="flex flex-row lg:flex-col gap-2 w-full lg:w-32 lg:shrink-0">


                                        <a
                                            href="{{ route('admin.articles.show', $article) }}"
                                            class="flex-1 lg:flex-none px-3 sm:px-5 py-2.5 bg-slate-900 text-white rounded-xl text-sm font-semibold text-center hover:bg-slate-800"
                                        >
                                            View
                                        </a>


                                        @if($article->status === 'pending')

                                            <form
                                                method="POST"
                                                action="{{ route('admin.articles.approve', $article) }}"
                                                class="flex-1 lg:flex-none"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="w-full px-3 sm:px-5 py-2.5 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700"
                                                >
                                                    <x-icon name="check" class="w-3.5 h-3.5 inline-block -mt-0.5" /> Approve
                                                </button>

                                            </form>


                                            {{-- IMPORTANT:
                                                 Reject goes to show page first.
                                                 Admin must provide reason there.
                                            --}}
                                            <a
                                                href="{{ route('admin.articles.show', $article) }}"
                                                class="flex-1 lg:flex-none px-3 sm:px-5 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold text-center hover:bg-red-700 inline-flex items-center justify-center gap-1"
                                            >
                                                <x-icon name="close" class="w-3.5 h-3.5" />
                                                Review / Reject
                                            </a>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Pagination --}}
            @if(method_exists($articles, 'links'))

                <div class="mt-8">
                    {{ $articles->links() }}
                </div>

            @endif


        @else

            <div class="bg-white border border-slate-200 rounded-2xl py-20 text-center">

                <div class="mb-5 text-slate-400 flex justify-center">
                    <x-icon name="newspaper" class="w-16 h-16" />
                </div>

                <h2 class="text-2xl font-bold text-slate-900">
                    No Articles Found
                </h2>

                <p class="text-slate-500 mt-2">
                    There are no news articles available yet.
                </p>

                <a
                    href="{{ route('admin.articles.pending') }}"
                    class="inline-block mt-6 px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700"
                >
                    View Pending Articles
                </a>

            </div>

        @endif

    </div>

</div>

</x-app-layout>