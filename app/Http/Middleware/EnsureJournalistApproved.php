<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureJournalistApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->isJournalist()) {
            // Check OTP / Email verification first
            if (!$user->email_verified_at) {
                return redirect()->route('otp.verify');
            }

            // Check Admin approval
            if (!$user->isApproved()) {
                if (!$request->routeIs('journalist.pending')) {
                    return redirect()->route('journalist.pending');
                }
            }
        }

        return $next($request);
    }
}
