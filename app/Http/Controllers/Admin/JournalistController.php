<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\JournalistApprovedMail;
use App\Mail\JournalistInvitationMail;
use App\Models\JournalistProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class JournalistController extends Controller
{
    /**
     * Display all approved journalists.
     */
    public function index(): View
    {
        $journalists = JournalistProfile::whereHas('user', function ($q) {
            $q->where('is_approved', true);
        })
        ->with('user')
        ->latest()
        ->paginate(15);

        $pendingCount = User::where('role', 'journalist')
            ->where('is_approved', false)
            ->count();

        return view('admin.journalists.index', compact('journalists', 'pendingCount'));
    }

    /**
     * Display pending journalist applications.
     */
    public function pending(): View
    {
        $pendingJournalists = User::where('role', 'journalist')
            ->where('is_approved', false)
            ->with('journalistProfile')
            ->latest()
            ->paginate(15);

        return view('admin.journalists.pending', compact('pendingJournalists'));
    }

    /**
     * Approve a pending journalist application.
     */
    public function approve(User $user): RedirectResponse
    {
        if (!$user->isJournalist()) {
            return back()->with('error', __('User is not a journalist.'));
        }

        $user->is_approved = true;
        $user->save();

        if ($user->journalistProfile) {
            $user->journalistProfile->is_verified = true;
            $user->journalistProfile->save();
        }

        // Send approval notification email
        try {
            Mail::to($user->email)->send(new JournalistApprovedMail($user));
        } catch (\Exception $e) {
            Log::error('Failed to send JournalistApprovedMail: ' . $e->getMessage());
        }

        return back()->with('success', __('Journalist account approved successfully. Notification email dispatched.'));
    }

    /**
     * Reject a pending journalist application.
     */
    public function reject(User $user): RedirectResponse
    {
        if (!$user->isJournalist()) {
            return back()->with('error', __('User is not a journalist.'));
        }

        if ($user->journalistProfile) {
            $user->journalistProfile->delete();
        }
        $user->delete();

        return back()->with('success', __('Journalist application rejected and removed successfully.'));
    }

    /**
     * Admin Direct Invitation to Journalist.
     */
    public function sendInvite(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'designation' => ['nullable', 'string', 'max:255'],
        ]);

        $inviteToken = Str::random(64);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(32)),
            'role' => 'journalist',
            'is_approved' => true,
            'invite_token' => $inviteToken,
        ]);

        // Create profile
        $baseSlug = Str::slug($user->name);
        if (empty($baseSlug)) {
            $baseSlug = 'journalist-' . $user->id;
        }
        $slug = $baseSlug;
        $count = 1;
        while (JournalistProfile::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        JournalistProfile::create([
            'user_id' => $user->id,
            'slug' => $slug,
            'designation' => $request->designation ?? 'Reporter',
            'status' => true,
            'is_verified' => true,
        ]);

        $inviteUrl = route('journalist.accept_invite', $inviteToken);

        try {
            Mail::to($user->email)->send(new JournalistInvitationMail($user, $inviteUrl));
        } catch (\Exception $e) {
            Log::error('Failed to send JournalistInvitationMail: ' . $e->getMessage());
        }

        return back()->with('success', __('Journalist invitation email sent successfully to :email', ['email' => $user->email]));
    }

    /**
     * Show form to set password for invited journalist.
     */
    public function acceptInviteShow(string $token): View|RedirectResponse
    {
        $user = User::where('invite_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', __('Invalid or expired invitation token.'));
        }

        return view('auth.accept_invite', compact('user', 'token'));
    }

    /**
     * Process password setup for invited journalist.
     */
    public function acceptInviteSubmit(Request $request, string $token): RedirectResponse
    {
        $user = User::where('invite_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', __('Invalid or expired invitation token.'));
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->password = Hash::make($request->password);
        $user->email_verified_at = now();
        $user->invite_token = null;
        $user->is_approved = true;
        $user->save();

        Auth::login($user);

        return redirect()->route('journalist.dashboard')->with('success', __('Account activated successfully! Welcome to your Journalist Dashboard.'));
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
    public function toggleVerification(JournalistProfile $journalist): RedirectResponse
    {
        $journalist->is_verified = !$journalist->is_verified;
        $journalist->save();

        return back()->with(
            'success',
            $journalist->is_verified
                ? __('Journalist verified successfully.')
                : __('Journalist verification removed.')
        );
    }
}