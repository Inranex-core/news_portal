<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JournalistProfile;
use Illuminate\View\View;

class JournalistController extends Controller
{
    /**
     * Display public directory of journalists.
     */
    public function index(): View
    {
        $journalists = JournalistProfile::with(['user', 'expertises', 'articles' => function ($q) {
            $q->where('status', 'published')->forLocale();
        }])
        ->where('status', true)
        ->orderBy('is_verified', 'desc')
        ->paginate(12);

        $categories = Category::all();

        return view('journalists.index', compact('journalists', 'categories'));
    }

    /**
     * Show public journalist portfolio.
     */
    public function show(string $slug): View
    {
        $journalist = JournalistProfile::with([
            'user',
            'experiences',
            'educations',
            'awards',
            'expertises',
            'articles' => function ($q) {
                $q->where('status', 'published')->forLocale()->orderBy('published_at', 'desc');
            }
        ])
        ->where('slug', $slug)
        ->where('status', true)
        ->firstOrFail();

        $categories = Category::all();

        return view(
            'journalists.show',
            compact('journalist', 'categories')
        );
    }
}