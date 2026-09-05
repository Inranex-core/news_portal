<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb Navigation --}}
            <nav class="flex text-sm font-medium text-slate-500 mb-6 gap-2 items-center">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-red-600 transition">{{ __('Dashboard') }}</a>
                <span>/</span>
                <a href="{{ route('admin.journalists.index') }}" class="hover:text-red-600 transition">{{ __('Journalists') }}</a>
                <span>/</span>
                <span class="text-slate-800 font-bold">{{ __('Send Email') }}</span>
            </nav>

            {{-- Alert Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-sm font-bold flex items-center gap-2">
                    <x-icon name="check" class="w-4 h-4 text-emerald-600" />
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl text-sm font-bold flex items-center gap-2">
                    <x-icon name="warning" class="w-4 h-4" />
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(config('mail.default') === 'log')
                <div class="mb-6 bg-amber-50 border border-amber-200 text-amber-900 p-4 rounded-2xl text-xs font-semibold flex items-start gap-3 shadow-2xs">
                    <span class="text-base">💡</span>
                    <div>
                        <span class="font-bold text-amber-950 block text-xs">{{ __('Mail Driver Notice (LOG Driver Active)') }}</span>
                        <span class="text-amber-800 leading-relaxed block mt-0.5">
                            {{ __('Your system is currently using the LOG mail driver (MAIL_MAILER=log). Emails sent from this page are captured in ') }}
                            <code class="font-mono bg-amber-100 px-1.5 py-0.5 rounded text-[11px] font-bold text-amber-900">storage/logs/laravel.log</code>.
                            {{ __(' To deliver real emails to actual Gmail/inboxes, configure SMTP credentials in your .env file.') }}
                        </span>
                    </div>
                </div>
            @endif

            {{-- Main Form Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                
                {{-- Card Header --}}
                <div class="bg-slate-900 text-white p-6 sm:p-8 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-black uppercase tracking-widest text-red-400 bg-red-950/80 px-2.5 py-1 rounded-full inline-flex items-center gap-1.5">
                            <x-icon name="mail" class="w-3.5 h-3.5" />
                            {{ __('ADMIN COMMUNICATION DESK') }}
                        </span>
                        <h1 class="text-2xl font-black mt-2">
                            {{ __('Send Direct Email to Journalist') }}
                        </h1>
                        <p class="text-xs text-slate-400 mt-1">
                            {{ __('Compose and deliver official announcements, article feedback, or assignment notes directly to reporter inboxes.') }}
                        </p>
                    </div>
                </div>

                {{-- Form Body --}}
                <form action="{{ route('admin.email.send') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                    @csrf

                    {{-- Journalist Selection --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Select Recipient Journalist') }} *
                        </label>
                        <select
                            name="journalist_profile_id"
                            required
                            class="w-full text-sm rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 p-3"
                        >
                            <option value="">-- {{ __('Select Journalist') }} --</option>
                            @foreach($journalists as $j)
                                <option
                                    value="{{ $j->id }}"
                                    {{ (isset($journalist) && $journalist->id == $j->id) || old('journalist_profile_id') == $j->id ? 'selected' : '' }}
                                >
                                    {{ $j->user->name ?? 'Journalist' }} ({{ $j->user->email ?? 'No email' }}) {{ $j->is_verified ? '✓ [Verified]' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('journalist_profile_id')
                            <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Subject --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Email Subject') }} *
                        </label>
                        <input
                            type="text"
                            name="subject"
                            required
                            placeholder="{{ __('e.g., Notice Regarding Article Submission & Editorial Guidelines') }}"
                            class="w-full text-sm rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 p-3"
                            value="{{ old('subject') }}"
                        >
                        @error('subject')
                            <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Message Body --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Email Message Body') }} *
                        </label>
                        <textarea
                            name="message"
                            rows="8"
                            required
                            placeholder="{{ __('Write your official message or instructions for the journalist here...') }}"
                            class="w-full text-sm rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 p-3 leading-relaxed"
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.journalists.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">
                            ← {{ __('Back to Journalists') }}
                        </a>

                        <button
                            type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold text-sm px-8 py-3 rounded-xl transition shadow-md flex items-center gap-2"
                        >
                            <x-icon name="paper-airplane" class="w-4 h-4" />
                            <span>{{ __('Send Email Now') }}</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
