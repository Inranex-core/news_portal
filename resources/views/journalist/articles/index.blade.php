<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="max-w-6xl mx-auto px-6">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div class="flex items-center justify-between mb-8">

                <div>

                    <h1 class="text-3xl font-bold text-slate-900">
                        My News
                    </h1>

                    <p class="text-slate-500 mt-2">
                        Manage your news articles.
                    </p>

                </div>


                {{-- Create News Button --}}
                <a
                    href="{{ route('journalist.articles.create') }}"
                    class="px-6 py-3 bg-red-600 text-white rounded-xl font-semibold
                           hover:bg-red-700 transition"
                >
                    + Create News
                </a>

            </div>


            {{-- =====================================================
                SUCCESS MESSAGE
            ====================================================== --}}
            @if(session('success'))

                <div
                    class="mb-6 bg-green-100 border border-green-200
                           text-green-800 p-4 rounded-xl"
                >
                    {{ session('success') }}
                </div>

            @endif


            {{-- =====================================================
                ERROR MESSAGE
            ====================================================== --}}
            @if(session('error'))

                <div
                    class="mb-6 bg-red-100 border border-red-200
                           text-red-800 p-4 rounded-xl"
                >
                    {{ session('error') }}
                </div>

            @endif


            {{-- =====================================================
                VALIDATION ERRORS
            ====================================================== --}}
            @if($errors->any())

                <div
                    class="mb-6 bg-red-50 border border-red-200
                           text-red-700 p-4 rounded-xl"
                >

                    <ul class="list-disc list-inside space-y-1">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =====================================================
                ARTICLES
            ====================================================== --}}
            <div
                class="bg-white rounded-2xl border border-slate-200
                       overflow-hidden shadow-sm"
            >

                @if($articles->count())

                    <div class="divide-y divide-slate-200">

                        @foreach($articles as $article)

                            {{-- =================================================
                                SINGLE ARTICLE
                            ================================================== --}}
                            <div
                                class="p-6 hover:bg-slate-50 transition"
                            >

                                <div
                                    class="flex flex-col lg:flex-row
                                           lg:items-start lg:justify-between
                                           gap-6"
                                >


                                    {{-- =========================================
                                        ARTICLE INFORMATION
                                    ========================================== --}}
                                    <div class="flex-1 min-w-0">

                                        {{-- Title --}}
                                        <h2
                                            class="text-xl font-bold
                                                   text-slate-900 break-words"
                                        >
                                            {{ $article->title }}
                                        </h2>


                                        {{-- Category + Status --}}
                                        <div
                                            class="flex flex-wrap
                                                   items-center gap-3 mt-3"
                                        >

                                            {{-- Category --}}
                                            @if($article->category)

                                                <span
                                                    class="text-sm font-medium
                                                           text-slate-500"
                                                >
                                                    {{ $article->category->name }}
                                                </span>

                                            @endif


                                            {{-- Status --}}
                                            <span
                                                class="text-sm px-3 py-1
                                                       rounded-full font-medium

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


                                        {{-- Excerpt --}}
                                        @if($article->excerpt)

                                            <p
                                                class="text-slate-500 mt-3
                                                       leading-6"
                                            >
                                                {{ $article->excerpt }}
                                            </p>

                                        @endif


                                        {{-- Created Date --}}
                                        @if($article->created_at)

                                            <p
                                                class="text-xs text-slate-400 mt-3"
                                            >
                                                Created:
                                                {{ $article->created_at->format('d M Y, h:i A') }}
                                            </p>

                                        @endif

                                    </div>


                                    {{-- =========================================
                                        ACTION BUTTONS
                                    ========================================== --}}
                                    <div
                                        class="flex flex-wrap items-center
                                               gap-2 lg:justify-end"
                                    >


                                        {{-- =====================================
                                            EDIT
                                        ====================================== --}}
                                        @if(
                                            $article->status === 'draft' ||
                                            $article->status === 'rejected'
                                        )

                                            <a
                                                href="{{ route(
                                                    'journalist.articles.edit',
                                                    $article
                                                ) }}"
                                                class="inline-flex items-center
                                                       justify-center
                                                       px-4 py-2
                                                       bg-blue-600
                                                       text-white
                                                       text-sm
                                                       font-semibold
                                                       rounded-lg
                                                       hover:bg-blue-700
                                                       transition"
                                            >
                                                ✏️ Edit
                                            </a>

                                        @endif


                                        {{-- =====================================
                                            SUBMIT FOR REVIEW
                                        ====================================== --}}
                                        @if(
                                            $article->status === 'draft' ||
                                            $article->status === 'rejected'
                                        )

                                            <form
                                                method="POST"
                                                action="{{ route(
                                                    'journalist.articles.submit',
                                                    $article
                                                ) }}"
                                                onsubmit="return confirm(
                                                    'Are you sure you want to submit this news for review?'
                                                )"
                                            >

                                                @csrf

                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center
                                                           justify-center
                                                           px-4 py-2
                                                           bg-green-600
                                                           text-white
                                                           text-sm
                                                           font-semibold
                                                           rounded-lg
                                                           hover:bg-green-700
                                                           transition"
                                                >
                                                    📤 Submit for Review
                                                </button>

                                            </form>

                                        @endif


                                        {{-- =====================================
                                            DELETE
                                        ====================================== --}}
                                        @if($article->status !== 'published')

                                            <form
                                                method="POST"
                                                action="{{ route(
                                                    'journalist.articles.destroy',
                                                    $article
                                                ) }}"
                                                onsubmit="return confirm(
                                                    'Are you sure you want to delete this news?'
                                                )"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center
                                                           justify-center
                                                           px-4 py-2
                                                           bg-red-600
                                                           text-white
                                                           text-sm
                                                           font-semibold
                                                           rounded-lg
                                                           hover:bg-red-700
                                                           transition"
                                                >
                                                    🗑️ Delete
                                                </button>

                                            </form>

                                        @endif


                                        {{-- =====================================
                                            STATUS INFORMATION
                                        ====================================== --}}

                                        @if($article->status === 'pending')

                                            <span
                                                class="inline-flex items-center
                                                       px-4 py-2
                                                       bg-yellow-50
                                                       text-yellow-700
                                                       text-sm
                                                       font-semibold
                                                       rounded-lg"
                                            >
                                                ⏳ Under Review
                                            </span>

                                        @endif


                                        @if($article->status === 'published')

                                            <span
                                                class="inline-flex items-center
                                                       px-4 py-2
                                                       bg-green-50
                                                       text-green-700
                                                       text-sm
                                                       font-semibold
                                                       rounded-lg"
                                            >
                                                ✓ Published
                                            </span>

                                        @endif

                                    </div>

                                </div>


                                {{-- =================================================
                                    REJECTED MESSAGE
                                ================================================== --}}
                                @if($article->status === 'rejected')

                                    <div
                                        class="mt-5 p-4
                                               bg-red-50
                                               border border-red-100
                                               rounded-xl"
                                    >

                                        <p
                                            class="text-sm
                                                   font-semibold
                                                   text-red-700"
                                        >
                                            ⚠️ This news was rejected.
                                        </p>

                                        <p
                                            class="text-sm
                                                   text-red-600
                                                   mt-1"
                                        >
                                            Please edit the article and
                                            submit it again for review.
                                        </p>

                                    </div>

                                @endif

                            </div>

                        @endforeach

                    </div>

                @else

                    {{-- =================================================
                        EMPTY STATE
                    ================================================== --}}
                    <div class="text-center py-16 px-6">

                        <div class="text-5xl mb-4">
                            📰
                        </div>


                        <h2
                            class="text-xl font-bold
                                   text-slate-900"
                        >
                            No news yet
                        </h2>


                        <p
                            class="text-slate-500
                                   mt-2"
                        >
                            Start by creating your first
                            news article.
                        </p>


                        <a
                            href="{{ route(
                                'journalist.articles.create'
                            ) }}"
                            class="inline-block
                                   mt-6
                                   px-6 py-3
                                   bg-red-600
                                   text-white
                                   rounded-xl
                                   font-semibold
                                   hover:bg-red-700
                                   transition"
                        >
                            + Create News
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>