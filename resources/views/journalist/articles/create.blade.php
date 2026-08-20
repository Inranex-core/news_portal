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
                Create News
            </h1>

            <p class="text-slate-500 mt-2">
                Write and submit your news article.
            </p>

        </div>


        {{-- Validation Errors --}}
        @if($errors->any())

            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-5 rounded-2xl">

                <h3 class="font-bold mb-2">
                    Please fix the following errors:
                </h3>

                <ul class="list-disc ml-5 space-y-1">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Form --}}
        <form
            method="POST"
            action="{{ route('journalist.articles.store') }}"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">


                {{-- TITLE --}}
                <div class="mb-6">

                    <label class="block font-semibold text-slate-800 mb-2">
                        News Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Enter news headline"
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

                    <label class="block font-semibold text-slate-800 mb-2">
                        Category
                    </label>

                    <select
                        name="category_id"
                        class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                        required
                    >

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)
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

                    <label class="block font-semibold text-slate-800 mb-2">
                        Short Description
                    </label>

                    <textarea
                        name="excerpt"
                        rows="4"
                        maxlength="1000"
                        placeholder="Write a short summary of the news..."
                        class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                    >{{ old('excerpt') }}</textarea>

                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- CONTENT --}}
                <div class="mb-8">

                    <label class="block font-semibold text-slate-800 mb-2">
                        News Content
                    </label>

                    <textarea
                        name="content"
                        rows="12"
                        placeholder="Write the full news article..."
                        class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500"
                        required
                    >{{ old('content') }}</textarea>

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
                            value="{{ old('title_bn') }}"
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
                        >{{ old('excerpt_bn') }}</textarea>
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
                        >{{ old('content_bn') }}</textarea>
                        @error('content_bn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                {{-- FEATURED IMAGE --}}
                <div class="mb-8">

                    <label class="block font-semibold text-slate-800 mb-2">
                        Featured Image
                    </label>

                    <div class="border-2 border-dashed border-slate-300 rounded-2xl p-6">

                        <input
                            type="file"
                            name="image"
                            accept="image/jpeg,image/png,image/webp"
                            class="w-full text-sm"
                        >

                        <p class="text-sm text-slate-500 mt-2">
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
                <div class="flex flex-wrap justify-end gap-3">

                    <a
                        href="{{ route('journalist.articles.index') }}"
                        class="px-6 py-3 border border-slate-300 rounded-xl font-semibold text-slate-700 hover:bg-slate-50"
                    >
                        Cancel
                    </a>


                    {{-- SAVE DRAFT --}}
                    <button
                        type="submit"
                        name="action"
                        value="draft"
                        class="px-6 py-3 bg-slate-700 text-white rounded-xl font-semibold hover:bg-slate-800"
                    >
                        Save as Draft
                    </button>


                    {{-- SUBMIT --}}
                    <button
                        type="submit"
                        name="action"
                        value="submit"
                        class="px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700"
                    >
                        Submit for Review
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

</x-app-layout>