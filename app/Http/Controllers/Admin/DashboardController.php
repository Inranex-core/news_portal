<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\JournalistProfile;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::count();

        $totalJournalists = JournalistProfile::count();

        $verifiedJournalists = JournalistProfile::where(
            'is_verified',
            true
        )->count();

        $pendingJournalists = JournalistProfile::where(
            'is_verified',
            false
        )->count();

        $totalArticles = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $pendingArticles = Article::where('status', 'pending')->count();
        $totalComments = Comment::count();

        $recentArticles = Article::with(['category', 'journalistProfile.user'])
            ->latest()
            ->take(5)
            ->get();

        $recentJournalists = JournalistProfile::with('user')
            ->latest()
            ->take(4)
            ->get();

        $recentComments = Comment::with('article')
            ->latest()
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalJournalists',
            'verifiedJournalists',
            'pendingJournalists',
            'totalArticles',
            'publishedArticles',
            'pendingArticles',
            'totalComments',
            'recentArticles',
            'recentJournalists',
            'recentComments'
        ));
    }
}