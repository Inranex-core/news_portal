<x-app-layout>
    <div class="min-h-screen bg-slate-100/70 py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- HEADER --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.journalists.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700 bg-slate-100 px-3 py-1 rounded-full">
                            ← {{ __('Back to All Journalists') }}
                        </a>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-2 flex items-center gap-3">
                        <span>⏳ {{ __('Pending Journalist Applications') }}</span>
                        <span class="text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-200 px-3 py-1 rounded-full">
                            {{ $pendingJournalists->total() }}
                        </span>
                    </h1>
                    <p class="text-sm font-medium text-slate-500 mt-1">
                        {{ __('Review and approve public registration applications from prospective journalists.') }}
                    </p>
                </div>
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
                @if($pendingJournalists->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-700">
                            <thead class="bg-slate-50/80 text-xs uppercase font-extrabold text-slate-500 border-b border-slate-200/80">
                                <tr>
                                    <th class="px-6 py-4">{{ __('Applicant') }}</th>
                                    <th class="px-6 py-4">{{ __('Email Verification') }}</th>
                                    <th class="px-6 py-4">{{ __('Applied Date') }}</th>
                                    <th class="px-6 py-4 text-right">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @foreach($pendingJournalists as $applicant)
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-extrabold text-slate-900 text-base">
                                                {{ $applicant->name }}
                                            </div>
                                            <div class="text-xs text-slate-500 font-semibold">
                                                ✉️ {{ $applicant->email }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($applicant->email_verified_at)
                                                <span class="inline-flex items-center gap-1 text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full">
                                                    ✓ {{ __('Verified') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full">
                                                    ⏳ {{ __('Unverified OTP') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-xs font-semibold text-slate-500">
                                            {{ $applicant->created_at->format('M d, Y h:i A') }}
                                        </td>
                                        <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                            <form method="POST" action="{{ route('admin.journalists.approve', $applicant) }}" class="inline-block" onsubmit="return confirm('{{ __('Approve this user as an active Journalist?') }}')">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black rounded-xl shadow-sm transition"
                                                >
                                                    ✓ {{ __('Approve') }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.journalists.reject', $applicant) }}" class="inline-block" onsubmit="return confirm('{{ __('Are you sure you want to reject and delete this application?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-black rounded-xl shadow-sm transition"
                                                >
                                                    ✕ {{ __('Reject') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 border-t border-slate-100">
                        {{ $pendingJournalists->links() }}
                    </div>
                @else
                    <div class="p-16 text-center text-slate-500 space-y-3">
                        <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-3xl font-black">
                            ✓
                        </div>
                        <h3 class="text-lg font-black text-slate-900">
                            {{ __('No pending applications') }}
                        </h3>
                        <p class="text-xs font-medium text-slate-500">
                            {{ __('All journalist registration requests have been processed.') }}
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
