<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="max-w-7xl mx-auto px-6">

            {{-- Header --}}
            <div class="mb-8">

                <h1 class="text-3xl font-bold text-slate-900">
                    Pending News
                </h1>

                <p class="text-slate-500 mt-2">
                    Review news submitted by journalists.
                </p>

            </div>


            {{-- Success --}}
            @if(session('success'))

                <div class="mb-6 bg-green-100 border border-green-200
                            text-green-800 p-4 rounded-xl">

                    {{ session('success') }}

                </div>

            @endif


            {{-- Error --}}
            @if(session('error'))

                <div class="mb-6 bg-red-100 border border-red-200
                            text-red-800 p-4 rounded-xl">

                    {{ session('error') }}

                </div>

            @endif


            {{-- Pending Articles --}}
            <div class="bg-white rounded-2xl border border-slate-200
                        overflow-hidden shadow-sm">

                @forelse($articles as $article)

                    <div class="p-6 border-b border-slate-200 last:border-b-0">

                        <div class="flex flex-col lg:flex-row
                                    lg:items-start lg:justify-between
                                    gap-6">


                            {{-- Article Information --}}
                            <div class="flex-1">

                                <h2 class="text-xl font-bold text-slate-900">
                                    {{ $article->title }}
                                </h2>


                                {{-- Category --}}
                                <div class="flex flex-wrap items-center
                                            gap-3 mt-3">

                                    @if($article->category)

                                        <span class="text-sm text-slate-500">
                                            Category:
                                            <strong>
                                                {{ $article->category->name }}
                                            </strong>
                                        </span>

                                    @endif


                                    <span class="px-3 py-1 rounded-full
                                                 text-sm font-medium
                                                 bg-yellow-100
                                                 text-yellow-700">
                                        Pending
                                    </span>

                                </div>


                                {{-- Journalist --}}
                                <p class="text-sm text-slate-500 mt-3">

                                    Journalist:

                                    <strong class="text-slate-700">

                                        @if($article->journalist &&
                                            $article->journalist->user)

                                            {{ $article->journalist->user->name }}

                                        @else

                                            Unknown

                                        @endif

                                    </strong>

                                </p>


                                {{-- Excerpt --}}
                                @if($article->excerpt)

                                    <p class="text-slate-600 mt-4 leading-6">
                                        {{ $article->excerpt }}
                                    </p>

                                @endif


                                {{-- Created --}}
                                @if($article->created_at)

                                    <p class="text-xs text-slate-400 mt-3">

                                        Submitted:

                                        {{ $article->created_at->format(
                                            'd M Y, h:i A'
                                        ) }}

                                    </p>

                                @endif

                            </div>


                            {{-- Actions --}}
                            <div class="flex flex-wrap items-center gap-2">


                                {{-- View --}}
                                <a
                                    href="{{ route(
                                        'admin.articles.show',
                                        $article
                                    ) }}"
                                    class="px-4 py-2 bg-slate-700
                                           text-white rounded-lg
                                           text-sm font-semibold
                                           hover:bg-slate-800"
                                >
                                    👁 View
                                </a>


                                {{-- Approve --}}
                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.articles.approve',
                                        $article
                                    ) }}"
                                    onsubmit="return confirm(
                                        'Are you sure you want to publish this news?'
                                    )"
                                >

                                    @csrf

                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-green-600
                                               text-white rounded-lg
                                               text-sm font-semibold
                                               hover:bg-green-700"
                                    >
                                        ✓ Approve
                                    </button>

                                </form>


                                {{-- Reject --}}
                                <button
                                    type="button"
                                    onclick="document.getElementById(
                                        'reject-{{ $article->id }}'
                                    ).classList.toggle('hidden')"
                                    class="px-4 py-2 bg-red-600
                                           text-white rounded-lg
                                           text-sm font-semibold
                                           hover:bg-red-700"
                                >
                                    ✕ Reject
                                </button>

                            </div>

                        </div>


                        {{-- Reject Form --}}
                        <div
                            id="reject-{{ $article->id }}"
                            class="hidden mt-5 p-5 bg-red-50
                                   border border-red-200 rounded-xl"
                        >

                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.articles.reject',
                                    $article
                                ) }}"
                            >

                                @csrf

                                @method('PATCH')


                                <label
                                    class="block text-sm font-semibold
                                           text-slate-700 mb-2"
                                >
                                    Rejection Reason
                                </label>


                                <textarea
                                    name="rejection_reason"
                                    rows="3"
                                    class="w-full border-slate-300
                                           rounded-lg focus:ring-red-500
                                           focus:border-red-500"
                                    placeholder="Explain why this news is being rejected..."
                                ></textarea>


                                <div class="mt-3">

                                    <button
                                        type="submit"
                                        class="px-5 py-2 bg-red-600
                                               text-white rounded-lg
                                               font-semibold
                                               hover:bg-red-700"
                                    >
                                        Confirm Rejection
                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                @empty

                    {{-- Empty --}}
                    <div class="text-center py-20">

                        <div class="text-5xl mb-4">
                            📰
                        </div>

                        <h2 class="text-xl font-bold text-slate-900">
                            No Pending News
                        </h2>

                        <p class="text-slate-500 mt-2">
                            There are currently no news articles
                            waiting for review.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</x-app-layout>