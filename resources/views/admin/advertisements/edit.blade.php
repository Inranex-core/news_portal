<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumbs --}}
            <nav class="flex text-sm font-medium text-slate-500 mb-6 gap-2 items-center">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-red-600 transition">{{ __('Dashboard') }}</a>
                <span>/</span>
                <a href="{{ route('admin.advertisements.index') }}" class="hover:text-red-600 transition">{{ __('Advertisements') }}</a>
                <span>/</span>
                <span class="text-slate-800 font-bold">{{ __('Edit') }}</span>
            </nav>

            {{-- Form Card --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ adType: '{{ old('type', $advertisement->type ?? 'image') }}' }">
                <div class="bg-slate-900 text-white p-6 sm:p-8">
                    <span class="text-xs font-black uppercase tracking-widest text-amber-400 bg-amber-950/80 px-3 py-1 rounded-full">
                        📢 {{ __('EDIT CAMPAIGN') }}
                    </span>
                    <h1 class="text-2xl font-black mt-2">
                        {{ __('Edit Advertisement Banner') }}
                    </h1>
                </div>

                <form action="{{ route('admin.advertisements.update', $advertisement) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Advertisement Title / Headline') }} *
                        </label>
                        <input
                            type="text"
                            name="title"
                            required
                            placeholder="{{ __('e.g., Admission Open 2026 - Comilla University Computer Science') }}"
                            class="w-full text-sm rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-3"
                            value="{{ old('title', $advertisement->title) }}"
                        >
                    </div>

                    {{-- Ad Format Selection (Image vs Video) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            🎬 {{ __('Advertisement Media Type') }} *
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="border-2 rounded-2xl p-4 flex items-center gap-3 cursor-pointer transition" :class="adType === 'image' ? 'border-amber-500 bg-amber-50/50 text-amber-900 font-bold' : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300'">
                                <input type="radio" name="type" value="image" x-model="adType" class="text-amber-600 focus:ring-amber-500">
                                <div>
                                    <span class="text-sm font-black block">🖼️ {{ __('Image Photocard') }}</span>
                                    <span class="text-[11px] font-normal text-slate-500">{{ __('JPG, PNG, WEBP banner image') }}</span>
                                </div>
                            </label>
                            <label class="border-2 rounded-2xl p-4 flex items-center gap-3 cursor-pointer transition" :class="adType === 'video' ? 'border-amber-500 bg-amber-50/50 text-amber-900 font-bold' : 'border-slate-200 bg-white text-slate-600 hover:border-slate-300'">
                                <input type="radio" name="type" value="video" x-model="adType" class="text-amber-600 focus:ring-amber-500">
                                <div>
                                    <span class="text-sm font-black block">🎥 {{ __('Video Ad Banner') }}</span>
                                    <span class="text-[11px] font-normal text-slate-500">{{ __('Autoplay MP4 / WebM video file') }}</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Target Website URL (Clickable Link)') }}
                        </label>
                        <input
                            type="url"
                            name="url"
                            placeholder="https://example.com"
                            class="w-full text-sm rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-3"
                            value="{{ old('url', $advertisement->url) }}"
                        >
                        <p class="text-xs text-slate-400 mt-1">
                            {{ __('When a reader clicks on the photocard image or video ad, they will be redirected to this link.') }}
                        </p>
                    </div>

                    {{-- Photocard Image Upload & Preview --}}
                    <div x-show="adType === 'image'" x-cloak>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            🖼️ {{ __('Photocard Banner Image') }}
                        </label>
                        
                        @if($advertisement->image)
                            <div class="mb-3 p-3 bg-slate-100 rounded-2xl border border-slate-200 flex items-center gap-4">
                                <img src="{{ asset('storage/' . $advertisement->image) }}" alt="Current Photocard" class="h-20 w-32 object-cover rounded-xl border">
                                <div>
                                    <span class="text-xs font-bold text-slate-700 block">{{ __('Current Photocard Banner') }}</span>
                                    <span class="text-[11px] text-slate-400">{{ __('Upload a new image below to replace this banner.') }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center bg-slate-50 hover:bg-white hover:border-amber-400 transition" x-data="{ imagePreview: null }">
                            <template x-if="imagePreview">
                                <div class="mb-4">
                                    <img :src="imagePreview" class="max-h-48 mx-auto rounded-xl shadow-md border border-slate-200 object-cover">
                                </div>
                            </template>
                            <input
                                type="file"
                                name="image"
                                accept="image/*"
                                class="hidden"
                                id="ad_image_input_edit"
                                @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }"
                            >
                            <label for="ad_image_input_edit" class="cursor-pointer inline-flex flex-col items-center">
                                <span class="text-2xl mb-1">📷</span>
                                <span class="text-xs font-bold text-amber-600 hover:underline">{{ __('Upload New Photocard Image') }}</span>
                                <span class="text-[11px] text-slate-400 mt-1">{{ __('Supported format: JPG, PNG, WEBP, GIF (Max 4MB)') }}</span>
                            </label>
                        </div>
                    </div>

                    {{-- Video File Upload & Preview --}}
                    <div x-show="adType === 'video'" x-cloak class="space-y-4">
                        @if($advertisement->video || $advertisement->video_url)
                            <div class="p-3 bg-slate-900 text-white rounded-2xl border border-slate-800 flex items-center gap-4">
                                @if($advertisement->video)
                                    <video src="{{ asset('storage/' . $advertisement->video) }}" controls class="h-24 w-36 object-cover rounded-xl border border-slate-700 bg-black"></video>
                                @elseif($advertisement->video_url)
                                    <video src="{{ $advertisement->video_url }}" controls class="h-24 w-36 object-cover rounded-xl border border-slate-700 bg-black"></video>
                                @endif
                                <div>
                                    <span class="text-xs font-bold text-amber-400 block">🎥 {{ __('Current Video Banner') }}</span>
                                    <span class="text-[11px] text-slate-400">{{ __('Upload a new video file or change link below to replace this video.') }}</span>
                                </div>
                            </div>
                        @endif

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                🎥 {{ __('Option A: Upload Video File (Max 10MB)') }}
                            </label>
                            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center bg-slate-50 hover:bg-white hover:border-amber-400 transition" x-data="{ videoPreview: null }">
                                <template x-if="videoPreview">
                                    <div class="mb-4">
                                        <video :src="videoPreview" controls autoplay muted loop class="max-h-56 mx-auto rounded-xl shadow-md border border-slate-200 bg-black"></video>
                                    </div>
                                </template>
                                <input
                                    type="file"
                                    name="video"
                                    accept="video/mp4,video/webm,video/ogg,video/quicktime"
                                    class="hidden"
                                    id="ad_video_input_edit"
                                    @change="const file = $event.target.files[0]; if (file) { if (file.size > 50 * 1024 * 1024) { alert('⚠️ ভিডিও ফাইলের সাইজ ৫০MB এর বেশি! সার্ভার লিমিট বজায় রাখতে ৫০MB এর কম সাইজের ভিডিও ফাইল আপলোড করুন, অথবা নিচে সরাসরি ভিডিও লিঙ্ক ব্যবহার করুন।'); $event.target.value = ''; videoPreview = null; return; } videoPreview = URL.createObjectURL(file); }"
                                >
                                <label for="ad_video_input_edit" class="cursor-pointer inline-flex flex-col items-center">
                                    <span class="text-2xl mb-1">🎬</span>
                                    <span class="text-xs font-bold text-amber-600 hover:underline">{{ __('Upload New Video Ad File') }}</span>
                                    <span class="text-[11px] text-slate-400 mt-1">{{ __('Supported format: MP4, WEBM, MOV (Recommended: Under 10MB)') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                🔗 {{ __('Option B: Direct Video Link / URL (No Size Limits)') }}
                            </label>
                            <input
                                type="url"
                                name="video_url"
                                placeholder="https://example.com/banner-video.mp4"
                                class="w-full text-sm rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-3"
                                value="{{ old('video_url', $advertisement->video_url) }}"
                            >
                            <p class="text-[11px] text-slate-500 mt-1">
                                {{ __('Paste a direct MP4/WebM video URL hosted on external CDNs or cloud storage without any upload size restrictions.') }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Banner Placement Position') }} *
                        </label>
                        <select name="placement" required class="w-full text-sm rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-3">
                            <option value="sidebar" {{ old('placement', $advertisement->placement) === 'sidebar' ? 'selected' : '' }}>{{ __('Sidebar Banner') }}</option>
                            <option value="in_article" {{ old('placement', $advertisement->placement) === 'in_article' ? 'selected' : '' }}>{{ __('In-Article Reading Banner') }}</option>
                            <option value="footer" {{ old('placement', $advertisement->placement) === 'footer' ? 'selected' : '' }}>{{ __('Footer Banner') }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Status') }} *
                        </label>
                        <select name="status" required class="w-full text-sm rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-3">
                            <option value="1" {{ old('status', $advertisement->status) ? 'selected' : '' }}>{{ __('Active (Enabled)') }}</option>
                            <option value="0" {{ !old('status', $advertisement->status) ? 'selected' : '' }}>{{ __('Inactive (Disabled)') }}</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.advertisements.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">
                            ← {{ __('Back to Advertisements') }}
                        </a>

                        <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm px-8 py-3 rounded-xl transition shadow-sm">
                            {{ __('Update Banner') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</x-app-layout>
