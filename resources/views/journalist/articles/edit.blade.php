<x-app-layout>

<div class="min-h-screen bg-slate-50 py-10">

    <div class="max-w-5xl mx-auto px-6">

        {{-- Header --}}
        <div class="mb-8">

            <a
                href="{{ route('journalist.articles.index') }}"
                class="text-sm text-red-600 hover:text-red-700 font-medium"
            >
                ← Back to My News
            </a>

            <h1 class="text-3xl font-bold text-slate-900 mt-4">
                Edit News
            </h1>

            <p class="text-slate-500 mt-2">
                Update your article and submit it again for review.
            </p>

        </div>


        {{-- Rejection Reason --}}
        @if($article->status === 'rejected' && $article->rejection_reason)

            <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-6">

                <div class="flex items-start gap-3">

                    <div class="text-2xl">
                        ⚠️
                    </div>

                    <div>

                        <h3 class="font-bold text-red-800">
                            Article Rejected
                        </h3>

                        <p class="text-sm text-red-700 mt-1">
                            Admin's feedback:
                        </p>

                        <p class="text-red-800 mt-2">
                            {{ $article->rejection_reason }}
                        </p>

                    </div>

                </div>

            </div>

        @endif


        {{-- Validation Errors --}}
        @if($errors->any())

            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-5 rounded-2xl">

                <ul class="list-disc ml-5 space-y-1">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">

            <form
                method="POST"
                action="{{ route('journalist.articles.update', $article) }}"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')


                {{-- TITLE --}}
                <div class="mb-6">

                    <label class="block mb-2 font-semibold text-slate-800">
                        News Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $article->title) }}"
                        class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                        required
                    >

                    @error('title')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- CATEGORY --}}
                <div class="mb-6">

                    <label class="block mb-2 font-semibold text-slate-800">
                        Category
                    </label>

                    <select
                        name="category_id"
                        class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                        required
                    >

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old(
                                        'category_id',
                                        $article->category_id
                                    ) == $category->id
                                )
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- EXCERPT --}}
                <div class="mb-6">

                    <label class="block mb-2 font-semibold text-slate-800">
                        Short Description
                    </label>

                    <textarea
                        name="excerpt"
                        rows="4"
                        maxlength="1000"
                        class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                    >{{ old('excerpt', $article->excerpt) }}</textarea>

                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- CONTENT --}}
                <div class="mb-8">

                    <label class="block mb-2 font-semibold text-slate-800">
                        News Content
                    </label>

                    <textarea
                        name="content"
                        rows="12"
                        class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                        required
                    >{{ old('content', $article->content) }}</textarea>

                    @error('content')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- BENGALI TRANSLATION SECTION --}}
                <div class="mb-8 p-6 bg-red-50/50 border border-red-200 rounded-2xl">
                    <div class="flex items-center gap-2 mb-4 text-red-700 font-bold">
                        <span>🇧🇩</span>
                        <span>Bangla Version / বাংলা সংস্করণ (Optional / ঐচ্ছিক)</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-4">
                        Provide Bengali headline and details so your article displays when readers switch to Bangla mode.
                    </p>

                    {{-- TITLE BN --}}
                    <div class="mb-4">
                        <label class="block font-semibold text-slate-800 text-sm mb-1">
                            বাংলা শিরোনাম (Bangla Headline)
                        </label>
                        <input
                            type="text"
                            name="title_bn"
                            value="{{ old('title_bn', $article->title_bn) }}"
                            placeholder="সংবাদের বাংলা শিরোনাম লিখুন..."
                            class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 text-sm"
                        >
                        @error('title_bn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- EXCERPT BN --}}
                    <div class="mb-4">
                        <label class="block font-semibold text-slate-800 text-sm mb-1">
                            বাংলা সংক্ষিপ্ত বিবরণ (Bangla Short Description)
                        </label>
                        <textarea
                            name="excerpt_bn"
                            rows="3"
                            maxlength="1000"
                            placeholder="সংক্ষিপ্ত বিবরণ লিখুন..."
                            class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 text-sm"
                        >{{ old('excerpt_bn', $article->excerpt_bn) }}</textarea>
                        @error('excerpt_bn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- CONTENT BN --}}
                    <div>
                        <label class="block font-semibold text-slate-800 text-sm mb-1">
                            বাংলা বিস্তারিত বিবরণ (Bangla Full Content)
                        </label>
                        <textarea
                            name="content_bn"
                            rows="10"
                            placeholder="বিস্তারিত বাংলা সংবাদ লিখুন..."
                            class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 text-sm"
                        >{{ old('content_bn', $article->content_bn) }}</textarea>
                        @error('content_bn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                {{-- CURRENT IMAGE --}}
                <div class="mb-6">

                    <label class="block mb-2 font-semibold text-slate-800">
                        Current Featured Image
                    </label>

                    @if($article->image)

                        <div class="mb-4">

                            <img
                                src="{{ asset('storage/' . $article->image) }}"
                                alt="{{ $article->title }}"
                                class="w-full max-w-2xl h-72 object-cover rounded-2xl border border-slate-200"
                            >

                            <p class="text-sm text-slate-500 mt-2">
                                Current featured image
                            </p>

                        </div>

                    @else

                        <div class="mb-4 bg-slate-100 rounded-2xl p-8 text-center text-slate-400">
                            📰 No featured image
                        </div>

                    @endif

                </div>


                {{-- NEW IMAGE --}}
                <div class="mb-8">

                    <label class="block mb-2 font-semibold text-slate-800">
                        Change Featured Image
                    </label>

                    <div class="border-2 border-dashed border-slate-300 rounded-2xl p-6">

                        <input
                            type="file"
                            name="image"
                            accept="image/jpeg,image/png,image/webp"
                            class="w-full text-sm"
                        >

                        <p class="text-sm text-slate-500 mt-2">
                            Leave empty to keep the current image.
                            JPG, JPEG, PNG or WEBP. Maximum 4MB.
                        </p>

                    </div>

                    @error('image')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- BUTTONS --}}
                <div class="flex flex-wrap gap-3">

                    <a
                        href="{{ route('journalist.articles.index') }}"
                        class="rounded-xl bg-slate-200 px-6 py-3 font-semibold text-slate-700 hover:bg-slate-300"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        name="action"
                        value="draft"
                        class="rounded-xl bg-slate-700 px-6 py-3 font-semibold text-white hover:bg-slate-800"
                    >
                        Save as Draft
                    </button>


                    <button
                        type="submit"
                        name="action"
                        value="submit"
                        class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white hover:bg-red-700"
                    >
                        Submit Again for Review
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</x-app-layout>