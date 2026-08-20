<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="max-w-3xl mx-auto px-6">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">

                {{-- Header --}}
                <div class="mb-8">

                    <h1 class="text-3xl font-bold text-slate-900">
                        Add Education
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Add your academic qualification.
                    </p>

                </div>


                {{-- Validation Errors --}}
                @if($errors->any())

                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">

                        <ul class="list-disc ml-5 text-red-600">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- Form --}}
                <form
                    method="POST"
                    action="{{ route('journalist.education.store') }}"
                    class="space-y-6"
                >

                    @csrf


                    {{-- Institution --}}
                    <div>

                        <label
                            for="institution"
                            class="block font-semibold text-slate-700 mb-2"
                        >
                            Institution *
                        </label>

                        <input
                            id="institution"
                            type="text"
                            name="institution"
                            value="{{ old('institution') }}"
                            placeholder="Example: University Name"
                            required
                            class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                        >

                        @error('institution')

                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Degree --}}
                    <div>

                        <label
                            for="degree"
                            class="block font-semibold text-slate-700 mb-2"
                        >
                            Degree *
                        </label>

                        <input
                            id="degree"
                            type="text"
                            name="degree"
                            value="{{ old('degree') }}"
                            placeholder="Example: BSc in Computer Science & Engineering"
                            required
                            class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                        >

                        @error('degree')

                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Field of Study --}}
                    <div>

                        <label
                            for="field_of_study"
                            class="block font-semibold text-slate-700 mb-2"
                        >
                            Field of Study
                        </label>

                        <input
                            id="field_of_study"
                            type="text"
                            name="field_of_study"
                            value="{{ old('field_of_study') }}"
                            placeholder="Example: Computer Science & Engineering"
                            class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                        >

                        @error('field_of_study')

                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Years --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Start Year --}}
                        <div>

                            <label
                                for="start_year"
                                class="block font-semibold text-slate-700 mb-2"
                            >
                                Start Year
                            </label>

                            <input
                                id="start_year"
                                type="number"
                                name="start_year"
                                value="{{ old('start_year') }}"
                                min="1900"
                                max="2100"
                                placeholder="2022"
                                class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                            >

                            @error('start_year')

                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- End Year --}}
                        <div>

                            <label
                                for="end_year"
                                class="block font-semibold text-slate-700 mb-2"
                            >
                                End Year
                            </label>

                            <input
                                id="end_year"
                                type="number"
                                name="end_year"
                                value="{{ old('end_year') }}"
                                min="1900"
                                max="2100"
                                placeholder="2026"
                                class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                            >

                            @error('end_year')

                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>


                    {{-- Description --}}
                    <div>

                        <label
                            for="description"
                            class="block font-semibold text-slate-700 mb-2"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            placeholder="Additional information about your education..."
                            class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                        >{{ old('description') }}</textarea>

                        @error('description')

                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Buttons --}}
                    <div class="flex items-center justify-between pt-4">

                        <a
                            href="{{ route('journalist.education.index') }}"
                            class="px-5 py-3 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50"
                        >
                            ← Cancel
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-3 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700"
                        >
                            Save Education
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>