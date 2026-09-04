<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="w-16 h-16 rounded-3xl bg-red-50 text-red-600 flex items-center justify-center mx-auto mb-4 text-3xl font-black shadow-sm">
            📩
        </div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
            {{ __('Email OTP Verification') }}
        </h2>
        <p class="text-sm text-slate-500 font-medium mt-1">
            {{ __('Enter the 6-digit code sent to:') }}
            <span class="font-bold text-slate-800">{{ $user->email }}</span>
        </p>
    </div>

    @if (session('info'))
        <div class="mb-4 text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200 p-4 rounded-2xl">
            {{ session('info') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 p-4 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    @if ($user->otp_code)
        <div class="mb-5 p-4 rounded-2xl bg-amber-50 border border-amber-200/80 text-amber-900 shadow-2xs text-center space-y-2" x-data="{ copied: false }">
            <div class="flex items-center justify-center gap-2 text-xs font-bold text-amber-800">
                <span>🔑 {{ __('Development Mode OTP Code:') }}</span>
                <span class="text-base font-black tracking-widest text-red-600 bg-white px-3 py-1 rounded-xl border border-amber-300 shadow-2xs font-mono">
                    {{ $user->otp_code }}
                </span>
            </div>
            <button 
                type="button" 
                @click="document.getElementById('otp').value = '{{ $user->otp_code }}'; copied = true; setTimeout(() => copied = false, 2000)"
                class="text-[11px] font-black text-white bg-amber-600 hover:bg-amber-700 px-3 py-1 rounded-lg transition shadow-2xs cursor-pointer inline-flex items-center gap-1"
            >
                <span x-text="copied ? '✓ Auto-Filled!' : '⚡ Click to Auto-Fill OTP'"></span>
            </button>
            @if(config('mail.default') === 'log')
                <p class="text-[10px] text-amber-700 font-medium">
                    ℹ️ Mailer is currently set to <code class="font-mono font-bold bg-amber-100 px-1 py-0.5 rounded">LOG</code> driver. Emails are saved in <code class="font-mono text-[9px] bg-amber-100 px-1 py-0.5 rounded">storage/logs/laravel.log</code>.
                </p>
            @endif
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify.submit') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="otp" :value="__('6-Digit Verification Code')" class="text-center font-bold text-slate-700" />
            <div class="mt-2 flex justify-center">
                <input
                    id="otp"
                    type="text"
                    name="otp"
                    maxlength="6"
                    pattern="[0-9]{6}"
                    inputmode="numeric"
                    placeholder="123456"
                    class="w-48 text-center text-2xl font-black tracking-widest rounded-2xl border-slate-300 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 py-3 text-slate-900 shadow-inner"
                    required
                    autofocus
                />
            </div>
            <x-input-error :messages="$errors->get('otp')" class="mt-2 text-center" />
        </div>

        <div class="flex flex-col gap-3">
            <button
                type="submit"
                class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-700 hover:to-rose-800 text-white font-black text-sm shadow-lg shadow-red-600/25 transition active:scale-98"
            >
                ✓ {{ __('Verify OTP & Continue') }}
            </button>
        </div>
    </form>

    <div class="mt-6 pt-6 border-t border-slate-100 flex items-center justify-between text-xs font-medium text-slate-500">
        <span>{{ __("Didn't receive code?") }}</span>
        <form method="POST" action="{{ route('otp.resend') }}">
            @csrf
            <button type="submit" class="font-bold text-red-600 hover:text-red-700 hover:underline">
                🔄 {{ __('Resend OTP') }}
            </button>
        </form>
    </div>
</x-guest-layout>
