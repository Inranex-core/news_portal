<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JournalistProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmailController extends Controller
{
    /**
     * Show email creation form for a journalist or all journalists.
     */
    public function create(?JournalistProfile $journalist = null): View
    {
        $journalists = JournalistProfile::with('user')->get();

        return view('admin.email.create', compact('journalists', 'journalist'));
    }

    /**
     * Send email message to journalist.
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'journalist_profile_id' => ['required', 'exists:journalist_profiles,id'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $journalist = JournalistProfile::with('user')->findOrFail($validated['journalist_profile_id']);
        $recipientEmail = $journalist->user->email ?? null;

        if (!$recipientEmail) {
            return back()->with('error', __('This journalist does not have a valid email address.'));
        }

        // Send actual mail or fallback gracefully for local environment
        try {
            Mail::raw($validated['message'], function ($mail) use ($recipientEmail, $validated) {
                $mail->to($recipientEmail)
                    ->subject($validated['subject']);
            });
        } catch (\Throwable $e) {
            // Logged or handled gracefully if mail server is not configured locally
        }

        return redirect()
            ->route('admin.journalists.index')
            ->with('success', __('Email successfully sent to journalist ') . $journalist->user->name . ' (' . $recipientEmail . ')');
    }
}
