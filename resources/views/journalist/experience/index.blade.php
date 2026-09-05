<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="max-w-6xl mx-auto px-4 sm:px-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">

                <div>
                    <h1 class="text-3xl font-bold text-slate-900">
                        Professional Experience
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Manage your professional journalism experience.
                    </p>
                </div>

                @if(auth()->user()->isApproved())
                    <a
                        href="{{ route('journalist.experience.create') }}"
                        class="px-5 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700"
                    >
                        + Add Experience
                    </a>
                @else
                    <button
                        type="button"
                        disabled
                        class="px-5 py-3 bg-slate-300 text-slate-500 rounded-lg font-semibold cursor-not-allowed opacity-60 pointer-events-none"
                    >
                        🔒 + Add Experience
                    </button>
                @endif

            </div>

            @if(!auth()->user()->isApproved())
                <div class="mb-6 bg-amber-50 border-2 border-amber-400 p-4 rounded-2xl flex items-center justify-between gap-3 text-amber-900 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">⏳</span>
                        <div>
                            <p class="text-sm font-black">{{ __('Account Pending Admin Approval') }}</p>
                            <p class="text-xs font-semibold text-amber-700">{{ __('Managing experience is in read-only mode until an administrator approves your account.') }}</p>
                        </div>
                    </div>
                    <span class="bg-amber-200 text-amber-900 text-xs font-black px-3 py-1 rounded-full shrink-0">🔒 {{ __('Read Only Mode') }}</span>
                </div>
            @endif


            {{-- Success Message --}}
            @if(session('success'))

                <div class="mb-6 rounded-lg bg-green-100 border border-green-200 px-5 py-4 text-green-800">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Validation Errors --}}
            @if($errors->any())

                <div class="mb-6 rounded-lg bg-red-100 border border-red-200 px-5 py-4 text-red-800">

                    <ul class="list-disc ml-5">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- Experiences --}}
            <div class="space-y-6">

                @forelse($experiences as $experience)

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                        <div class="flex items-start justify-between gap-6">

                            <div>

                                <h2 class="text-xl font-bold text-slate-900">
                                    {{ $experience->designation }}
                                </h2>

                                <p class="text-red-600 font-semibold mt-1">
                                    {{ $experience->organization }}
                                </p>

                                <p class="text-sm text-slate-500 mt-2">

                                    {{ $experience->start_date?->format('M Y') }}

                                    -

                                    @if($experience->is_current)

                                        <span class="text-green-600 font-semibold">
                                            Present
                                        </span>

                                    @else

                                        {{ $experience->end_date?->format('M Y') }}

                                    @endif

                                </p>

                            </div>


                            {{-- Actions --}}
                            <div class="flex gap-2">

                                <a
                                    href="{{ route('journalist.experience.edit', $experience) }}"
                                    class="px-4 py-2 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50"
                                >
                                    Edit
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route('journalist.experience.destroy', $experience) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this experience?')"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-4 py-2 rounded-lg border border-red-200 text-red-600 hover:bg-red-50"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </div>


                        @if($experience->description)

                            <div class="mt-5 pt-5 border-t border-slate-100">

                                <p class="text-slate-600 leading-7">
                                    {{ $experience->description }}
                                </p>

                            </div>

                        @endif

                    </div>

                @empty

                    <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center">

                        <div class="text-5xl mb-4 text-slate-300 flex justify-center">
                            <x-icon name="briefcase" class="w-12 h-12" />
                        </div>

                        <h3 class="text-xl font-bold text-slate-800">
                            No professional experience yet
                        </h3>

                        <p class="text-slate-500 mt-2">
                            Add your first professional experience.
                        </p>

                        <a
                            href="{{ route('journalist.experience.create') }}"
                            class="inline-block mt-5 px-5 py-3 bg-red-600 text-white rounded-lg font-semibold"
                        >
                            Add Experience
                        </a>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</x-app-layout>