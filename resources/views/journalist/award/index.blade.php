<x-app-layout>

<div class="min-h-screen bg-slate-50 py-10">

    <div class="max-w-5xl mx-auto px-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-3xl font-bold text-slate-900">
                    Awards & Achievements
                </h1>

                <p class="text-slate-500 mt-2">
                    Recognition and professional achievements
                </p>
            </div>

            <a
                href="{{ route('journalist.award.create') }}"
                class="px-5 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700"
            >
                + Add Award
            </a>

        </div>


        {{-- Success --}}
        @if(session('success'))

            <div class="mb-6 rounded-xl bg-green-100 text-green-800 px-5 py-4">
                {{ session('success') }}
            </div>

        @endif


        {{-- Awards --}}
        @forelse($awards as $award)

            <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-5 shadow-sm">

                <div class="flex justify-between gap-6">

                    <div>

                        <h2 class="text-xl font-bold text-slate-900">
                            {{ $award->title }}
                        </h2>

                        @if($award->organization)

                            <p class="text-red-600 font-semibold mt-1">
                                {{ $award->organization }}
                            </p>

                        @endif

                        @if($award->award_year)

                            <p class="text-slate-500 mt-2">
                                {{ $award->award_year }}
                            </p>

                        @endif

                        @if($award->description)

                            <p class="text-slate-600 mt-4">
                                {{ $award->description }}
                            </p>

                        @endif

                    </div>


                    <div class="flex gap-2">

                        <a
                            href="{{ route('journalist.award.edit', $award) }}"
                            class="px-4 py-2 border rounded-lg"
                        >
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="{{ route('journalist.award.destroy', $award) }}"
                            onsubmit="return confirm('Delete this award?')"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg"
                            >
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div class="bg-white rounded-2xl border p-10 text-center">

                <div class="text-5xl mb-4">
                    🏆
                </div>

                <h2 class="text-xl font-bold">
                    No awards added yet.
                </h2>

                <p class="text-slate-500 mt-2">
                    Add your professional awards and achievements.
                </p>

            </div>

        @endforelse


        {{-- Sequential navigation --}}
        <div class="flex justify-between items-center mt-10">

            <a
                href="{{ route('journalist.education.index') }}"
                class="px-5 py-3 border border-slate-300 rounded-xl"
            >
                ← Education
            </a>

            <a
                href="{{ route('journalist.expertise.index') }}"
                class="px-5 py-3 bg-red-600 text-white rounded-xl font-semibold"
            >
                Next: Expertise →
            </a>

        </div>

    </div>

</div>

</x-app-layout>