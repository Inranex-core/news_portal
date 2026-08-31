<x-app-layout>

<div class="min-h-screen bg-slate-50 py-10">

    <div class="max-w-5xl mx-auto px-6">

        {{-- Back --}}
        <div class="mb-6">

            <a
                href="{{ route('admin.articles.pending') }}"
                class="text-slate-600 hover:text-red-600 font-medium"
            >
                ← Back to Pending Articles
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


        {{-- Validation --}}
        @if($errors->any())

            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">

                <ul class="list-disc ml-5">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Article --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">


            {{-- FEATURED IMAGE --}}
            @if($article->image)

                <div class="w-full bg-slate-100">

                    <img
                        src="{{ asset('storage/' . $article->image) }}"
                        alt="{{ $article->title }}"
                        class="w-full max-h-[550px] object-cover"
                    >

                </div>

            @endif


            {{-- Header --}}
            <div class="p-8 border-b border-slate-200">

                <div class="flex items-center gap-3 mb-4">

                    @if($article->category)

                        <span class="text-sm text-slate-500">
                            {{ $article->category->name }}
                        </span>

                    @endif


                    <span
                        class="px-3 py-1 rounded-full text-sm font-medium

                        @if($article->status === 'pending')
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


                <h1 class="text-3xl font-bold text-slate-900">
                    {{ $article->title }}
                </h1>


                @if($article->excerpt)

                    <p class="mt-4 text-lg text-slate-600">
                        {{ $article->excerpt }}
                    </p>

                @endif

            </div>


            {{-- Author --}}
            <div class="px-8 py-5 bg-slate-50 border-b border-slate-200">

                <div class="flex flex-wrap gap-8 text-sm">

                    <div>

                        <span class="text-slate-500">
                            Journalist
                        </span>

                        <p class="font-semibold text-slate-900">
                            {{ $article->journalist?->user?->name ?? 'Unknown' }}
                        </p>

                    </div>


                    <div>

                        <span class="text-slate-500">
                            Category
                        </span>

                        <p class="font-semibold text-slate-900">
                            {{ $article->category?->name ?? 'N/A' }}
                        </p>

                    </div>


                    <div>

                        <span class="text-slate-500">
                            Created
                        </span>

                        <p class="font-semibold text-slate-900">
                            {{ $article->created_at?->format('d M Y, h:i A') }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- Rejection reason --}}
            @if($article->status === 'rejected' && $article->rejection_reason)

                <div class="p-8 bg-red-50 border-b border-red-200">

                    <h3 class="font-bold text-red-800">
                        Rejection Reason
                    </h3>

                    <p class="mt-2 text-red-700 whitespace-pre-line">
                        {{ $article->rejection_reason }}
                    </p>

                </div>

            @endif


            {{-- Content --}}
            <div class="p-8">

                <h2 class="text-xl font-bold text-slate-900 mb-4">
                    Article Content
                </h2>

                <div class="prose max-w-none text-slate-700 leading-8">

                    {!! nl2br(e($article->content)) !!}

                </div>

            </div>


            {{-- Admin Actions --}}
            @if($article->status === 'pending')

                <div class="p-8 border-t border-slate-200 bg-slate-50">

                    <h3 class="text-lg font-bold text-slate-900 mb-5">
                        Admin Review
                    </h3>


                    <div class="grid md:grid-cols-2 gap-6">


                        {{-- APPROVE --}}
                        <div class="bg-white rounded-2xl border border-green-200 p-6">

                            <h4 class="font-bold text-green-800 mb-2">
                                Approve Article
                            </h4>

                            <p class="text-sm text-slate-500 mb-4">
                                This article will be published.
                            </p>

                            <form
                                method="POST"
                                action="{{ route('admin.articles.approve', $article) }}"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="w-full px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700"
                                >
                                    <x-icon name="check" class="w-4 h-4 inline-block -mt-0.5" /> Approve & Publish
                                </button>

                            </form>

                        </div>


                        {{-- REJECT --}}
                        <div class="bg-white rounded-2xl border border-red-200 p-6">

                            <h4 class="font-bold text-red-800 mb-2">
                                Reject Article
                            </h4>

                            <p class="text-sm text-slate-500 mb-4">
                                Explain what the journalist needs to fix.
                            </p>

                            <form
                                method="POST"
                                action="{{ route('admin.articles.reject', $article) }}"
                            >

                                @csrf
                                @method('PATCH')


                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Rejection Reason
                                </label>

                                <textarea
                                    name="rejection_reason"
                                    rows="5"
                                    required
                                    minlength="5"
                                    maxlength="2000"
                                    placeholder="Example: Please upload a relevant featured image and correct the article content."
                                    class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                                ></textarea>


                                @error('rejection_reason')

                                    <p class="text-sm text-red-600 mt-2">
                                        {{ $message }}
                                    </p>

                                @enderror


                                <button
                                    type="submit"
                                    class="w-full mt-4 px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700"
                                >
                                    <x-icon name="close" class="w-4 h-4 inline-block -mt-0.5" /> Reject Article
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endif


        </div>

    </div>

</div>

</x-app-layout>