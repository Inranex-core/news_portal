@props(['ad', 'layout' => 'sidebar'])

@if($ad && $ad->status)
    @php
        $targetUrl = route('ads.click', $ad);
        $isVideo = ($ad->type === 'video' && $ad->video);
    @endphp

    @if($layout === 'in_article')
        {{-- In-Article Photocard / Video Banner --}}
        <div class="my-6">
            <a href="{{ $targetUrl }}" target="_blank" rel="noopener noreferrer" class="group block rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm hover:shadow-md hover:border-amber-400 transition duration-300 relative">
                <div class="relative">
                    @if($isVideo)
                        <div class="h-56 sm:h-72 w-full overflow-hidden bg-slate-950 relative">
                            <video src="{{ asset('storage/' . $ad->video) }}" autoplay loop muted playsinline class="w-full h-full object-cover group-hover:scale-105 transition duration-500"></video>
                            <div class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-xs text-amber-400 text-[10px] font-black uppercase px-2.5 py-1 rounded-full border border-amber-500/30 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                                🎥 {{ __('SPONSORED VIDEO') }}
                            </div>
                        </div>
                    @elseif($ad->image)
                        <div class="h-52 sm:h-64 w-full overflow-hidden bg-slate-900 relative">
                            <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-xs text-amber-400 text-[10px] font-black uppercase px-2.5 py-1 rounded-full border border-amber-500/30">
                                📢 {{ __('SPONSORED') }}
                            </div>
                        </div>
                    @else
                        <div class="p-6 bg-gradient-to-br from-amber-600 to-red-700 text-white">
                            <span class="text-[10px] font-black uppercase tracking-widest bg-black/30 px-2.5 py-1 rounded-full border border-white/20">
                                📢 {{ __('SPONSORED') }}
                            </span>
                            <h3 class="text-lg font-black mt-3 leading-snug">
                                {{ $ad->title }}
                            </h3>
                        </div>
                    @endif
                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 group-hover:text-amber-700 transition truncate pr-2">
                            {{ $ad->title }}
                        </span>
                        <span class="text-xs font-black text-white bg-amber-600 group-hover:bg-amber-700 px-3 py-1 rounded-lg transition shrink-0">
                            {{ __('Visit Site ↗') }}
                        </span>
                    </div>
                </div>
            </a>
        </div>

    @elseif($layout === 'footer')
        {{-- Footer Photocard / Video Banner --}}
        <div class="my-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ $targetUrl }}" target="_blank" rel="noopener noreferrer" class="group block rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm hover:shadow-md hover:border-amber-400 transition duration-300 p-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        @if($isVideo)
                            <div class="h-16 w-28 rounded-xl overflow-hidden bg-slate-950 border border-slate-200 shrink-0 relative">
                                <video src="{{ asset('storage/' . $ad->video) }}" autoplay loop muted playsinline class="w-full h-full object-cover"></video>
                            </div>
                        @elseif($ad->image)
                            <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="h-16 w-24 object-cover rounded-xl border border-slate-200 shrink-0">
                        @endif
                        <div>
                            <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest">
                                {{ $isVideo ? '🎥 SPONSORED VIDEO' : '📢 SPONSORED CAMPAIGN' }}
                            </span>
                            <h4 class="text-sm font-bold text-slate-900 group-hover:text-red-600 transition">{{ $ad->title }}</h4>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-700 bg-slate-100 group-hover:bg-amber-500 group-hover:text-slate-950 px-4 py-2 rounded-xl transition shrink-0">
                        {{ __('Click to View ↗') }}
                    </span>
                </div>
            </a>
        </div>

    @else
        {{-- Default / Sidebar Photocard / Video Banner --}}
        <div class="my-4">
            <a href="{{ $targetUrl }}" target="_blank" rel="noopener noreferrer" class="group block rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm hover:shadow-md hover:border-amber-400 transition duration-300">
                <div class="relative">
                    @if($isVideo)
                        <div class="h-48 w-full overflow-hidden bg-slate-950 relative">
                            <video src="{{ asset('storage/' . $ad->video) }}" autoplay loop muted playsinline class="w-full h-full object-cover group-hover:scale-105 transition duration-500"></video>
                            <div class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-xs text-amber-400 text-[10px] font-black uppercase px-2.5 py-1 rounded-full border border-amber-500/30 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
                                🎥 {{ __('VIDEO AD') }}
                            </div>
                        </div>
                    @elseif($ad->image)
                        <div class="h-44 w-full overflow-hidden bg-slate-100 relative">
                            <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-xs text-amber-400 text-[10px] font-black uppercase px-2.5 py-1 rounded-full border border-amber-500/30">
                                📢 {{ __('ADVERTISEMENT') }}
                            </div>
                        </div>
                    @else
                        <div class="p-5 bg-gradient-to-br from-slate-900 via-amber-950 to-slate-900 text-white relative">
                            <span class="text-[10px] font-black uppercase tracking-widest text-amber-400 bg-amber-950/80 px-2.5 py-0.5 rounded-full border border-amber-500/30">
                                📢 {{ __('SPONSORED') }}
                            </span>
                            <h4 class="text-sm font-bold text-white mt-3 leading-snug group-hover:text-amber-300 transition">
                                {{ $ad->title }}
                            </h4>
                        </div>
                    @endif

                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 group-hover:text-amber-700 transition truncate pr-2">
                            {{ $ad->title }}
                        </span>
                        <span class="text-[11px] font-black text-amber-600 bg-amber-50 group-hover:bg-amber-600 group-hover:text-white px-2.5 py-1 rounded-lg transition shrink-0 border border-amber-200">
                            {{ __('Open ↗') }}
                        </span>
                    </div>
                </div>
            </a>
        </div>
    @endif
@endif
