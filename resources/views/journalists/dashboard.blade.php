<x-app-layout>

    <div class="min-h-screen bg-gray-100">

        {{-- Header --}}
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-6 py-8">

                <div class="flex flex-col md:flex-row
                            md:items-center md:justify-between gap-5">

                    <div>

                        <h1 class="text-3xl font-bold text-gray-900">
                            Journalist Dashboard
                        </h1>

                        <p class="mt-2 text-gray-500">
                            Manage your professional journalist portfolio.
                        </p>

                    </div>

                    @if($profile)

                        <a href="{{ route('journalist.profile.edit') }}"
                           class="inline-flex items-center justify-center
                                  px-6 py-3 rounded-xl
                                  bg-red-600 text-white
                                  font-semibold
                                  hover:bg-red-700">

                            ✏️ Edit Profile

                        </a>

                    @endif

                </div>

            </div>
        </div>


        <div class="max-w-7xl mx-auto px-6 py-10">

            @if(!$profile)

                {{-- No Profile --}}
                <div class="bg-white rounded-2xl border
                            shadow-sm p-10 text-center">

                    <div class="text-6xl mb-5">
                        📰
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900">
                        Create Your Journalist Profile
                    </h2>

                    <p class="text-gray-500 mt-3">
                        You don't have a journalist profile yet.
                    </p>

                    <a href="{{ route('journalist.profile.edit') }}"
                       class="inline-block mt-6 px-6 py-3
                              bg-red-600 text-white
                              rounded-xl font-semibold
                              hover:bg-red-700">

                        Create Profile

                    </a>

                </div>

            @else

                {{-- Profile Card --}}
                <div class="bg-white rounded-3xl border
                            shadow-sm overflow-hidden mb-8">

                    {{-- Cover --}}
                    <div class="h-48 bg-gradient-to-r
                                from-red-600 via-red-700
                                to-gray-900">

                        @if($profile->cover_image)

                            <img
                                src="{{ asset('storage/' . $profile->cover_image) }}"
                                alt="Cover Image"
                                class="w-full h-full object-cover"
                            >

                        @endif

                    </div>


                    <div class="px-8 pb-8">

                        <div class="-mt-16 flex flex-col
                                    md:flex-row md:items-end
                                    md:justify-between gap-6">

                            {{-- Profile info --}}
                            <div class="flex items-end gap-5">

                                @if($profile->profile_image)

                                    <img
                                        src="{{ asset('storage/' . $profile->profile_image) }}"
                                        alt="{{ $profile->user->name }}"
                                        class="w-32 h-32 rounded-full
                                               object-cover border-4
                                               border-white shadow-lg"
                                    >

                                @else

                                    <div class="w-32 h-32 rounded-full
                                                bg-gray-100
                                                border-4 border-white
                                                shadow-lg
                                                flex items-center
                                                justify-center">

                                        <span class="text-5xl font-bold
                                                     text-gray-500">

                                            {{ strtoupper(
                                                substr(
                                                    $profile->user->name,
                                                    0,
                                                    1
                                                )
                                            ) }}

                                        </span>

                                    </div>

                                @endif


                                <div class="pb-2">

                                    <div class="flex flex-wrap
                                                items-center gap-3">

                                        <h2 class="text-3xl font-bold
                                                   text-gray-900">

                                            {{ $profile->user->name }}

                                        </h2>


                                        @if($profile->is_verified)

                                            <span class="px-3 py-1
                                                         rounded-full
                                                         bg-blue-100
                                                         text-blue-700
                                                         text-sm
                                                         font-semibold">

                                                ✓ Verified Journalist

                                            </span>

                                        @else

                                            <span class="px-3 py-1
                                                         rounded-full
                                                         bg-yellow-100
                                                         text-yellow-700
                                                         text-sm
                                                         font-semibold">

                                                Pending Verification

                                            </span>

                                        @endif

                                    </div>


                                    <p class="text-red-600
                                              font-semibold mt-1">

                                        {{ $profile->designation
                                            ?? 'Journalist' }}

                                    </p>


                                    @if($profile->organization)

                                        <p class="text-gray-600 mt-1">

                                            {{ $profile->organization }}

                                        </p>

                                    @endif

                                </div>

                            </div>


                            {{-- Profile URL --}}
                            <div>

                                <a
                                    href="{{ route(
                                        'journalists.show',
                                        $profile->slug
                                    ) }}"
                                    target="_blank"
                                    class="inline-flex items-center
                                           px-5 py-3 rounded-xl
                                           border border-gray-300
                                           text-gray-700
                                           font-semibold
                                           hover:bg-gray-50">

                                    👁 View Public Profile

                                </a>

                            </div>

                        </div>


                        {{-- Location / website --}}
                        <div class="flex flex-wrap gap-6
                                    mt-8 text-gray-600">

                            @if($profile->location)

                                <span>
                                    📍 {{ $profile->location }}
                                </span>

                            @endif


                            @if($profile->website)

                                <a href="{{ $profile->website }}"
                                   target="_blank"
                                   class="text-red-600
                                          hover:underline">

                                    🌐 Website

                                </a>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- Statistics --}}
                <div class="grid grid-cols-1 sm:grid-cols-2
                            lg:grid-cols-4 gap-6 mb-8">


                    {{-- Experience --}}
                    <div class="bg-white rounded-2xl border
                                shadow-sm p-6">

                        <div class="flex items-center
                                    justify-between">

                            <div>

                                <p class="text-sm text-gray-500">
                                    Experience
                                </p>

                                <h3 class="text-3xl font-bold
                                           text-gray-900 mt-2">

                                    {{ $profile->experiences->count() }}

                                </h3>

                            </div>

                            <div class="w-12 h-12 rounded-xl
                                        bg-red-100
                                        flex items-center
                                        justify-center text-xl">

                                💼

                            </div>

                        </div>

                    </div>


                    {{-- Education --}}
                    <div class="bg-white rounded-2xl border
                                shadow-sm p-6">

                        <div class="flex items-center
                                    justify-between">

                            <div>

                                <p class="text-sm text-gray-500">
                                    Education
                                </p>

                                <h3 class="text-3xl font-bold
                                           text-gray-900 mt-2">

                                    {{ $profile->educations->count() }}

                                </h3>

                            </div>

                            <div class="w-12 h-12 rounded-xl
                                        bg-blue-100
                                        flex items-center
                                        justify-center text-xl">

                                🎓

                            </div>

                        </div>

                    </div>


                    {{-- Expertise --}}
                    <div class="bg-white rounded-2xl border
                                shadow-sm p-6">

                        <div class="flex items-center
                                    justify-between">

                            <div>

                                <p class="text-sm text-gray-500">
                                    Expertise
                                </p>

                                <h3 class="text-3xl font-bold
                                           text-gray-900 mt-2">

                                    {{ $profile->expertises->count() }}

                                </h3>

                            </div>

                            <div class="w-12 h-12 rounded-xl
                                        bg-purple-100
                                        flex items-center
                                        justify-center text-xl">

                                🎯

                            </div>

                        </div>

                    </div>


                    {{-- Awards --}}
                    <div class="bg-white rounded-2xl border
                                shadow-sm p-6">

                        <div class="flex items-center
                                    justify-between">

                            <div>

                                <p class="text-sm text-gray-500">
                                    Awards
                                </p>

                                <h3 class="text-3xl font-bold
                                           text-gray-900 mt-2">

                                    {{ $profile->awards->count() }}

                                </h3>

                            </div>

                            <div class="w-12 h-12 rounded-xl
                                        bg-yellow-100
                                        flex items-center
                                        justify-center text-xl">

                                🏆

                            </div>

                        </div>

                    </div>

                </div>


                {{-- About --}}
                <div class="bg-white rounded-2xl border
                            shadow-sm p-8 mb-8">

                    <div class="flex items-center
                                justify-between">

                        <div>

                            <h2 class="text-xl font-bold
                                       text-gray-900">

                                About Me

                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                Professional biography
                            </p>

                        </div>

                        <a href="{{ route('journalist.profile.edit') }}"
                           class="text-red-600 font-semibold">

                            Edit

                        </a>

                    </div>


                    <p class="text-gray-600 mt-6 leading-7">

                        {{ $profile->bio
                            ?? 'No biography added yet.' }}

                    </p>

                </div>


                {{-- Quick Management --}}
                <div class="mb-5">

                    <h2 class="text-2xl font-bold text-gray-900">
                        Portfolio Management
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Manage your professional information.
                    </p>

                </div>


                <div class="grid grid-cols-1 md:grid-cols-2
                            lg:grid-cols-4 gap-6">


                    {{-- Experience --}}
                    <a href="#"
                       class="bg-white rounded-2xl border
                              shadow-sm p-6
                              hover:-translate-y-1
                              transition">

                        <div class="w-12 h-12 rounded-xl
                                    bg-red-100
                                    flex items-center
                                    justify-center text-xl mb-5">

                            💼

                        </div>

                        <h3 class="font-bold text-gray-900 text-lg">
                            Experience
                        </h3>

                        <p class="text-gray-500 text-sm mt-2">
                            Add your professional career history.
                        </p>

                    </a>


                    {{-- Education --}}
                    <a href="#"
                       class="bg-white rounded-2xl border
                              shadow-sm p-6
                              hover:-translate-y-1
                              transition">

                        <div class="w-12 h-12 rounded-xl
                                    bg-blue-100
                                    flex items-center
                                    justify-center text-xl mb-5">

                            🎓

                        </div>

                        <h3 class="font-bold text-gray-900 text-lg">
                            Education
                        </h3>

                        <p class="text-gray-500 text-sm mt-2">
                            Manage academic background.
                        </p>

                    </a>


                    {{-- Expertise --}}
                    <a href="#"
                       class="bg-white rounded-2xl border
                              shadow-sm p-6
                              hover:-translate-y-1
                              transition">

                        <div class="w-12 h-12 rounded-xl
                                    bg-purple-100
                                    flex items-center
                                    justify-center text-xl mb-5">

                            🎯

                        </div>

                        <h3 class="font-bold text-gray-900 text-lg">
                            Expertise
                        </h3>

                        <p class="text-gray-500 text-sm mt-2">
                            Add topics and areas you specialize in.
                        </p>

                    </a>


                    {{-- Awards --}}
                    <a href="#"
                       class="bg-white rounded-2xl border
                              shadow-sm p-6
                              hover:-translate-y-1
                              transition">

                        <div class="w-12 h-12 rounded-xl
                                    bg-yellow-100
                                    flex items-center
                                    justify-center text-xl mb-5">

                            🏆

                        </div>

                        <h3 class="font-bold text-gray-900 text-lg">
                            Awards
                        </h3>

                        <p class="text-gray-500 text-sm mt-2">
                            Add awards and achievements.
                        </p>

                    </a>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>