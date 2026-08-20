<?php

namespace App\Http\Controllers\Journalist;

use App\Http\Controllers\Controller;
use App\Models\JournalistExperience;
use App\Models\JournalistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    /**
     * Get logged-in journalist profile.
     */
    private function getProfile(): JournalistProfile
    {
        return JournalistProfile::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'slug' => str()->slug(Auth::user()->name) . '-' . Auth::id(),
                'status' => true,
            ]
        );
    }

    /**
     * Display all experiences.
     */
    public function index()
    {
        $profile = $this->getProfile();

        $experiences = $profile->experiences()
            ->orderByDesc('start_date')
            ->get();

        return view(
            'journalist.experience.index',
            compact('profile', 'experiences')
        );
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $profile = $this->getProfile();

        return view(
            'journalist.experience.create',
            compact('profile')
        );
    }

    /**
     * Store new experience.
     */
    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'organization' => [
                'required',
                'string',
                'max:255',
            ],

            'designation' => [
                'required',
                'string',
                'max:255',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'is_current' => [
                'nullable',
                'boolean',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $validated['is_current'] = $request->boolean('is_current');

        /*
        |--------------------------------------------------------------------------
        | If current job is selected, end date should be NULL
        |--------------------------------------------------------------------------
        */

        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        $profile->experiences()->create($validated);

        return redirect()
            ->route('journalist.experience.index')
            ->with(
                'success',
                'Professional experience added successfully.'
            );
    }

    /**
     * Show edit form.
     */
    public function edit(JournalistExperience $experience)
    {
        $profile = $this->getProfile();

        /*
        |--------------------------------------------------------------------------
        | Security check
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $experience->journalist_profile_id === $profile->id,
            403
        );

        return view(
            'journalist.experience.edit',
            compact('profile', 'experience')
        );
    }

    /**
     * Update experience.
     */
    public function update(
        Request $request,
        JournalistExperience $experience
    ) {
        $profile = $this->getProfile();

        /*
        |--------------------------------------------------------------------------
        | Security check
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $experience->journalist_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'organization' => [
                'required',
                'string',
                'max:255',
            ],

            'designation' => [
                'required',
                'string',
                'max:255',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'is_current' => [
                'nullable',
                'boolean',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $validated['is_current'] = $request->boolean('is_current');

        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        $experience->update($validated);

        return redirect()
            ->route('journalist.experience.index')
            ->with(
                'success',
                'Professional experience updated successfully.'
            );
    }

    /**
     * Delete experience.
     */
    public function destroy(JournalistExperience $experience)
    {
        $profile = $this->getProfile();

        /*
        |--------------------------------------------------------------------------
        | Security check
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $experience->journalist_profile_id === $profile->id,
            403
        );

        $experience->delete();

        return redirect()
            ->route('journalist.experience.index')
            ->with(
                'success',
                'Professional experience deleted successfully.'
            );
    }
}