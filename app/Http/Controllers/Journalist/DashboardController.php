<?php

namespace App\Http\Controllers\Journalist;

use App\Http\Controllers\Controller;
use App\Models\JournalistProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display journalist dashboard.
     */
    public function index(): View
    {
        $profile = JournalistProfile::with([
            'experiences',
            'educations',
            'expertises',
            'awards',
            'articles.category',
        ])
        ->where('user_id', Auth::id())
        ->first();

        $articlesCount = $profile ? $profile->articles()->count() : 0;
        $publishedArticlesCount = $profile ? $profile->articles()->where('status', 'published')->count() : 0;
        $pendingArticlesCount = $profile ? $profile->articles()->where('status', 'pending')->count() : 0;
        $latestArticles = $profile ? $profile->articles()->with('category')->latest()->take(5)->get() : collect();

        return view(
            'journalist.dashboard',
            compact(
                'profile',
                'articlesCount',
                'publishedArticlesCount',
                'pendingArticlesCount',
                'latestArticles'
            )
        );
    }
}