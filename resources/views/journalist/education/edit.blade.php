<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="max-w-3xl mx-auto px-6">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">

                <h1 class="text-3xl font-bold text-slate-900">
                    Edit Education
                </h1>

                <p class="mt-2 text-slate-500">
                    Update your academic qualification.
                </p>


                <form
                    method="POST"
                    action="{{ route('journalist.education.update', $education) }}"
                    class="mt-8 space-y-6"
                >

                    @csrf
                    @method('PUT')


                    <div>

                        <label class="block font-semibold text-slate-700 mb-2">
                            Institution *
                        </label>

                        <input
                            type="text"
                            name="institution"
                            value="{{ old('institution', $education->institution) }}"
                            required
                            class="w-full rounded-lg border-slate-300"
                        >

                    </div>


                    <div>

                        <label class="block font-semibold text-slate-700 mb-2">
                            Degree *
                        </label>

                        <input
                            type="text"
                            name="degree"
                            value="{{ old('degree', $education->degree) }}"
                            required
                            class="w-full rounded-lg border-slate-300"
                        >

                    </div>


                    <div>

                        <label class="block font-semibold text-slate-700 mb-2">
                            Field of Study
                        </label>

                        <input
                            type="text"
                            name="field_of_study"
                            value="{{ old('field_of_study', $education->field_of_study) }}"
                            class="w-full rounded-lg border-slate-300"
                        >

                    </div>


                    <div class="grid grid-cols-2 gap-6">

                        <div>

                            <label class="block font-semibold text-slate-700 mb-2">
                                Start Year
                            </label>

                            <input
                                type="number"
                                name="start_year"
                                value="{{ old('start_year', $education->start_year) }}"
                                min="1900"
                                max="2100"
                                class="w-full rounded-lg border-slate-300"
                            >

                        </div>


                        <div>

                            <label class="block font-semibold text-slate-700 mb-2">
                                End Year
                            </label>

                            <input
                                type="number"
                                name="end_year"
                                value="{{ old('end_year', $education->end_year) }}"
                                min="1900"
                                max="2100"
                                class="w-full rounded-lg border-slate-300"
                            >

                        </div>

                    </div>


                    <div>

                        <label class="block font-semibold text-slate-700 mb-2">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="5"
                            class="w-full rounded-lg border-slate-300"
                        >{{ old('description', $education->description) }}</textarea>

                    </div>


                    <div class="flex justify-between pt-4">

                        <a
                            href="{{ route('journalist.education.index') }}"
                            class="px-5 py-3 rounded-lg bg-slate-100 text-slate-700"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-3 rounded-lg bg-red-600 text-white font-semibold"
                        >
                            Update Education
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>