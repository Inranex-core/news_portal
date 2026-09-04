<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\JournalistProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'string', 'in:user,journalist'],
        ]);

        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            if (!is_null($existingUser->email_verified_at)) {
                throw ValidationException::withMessages([
                    'email' => __('The email has already been taken.'),
                ]);
            }
        }

        $role = $request->input('role', 'user');
        $isApproved = ($role !== 'journalist');

        $otp = null;
        $otpExpiresAt = null;

        if ($role === 'journalist') {
            $otp = (string) random_int(100000, 999999);
            $otpExpiresAt = now()->addMinutes(15);
        }

        if ($existingUser) {
            $existingUser->update([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'role' => $role,
                'is_approved' => $isApproved,
                'otp_code' => $otp,
                'otp_expires_at' => $otpExpiresAt,
            ]);
            $user = $existingUser;
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $role,
                'is_approved' => $isApproved,
                'otp_code' => $otp,
                'otp_expires_at' => $otpExpiresAt,
            ]);
        }

        // Auto-create JournalistProfile if registering as a journalist
        if ($role === 'journalist') {
            $baseSlug = Str::slug($user->name);
            if (empty($baseSlug)) {
                $baseSlug = 'journalist-' . $user->id;
            }
            $slug = $baseSlug;
            $count = 1;
            while (JournalistProfile::where('user_id', '!=', $user->id)->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            JournalistProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'slug' => $slug,
                    'status' => true,
                    'is_verified' => false,
                ]
            );

            // Send OTP email
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp, $user->name));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send OTP email: ' . $e->getMessage());
            }
        }

        event(new Registered($user));

        Auth::login($user);

        if ($role === 'journalist') {
            return redirect()->route('otp.verify')->with('info', __('An OTP code has been sent to your email. Please verify to continue.'));
        }

        return redirect(route('dashboard', absolute: false));
    }
}
