@props(['ads', 'layout' => 'sidebar'])

@if(isset($ads) && $ads->count() > 0)
    @if($ads->count() === 1)
        {{-- Single Ad Photocard --}}
        <x-ad-photocard :ad="$ads->first()" :layout="$layout" />
    @else
        {{-- Multi-Ad Auto-Rotating Carousel --}}
        <div 
            class="relative group/carousel my-4"
            x-data="{ 
                activeIndex: 0, 
                total: {{ $ads->count() }}, 
                paused: false,
                timer: null,
                init() {
                    this.timer = setInterval(() => {
                        if (!this.paused) {
                            this.activeIndex = (this.activeIndex + 1) % this.total;
                        }
                    }, 4500);
                }
            }"
            @mouseenter="paused = true"
            @mouseleave="paused = false"
        >
            {{-- Slides Container --}}
            <div class="relative overflow-hidden">
                @foreach($ads as $index => $ad)
                    <div 
                        x-show="activeIndex === {{ $index }}"
                        x-cloak
                        x-transition:enter="transition ease-out duration-500 transform"
                        x-transition:enter-start="opacity-0 translate-x-4 scale-98"
                        x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                        x-transition:leave="transition ease-in duration-300 transform absolute top-0 left-0 w-full"
                        x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-x-4 scale-98"
                    >
                        <x-ad-photocard :ad="$ad" :layout="$layout" />
                    </div>
                @endforeach
            </div>

            {{-- Slider Controls & Progress Indicator Overlay --}}
            <div class="flex items-center justify-between px-2 py-1 mt-1">
                {{-- Carousel Indicator Dots --}}
                <div class="flex items-center gap-1.5">
                    @foreach($ads as $index => $ad)
                        <button 
                            type="button" 
                            @click="activeIndex = {{ $index }}"
                            class="h-1.5 rounded-full transition-all duration-300 cursor-pointer"
                            :class="activeIndex === {{ $index }} ? 'w-6 bg-amber-600 shadow-xs' : 'w-1.5 bg-slate-300 hover:bg-slate-400'"
                            title="Go to ad {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>

                {{-- Status Badge (e.g. 1/3 Ads Auto-Rotating) --}}
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-slate-400 bg-slate-100 px-2.5 py-0.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span><span x-text="activeIndex + 1">1</span>/{{ $ads->count() }} {{ __('Ads') }}</span>
                </div>
            </div>
        </div>
    @endif
@endif
