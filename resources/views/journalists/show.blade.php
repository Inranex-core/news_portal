@extends('layouts.public')

@section('title', $journalist->user->name . ' - ' . __('Journalist Profile'))

@section('content')

<div class="min-h-screen bg-slate-50">

    {{-- =========================================================
        HERO / COVER SECTION
    ========================================================== --}}
    <section class="relative">

        {{-- Cover --}}
        <div class="relative h-72 overflow-hidden bg-slate-900 md:h-96">

            @if ($journalist->cover_image)

                <img
                    src="{{ asset('storage/' . $journalist->cover_image) }}"
                    alt="{{ $journalist->user->name }}"
                    class="h-full w-full object-cover"
                >

            @else

                <div class="h-full w-full bg-gradient-to-br from-red-700 via-red-600 to-slate-950">
                </div>

            @endif

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-black/10"></div>

        </div>


        {{-- Profile Card --}}
        <div class="relative mx-auto -mt-24 max-w-6xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-3xl bg-white p-6 shadow-xl ring-1 ring-slate-200 md:p-8">

                <div class="flex flex-col gap-6 md:flex-row md:items-end">

                    {{-- Profile Image --}}
                    <div class="relative -mt-24 shrink-0">

                        @if ($journalist->profile_image)

                            <img
                                src="{{ asset('storage/' . $journalist->profile_image) }}"
                                alt="{{ $journalist->user->name }}"
                                class="h-36 w-36 rounded-full border-8 border-white object-cover shadow-xl md:h-40 md:w-40"
                            >

                        @else

                            <div class="flex h-36 w-36 items-center justify-center rounded-full border-8 border-white bg-slate-100 text-5xl font-black text-slate-500 shadow-xl md:h-40 md:w-40">
                                {{ strtoupper(substr($journalist->user->name, 0, 1)) }}
                            </div>

                        @endif

                    </div>


                    {{-- Basic Information --}}
                    <div class="min-w-0 flex-1">

                        <div class="flex flex-wrap items-center gap-3">

                            <h1 class="text-3xl font-black tracking-tight text-slate-900 md:text-4xl">
                                {{ $journalist->user->name }}
                            </h1>


                            @if ($journalist->is_verified)

                                <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-3 py-1.5 text-sm font-bold text-blue-700 ring-1 ring-blue-100">
                                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-blue-600 text-xs text-white">
                                        ✓
                                    </span>

                                    {{ __('Verified Journalist') }}
                                </span>

                            @endif

                        </div>


                        @if ($journalist->display_designation)

                            <p class="mt-2 text-lg font-bold text-red-600">
                                {{ $journalist->display_designation }}
                            </p>

                        @endif


                        @if ($journalist->display_organization)

                            <p class="mt-1 text-base font-medium text-slate-600">
                                {{ $journalist->display_organization }}
                            </p>

                        @endif


                        @if ($journalist->location)

                            <p class="mt-3 flex items-center gap-2 text-sm text-slate-500">
                                <span>📍</span>
                                {{ $journalist->location }}
                            </p>

                        @endif

                    </div>


                    {{-- Profile Action --}}
                    <div class="shrink-0">

                        <button
                            type="button"
                            onclick="window.history.back()"
                            class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-red-500 hover:text-red-600"
                        >
                            {{ __('Back') }}
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">


            {{-- =================================================
                LEFT / MAIN CONTENT
            ================================================== --}}
            <div class="space-y-8 lg:col-span-2">


                {{-- ================= ABOUT ================= --}}
                <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 md:p-8">

                    <div class="mb-6 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600">
                            👤
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                {{ __('About') }}
                            </h2>

                            <p class="text-sm text-slate-500">
                                {{ __('Professional biography') }}
                            </p>
                        </div>

                    </div>


                    <p class="leading-8 text-slate-600">
                        {{ $journalist->display_bio ?? __('No biography available.') }}
                    </p>

                </section>



                {{-- ================= EXPERTISE ================= --}}
                <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 md:p-8">

                    <div class="mb-6 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600">
                            🎯
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                {{ __('Areas of Expertise') }}
                            </h2>

                            <p class="text-sm text-slate-500">
                                {{ __('Topics this journalist specializes in') }}
                            </p>
                        </div>

                    </div>


                    @if ($journalist->expertises->count())

                        <div class="flex flex-wrap gap-3">

                            @foreach ($journalist->expertises as $expertise)

                                <span class="rounded-full bg-red-50 px-4 py-2 text-sm font-bold text-red-600 ring-1 ring-red-100">
                                    {{ $expertise->display_name ?? $expertise->name }}
                                </span>

                            @endforeach

                        </div>

                    @else

                        <p class="text-sm text-slate-500">
                            {{ __('No expertise added yet.') }}
                        </p>

                    @endif

                </section>



                {{-- ================= EXPERIENCE ================= --}}
                <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 md:p-8">

                    {{-- Section Header --}}
                    <div class="mb-8 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600">
                            💼
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                {{ __('Professional Experience') }}
                            </h2>

                            <p class="text-sm text-slate-500">
                                {{ __('Career history') }}
                            </p>
                        </div>

                    </div>


                    {{-- Experiences --}}
                    @if ($journalist->experiences->count())

                        <div class="relative">

                            {{-- Timeline Line --}}
                            <div class="absolute bottom-0 left-5 top-0 w-px bg-slate-200"></div>

                            <div class="space-y-8">

                                @foreach ($journalist->experiences->sortByDesc('start_date') as $experience)

                                    <div class="relative flex gap-6">

                                        {{-- Timeline Icon --}}
                                        <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-600 text-white">
                                            💼
                                        </div>


                                        {{-- Experience Content --}}
                                        <div class="flex-1">

                                            {{-- Designation --}}
                                            <h3 class="text-xl font-bold text-gray-900">
                                                {{ $experience->designation }}
                                            </h3>


                                            {{-- Organization --}}
                                            <p class="mt-1 font-semibold text-red-600">
                                                {{ $experience->organization }}
                                            </p>


                                            {{-- Dates --}}
                                            <p class="mt-2 text-sm text-gray-500">

                                                @if ($experience->start_date)
                                                    {{ \Carbon\Carbon::parse($experience->start_date)->locale(app()->getLocale())->isoFormat('MMM YYYY') }}
                                                @endif

                                                @if ($experience->is_current)

                                                    <span class="mx-1">—</span>

                                                    <span class="font-semibold text-green-600">
                                                        {{ __('Present') }}
                                                    </span>

                                                @elseif ($experience->end_date)

                                                    <span class="mx-1">—</span>

                                                    {{ \Carbon\Carbon::parse($experience->end_date)->locale(app()->getLocale())->isoFormat('MMM YYYY') }}

                                                @endif

                                            </p>


                                            {{-- Description --}}
                                            @if ($experience->description)

                                                <p class="mt-4 leading-relaxed text-gray-600">
                                                    {{ $experience->description }}
                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @else

                        <p class="py-8 text-sm text-slate-500">
                            {{ __('No professional experience added yet.') }}
                        </p>

                    @endif

                </section>

                {{-- ================= EDUCATION ================= --}}
                <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 md:p-8">

                    <div class="mb-8 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600">
                            🎓
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                {{ __('Education') }}
                            </h2>

                            <p class="text-sm text-slate-500">
                                {{ __('Academic background') }}
                            </p>
                        </div>

                    </div>


                    @if ($journalist->educations->count())

                        <div class="space-y-6">

                            @foreach ($journalist->educations as $education)

                                <div class="rounded-xl border border-slate-200 p-5 transition hover:border-red-200 hover:shadow-sm">

                                    <h3 class="text-lg font-black text-slate-900">
                                        {{ $education->degree }}
                                    </h3>


                                    <p class="mt-1 font-bold text-red-600">
                                        {{ $education->institution }}
                                    </p>


                                    @if ($education->field_of_study)

                                        <p class="mt-2 text-slate-600">
                                            {{ $education->field_of_study }}
                                        </p>

                                    @endif


                                    @if ($education->start_year || $education->end_year)

                                        <p class="mt-3 text-sm font-medium text-slate-500">

                                            {{ $education->start_year ?? '' }}

                                            @if ($education->end_year)
                                                — {{ $education->end_year }}
                                            @endif

                                        </p>

                                    @endif

                                </div>

                            @endforeach

                        </div>

                    @else

                        <p class="text-sm text-slate-500">
                            {{ __('No education information added yet.') }}
                        </p>

                    @endif

                </section>



                {{-- ================= AWARDS ================= --}}
                <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 md:p-8">

                    <div class="mb-8 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600">
                            🏆
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                {{ __('Awards & Achievements') }}
                            </h2>

                            <p class="text-sm text-slate-500">
                                {{ __('Recognition and achievements') }}
                            </p>
                        </div>

                    </div>


                    @if ($journalist->awards->count())

                        <div class="grid gap-5 sm:grid-cols-2">

                            @foreach ($journalist->awards as $award)

                                <div class="rounded-xl border border-slate-200 p-5 transition hover:border-red-200 hover:shadow-sm">

                                    <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-yellow-50 text-xl">
                                        🏆
                                    </div>


                                    <h3 class="font-black text-slate-900">
                                        {{ $award->title }}
                                    </h3>


                                    @if ($award->organization)

                                        <p class="mt-1 font-semibold text-red-600">
                                            {{ $award->organization }}
                                        </p>

                                    @endif


                                    @if ($award->award_year)

                                        <p class="mt-2 text-sm font-medium text-slate-500">
                                            {{ $award->award_year }}
                                        </p>

                                    @endif


                                    @if ($award->description)

                                        <p class="mt-3 text-sm leading-6 text-slate-600">
                                            {{ $award->description }}
                                        </p>

                                    @endif

                                </div>

                            @endforeach

                        </div>

                    @else

                        <p class="text-sm text-slate-500">
                            {{ __('No awards added yet.') }}
                        </p>

                    @endif

                </section>

            </div>



            {{-- =================================================
                RIGHT SIDEBAR
            ================================================== --}}
            <aside class="space-y-6">


                {{-- ================= CONTACT ================= --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

                    <h2 class="mb-5 text-lg font-black text-slate-900">
                        {{ __('Contact Information') }}
                    </h2>


                    <div class="space-y-4">

                        @if ($journalist->phone)

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50">
                                    📞
                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        {{ __('Phone') }}
                                    </p>

                                    <p class="mt-1 break-words text-sm font-medium text-slate-700">
                                        {{ $journalist->phone }}
                                    </p>

                                </div>

                            </div>

                        @endif


                        @if ($journalist->user->email)

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50">
                                    ✉️
                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        {{ __('Email') }}
                                    </p>

                                    <p class="mt-1 break-all text-sm font-medium text-slate-700">
                                        {{ $journalist->user->email }}
                                    </p>

                                </div>

                            </div>

                        @endif


                        @if ($journalist->website)

                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50">
                                    🌐
                                </div>

                                <div>

                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        {{ __('Website') }}
                                    </p>

                                    <a
                                        href="{{ $journalist->website }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="mt-1 block text-sm font-bold text-red-600 hover:underline"
                                    >
                                        {{ __('Visit Website →') }}
                                    </a>

                                </div>

                            </div>

                        @endif


                        @if (!$journalist->phone && !$journalist->user->email && !$journalist->website)

                            <p class="text-sm text-slate-500">
                                {{ __('No contact information available.') }}
                            </p>

                        @endif

                    </div>

                </div>



                {{-- ================= EXPERIENCE SUMMARY ================= --}}
                <div class="overflow-hidden rounded-2xl bg-gradient-to-br from-red-600 to-red-700 p-6 text-white shadow-lg">

                    <p class="text-sm font-semibold text-red-100">
                        {{ __('Professional Experience') }}
                    </p>


                    <div class="mt-3 flex items-end gap-2">

                        <span class="text-5xl font-black">
                            {{ $journalist->experience_years ?? 0 }}
                        </span>

                        <span class="pb-2 text-sm font-semibold text-red-100">
                            {{ __('Years') }}
                        </span>

                    </div>


                    <p class="mt-2 text-sm text-red-100">
                        {{ __('of professional journalism experience') }}
                    </p>

                </div>



                {{-- ================= VERIFIED CARD ================= --}}
                @if ($journalist->is_verified)

                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-6">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-600 text-lg text-white">
                                ✓
                            </div>

                            <div>

                                <h3 class="font-black text-blue-900">
                                    {{ __('Verified Journalist') }}
                                </h3>

                                <p class="mt-1 text-sm leading-6 text-blue-700">
                                    {{ __('This journalist profile has been verified by News Portal.') }}
                                </p>

                            </div>

                        </div>

                    </div>

                @endif

            </aside>

        </div>

    </section>

</div>

@endsection