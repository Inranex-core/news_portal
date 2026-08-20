<?php

namespace App\Http\Controllers\Journalist;

use App\Http\Controllers\Controller;
use App\Models\JournalistEducation;
use App\Models\JournalistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    private function getProfile(): JournalistProfile
    {
        return JournalistProfile::where(
            'user_id',
            Auth::id()
        )->firstOrFail();
    }


    /**
     * Display education.
     */
    public function index()
    {
        $profile = $this->getProfile();

        $educations = $profile->educations()
            ->orderByDesc('end_year')
            ->get();

        return view(
            'journalist.education.index',
            compact('profile', 'educations')
        );
    }


    /**
     * Create form.
     */
    public function create()
    {
        $profile = $this->getProfile();

        return view(
            'journalist.education.create',
            compact('profile')
        );
    }


    /**
     * Store education.
     */
    public function store(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'institution' => [
                'required',
                'string',
                'max:255',
            ],

            'degree' => [
                'required',
                'string',
                'max:255',
            ],

            'field_of_study' => [
                'nullable',
                'string',
                'max:255',
            ],

            'start_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'end_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
                'gte:start_year',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $profile->educations()->create($validated);

        return redirect()
            ->route('journalist.education.index')
            ->with(
                'success',
                'Education added successfully.'
            );
    }


    /**
     * Edit education.
     */
    public function edit(JournalistEducation $education)
    {
        $profile = $this->getProfile();

        abort_unless(
            $education->journalist_profile_id === $profile->id,
            403
        );

        return view(
            'journalist.education.edit',
            compact('profile', 'education')
        );
    }


    /**
     * Update education.
     */
    public function update(
        Request $request,
        JournalistEducation $education
    ) {
        $profile = $this->getProfile();

        abort_unless(
            $education->journalist_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'institution' => [
                'required',
                'string',
                'max:255',
            ],

            'degree' => [
                'required',
                'string',
                'max:255',
            ],

            'field_of_study' => [
                'nullable',
                'string',
                'max:255',
            ],

            'start_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'end_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
                'gte:start_year',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $education->update($validated);

        return redirect()
            ->route('journalist.education.index')
            ->with(
                'success',
                'Education updated successfully.'
            );
    }


    /**
     * Delete education.
     */
    public function destroy(JournalistEducation $education)
    {
        $profile = $this->getProfile();

        abort_unless(
            $education->journalist_profile_id === $profile->id,
            403
        );

        $education->delete();

        return redirect()
            ->route('journalist.education.index')
            ->with(
                'success',
                'Education deleted successfully.'
            );
    }
}