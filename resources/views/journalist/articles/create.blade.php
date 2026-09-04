<x-app-layout>

<div class="min-h-screen bg-slate-100/70 py-8 sm:py-12">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Header Card --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a
                    href="{{ route('journalist.articles.index') }}"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3.5 py-1.5 rounded-full transition duration-200 mb-3 shadow-xs"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>{{ __('Back to My News') }}</span>
                </a>

                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                    <span>✍️ {{ __('Create News') }}</span>
                </h1>

                <p class="text-sm text-slate-500 font-medium mt-1">
                    {{ __('Write and submit your news article for review.') }}
                </p>
            </div>
        </div>


        @if(!auth()->user()->isApproved())
            <div class="bg-amber-50 border-2 border-amber-400 p-5 rounded-2xl shadow-sm text-amber-900 flex items-center justify-between gap-4 mb-4">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">⏳</span>
                    <div>
                        <p class="text-sm font-black">{{ __('Account Pending Admin Approval') }}</p>
                        <p class="text-xs font-semibold text-amber-700">{{ __('Submitting news articles is disabled until an administrator approves your journalist account.') }}</p>
                    </div>
                </div>
                <span class="bg-amber-200 text-amber-900 text-xs font-black px-3 py-1 rounded-full shrink-0">🔒 {{ __('Disabled') }}</span>
            </div>
        @endif

        {{-- Validation Errors Alert --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-5 rounded-2xl shadow-xs">
                <h3 class="font-bold text-sm mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ __('Please fix the following errors:') }}</span>
                </h3>
                <ul class="list-disc ml-6 space-y-1 text-xs font-semibold text-red-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- Main Form Card --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-10 shadow-sm">

            <form
                method="POST"
                action="{{ route('journalist.articles.store') }}"
                enctype="multipart/form-data"
                class="space-y-8"
            >
                @csrf


                {{-- TITLE --}}
                <div class="space-y-2">
                    <label class="block font-bold text-sm text-slate-800">
                        {{ __('News Title') }} <span class="text-red-600">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-4 py-3.5 text-sm font-semibold text-slate-900 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition shadow-inner"
                        placeholder="{{ __('Enter news headline') }}"
                        required
                    >

                    @error('title')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- CATEGORY --}}
                <div class="space-y-2">
                    <label class="block font-bold text-sm text-slate-800">
                        {{ __('Category') }} <span class="text-red-600">*</span>
                    </label>

                    <select
                        name="category_id"
                        class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-4 py-3.5 text-sm font-semibold text-slate-900 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition shadow-inner"
                        required
                    >
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)
                            >
                                {{ $category->display_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- EXCERPT --}}
                <div class="space-y-2">
                    <label class="block font-bold text-sm text-slate-800">
                        {{ __('Short Description') }}
                    </label>

                    <textarea
                        name="excerpt"
                        rows="4"
                        maxlength="1000"
                        class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-4 py-3.5 text-sm font-medium text-slate-900 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition shadow-inner"
                        placeholder="{{ __('Write a short summary of the news...') }}"
                    >{{ old('excerpt') }}</textarea>

                    @error('excerpt')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- CONTENT --}}
                <div class="space-y-2">
                    <label class="block font-bold text-sm text-slate-800">
                        {{ __('News Content') }} <span class="text-red-600">*</span>
                    </label>

                    <textarea
                        name="content"
                        rows="12"
                        class="w-full rounded-2xl border-slate-200 bg-slate-50/50 px-4 py-3.5 text-sm font-normal text-slate-900 leading-relaxed focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition shadow-inner"
                        placeholder="{{ __('Write the full news article...') }}"
                        required
                    >{{ old('content') }}</textarea>

                    @error('content')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- BENGALI TRANSLATION SECTION CARD --}}
                <div class="bg-gradient-to-br from-rose-50/60 to-slate-50 border border-rose-200/80 rounded-3xl p-6 sm:p-8 space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">🇧🇩</span>
                        <div>
                            <h3 class="text-base font-black text-rose-900">
                                Bangla Version / বাংলা সংস্করণ (Optional / ঐচ্ছিক)
                            </h3>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">
                                Provide Bengali headline and details so your article displays when readers switch to Bangla mode.
                            </p>
                        </div>
                    </div>

                    {{-- TITLE BN --}}
                    <div class="space-y-1.5">
                        <label class="block font-bold text-xs uppercase tracking-wider text-slate-700">
                            বাংলা শিরোনাম (Bangla Headline)
                        </label>
                        <input
                            type="text"
                            name="title_bn"
                            value="{{ old('title_bn') }}"
                            placeholder="সংবাদের বাংলা শিরোনাম লিখুন..."
                            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition shadow-xs"
                        >
                        @error('title_bn')
                            <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- EXCERPT BN --}}
                    <div class="space-y-1.5">
                        <label class="block font-bold text-xs uppercase tracking-wider text-slate-700">
                            বাংলা সংক্ষিপ্ত বিবরণ (Bangla Short Description)
                        </label>
                        <textarea
                            name="excerpt_bn"
                            rows="3"
                            maxlength="1000"
                            placeholder="সংক্ষিপ্ত বিবরণ লিখুন..."
                            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-900 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition shadow-xs"
                        >{{ old('excerpt_bn') }}</textarea>
                        @error('excerpt_bn')
                            <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- CONTENT BN --}}
                    <div class="space-y-1.5">
                        <label class="block font-bold text-xs uppercase tracking-wider text-slate-700">
                            বাংলা বিস্তারিত বিবরণ (Bangla Full Content)
                        </label>
                        <textarea
                            name="content_bn"
                            rows="8"
                            placeholder="বিস্তারিত বাংলা সংবাদ লিখুন..."
                            class="w-full rounded-2xl border-slate-200 bg-white px-4 py-3 text-sm font-normal text-slate-900 leading-relaxed focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition shadow-xs"
                        >{{ old('content_bn') }}</textarea>
                        @error('content_bn')
                            <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                {{-- FEATURED IMAGE SECTION --}}
                <div class="space-y-2 pt-4 border-t border-slate-100">
                    <label class="block font-bold text-sm text-slate-800">
                        {{ __('Featured Image') }}
                    </label>

                    <div class="border-2 border-dashed border-slate-300 hover:border-red-400 bg-slate-50/50 hover:bg-white rounded-2xl p-6 transition text-center group cursor-pointer">
                        <input
                            type="file"
                            name="image"
                            accept="image/jpeg,image/png,image/webp"
                            class="w-full text-xs font-semibold text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer"
                        >
                        <p class="text-xs font-medium text-slate-500 mt-2">
                            {{ __('JPG, JPEG, PNG or WEBP. Maximum 4MB.') }}
                        </p>
                    </div>

                    @error('image')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- ACTION BUTTONS --}}
                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a
                        href="{{ route('journalist.articles.index') }}"
                        class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm text-center transition"
                    >
                        {{ __('Cancel') }}
                    </a>

                @if(auth()->user()->isApproved())
                    <button
                        type="submit"
                        name="action"
                        value="draft"
                        class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-sm transition flex items-center justify-center gap-2 shadow-sm"
                    >
                        <span>📝</span>
                        <span>{{ __('Save as Draft') }}</span>
                    </button>

                    <button
                        type="submit"
                        name="action"
                        value="submit"
                        class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-700 hover:to-rose-800 text-white font-black text-sm transition flex items-center justify-center gap-2 shadow-lg shadow-red-600/25 active:scale-98"
                    >
                        <span>🚀</span>
                        <span>{{ __('Submit for Review') }}</span>
                    </button>
                @else
                    <button
                        type="button"
                        disabled
                        class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-slate-300 text-slate-500 font-bold text-sm opacity-60 cursor-not-allowed pointer-events-none"
                    >
                        🔒 {{ __('Submit Disabled (Pending Approval)') }}
                    </button>
                @endif
                </div>

            </form>

        </div>

    </div>

</div>

</x-app-layout>