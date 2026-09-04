<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    /**
     * Display the OTP verification screen.
     */
    public function show(): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // If email is already verified, redirect to dashboard
        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        // If OTP code is missing or expired, generate and send a new code automatically
        if (empty($user->otp_code) || ($user->otp_expires_at && $user->otp_expires_at->isPast())) {
            $otp = (string) random_int(100000, 999999);
            $user->otp_code = $otp;
            $user->otp_expires_at = now()->addMinutes(15);
            $user->save();

            try {
                Mail::to($user->email)->send(new SendOtpMail($otp, $user->name));
            } catch (\Exception $e) {
                Log::error('Failed to send OTP email: ' . $e->getMessage());
            }
        }

        return view('auth.otp_verify', compact('user'));
    }

    /**
     * Handle OTP verification submission.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->isValidOtp($request->otp)) {
            return back()->withErrors(['otp' => __('Invalid or expired OTP code. Please try again or click Resend.')]);
        }

        // Mark email as verified and clear OTP
        $user->email_verified_at = now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        if ($user->isJournalist() && !$user->isApproved()) {
            return redirect()->route('journalist.dashboard')->with('success', __('Email verified successfully! Your account is accessible in read-only mode while pending admin approval.'));
        }

        return redirect()->route('dashboard')->with('success', __('Email verified successfully!'));
    }

    /**
     * Resend OTP verification code.
     */
    public function resend(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $otp = (string) random_int(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(15);
        $user->save();

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp, $user->name));
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP email: ' . $e->getMessage());
        }

        return back()->with('success', __('A new OTP code has been sent to your email address.'));
    }
}
