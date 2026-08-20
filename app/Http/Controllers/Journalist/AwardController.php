<?php

namespace App\Http\Controllers\Journalist;

use App\Http\Controllers\Controller;
use App\Models\JournalistAward;
use App\Models\JournalistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AwardController extends Controller
{
    /**
     * Display all awards.
     */
    public function index()
    {
        $profile = JournalistProfile::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $awards = JournalistAward::where(
            'journalist_profile_id',
            $profile->id
        )
        ->orderByDesc('award_year')
        ->get();

        return view(
            'journalist.award.index',
            compact('profile', 'awards')
        );
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('journalist.award.create');
    }

    /**
     * Store award.
     */
    public function store(Request $request)
    {
        $profile = JournalistProfile::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'organization' => [
                'nullable',
                'string',
                'max:255',
            ],

            'award_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'certificate_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if ($request->hasFile('certificate_image')) {
            $validated['certificate_image'] =
                $request->file('certificate_image')
                    ->store('journalist/awards', 'public');
        }

        $validated['journalist_profile_id'] = $profile->id;

        JournalistAward::create($validated);

        return redirect()
            ->route('journalist.award.index')
            ->with(
                'success',
                'Award added successfully.'
            );
    }

    /**
     * Show edit form.
     */
    public function edit(JournalistAward $award)
    {
        $this->authorizeAward($award);

        return view(
            'journalist.award.edit',
            compact('award')
        );
    }

    /**
     * Update award.
     */
    public function update(
        Request $request,
        JournalistAward $award
    ) {
        $this->authorizeAward($award);

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'organization' => [
                'nullable',
                'string',
                'max:255',
            ],

            'award_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'certificate_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if ($request->hasFile('certificate_image')) {

            if ($award->certificate_image) {
                Storage::disk('public')
                    ->delete($award->certificate_image);
            }

            $validated['certificate_image'] =
                $request->file('certificate_image')
                    ->store('journalist/awards', 'public');
        }

        $award->update($validated);

        return redirect()
            ->route('journalist.award.index')
            ->with(
                'success',
                'Award updated successfully.'
            );
    }

    /**
     * Delete award.
     */
    public function destroy(JournalistAward $award)
    {
        $this->authorizeAward($award);

        if ($award->certificate_image) {
            Storage::disk('public')
                ->delete($award->certificate_image);
        }

        $award->delete();

        return redirect()
            ->route('journalist.award.index')
            ->with(
                'success',
                'Award deleted successfully.'
            );
    }

    /**
     * Make sure award belongs to logged-in journalist.
     */
    private function authorizeAward(
        JournalistAward $award
    ): void {
        $profile = JournalistProfile::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        if (
            $award->journalist_profile_id
            !== $profile->id
        ) {
            abort(403);
        }
    }
}