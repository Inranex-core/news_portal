<x-app-layout>

    <div class="min-h-screen bg-gray-100">

        {{-- Header --}}
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-6 py-8">

                <div class="flex items-center justify-between">

                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Manage Journalists
                        </h1>

                        <p class="mt-2 text-gray-500">
                            View, verify and manage journalists.
                        </p>
                    </div>

                    <a href="{{ route('admin.dashboard') }}"
                       class="px-5 py-2.5 rounded-xl border
                              bg-white text-gray-700
                              hover:bg-gray-50">
                        ← Dashboard
                    </a>

                </div>

            </div>
        </div>


        <div class="max-w-7xl mx-auto px-6 py-10">

            {{-- Success Message --}}
            @if(session('success'))

                <div class="mb-6 px-5 py-4 rounded-xl
                            bg-green-100 text-green-800
                            border border-green-200">

                    {{ session('success') }}

                </div>

            @endif


            {{-- Journalists Table --}}
            <div class="bg-white rounded-2xl border
                        shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b">

                    <h2 class="text-xl font-bold text-gray-900">
                        All Journalists
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Total journalists:
                        {{ $journalists->total() }}
                    </p>

                </div>


                @if($journalists->count())

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-6 py-4 text-left
                                               text-sm font-semibold
                                               text-gray-600">
                                        Journalist
                                    </th>

                                    <th class="px-6 py-4 text-left
                                               text-sm font-semibold
                                               text-gray-600">
                                        Designation
                                    </th>

                                    <th class="px-6 py-4 text-left
                                               text-sm font-semibold
                                               text-gray-600">
                                        Organization
                                    </th>

                                    <th class="px-6 py-4 text-left
                                               text-sm font-semibold
                                               text-gray-600">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-right
                                               text-sm font-semibold
                                               text-gray-600">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y">

                                @foreach($journalists as $journalist)

                                    <tr class="hover:bg-gray-50">

                                        {{-- Journalist --}}
                                        <td class="px-6 py-5">

                                            <div class="flex items-center gap-4">

                                                @if($journalist->profile_image)

                                                    <img
                                                        src="{{ asset('storage/' . $journalist->profile_image) }}"
                                                        class="w-12 h-12 rounded-full
                                                               object-cover"
                                                        alt="{{ $journalist->user->name }}"
                                                    >

                                                @else

                                                    <div class="w-12 h-12 rounded-full
                                                                bg-red-100
                                                                flex items-center
                                                                justify-center">

                                                        <span class="text-red-600
                                                                     font-bold text-lg">

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


                                                <div>

                                                    <p class="font-semibold
                                                              text-gray-900">

                                                        {{ $journalist->user->name }}

                                                    </p>

                                                    <p class="text-sm
                                                              text-gray-500">

                                                        {{ $journalist->user->email }}

                                                    </p>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- Designation --}}
                                        <td class="px-6 py-5">

                                            <span class="text-gray-700">

                                                {{ $journalist->designation
                                                    ?? 'Not specified' }}

                                            </span>

                                        </td>


                                        {{-- Organization --}}
                                        <td class="px-6 py-5">

                                            <span class="text-gray-700">

                                                {{ $journalist->organization
                                                    ?? 'Not specified' }}

                                            </span>

                                        </td>


                                        {{-- Status --}}
                                        <td class="px-6 py-5">

                                            @if($journalist->is_verified)

                                                <span class="inline-flex
                                                             items-center
                                                             px-3 py-1
                                                             rounded-full
                                                             text-sm
                                                             font-semibold
                                                             bg-green-100
                                                             text-green-700">

                                                    ✓ Verified

                                                </span>

                                            @else

                                                <span class="inline-flex
                                                             items-center
                                                             px-3 py-1
                                                             rounded-full
                                                             text-sm
                                                             font-semibold
                                                             bg-yellow-100
                                                             text-yellow-700">

                                                    Pending

                                                </span>

                                            @endif

                                        </td>


                                        {{-- Actions --}}
                                        <td class="px-6 py-5">

                                            <div class="flex items-center
                                                        justify-end gap-2">

                                                <a
                                                    href="{{ route('admin.email.create', $journalist) }}"
                                                    class="px-4 py-2 rounded-lg bg-blue-50 text-blue-600 font-semibold hover:bg-blue-100 flex items-center gap-1">
                                                    ✉️ Email
                                                </a>

                                                <a
                                                    href="{{ route(
                                                        'admin.journalists.show',
                                                        $journalist
                                                    ) }}"
                                                    class="px-4 py-2 rounded-lg
                                                           bg-gray-100
                                                           text-gray-700
                                                           font-semibold
                                                           hover:bg-gray-200">

                                                    View

                                                </a>


                                                <form
                                                    method="POST"
                                                    action="{{ route(
                                                        'admin.journalists.verification',
                                                        $journalist
                                                    ) }}"
                                                >

                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="px-4 py-2 rounded-lg
                                                               bg-red-600
                                                               text-white
                                                               font-semibold
                                                               hover:bg-red-700"
                                                    >

                                                        {{ $journalist->is_verified
                                                            ? 'Unverify'
                                                            : 'Verify' }}

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- Pagination --}}
                    <div class="px-6 py-5 border-t">

                        {{ $journalists->links() }}

                    </div>

                @else

                    <div class="py-20 text-center">

                        <div class="text-5xl mb-4">
                            📰
                        </div>

                        <h3 class="text-xl font-bold text-gray-900">
                            No Journalists Found
                        </h3>

                        <p class="text-gray-500 mt-2">
                            There are no journalist profiles yet.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>