<x-app-layout>
    <div class="min-h-screen bg-slate-100/70 py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
        <div class="max-w-xl w-full bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/80 shadow-sm text-center space-y-6">
            
            {{-- ICON BADGE --}}
            <div class="w-20 h-20 rounded-3xl bg-amber-50 text-amber-600 border border-amber-200/60 flex items-center justify-center mx-auto text-4xl font-black shadow-inner">
                <x-icon name="clock" class="w-10 h-10" />
            </div>

            {{-- HEADINGS --}}
            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200 mb-2">
                    <x-icon name="check" class="w-3.5 h-3.5" />
                    {{ __('Email Verified') }}
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ __('Journalist Application Pending Approval') }}
                </h1>
                <p class="text-sm font-medium text-slate-500">
                    {{ __('Your email has been verified. Your application is currently awaiting editorial approval.') }}
                </p>
            </div>

            {{-- NOTICE CARD --}}
            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-5 text-left text-xs space-y-2 text-slate-700">
                <div class="font-extrabold text-slate-900 flex items-center gap-2 text-sm">
                    <x-icon name="bell" class="w-4 h-4 text-amber-500" />
                    <span>{{ __('What happens next?') }}</span>
                </div>
                <ul class="list-disc ml-5 space-y-1 font-medium leading-relaxed">
                    <li>{{ __('An administrator will review your journalist registration details.') }}</li>
                    <li>{{ __('Once approved, you will receive an instant email notification.') }}</li>
                    <li>{{ __('You can then log in to write news articles and manage your journalist profile.') }}</li>
                </ul>
            </div>

            {{-- ALERT MESSAGES --}}
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ACTION BUTTONS --}}
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a
                    href="{{ route('public.home') }}"
                    class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition inline-flex items-center justify-center gap-1.5"
                >
                    <x-icon name="globe" class="w-4 h-4" />
                    {{ __('Back to Live News Portal') }}
                </a>

                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button
                        type="submit"
                        class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs border border-rose-200 transition inline-flex items-center justify-center gap-1.5"
                    >
                        <x-icon name="logout" class="w-4 h-4" />
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
