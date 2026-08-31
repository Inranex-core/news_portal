<x-app-layout>

    <div class="min-h-screen bg-gray-50">

        {{-- Header --}}
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-6 py-8">

                <h1 class="text-3xl font-bold text-gray-900">
                    User Dashboard
                </h1>

                <p class="mt-2 text-gray-600">
                    Welcome back, {{ auth()->user()->name }}!
                </p>

            </div>
        </div>


        {{-- Main Content --}}
        <div class="max-w-7xl mx-auto px-6 py-10">

            {{-- Welcome Card --}}
            <div class="bg-white rounded-2xl shadow-sm border p-8 mb-8">

                <div class="flex items-center gap-5">

                    <div class="w-16 h-16 rounded-full bg-red-100
                                flex items-center justify-center">

                        <span class="text-2xl font-bold text-red-600">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>

                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            {{ auth()->user()->name }}
                        </h2>

                        <p class="text-gray-500">
                            {{ auth()->user()->email }}
                        </p>

                        <span class="inline-block mt-2 px-3 py-1
                                     text-sm rounded-full
                                     bg-blue-100 text-blue-700">
                            Reader
                        </span>
                    </div>

                </div>

            </div>


            {{-- Dashboard Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Saved Articles --}}
                <div class="bg-white rounded-2xl border shadow-sm p-6">

                    <div class="w-12 h-12 rounded-xl bg-red-100
                                flex items-center justify-center mb-4">

                        <x-icon name="newspaper" class="w-6 h-6 text-red-600" />

                    </div>

                    <h3 class="text-lg font-bold text-gray-900">
                        Saved Articles
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Articles you saved for later.
                    </p>

                    <div class="mt-5">
                        <a href="#"
                           class="text-red-600 font-semibold hover:underline">
                            View Saved Articles →
                        </a>
                    </div>

                </div>


                {{-- Reading History --}}
                <div class="bg-white rounded-2xl border shadow-sm p-6">

                    <div class="w-12 h-12 rounded-xl bg-blue-100
                                flex items-center justify-center mb-4">

                        <x-icon name="briefcase" class="w-6 h-6 text-blue-600" />

                    </div>

                    <h3 class="text-lg font-bold text-gray-900">
                        Reading History
                    </h3>

                    <p class="text-gray-500 mt-2">
                        See the news articles you recently viewed.
                    </p>

                    <div class="mt-5">
                        <a href="#"
                           class="text-blue-600 font-semibold hover:underline">
                            View History →
                        </a>
                    </div>

                </div>


                {{-- Profile --}}
                <div class="bg-white rounded-2xl border shadow-sm p-6">

                    <div class="w-12 h-12 rounded-xl bg-green-100
                                flex items-center justify-center mb-4">

                        <x-icon name="user" class="w-6 h-6 text-green-600" />

                    </div>

                    <h3 class="text-lg font-bold text-gray-900">
                        My Profile
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Manage your account information.
                    </p>

                    <div class="mt-5">
                        <a href="{{ route('profile.edit') }}"
                           class="text-green-600 font-semibold hover:underline">
                            Edit Profile →
                        </a>
                    </div>

                </div>

            </div>


            {{-- Latest News --}}
            <div class="mt-10">

                <div class="flex items-center justify-between mb-5">

                    <h2 class="text-2xl font-bold text-gray-900">
                        Latest News
                    </h2>

                    <a href="/"
                       class="text-red-600 font-semibold hover:underline">
                        Browse News →
                    </a>

                </div>

                <div class="bg-white rounded-2xl border
                            p-10 text-center">

                    <div class="text-5xl mb-4 text-slate-300 flex justify-center">
                        <x-icon name="newspaper" class="w-12 h-12" />
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900">
                        Discover the latest news
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Explore Bangladesh, Politics, Sports,
                        Technology, Business and World news.
                    </p>

                    <a href="/"
                       class="inline-block mt-5 px-6 py-3
                              bg-red-600 text-white rounded-xl
                              font-semibold hover:bg-red-700">
                        Explore News
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>