<x-app-layout>

    <div class="min-h-screen bg-gray-100 py-10">

        <div class="max-w-6xl mx-auto px-4 sm:px-6">

            {{-- Page Header --}}
            <div class="mb-8">

                <h1 class="text-3xl font-bold text-gray-900">
                    Edit Journalist Profile
                </h1>

                <p class="text-gray-500 mt-2">
                    Update your professional information and portfolio.
                </p>

            </div>


            {{-- Profile Form --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">

                <form
                    method="POST"
                    action="{{ route('journalist.profile.update') }}"
                    enctype="multipart/form-data"
                >

                    @csrf

                    @method('PATCH')


                    {{-- Basic Information --}}
                    <div class="mb-10">

                        <h2 class="text-xl font-bold text-gray-900 mb-6">
                            Basic Information
                        </h2>


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Designation --}}
                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Designation
                                </label>

                                <input
                                    type="text"
                                    name="designation"
                                    value="{{ old('designation', $profile?->designation) }}"
                                    placeholder="Technology Journalist"
                                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                                >

                                @error('designation')
                                    <p class="text-red-600 text-sm mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Organization --}}
                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Organization
                                </label>

                                <input
                                    type="text"
                                    name="organization"
                                    value="{{ old('organization', $profile?->organization) }}"
                                    placeholder="News Portal"
                                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                                >

                                @error('organization')
                                    <p class="text-red-600 text-sm mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Headline --}}
                            <div class="md:col-span-2">

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Professional Headline
                                </label>

                                <input
                                    type="text"
                                    name="headline"
                                    value="{{ old('headline', $profile?->headline) }}"
                                    placeholder="Technology, Science & Current Affairs Journalist"
                                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                                >

                            </div>


                            {{-- Location --}}
                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Location
                                </label>

                                <input
                                    type="text"
                                    name="location"
                                    value="{{ old('location', $profile?->location) }}"
                                    placeholder="Dhaka, Bangladesh"
                                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                                >

                            </div>


                            {{-- Phone --}}
                            <div>

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone', $profile?->phone) }}"
                                    placeholder="+880..."
                                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                                >

                            </div>


                            {{-- Website --}}
                            <div class="md:col-span-2">

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Website
                                </label>

                                <input
                                    type="url"
                                    name="website"
                                    value="{{ old('website', $profile?->website) }}"
                                    placeholder="https://example.com"
                                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- About --}}
                    <div class="mb-10">

                        <h2 class="text-xl font-bold text-gray-900 mb-6">
                            About Me
                        </h2>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Biography
                        </label>

                        <textarea
                            name="bio"
                            rows="6"
                            placeholder="Write your professional biography..."
                            class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                        >{{ old('bio', $profile?->bio) }}</textarea>

                    </div>


                    {{-- Experience --}}
                    <div class="mb-10">

                        <h2 class="text-xl font-bold text-gray-900 mb-6">
                            Professional Experience
                        </h2>

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Years of Experience
                            </label>

                            <input
                                type="number"
                                min="0"
                                name="experience_years"
                                value="{{ old('experience_years', $profile?->experience_years ?? 0) }}"
                                class="w-full md:w-1/2 rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                            >

                        </div>

                    </div>


                    {{-- Profile Image --}}
                    <div class="mb-10">

                        <h2 class="text-xl font-bold text-gray-900 mb-6">
                            Profile Photo
                        </h2>

                        @if($profile?->profile_image)

                            <div class="mb-4">

                                <img
                                    src="{{ asset('storage/' . $profile->profile_image) }}"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-gray-100"
                                    alt="Profile"
                                >

                            </div>

                        @endif


                        <input
                            type="file"
                            name="profile_image"
                            accept="image/*"
                            class="block w-full text-sm text-gray-600"
                        >

                    </div>


                    {{-- Cover Image --}}
                    <div class="mb-10">

                        <h2 class="text-xl font-bold text-gray-900 mb-6">
                            Cover Image
                        </h2>

                        @if($profile?->cover_image)

                            <div class="mb-4">

                                <img
                                    src="{{ asset('storage/' . $profile->cover_image) }}"
                                    class="w-full max-h-60 object-cover rounded-xl"
                                    alt="Cover"
                                >

                            </div>

                        @endif


                        <input
                            type="file"
                            name="cover_image"
                            accept="image/*"
                            class="block w-full text-sm text-gray-600"
                        >

                    </div>


                    {{-- Submit --}}
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">

                        <a
                            href="{{ route('journalist.dashboard') }}"
                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50"
                        >
                            Cancel
                        </a>


                        <button
                            type="submit"
                            class="px-8 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition"
                        >
                            Save Profile
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>