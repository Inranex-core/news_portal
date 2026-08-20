<x-app-layout>

    <div class="min-h-screen bg-gray-100 py-10">

        <div class="max-w-5xl mx-auto px-6">

            {{-- Header --}}
            <div class="mb-8">

                <a
                    href="{{ route('journalist.dashboard') }}"
                    class="text-red-600 font-semibold"
                >
                    ← Back to Dashboard
                </a>

                <h1 class="text-3xl font-bold text-gray-900 mt-4">
                    Edit Journalist Profile
                </h1>

                <p class="text-gray-500 mt-2">
                    Update your professional journalist portfolio.
                </p>

            </div>


            {{-- Success --}}
            @if(session('success'))

                <div class="mb-6 rounded-xl bg-green-100
                            border border-green-200
                            px-5 py-4 text-green-800">

                    {{ session('success') }}

                </div>

            @endif


            {{-- Errors --}}
            @if($errors->any())

                <div class="mb-6 rounded-xl bg-red-100
                            border border-red-200
                            px-5 py-4 text-red-800">

                    <ul class="list-disc ml-5 space-y-1">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('journalist.profile.update') }}"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PATCH')


                {{-- Profile Images --}}
                <div class="bg-white rounded-2xl
                            border shadow-sm p-8 mb-6">

                    <h2 class="text-xl font-bold text-gray-900">
                        Profile Images
                    </h2>


                    <div class="grid md:grid-cols-2 gap-8 mt-6">

                        {{-- Profile Image --}}
                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-3">

                                Profile Photo

                            </label>


                            @if($profile->profile_image)

                                <img
                                    src="{{ asset(
                                        'storage/' . $profile->profile_image
                                    ) }}"
                                    class="w-32 h-32 rounded-full
                                           object-cover mb-4"
                                >

                            @else

                                <div class="w-32 h-32 rounded-full
                                            bg-gray-100
                                            flex items-center
                                            justify-center mb-4">

                                    <span class="text-4xl">
                                        👤
                                    </span>

                                </div>

                            @endif


                            <input
                                type="file"
                                name="profile_image"
                                accept="image/*"
                                class="w-full rounded-xl
                                       border border-gray-300
                                       p-3"
                            >

                            <p class="text-xs text-gray-500 mt-2">
                                JPG, PNG or WEBP. Maximum 2MB.
                            </p>

                        </div>


                        {{-- Cover Image --}}
                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-3">

                                Cover Photo

                            </label>


                            @if($profile->cover_image)

                                <img
                                    src="{{ asset(
                                        'storage/' . $profile->cover_image
                                    ) }}"
                                    class="w-full h-32
                                           rounded-xl object-cover mb-4"
                                >

                            @else

                                <div class="w-full h-32 rounded-xl
                                            bg-gradient-to-r
                                            from-red-600 to-gray-900
                                            flex items-center
                                            justify-center mb-4">

                                    <span class="text-white text-2xl">
                                        Cover Photo
                                    </span>

                                </div>

                            @endif


                            <input
                                type="file"
                                name="cover_image"
                                accept="image/*"
                                class="w-full rounded-xl
                                       border border-gray-300
                                       p-3"
                            >

                            <p class="text-xs text-gray-500 mt-2">
                                JPG, PNG or WEBP. Maximum 5MB.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Basic Information --}}
                <div class="bg-white rounded-2xl
                            border shadow-sm p-8 mb-6">

                    <h2 class="text-xl font-bold text-gray-900">
                        Basic Information
                    </h2>


                    <div class="grid md:grid-cols-2 gap-6 mt-6">


                        {{-- Name --}}
                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Name

                            </label>

                            <input
                                type="text"
                                value="{{ auth()->user()->name }}"
                                disabled
                                class="w-full rounded-xl
                                       border-gray-300
                                       bg-gray-100"
                            >

                            <p class="text-xs text-gray-500 mt-2">
                                Your account name can be changed from
                                your account profile.
                            </p>

                        </div>


                        {{-- Slug --}}
                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Profile Slug

                            </label>

                            <input
                                type="text"
                                name="slug"
                                value="{{ old(
                                    'slug',
                                    $profile->slug
                                ) }}"
                                class="w-full rounded-xl
                                       border-gray-300
                                       focus:border-red-500
                                       focus:ring-red-500"
                            >

                        </div>


                        {{-- Designation --}}
                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Designation

                            </label>

                            <input
                                type="text"
                                name="designation"
                                value="{{ old(
                                    'designation',
                                    $profile->designation
                                ) }}"
                                placeholder="Senior Journalist"
                                class="w-full rounded-xl
                                       border-gray-300
                                       focus:border-red-500
                                       focus:ring-red-500"
                            >

                        </div>


                        {{-- Organization --}}
                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Organization

                            </label>

                            <input
                                type="text"
                                name="organization"
                                value="{{ old(
                                    'organization',
                                    $profile->organization
                                ) }}"
                                placeholder="News Organization"
                                class="w-full rounded-xl
                                       border-gray-300
                                       focus:border-red-500
                                       focus:ring-red-500"
                            >

                        </div>


                        {{-- Headline --}}
                        <div class="md:col-span-2">

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Professional Headline

                            </label>

                            <input
                                type="text"
                                name="headline"
                                value="{{ old(
                                    'headline',
                                    $profile->headline
                                ) }}"
                                placeholder="Investigative journalist covering technology and politics"
                                class="w-full rounded-xl
                                       border-gray-300
                                       focus:border-red-500
                                       focus:ring-red-500"
                            >

                        </div>


                        {{-- Bio --}}
                        <div class="md:col-span-2">

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Biography

                            </label>

                            <textarea
                                name="bio"
                                rows="6"
                                placeholder="Write your professional biography..."
                                class="w-full rounded-xl
                                       border-gray-300
                                       focus:border-red-500
                                       focus:ring-red-500"
                            >{{ old(
                                'bio',
                                $profile->bio
                            ) }}</textarea>

                        </div>


                        {{-- Location --}}
                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Location

                            </label>

                            <input
                                type="text"
                                name="location"
                                value="{{ old(
                                    'location',
                                    $profile->location
                                ) }}"
                                placeholder="Dhaka, Bangladesh"
                                class="w-full rounded-xl
                                       border-gray-300
                                       focus:border-red-500
                                       focus:ring-red-500"
                            >

                        </div>


                        {{-- Phone --}}
                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Phone

                            </label>

                            <input
                                type="text"
                                name="phone"
                                value="{{ old(
                                    'phone',
                                    $profile->phone
                                ) }}"
                                placeholder="+880..."
                                class="w-full rounded-xl
                                       border-gray-300
                                       focus:border-red-500
                                       focus:ring-red-500"
                            >

                        </div>


                        {{-- Website --}}
                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Website

                            </label>

                            <input
                                type="url"
                                name="website"
                                value="{{ old(
                                    'website',
                                    $profile->website
                                ) }}"
                                placeholder="https://example.com"
                                class="w-full rounded-xl
                                       border-gray-300
                                       focus:border-red-500
                                       focus:ring-red-500"
                            >

                        </div>


                        {{-- Experience Years --}}
                        <div>

                            <label class="block text-sm font-semibold
                                          text-gray-700 mb-2">

                                Experience (Years)

                            </label>

                            <input
                                type="number"
                                name="experience_years"
                                min="0"
                                max="70"
                                value="{{ old(
                                    'experience_years',
                                    $profile->experience_years
                                ) }}"
                                class="w-full rounded-xl
                                       border-gray-300
                                       focus:border-red-500
                                       focus:ring-red-500"
                            >

                        </div>

                    </div>

                </div>


                {{-- Save --}}
                <div class="flex items-center
                            justify-end gap-4">

                    <a
                        href="{{ route('journalist.dashboard') }}"
                        class="px-6 py-3 rounded-xl
                               border border-gray-300
                               text-gray-700
                               font-semibold
                               hover:bg-gray-50"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="px-7 py-3 rounded-xl
                               bg-red-600 text-white
                               font-semibold
                               hover:bg-red-700"
                    >
                        Save Profile
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>