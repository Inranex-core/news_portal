<x-app-layout>

<div class="min-h-screen bg-slate-50 py-10">

    <div class="max-w-5xl mx-auto px-6">

        {{-- Header --}}
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-slate-900">
                Areas of Expertise
            </h1>

            <p class="text-slate-500 mt-2">
                Select the topics you specialize in.
            </p>

        </div>


        {{-- Success Message --}}
        @if(session('success'))

            <div class="mb-6 bg-green-100 text-green-800 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>

        @endif


        {{-- Validation Errors --}}
        @if($errors->any())

            <div class="mb-6 bg-red-100 text-red-700 px-5 py-4 rounded-xl">

                <ul class="list-disc ml-5">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Expertise Form --}}
        <form
            method="POST"
            action="{{ route('journalist.expertise.update') }}"
        >

            @csrf
            @method('PATCH')


            <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">

                @if($expertises->count())

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                        @foreach($expertises as $expertise)

                            <label
                                class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:border-red-400 hover:bg-red-50 transition"
                            >

                                <input
                                    type="checkbox"
                                    name="expertises[]"
                                    value="{{ $expertise->id }}"
                                    {{ in_array($expertise->id, $selectedExpertises) ? 'checked' : '' }}
                                    class="rounded text-red-600 focus:ring-red-500"
                                >

                                <span class="font-medium text-slate-800">
                                    {{ $expertise->name }}
                                </span>

                            </label>

                        @endforeach

                    </div>

                @else

                    <div class="text-center py-10">

                        <div class="text-5xl mb-4">
                            🎯
                        </div>

                        <h2 class="text-xl font-bold text-slate-900">
                            No expertise available
                        </h2>

                        <p class="text-slate-500 mt-2">
                            No expertise topics have been added yet.
                        </p>

                    </div>

                @endif


                @if($expertises->count())

                    <div class="flex justify-end mt-8">

                        <button
                            type="submit"
                            class="px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700"
                        >
                            Save Expertise
                        </button>

                    </div>

                @endif

            </div>

        </form>


        {{-- Sequential Navigation --}}
        <div class="flex justify-between items-center mt-10">

            <a
                href="{{ route('journalist.award.index') }}"
                class="px-5 py-3 border border-slate-300 rounded-xl bg-white"
            >
                ← Awards
            </a>


            <a
                href="{{ route(
                    'journalists.show',
                    $profile->slug
                ) }}"
                class="px-5 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700"
            >
                View Public Profile →
            </a>

        </div>

    </div>

</div>

</x-app-layout>