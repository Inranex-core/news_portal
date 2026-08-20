<?php

namespace App\Http\Controllers\Journalist;

use App\Http\Controllers\Controller;
use App\Models\JournalistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Show journalist profile edit page.
     */
    public function edit()
    {
        $profile = JournalistProfile::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'slug' => Str::slug(Auth::user()->name) . '-' . Auth::id(),
                'designation' => 'Technology Journalist',
                'organization' => 'News Portal',
                'status' => true,
            ]
        );

        return view(
            'journalist.profile.edit',
            compact('profile')
        );
    }


    /**
     * Update journalist profile.
     */
    public function update(Request $request)
    {
        $profile = JournalistProfile::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'slug' => Str::slug(Auth::user()->name) . '-' . Auth::id(),
                'status' => true,
            ]
        );


        $validated = $request->validate([
            'designation' => [
                'nullable',
                'string',
                'max:255'
            ],

            'organization' => [
                'nullable',
                'string',
                'max:255'
            ],

            'headline' => [
                'nullable',
                'string',
                'max:255'
            ],

            'bio' => [
                'nullable',
                'string'
            ],

            'location' => [
                'nullable',
                'string',
                'max:255'
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30'
            ],

            'website' => [
                'nullable',
                'url',
                'max:255'
            ],

            'experience_years' => [
                'nullable',
                'integer',
                'min:0',
                'max:60'
            ],

            'profile_image' => [
                'nullable',
                'image',
                'max:2048'
            ],

            'cover_image' => [
                'nullable',
                'image',
                'max:4096'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Profile Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_image')) {

            $validated['profile_image'] =
                $request->file('profile_image')
                    ->store('journalists/profiles', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Cover Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('cover_image')) {

            $validated['cover_image'] =
                $request->file('cover_image')
                    ->store('journalists/covers', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Update Profile
        |--------------------------------------------------------------------------
        */

        $profile->update($validated);


        return redirect()
            ->route('journalist.dashboard')
            ->with('success', 'Journalist profile updated successfully.');
    }
}