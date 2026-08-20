<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * Redirect user according to their role.
     */
    public function redirect(): RedirectResponse
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),

            'journalist' => redirect()->route('journalist.dashboard'),

            default => redirect()->route('user.dashboard'),
        };
    }
}