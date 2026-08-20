<x-app-layout>

    <div class="min-h-screen bg-gray-100">

        {{-- Header --}}
        <div class="bg-white border-b">

            <div class="max-w-6xl mx-auto px-6 py-8">

                <a href="{{ route('admin.journalists.index') }}"
                   class="text-red-600 font-semibold">
                    ← Back to Journalists
                </a>

            </div>

        </div>


        <div class="max-w-6xl mx-auto px-6 py-10">

            {{-- Profile Card --}}
            <div class="bg-white rounded-3xl
                        border shadow-sm overflow-hidden">


                {{-- Cover --}}
                <div class="h-48 bg-gradient-to-r
                            from-red-600 to-red-900">

                    @if($journalist->cover_image)

                        <img
                            src="{{ asset('storage/' . $journalist->cover_image) }}"
                            class="w-full h-full object-cover"
                            alt="Cover"
                        >

                    @endif

                </div>


                {{-- Profile --}}
                <div class="px-8 pb-8">

                    <div class="-mt-16 flex items-end
                                justify-between">

                        <div class="flex items-end gap-5">

                            @if($journalist->profile_image)

                                <img
                                    src="{{ asset('storage/' . $journalist->profile_image) }}"
                                    class="w-32 h-32 rounded-full
                                           object-cover border-4
                                           border-white shadow-lg"
                                    alt="{{ $journalist->user->name }}"
                                >

                            @else

                                <div class="w-32 h-32 rounded-full
                                            bg-gray-100 border-4
                                            border-white shadow-lg
                                            flex items-center
                                            justify-center">

                                    <span class="text-5xl
                                                 font-bold text-gray-500">

                                        {{ strtoupper(
                                            substr(
                                                $journalist->user->name,
                                                0,
                                                1
                                            )
                                        ) }}

                                    </span>

                                </div>

                            @endif


                            <div class="pb-2">

                                <h1 class="text-3xl font-bold
                                           text-gray-900">

                                    {{ $journalist->user->name }}

                                </h1>

                                <p class="text-red-600 font-semibold">

                                    {{ $journalist->designation
                                        ?? 'Journalist' }}

                                </p>

                            </div>

                        </div>


                        {{-- Verification --}}
                        @if($journalist->is_verified)

                            <span class="mb-3 px-4 py-2
                                         rounded-full
                                         bg-green-100
                                         text-green-700
                                         font-semibold">

                                ✓ Verified Journalist

                            </span>

                        @else

                            <span class="mb-3 px-4 py-2
                                         rounded-full
                                         bg-yellow-100
                                         text-yellow-700
                                         font-semibold">

                                Pending Verification

                            </span>

                        @endif

                    </div>


                    {{-- Information --}}
                    <div class="grid md:grid-cols-2 gap-6 mt-10">

                        <div>

                            <p class="text-sm text-gray-500">
                                Email
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">
                                {{ $journalist->user->email }}
                            </p>

                        </div>


                        <div>

                            <p class="text-sm text-gray-500">
                                Organization
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">
                                {{ $journalist->organization
                                    ?? 'Not specified' }}
                            </p>

                        </div>


                        <div>

                            <p class="text-sm text-gray-500">
                                Location
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">
                                {{ $journalist->location
                                    ?? 'Not specified' }}
                            </p>

                        </div>


                        <div>

                            <p class="text-sm text-gray-500">
                                Experience
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">

                                {{ $journalist->experience_years ?? 0 }}
                                years

                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- About --}}
            <div class="bg-white rounded-2xl
                        border shadow-sm p-8 mt-6">

                <h2 class="text-xl font-bold text-gray-900">
                    About
                </h2>

                <p class="text-gray-600 mt-4 leading-7">

                    {{ $journalist->bio
                        ?? 'No biography available.' }}

                </p>

            </div>


            {{-- Expertise --}}
            <div class="bg-white rounded-2xl
                        border shadow-sm p-8 mt-6">

                <h2 class="text-xl font-bold text-gray-900">
                    Areas of Expertise
                </h2>

                @if($journalist->expertises->count())

                    <div class="flex flex-wrap gap-3 mt-5">

                        @foreach($journalist->expertises as $expertise)

                            <span class="px-4 py-2 rounded-full
                                         bg-red-100 text-red-700
                                         font-medium">

                                {{ $expertise->name }}

                            </span>

                        @endforeach

                    </div>

                @else

                    <p class="text-gray-500 mt-4">
                        No expertise added.
                    </p>

                @endif

            </div>


            {{-- Experience --}}
            <div class="bg-white rounded-2xl
                        border shadow-sm p-8 mt-6">

                <h2 class="text-xl font-bold text-gray-900">
                    Professional Experience
                </h2>

                @forelse($journalist->experiences as $experience)

                    <div class="mt-6 pb-6 border-b last:border-0">

                        <h3 class="text-lg font-bold text-gray-900">

                            {{ $experience->position }}

                        </h3>

                        <p class="text-red-600 mt-1">

                            {{ $experience->organization }}

                        </p>

                        <p class="text-gray-500 text-sm mt-2">

                            {{ $experience->start_date }}
                            -
                            {{ $experience->end_date ?? 'Present' }}

                        </p>

                    </div>

                @empty

                    <p class="text-gray-500 mt-5">
                        No professional experience added.
                    </p>

                @endforelse

            </div>


            {{-- Education --}}
            <div class="bg-white rounded-2xl
                        border shadow-sm p-8 mt-6">

                <h2 class="text-xl font-bold text-gray-900">
                    Education
                </h2>

                @forelse($journalist->educations as $education)

                    <div class="mt-6">

                        <h3 class="text-lg font-bold text-gray-900">

                            {{ $education->degree }}

                        </h3>

                        <p class="text-red-600 mt-1">

                            {{ $education->institution }}

                        </p>

                    </div>

                @empty

                    <p class="text-gray-500 mt-5">
                        No education information added.
                    </p>

                @endforelse

            </div>


            {{-- Verification Action --}}
            <div class="bg-white rounded-2xl
                        border shadow-sm p-8 mt-6">

                <h2 class="text-xl font-bold text-gray-900">
                    Verification
                </h2>

                <form
                    method="POST"
                    action="{{ route(
                        'admin.journalists.verification',
                        $journalist
                    ) }}"
                    class="mt-5"
                >

                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-xl
                               bg-red-600 text-white
                               font-semibold
                               hover:bg-red-700"
                    >

                        {{ $journalist->is_verified
                            ? 'Remove Verification'
                            : 'Verify Journalist' }}

                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>