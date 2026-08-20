<x-app-layout>

<div class="min-h-screen bg-slate-50 py-10">

    <div class="max-w-3xl mx-auto px-6">

        <div class="bg-white rounded-2xl border p-8">

            <h1 class="text-2xl font-bold mb-2">
                Add Award
            </h1>

            <p class="text-slate-500 mb-8">
                Add your professional achievement.
            </p>


            <form
                method="POST"
                action="{{ route('journalist.award.store') }}"
                enctype="multipart/form-data"
                class="space-y-6"
            >

                @csrf


                <div>

                    <label class="block font-semibold mb-2">
                        Award Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="e.g. Best Sports Journalist Award"
                        class="w-full rounded-xl border-slate-300"
                        required
                    >

                    @error('title')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label class="block font-semibold mb-2">
                        Organization
                    </label>

                    <input
                        type="text"
                        name="organization"
                        value="{{ old('organization') }}"
                        placeholder="Award organization"
                        class="w-full rounded-xl border-slate-300"
                    >

                </div>


                <div>

                    <label class="block font-semibold mb-2">
                        Award Year
                    </label>

                    <input
                        type="number"
                        name="award_year"
                        value="{{ old('award_year') }}"
                        placeholder="{{ date('Y') }}"
                        class="w-full rounded-xl border-slate-300"
                    >

                </div>


                <div>

                    <label class="block font-semibold mb-2">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        placeholder="Describe the achievement..."
                        class="w-full rounded-xl border-slate-300"
                    >{{ old('description') }}</textarea>

                </div>


                <div>

                    <label class="block font-semibold mb-2">
                        Certificate Image
                    </label>

                    <input
                        type="file"
                        name="certificate_image"
                        accept="image/*"
                        class="w-full"
                    >

                </div>


                <div class="flex justify-between pt-5">

                    <a
                        href="{{ route('journalist.award.index') }}"
                        class="px-5 py-3 border rounded-xl"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-red-600 text-white rounded-xl font-semibold"
                    >
                        Save Award
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</x-app-layout>