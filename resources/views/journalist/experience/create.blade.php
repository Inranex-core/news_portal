<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="max-w-3xl mx-auto px-6">

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

                <div class="mb-8">

                    <h1 class="text-3xl font-bold text-slate-900">
                        Add Professional Experience
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Add your journalism career information.
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('journalist.experience.store') }}"
                    class="space-y-6"
                >

                    @csrf


                    {{-- Organization --}}
                    <div>

                        <label class="block font-semibold text-slate-700 mb-2">
                            Organization
                        </label>

                        <input
                            type="text"
                            name="organization"
                            value="{{ old('organization') }}"
                            placeholder="Example: Amar Desh"
                            class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                            required
                        >

                        @error('organization')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Designation --}}
                    <div>

                        <label class="block font-semibold text-slate-700 mb-2">
                            Designation
                        </label>

                        <input
                            type="text"
                            name="designation"
                            value="{{ old('designation') }}"
                            placeholder="Example: Sports Journalist"
                            class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                            required
                        >

                        @error('designation')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Start Date --}}
                    <div>

                        <label class="block font-semibold text-slate-700 mb-2">
                            Start Date
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            value="{{ old('start_date') }}"
                            class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                            required
                        >

                        @error('start_date')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Current Job --}}
                    <div class="flex items-center gap-3">

                        <input
                            type="checkbox"
                            name="is_current"
                            value="1"
                            id="is_current"
                            {{ old('is_current') ? 'checked' : '' }}
                            class="rounded border-slate-300 text-red-600 focus:ring-red-500"
                        >

                        <label
                            for="is_current"
                            class="font-medium text-slate-700"
                        >
                            I currently work here
                        </label>

                    </div>


                    {{-- End Date --}}
                    <div>

                        <label class="block font-semibold text-slate-700 mb-2">
                            End Date
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            value="{{ old('end_date') }}"
                            class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                        >

                        <p class="text-sm text-slate-500 mt-1">
                            Leave empty if this is your current job.
                        </p>

                        @error('end_date')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Description --}}
                    <div>

                        <label class="block font-semibold text-slate-700 mb-2">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="5"
                            placeholder="Describe your responsibilities and achievements..."
                            class="w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Buttons --}}
                    <div class="flex justify-between pt-4">

                        <a
                            href="{{ route('journalist.experience.index') }}"
                            class="px-5 py-3 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50"
                        >
                            ← Cancel
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700"
                        >
                            Save Experience
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>