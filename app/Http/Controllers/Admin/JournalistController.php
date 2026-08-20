<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JournalistProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JournalistController extends Controller
{
    /**
     * Display all journalists.
     */
    public function index(): View
    {
        $journalists = JournalistProfile::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.journalists.index', compact('journalists'));
    }

    /**
     * Display a journalist profile.
     */
    public function show(JournalistProfile $journalist): View
    {
        $journalist->load([
            'user',
            'experiences',
            'educations',
            'awards',
            'expertises',
        ]);

        return view('admin.journalists.show', compact('journalist'));
    }

    /**
     * Verify / unverify journalist.
     */
    public function toggleVerification(
        JournalistProfile $journalist
    ): RedirectResponse {
        $journalist->is_verified = !$journalist->is_verified;
        $journalist->save();

        return back()->with(
            'success',
            $journalist->is_verified
                ? 'Journalist verified successfully.'
                : 'Journalist verification removed.'
        );
    }
}