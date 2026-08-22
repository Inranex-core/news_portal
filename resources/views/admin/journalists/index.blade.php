<x-app-layout>

    <div class="min-h-screen bg-slate-100/70 py-8 sm:py-12">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER CARD --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                            <span>📰 {{ __('Manage Journalists') }}</span>
                            <span class="text-xs font-extrabold bg-slate-100 text-slate-700 px-3 py-1 rounded-full border border-slate-200">
                                {{ $journalists->total() }}
                            </span>
                        </h1>
                    </div>
                    <p class="text-sm font-medium text-slate-500 mt-1">
                        {{ __('View, verify, invite, and manage accredited journalists.') }}
                    </p>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    @if(isset($pendingCount) && $pendingCount > 0)
                        <a
                            href="{{ route('admin.journalists.pending') }}"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 font-extrabold text-xs transition shadow-xs"
                        >
                            <span>⏳ {{ __('Pending Approvals') }}</span>
                            <span class="bg-amber-600 text-white px-2 py-0.5 rounded-full text-[11px]">
                                {{ $pendingCount }}
                            </span>
                        </a>
                    @endif

                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                        ← {{ __('Dashboard') }}
                    </a>
                </div>
            </div>


            {{-- DIRECT INVITATION CARD --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">✉️</span>
                    <div>
                        <h3 class="text-base font-black text-slate-900">
                            {{ __('Send Direct Email Invitation') }}
                        </h3>
                        <p class="text-xs font-medium text-slate-500">
                            {{ __('Invite a correspondent directly. An invitation link will be emailed to set their password and activate their account.') }}
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.journalists.invite') }}" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 items-end pt-2">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('Full Name') }} *</label>
                        <input type="text" name="name" required placeholder="e.g. Tariqul Islam" class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('Email Address') }} *</label>
                        <input type="email" name="email" required placeholder="journalist@news.com" class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('Designation') }}</label>
                        <input type="text" name="designation" placeholder="e.g. Senior Reporter" class="w-full rounded-2xl border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
                    </div>

                    <div>
                        <button type="submit" class="w-full py-2.5 px-6 rounded-2xl bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-700 hover:to-rose-800 text-white font-black text-xs shadow-md shadow-red-600/25 transition">
                            🚀 {{ __('Send Email Invite') }}
                        </button>
                    </div>
                </form>
            </div>


            {{-- ALERTS --}}
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 text-rose-800 text-xs font-bold border border-rose-200">
                    ⚠️ {{ session('error') }}
                </div>
            @endif


            {{-- TABLE CONTAINER --}}
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-lg font-black text-slate-900">
                        {{ __('Active Journalists') }}
                    </h2>
                    <span class="text-xs font-bold text-slate-500">
                        {{ __('Showing') }} {{ $journalists->count() }} {{ __('of') }} {{ $journalists->total() }}
                    </span>
                </div>

                @if($journalists->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-700">
                            <thead class="bg-slate-50/80 text-xs uppercase font-extrabold text-slate-500 border-b border-slate-200/80">
                                <tr>
                                    <th class="px-6 py-4">{{ __('Journalist') }}</th>
                                    <th class="px-6 py-4">{{ __('Designation') }}</th>
                                    <th class="px-6 py-4">{{ __('Organization') }}</th>
                                    <th class="px-6 py-4">{{ __('Status') }}</th>
                                    <th class="px-6 py-4 text-right">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @foreach($journalists as $journalist)
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($journalist->profile_image)
                                                    <img src="{{ asset('storage/' . $journalist->profile_image) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200" alt="{{ $journalist->user->name }}">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-700 font-black flex items-center justify-center text-sm">
                                                        {{ strtoupper(substr($journalist->user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-extrabold text-slate-900 text-sm">
                                                        {{ $journalist->user->name }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 font-medium">
                                                        {{ $journalist->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-semibold text-slate-700">
                                            {{ $journalist->display_designation }}
                                        </td>
                                        <td class="px-6 py-4 text-xs font-semibold text-slate-700">
                                            {{ $journalist->display_organization ?? __('N/A') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($journalist->is_verified)
                                                <span class="inline-flex items-center gap-1 text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 px-3 py-1 rounded-full">
                                                    ✓ {{ __('Verified') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200 px-3 py-1 rounded-full">
                                                    {{ __('Unverified') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.email.create', $journalist) }}" class="px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold transition">
                                                    ✉️ {{ __('Email') }}
                                                </a>
                                                <a href="{{ route('admin.journalists.show', $journalist) }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                                    👁️ {{ __('View') }}
                                                </a>
                                                <form method="POST" action="{{ route('admin.journalists.verification', $journalist) }}" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold transition">
                                                        {{ $journalist->is_verified ? __('Unverify') : __('Verify') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 border-t border-slate-100">
                        {{ $journalists->links() }}
                    </div>
                @else
                    <div class="p-16 text-center text-slate-500 space-y-3">
                        <div class="text-4xl">📰</div>
                        <h3 class="text-lg font-black text-slate-900">{{ __('No active journalists found') }}</h3>
                        <p class="text-xs font-medium text-slate-500">{{ __('Invite a new journalist using the form above.') }}</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>