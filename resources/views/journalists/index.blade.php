@extends('layouts.public')

@section('title', __('Journalists & Reporters Directory') . ' - ' . __('News Portal'))

@section('content')
<div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8 py-6 sm:py-8">

    {{-- Page Header --}}
    <div class="bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 mb-6 sm:mb-8">
        <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('Editorial Team') }}</span>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1 break-words-safe">
            {{ __('Journalists & Reporters Directory') }}
        </h1>
        <p class="text-sm text-slate-500 mt-2">
            {{ __('Meet our team of verified journalists, news reporters, and investigative columnists.') }}
        </p>
    </div>

    {{-- Journalists Grid --}}
    @if($journalists->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($journalists as $journalist)
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col items-center text-center hover:shadow-md transition">
                    <div class="h-20 w-20 rounded-full overflow-hidden bg-slate-100 border-2 border-red-500 shadow-sm mb-4">
                        @if($journalist->profile_image)
                            <img src="{{ asset('storage/' . $journalist->profile_image) }}" alt="{{ $journalist->user->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center font-black text-lg text-slate-500 bg-slate-200">
                                {{ strtoupper(substr($journalist->user->name ?? 'J', 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-1">
                        {{ $journalist->user->name ?? __('Journalist') }}
                        @if($journalist->is_verified)
                            <svg class="w-4 h-4 text-blue-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </h3>

                    <p class="text-xs font-semibold text-red-600 mt-0.5">
                        {{ $journalist->display_designation }}
                    </p>

                    @if($journalist->display_organization)
                        <p class="text-xs text-slate-400 font-medium mt-0.5">
                            {{ $journalist->display_organization }}
                        </p>
                    @endif

                    @if($journalist->display_bio)
                        <p class="text-xs text-slate-500 mt-3 line-clamp-2">
                            {{ $journalist->display_bio }}
                        </p>
                    @endif

                    <div class="mt-4 pt-4 border-t border-slate-100 w-full flex items-center justify-between text-xs text-slate-400">
                        <span>{{ $journalist->articles->count() }} {{ __('Published News') }}</span>
                        <a href="{{ route('journalists.show', $journalist->slug) }}" class="font-bold text-red-600 hover:underline">
                            {{ __('View Portfolio →') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $journalists->links() }}
        </div>
    @else
        <div class="bg-white p-12 text-center rounded-2xl border border-slate-200">
            <h3 class="text-lg font-bold text-slate-700">{{ __('No journalists registered yet.') }}</h3>
        </div>
    @endif

</div>
@endsection
