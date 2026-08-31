<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="max-w-6xl mx-auto px-4 sm:px-6">

            <div class="flex items-center justify-between mb-8">

                <div>
                    <h1 class="text-3xl font-bold text-slate-900">
                        Education
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Manage your academic qualifications.
                    </p>
                </div>

                <a
                    href="{{ route('journalist.education.create') }}"
                    class="px-5 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700"
                >
                    + Add Education
                </a>

            </div>


            @if(session('success'))

                <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700">
                    {{ session('success') }}
                </div>

            @endif


            <div class="space-y-6">

                @forelse($educations as $education)

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                        <div class="flex items-start justify-between gap-6">

                            <div>

                                <h2 class="text-xl font-bold text-slate-900">
                                    {{ $education->degree }}
                                </h2>

                                <p class="mt-1 font-semibold text-red-600">
                                    {{ $education->institution }}
                                </p>


                                @if($education->field_of_study)

                                    <p class="mt-2 text-slate-600">
                                        {{ $education->field_of_study }}
                                    </p>

                                @endif


                                @if($education->start_year || $education->end_year)

                                    <p class="mt-2 text-sm text-slate-500">

                                        {{ $education->start_year ?? '' }}

                                        @if($education->end_year)
                                            - {{ $education->end_year }}
                                        @endif

                                    </p>

                                @endif


                                @if($education->description)

                                    <p class="mt-4 text-slate-600 leading-7">
                                        {{ $education->description }}
                                    </p>

                                @endif

                            </div>


                            <div class="flex gap-2">

                                <a
                                    href="{{ route('journalist.education.edit', $education) }}"
                                    class="px-4 py-2 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50"
                                >
                                    Edit
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route('journalist.education.destroy', $education) }}"
                                    onsubmit="return confirm('Delete this education record?')"
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

                    </div>

                @empty

                    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">

                        <div class="text-5xl mb-4 text-slate-300 flex justify-center">
                            <x-icon name="briefcase" class="w-12 h-12" />
                        </div>

                        <h2 class="text-xl font-bold text-slate-900">
                            No Education Added
                        </h2>

                        <p class="text-slate-500 mt-2">
                            Add your academic qualifications.
                        </p>

                        <a
                            href="{{ route('journalist.education.create') }}"
                            class="inline-block mt-5 px-5 py-3 bg-red-600 text-white rounded-lg font-semibold"
                        >
                            Add Education
                        </a>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</x-app-layout>