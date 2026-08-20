<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Edit Journalist Profile</h1>
                <p class="mt-2 text-slate-600">
                    Manage your photo, cover, basic information, experience, education, awards and expertise from one page.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-5 py-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-red-800">
                    <p class="font-semibold mb-2">Please fix the following:</p>
                    <ul class="list-disc ml-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('journalist.profile.setup.update') }}"
                enctype="multipart/form-data"
                id="profileSetupForm"
            >
                @csrf
                @method('PATCH')

                {{-- ========================================================= --}}
                {{-- 1. PHOTOS --}}
                {{-- ========================================================= --}}
                <section class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-2xl font-bold text-slate-900">1. Profile & Cover Photo</h2>
                        <p class="text-slate-500 mt-1">Change your public profile and cover image.</p>
                    </div>

                    <div class="p-6 grid lg:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Profile Picture</label>

                            <div class="flex items-center gap-5">
                                <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow ring-2 ring-slate-200 bg-slate-100 flex-shrink-0">
                                    @if($profile->profile_image)
                                        <img
                                            src="{{ asset('storage/' . $profile->profile_image) }}"
                                            class="w-full h-full object-cover"
                                            id="profilePreview"
                                            alt="Profile"
                                        >
                                    @else
                                        <div id="profilePlaceholder" class="w-full h-full flex items-center justify-center text-3xl font-bold text-slate-500">
                                            {{ strtoupper(substr($profile->user->name ?? 'J', 0, 1)) }}
                                        </div>
                                        <img id="profilePreview" class="hidden w-full h-full object-cover" alt="Profile preview">
                                    @endif
                                </div>

                                <div>
                                    <input
                                        type="file"
                                        name="profile_image"
                                        id="profile_image"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="block w-full text-sm text-slate-600"
                                    >
                                    <p class="mt-2 text-xs text-slate-500">JPG, PNG or WebP. Maximum 4MB.</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Cover Picture</label>

                            <div class="h-36 rounded-xl overflow-hidden border border-slate-200 bg-slate-100">
                                @if($profile->cover_image)
                                    <img
                                        src="{{ asset('storage/' . $profile->cover_image) }}"
                                        class="w-full h-full object-cover"
                                        id="coverPreview"
                                        alt="Cover"
                                    >
                                @else
                                    <div id="coverPlaceholder" class="w-full h-full flex items-center justify-center text-slate-400">
                                        No cover image
                                    </div>
                                    <img id="coverPreview" class="hidden w-full h-full object-cover" alt="Cover preview">
                                @endif
                            </div>

                            <input
                                type="file"
                                name="cover_image"
                                id="cover_image"
                                accept="image/jpeg,image/png,image/webp"
                                class="mt-3 block w-full text-sm text-slate-600"
                            >
                            <p class="mt-2 text-xs text-slate-500">JPG, PNG or WebP. Maximum 8MB.</p>
                        </div>
                    </div>
                </section>

                {{-- ========================================================= --}}
                {{-- 2. BASIC PROFILE --}}
                {{-- ========================================================= --}}
                <section class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-2xl font-bold text-slate-900">2. Basic Information</h2>
                    </div>

                    <div class="p-6 grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="label">Designation</label>
                            <input class="input" type="text" name="designation"
                                   value="{{ old('designation', $profile->designation) }}"
                                   placeholder="Sports Journalist">
                        </div>

                        <div>
                            <label class="label">Organization</label>
                            <input class="input" type="text" name="organization"
                                   value="{{ old('organization', $profile->organization) }}"
                                   placeholder="News Portal">
                        </div>

                        <div>
                            <label class="label">Headline</label>
                            <input class="input" type="text" name="headline"
                                   value="{{ old('headline', $profile->headline) }}"
                                   placeholder="Technology, science and current affairs journalist">
                        </div>

                        <div>
                            <label class="label">Phone</label>
                            <input class="input" type="text" name="phone"
                                   value="{{ old('phone', $profile->phone) }}"
                                   placeholder="01XXXXXXXXX">
                        </div>

                        <div>
                            <label class="label">Location</label>
                            <input class="input" type="text" name="location"
                                   value="{{ old('location', $profile->location) }}"
                                   placeholder="Dhaka, Bangladesh">
                        </div>

                        <div>
                            <label class="label">Website</label>
                            <input class="input" type="url" name="website"
                                   value="{{ old('website', $profile->website) }}"
                                   placeholder="https://example.com">
                        </div>

                        <div class="md:col-span-2">
                            <label class="label">Biography</label>
                            <textarea class="input min-h-32" name="bio"
                                      placeholder="Write a short professional biography...">{{ old('bio', $profile->bio) }}</textarea>
                        </div>
                    </div>
                </section>

                {{-- ========================================================= --}}
                {{-- 3. EXPERIENCE --}}
                {{-- ========================================================= --}}
                <section class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">3. Professional Experience</h2>
                            <p class="text-slate-500 mt-1">Add as many professional experiences as you need.</p>
                        </div>
                        <button type="button" onclick="addExperience()" class="add-btn">+ Add Experience</button>
                    </div>

                    <div id="experienceContainer" class="p-6 space-y-5">
                        @forelse($profile->experiences as $i => $experience)
                            <div class="repeat-card experience-item">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-slate-800 experience-number">Experience {{ $i + 1 }}</h3>
                                    <button type="button" onclick="removeItem(this)" class="remove-btn">Remove</button>
                                </div>

                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="label">Organization</label>
                                        <input class="input" name="experiences[{{ $i }}][organization]"
                                               value="{{ $experience->organization }}">
                                    </div>

                                    <div>
                                        <label class="label">Designation</label>
                                        <input class="input" name="experiences[{{ $i }}][designation]"
                                               value="{{ $experience->designation }}">
                                    </div>

                                    <div>
                                        <label class="label">Start Date</label>
                                        <input class="input" type="date" name="experiences[{{ $i }}][start_date]"
                                               value="{{ $experience->start_date }}">
                                    </div>

                                    <div>
                                        <label class="label">End Date</label>
                                        <input class="input end-date" type="date" name="experiences[{{ $i }}][end_date]"
                                               value="{{ $experience->end_date }}">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                                            <input type="checkbox"
                                                   name="experiences[{{ $i }}][is_current]"
                                                   value="1"
                                                   onchange="toggleCurrent(this)"
                                                   @checked($experience->is_current)>
                                            I currently work here
                                        </label>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="label">Description</label>
                                        <textarea class="input min-h-24"
                                                  name="experiences[{{ $i }}][description]">{{ $experience->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="repeat-card experience-item">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-slate-800 experience-number">Experience 1</h3>
                                    <button type="button" onclick="removeItem(this)" class="remove-btn">Remove</button>
                                </div>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div><label class="label">Organization</label><input class="input" name="experiences[0][organization]"></div>
                                    <div><label class="label">Designation</label><input class="input" name="experiences[0][designation]"></div>
                                    <div><label class="label">Start Date</label><input class="input" type="date" name="experiences[0][start_date]"></div>
                                    <div><label class="label">End Date</label><input class="input end-date" type="date" name="experiences[0][end_date]"></div>
                                    <div class="md:col-span-2">
                                        <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                                            <input type="checkbox" name="experiences[0][is_current]" value="1" onchange="toggleCurrent(this)">
                                            I currently work here
                                        </label>
                                    </div>
                                    <div class="md:col-span-2"><label class="label">Description</label><textarea class="input min-h-24" name="experiences[0][description]"></textarea></div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- ========================================================= --}}
                {{-- 4. EDUCATION --}}
                {{-- ========================================================= --}}
                <section class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">4. Education</h2>
                            <p class="text-slate-500 mt-1">Add multiple academic records.</p>
                        </div>
                        <button type="button" onclick="addEducation()" class="add-btn">+ Add Education</button>
                    </div>

                    <div id="educationContainer" class="p-6 space-y-5">
                        @forelse($profile->educations as $i => $education)
                            <div class="repeat-card education-item">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-slate-800 education-number">Education {{ $i + 1 }}</h3>
                                    <button type="button" onclick="removeItem(this)" class="remove-btn">Remove</button>
                                </div>

                                <div class="grid md:grid-cols-2 gap-4">
                                    <div><label class="label">Institution</label><input class="input" name="educations[{{ $i }}][institution]" value="{{ $education->institution }}"></div>
                                    <div><label class="label">Degree</label><input class="input" name="educations[{{ $i }}][degree]" value="{{ $education->degree }}"></div>
                                    <div><label class="label">Field of Study</label><input class="input" name="educations[{{ $i }}][field_of_study]" value="{{ $education->field_of_study }}"></div>
                                    <div><label class="label">Start Year</label><input class="input" type="number" min="1900" max="2100" name="educations[{{ $i }}][start_year]" value="{{ $education->start_year }}"></div>
                                    <div><label class="label">End Year</label><input class="input" type="number" min="1900" max="2100" name="educations[{{ $i }}][end_year]" value="{{ $education->end_year }}"></div>
                                    <div class="md:col-span-2"><label class="label">Description</label><textarea class="input min-h-24" name="educations[{{ $i }}][description]">{{ $education->description }}</textarea></div>
                                </div>
                            </div>
                        @empty
                            <div class="repeat-card education-item">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-slate-800 education-number">Education 1</h3>
                                    <button type="button" onclick="removeItem(this)" class="remove-btn">Remove</button>
                                </div>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div><label class="label">Institution</label><input class="input" name="educations[0][institution]"></div>
                                    <div><label class="label">Degree</label><input class="input" name="educations[0][degree]"></div>
                                    <div><label class="label">Field of Study</label><input class="input" name="educations[0][field_of_study]"></div>
                                    <div><label class="label">Start Year</label><input class="input" type="number" min="1900" max="2100" name="educations[0][start_year]"></div>
                                    <div><label class="label">End Year</label><input class="input" type="number" min="1900" max="2100" name="educations[0][end_year]"></div>
                                    <div class="md:col-span-2"><label class="label">Description</label><textarea class="input min-h-24" name="educations[0][description]"></textarea></div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- ========================================================= --}}
                {{-- 5. EXPERTISE --}}
                {{-- ========================================================= --}}
                <section class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-2xl font-bold text-slate-900">5. Areas of Expertise</h2>
                        <p class="text-slate-500 mt-1">Select all topics you specialize in.</p>
                    </div>

                    <div class="p-6">
                        @if($expertises->count())
                            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach($expertises as $expertise)
                                    <label class="expertise-option">
                                        <input
                                            type="checkbox"
                                            name="expertises[]"
                                            value="{{ $expertise->id }}"
                                            @checked($profile->expertises->contains('id', $expertise->id))
                                        >
                                        <span>
                                            <strong>{{ $expertise->name }}</strong>
                                            @if($expertise->description)
                                                <small>{{ $expertise->description }}</small>
                                            @endif
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-xl bg-amber-50 border border-amber-200 p-5 text-amber-800">
                                No expertise options have been added yet.
                            </div>
                        @endif
                    </div>
                </section>

                {{-- ========================================================= --}}
                {{-- 6. AWARDS --}}
                {{-- ========================================================= --}}
                <section class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">6. Awards & Achievements</h2>
                            <p class="text-slate-500 mt-1">Add multiple awards and achievements.</p>
                        </div>
                        <button type="button" onclick="addAward()" class="add-btn">+ Add Award</button>
                    </div>

                    <div id="awardContainer" class="p-6 space-y-5">
                        @forelse($profile->awards as $i => $award)
                            <div class="repeat-card award-item">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-slate-800 award-number">Award {{ $i + 1 }}</h3>
                                    <button type="button" onclick="removeItem(this)" class="remove-btn">Remove</button>
                                </div>

                                <div class="grid md:grid-cols-2 gap-4">
                                    <div><label class="label">Award Title</label><input class="input" name="awards[{{ $i }}][title]" value="{{ $award->title }}"></div>
                                    <div><label class="label">Organization</label><input class="input" name="awards[{{ $i }}][organization]" value="{{ $award->organization }}"></div>
                                    <div><label class="label">Year</label><input class="input" type="number" min="1900" max="2100" name="awards[{{ $i }}][award_year]" value="{{ $award->award_year }}"></div>
                                    <div>
                                        <label class="label">Certificate</label>
                                        <input class="input" type="file" name="awards[{{ $i }}][certificate_image]" accept="image/jpeg,image/png,image/webp,application/pdf">
                                        @if($award->certificate_image)
                                            <input type="hidden" name="awards[{{ $i }}][existing_certificate_image]" value="{{ $award->certificate_image }}">
                                            <p class="text-xs text-green-700 mt-1">Existing certificate will be kept unless you upload a new one.</p>
                                        @endif
                                    </div>
                                    <div class="md:col-span-2"><label class="label">Description</label><textarea class="input min-h-24" name="awards[{{ $i }}][description]">{{ $award->description }}</textarea></div>
                                </div>
                            </div>
                        @empty
                            <div class="repeat-card award-item">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-slate-800 award-number">Award 1</h3>
                                    <button type="button" onclick="removeItem(this)" class="remove-btn">Remove</button>
                                </div>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div><label class="label">Award Title</label><input class="input" name="awards[0][title]"></div>
                                    <div><label class="label">Organization</label><input class="input" name="awards[0][organization]"></div>
                                    <div><label class="label">Year</label><input class="input" type="number" min="1900" max="2100" name="awards[0][award_year]"></div>
                                    <div><label class="label">Certificate</label><input class="input" type="file" name="awards[0][certificate_image]" accept="image/jpeg,image/png,image/webp,application/pdf"></div>
                                    <div class="md:col-span-2"><label class="label">Description</label><textarea class="input min-h-24" name="awards[0][description]"></textarea></div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- Save --}}
                <div class="sticky bottom-4 z-20 flex justify-end">
                    <button
                        type="submit"
                        class="px-8 py-4 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold shadow-lg transition"
                    >
                        Save Complete Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .label {
            display:block;
            font-size:.875rem;
            font-weight:600;
            color:#334155;
            margin-bottom:.5rem;
        }
        .input {
            width:100%;
            border:1px solid #cbd5e1;
            border-radius:.75rem;
            padding:.7rem .85rem;
            background:#fff;
            color:#0f172a;
        }
        .input:focus {
            outline:none;
            border-color:#ef4444;
            box-shadow:0 0 0 3px rgba(239,68,68,.12);
        }
        .add-btn {
            white-space:nowrap;
            background:#dc2626;
            color:white;
            padding:.65rem 1rem;
            border-radius:.75rem;
            font-weight:700;
        }
        .add-btn:hover { background:#b91c1c; }
        .remove-btn {
            color:#dc2626;
            font-size:.875rem;
            font-weight:700;
        }
        .remove-btn:hover { text-decoration:underline; }
        .repeat-card {
            border:1px solid #e2e8f0;
            border-radius:1rem;
            padding:1.25rem;
            background:#f8fafc;
        }
        .expertise-option {
            display:flex;
            gap:.7rem;
            align-items:flex-start;
            padding:1rem;
            border:1px solid #e2e8f0;
            border-radius:.85rem;
            cursor:pointer;
            background:#fff;
        }
        .expertise-option:hover {
            border-color:#f87171;
            background:#fff7f7;
        }
        .expertise-option input {
            margin-top:.25rem;
            accent-color:#dc2626;
        }
        .expertise-option small {
            display:block;
            color:#64748b;
            margin-top:.2rem;
        }
    </style>

    <script>
        let experienceIndex = {{ $profile->experiences->count() }};
        let educationIndex = {{ $profile->educations->count() }};
        let awardIndex = {{ $profile->awards->count() }};

        function addExperience() {
            const i = experienceIndex++;
            document.getElementById('experienceContainer').insertAdjacentHTML('beforeend', `
                <div class="repeat-card experience-item">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-slate-800 experience-number">Experience</h3>
                        <button type="button" onclick="removeItem(this)" class="remove-btn">Remove</button>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div><label class="label">Organization</label><input class="input" name="experiences[${i}][organization]"></div>
                        <div><label class="label">Designation</label><input class="input" name="experiences[${i}][designation]"></div>
                        <div><label class="label">Start Date</label><input class="input" type="date" name="experiences[${i}][start_date]"></div>
                        <div><label class="label">End Date</label><input class="input end-date" type="date" name="experiences[${i}][end_date]"></div>
                        <div class="md:col-span-2">
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                                <input type="checkbox" name="experiences[${i}][is_current]" value="1" onchange="toggleCurrent(this)">
                                I currently work here
                            </label>
                        </div>
                        <div class="md:col-span-2"><label class="label">Description</label><textarea class="input min-h-24" name="experiences[${i}][description]"></textarea></div>
                    </div>
                </div>
            `);
            renumber('.experience-item', '.experience-number', 'Experience');
        }

        function addEducation() {
            const i = educationIndex++;
            document.getElementById('educationContainer').insertAdjacentHTML('beforeend', `
                <div class="repeat-card education-item">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-slate-800 education-number">Education</h3>
                        <button type="button" onclick="removeItem(this)" class="remove-btn">Remove</button>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div><label class="label">Institution</label><input class="input" name="educations[${i}][institution]"></div>
                        <div><label class="label">Degree</label><input class="input" name="educations[${i}][degree]"></div>
                        <div><label class="label">Field of Study</label><input class="input" name="educations[${i}][field_of_study]"></div>
                        <div><label class="label">Start Year</label><input class="input" type="number" min="1900" max="2100" name="educations[${i}][start_year]"></div>
                        <div><label class="label">End Year</label><input class="input" type="number" min="1900" max="2100" name="educations[${i}][end_year]"></div>
                        <div class="md:col-span-2"><label class="label">Description</label><textarea class="input min-h-24" name="educations[${i}][description]"></textarea></div>
                    </div>
                </div>
            `);
            renumber('.education-item', '.education-number', 'Education');
        }

        function addAward() {
            const i = awardIndex++;
            document.getElementById('awardContainer').insertAdjacentHTML('beforeend', `
                <div class="repeat-card award-item">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-slate-800 award-number">Award</h3>
                        <button type="button" onclick="removeItem(this)" class="remove-btn">Remove</button>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div><label class="label">Award Title</label><input class="input" name="awards[${i}][title]"></div>
                        <div><label class="label">Organization</label><input class="input" name="awards[${i}][organization]"></div>
                        <div><label class="label">Year</label><input class="input" type="number" min="1900" max="2100" name="awards[${i}][award_year]"></div>
                        <div><label class="label">Certificate</label><input class="input" type="file" name="awards[${i}][certificate_image]" accept="image/jpeg,image/png,image/webp,application/pdf"></div>
                        <div class="md:col-span-2"><label class="label">Description</label><textarea class="input min-h-24" name="awards[${i}][description]"></textarea></div>
                    </div>
                </div>
            `);
            renumber('.award-item', '.award-number', 'Award');
        }

        function removeItem(button) {
            const item = button.closest('.repeat-card');
            const container = item.parentElement;

            // Keep at least one empty row for each repeatable section.
            if (container.children.length === 1) {
                item.querySelectorAll('input, textarea').forEach(el => {
                    if (el.type === 'checkbox' || el.type === 'file') el.checked = false;
                    else el.value = '';
                });
                return;
            }

            item.remove();
            renumber('.experience-item', '.experience-number', 'Experience');
            renumber('.education-item', '.education-number', 'Education');
            renumber('.award-item', '.award-number', 'Award');
        }

        function renumber(itemSelector, titleSelector, label) {
            document.querySelectorAll(itemSelector).forEach((item, index) => {
                const title = item.querySelector(titleSelector);
                if (title) title.textContent = `${label} ${index + 1}`;
            });
        }

        function toggleCurrent(checkbox) {
            const card = checkbox.closest('.repeat-card');
            const end = card.querySelector('.end-date');
            if (!end) return;

            end.disabled = checkbox.checked;
            if (checkbox.checked) end.value = '';
        }

        document.querySelectorAll('.experience-item input[type="checkbox"]').forEach(toggleCurrent);

        document.getElementById('profile_image')?.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const preview = document.getElementById('profilePreview');
            const placeholder = document.getElementById('profilePlaceholder');

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        });

        document.getElementById('cover_image')?.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const preview = document.getElementById('coverPreview');
            const placeholder = document.getElementById('coverPlaceholder');

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        });
    </script>
</x-app-layout>