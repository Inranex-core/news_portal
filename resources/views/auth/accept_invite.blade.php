<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="w-16 h-16 rounded-3xl bg-red-50 text-red-600 flex items-center justify-center mx-auto mb-4 text-3xl font-black shadow-sm">
            <x-icon name="shield" class="w-8 h-8" />
        </div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
            {{ __('Activate Journalist Account') }}
        </h2>
        <p class="text-sm text-slate-500 font-medium mt-1">
            {{ __('Welcome,') }} <span class="font-bold text-slate-800">{{ $user->name }}</span>! {{ __('Set your password to activate your account.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('journalist.accept_invite.submit', $token) }}" class="space-y-5">
        @csrf

        {{-- Email (Readonly) --}}
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" type="email" class="block mt-1 w-full bg-slate-100 font-semibold" :value="$user->email" readonly />
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autofocus />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <button
                type="submit"
                class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-700 hover:to-rose-800 text-white font-black text-sm shadow-lg shadow-red-600/25 transition active:scale-98"
            >
                <x-icon name="check" class="w-4 h-4 inline-block -mt-0.5" /> {{ __('Set Password & Activate Account') }}
            </button>
        </div>
    </form>
</x-guest-layout>
