<?php

namespace App\Http\Controllers\Journalist;

use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\JournalistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileSetupController extends Controller
{
    /**
     * Show the complete journalist profile editor.
     * Everything is managed from this single page.
     */
    public function edit()
    {
        $profile = JournalistProfile::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'slug' => Str::slug(Auth::user()->name) . '-' . Auth::id(),
                'status' => true,
            ]
        );

        $profile->load([
            'experiences' => fn ($q) => $q->orderByDesc('start_date'),
            'educations' => fn ($q) => $q->orderByDesc('start_year'),
            'awards' => fn ($q) => $q->orderByDesc('award_year'),
            'expertises',
        ]);

        $expertises = Expertise::where('status', true)
            ->orderBy('name')
            ->get();

        return view('journalist.profile.setup', compact('profile', 'expertises'));
    }

    /**
     * Save the complete journalist profile from one form.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // Profile
            'designation' => ['nullable', 'string', 'max:255'],
            'organization' => ['nullable', 'string', 'max:255'],
            'headline' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],

            // Images
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],

            // Multiple experiences
            'experiences' => ['nullable', 'array'],
            'experiences.*.organization' => ['nullable', 'string', 'max:255'],
            'experiences.*.designation' => ['nullable', 'string', 'max:255'],
            'experiences.*.start_date' => ['nullable', 'date'],
            'experiences.*.end_date' => ['nullable', 'date'],
            'experiences.*.is_current' => ['nullable', 'boolean'],
            'experiences.*.description' => ['nullable', 'string'],

            // Multiple education
            'educations' => ['nullable', 'array'],
            'educations.*.institution' => ['nullable', 'string', 'max:255'],
            'educations.*.degree' => ['nullable', 'string', 'max:255'],
            'educations.*.field_of_study' => ['nullable', 'string', 'max:255'],
            'educations.*.start_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'educations.*.end_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'educations.*.description' => ['nullable', 'string'],

            // Multiple awards
            'awards' => ['nullable', 'array'],
            'awards.*.title' => ['nullable', 'string', 'max:255'],
            'awards.*.organization' => ['nullable', 'string', 'max:255'],
            'awards.*.award_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'awards.*.description' => ['nullable', 'string'],
            'awards.*.certificate_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
            'awards.*.existing_certificate_image' => ['nullable', 'string', 'max:500'],

            // Expertise checkboxes
            'expertises' => ['nullable', 'array'],
            'expertises.*' => ['integer', 'exists:expertises,id'],
        ]);

        $profile = JournalistProfile::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'slug' => Str::slug(Auth::user()->name) . '-' . Auth::id(),
                'status' => true,
            ]
        );

        DB::transaction(function () use ($request, $validated, $profile) {
            // -----------------------------
            // 1. Basic profile
            // -----------------------------
            $profileData = [
                'designation' => $validated['designation'] ?? null,
                'organization' => $validated['organization'] ?? null,
                'headline' => $validated['headline'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'location' => $validated['location'] ?? null,
                'website' => $validated['website'] ?? null,
            ];

            if ($request->hasFile('profile_image')) {
                $this->deletePublicFile($profile->profile_image);
                $profileData['profile_image'] = $request->file('profile_image')
                    ->store('journalists/profile', 'public');
            }

            if ($request->hasFile('cover_image')) {
                $this->deletePublicFile($profile->cover_image);
                $profileData['cover_image'] = $request->file('cover_image')
                    ->store('journalists/cover', 'public');
            }

            $profile->update($profileData);

            // -----------------------------
            // 2. Experiences
            // -----------------------------
            $profile->experiences()->delete();

            foreach ($validated['experiences'] ?? [] as $experience) {
                if (
                    blank($experience['organization'] ?? null) &&
                    blank($experience['designation'] ?? null) &&
                    blank($experience['start_date'] ?? null) &&
                    blank($experience['description'] ?? null)
                ) {
                    continue;
                }

                $profile->experiences()->create([
                    'organization' => $experience['organization'] ?? '',
                    'designation' => $experience['designation'] ?? '',
                    'start_date' => $experience['start_date'] ?? null,
                    'end_date' => !empty($experience['is_current'])
                        ? null
                        : ($experience['end_date'] ?? null),
                    'is_current' => !empty($experience['is_current']),
                    'description' => $experience['description'] ?? null,
                ]);
            }

            // -----------------------------
            // 3. Education
            // -----------------------------
            $profile->educations()->delete();

            foreach ($validated['educations'] ?? [] as $education) {
                if (
                    blank($education['institution'] ?? null) &&
                    blank($education['degree'] ?? null) &&
                    blank($education['field_of_study'] ?? null)
                ) {
                    continue;
                }

                $profile->educations()->create([
                    'institution' => $education['institution'] ?? '',
                    'degree' => $education['degree'] ?? null,
                    'field_of_study' => $education['field_of_study'] ?? null,
                    'start_year' => $education['start_year'] ?? null,
                    'end_year' => $education['end_year'] ?? null,
                    'description' => $education['description'] ?? null,
                ]);
            }

            // -----------------------------
            // 4. Awards
            // -----------------------------
            $oldAwardFiles = $profile->awards()
                ->whereNotNull('certificate_image')
                ->pluck('certificate_image')
                ->all();
            $keptAwardFiles = [];

            $profile->awards()->delete();

            foreach ($validated['awards'] ?? [] as $index => $award) {
                if (
                    blank($award['title'] ?? null) &&
                    blank($award['organization'] ?? null) &&
                    blank($award['award_year'] ?? null) &&
                    blank($award['description'] ?? null)
                ) {
                    continue;
                }

                $certificatePath = null;

                if ($request->hasFile("awards.$index.certificate_image")) {
                    $certificatePath = $request
                        ->file("awards.$index.certificate_image")
                        ->store('journalists/awards', 'public');
                } elseif (!empty($award['existing_certificate_image'])) {
                    $candidate = $award['existing_certificate_image'];

                    if (in_array($candidate, $oldAwardFiles, true)) {
                        $certificatePath = $candidate;
                        $keptAwardFiles[] = $candidate;
                    }
                }

                $profile->awards()->create([
                    'title' => $award['title'] ?? '',
                    'organization' => $award['organization'] ?? null,
                    'award_year' => $award['award_year'] ?? null,
                    'description' => $award['description'] ?? null,
                    'certificate_image' => $certificatePath,
                ]);
            }

            // Delete old award files after successful replacement.
            foreach ($oldAwardFiles as $file) {
                if (!in_array($file, $keptAwardFiles, true)) {
                    $this->deletePublicFile($file);
                }
            }

            // -----------------------------
            // 5. Expertise
            // -----------------------------
            $profile->expertises()->sync($validated['expertises'] ?? []);

            // -----------------------------
            // 6. Experience years
            // -----------------------------
            $years = 0;

            foreach ($profile->experiences()->get() as $experience) {
                if (!$experience->start_date) {
                    continue;
                }

                $start = \Carbon\Carbon::parse($experience->start_date);
                $end = $experience->is_current || !$experience->end_date
                    ? now()
                    : \Carbon\Carbon::parse($experience->end_date);

                $years += max(0, $start->diffInYears($end));
            }

            $profile->update(['experience_years' => $years]);
        });

        return redirect()
            ->route('journalist.profile.edit')
            ->with('success', 'Your complete journalist profile has been saved successfully.');
    }

    private function deletePublicFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}