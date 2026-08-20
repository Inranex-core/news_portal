<?php

namespace App\Http\Controllers\Journalist;

use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\JournalistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpertiseController extends Controller
{
    /**
     * Display expertise management page.
     */
    public function index()
    {
        $profile = JournalistProfile::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $expertises = Expertise::orderBy('name')->get();

        $selectedExpertises = $profile->expertises()
            ->pluck('expertises.id')
            ->toArray();

        return view(
            'journalist.expertise.index',
            compact(
                'profile',
                'expertises',
                'selectedExpertises'
            )
        );
    }

    /**
     * Update journalist expertise.
     */
    public function update(Request $request)
    {
        $profile = JournalistProfile::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $validated = $request->validate([
            'expertises' => [
                'nullable',
                'array'
            ],

            'expertises.*' => [
                'integer',
                'exists:expertises,id'
            ],
        ]);

        $profile->expertises()->sync(
            $validated['expertises'] ?? []
        );

        return redirect()
            ->route('journalist.expertise.index')
            ->with(
                'success',
                'Expertise updated successfully.'
            );
    }
}