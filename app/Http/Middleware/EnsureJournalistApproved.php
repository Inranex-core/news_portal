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
            // 1. Check OTP / Email verification first
            if (!$user->email_verified_at) {
                if (!$request->routeIs('otp.*') && !$request->routeIs('logout')) {
                    return redirect()->route('otp.verify')->with('info', __('Please verify your 6-digit email OTP before accessing your desk.'));
                }
            }

            // 2. Check Admin approval for mutating actions (POST, PUT, PATCH, DELETE)
            if (!$user->isApproved()) {
                if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH') || $request->isMethod('DELETE')) {
                    if (!$request->routeIs('logout') && !$request->routeIs('otp.*')) {
                        return redirect()->back()->with('error', __('Your journalist account is currently pending admin approval. All create, edit, and delete actions are disabled until approved.'));
                    }
                }
            }
        }

        return $next($request);
    }
}
