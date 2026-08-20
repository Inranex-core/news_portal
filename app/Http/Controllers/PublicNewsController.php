<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Article;
use App\Models\Category;
use App\Models\JournalistProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicNewsController extends Controller
{
    /**
     * Public news portal homepage.
     */
    public function index(Request $request): View
    {
        $order = ['bangladesh', 'politics', 'campus', 'sports', 'technology', 'business', 'entertainment', 'education', 'health', 'international', 'lifestyle'];
        $categories = Category::withCount(['articles' => function ($query) {
            $query->where('status', 'published')->forLocale();
        }])->get()->sortBy(function ($cat) use ($order) {
            $pos = array_search($cat->slug, $order);
            return $pos !== false ? $pos : 999;
        });


        $search = $request->input('search');
        $selectedCategory = $request->input('category');

        $query = Article::with(['category', 'journalistProfile.user'])
            ->where('status', 'published')
            ->forLocale()
            ->orderBy('published_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('title_bn', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('excerpt_bn', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('content_bn', 'like', "%{$search}%");
            });
        }

        if ($selectedCategory) {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        $latestArticles = $query->paginate(9)->withQueryString();

        // Featured / Breaking news articles (top 3)
        $featuredArticles = Article::with(['category', 'journalistProfile.user'])
            ->where('status', 'published')
            ->forLocale()
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Top verified journalists
        $journalists = JournalistProfile::with('user')
            ->where('is_verified', true)
            ->take(4)
            ->get();

        return view('welcome', compact(
            'categories',
            'latestArticles',
            'featuredArticles',
            'journalists',
            'search',
            'selectedCategory'
        ));
    }

    /**
     * Display a single public news article.
     */
    public function showArticle(string $slug): View
    {
        $article = Article::with(['category', 'journalistProfile.user', 'journalistProfile.expertises'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view count
        $article->increment('views');

        // Related articles from same category
        $relatedArticles = Article::with(['category', 'journalistProfile.user'])
            ->where('status', 'published')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->forLocale()
            ->take(3)
            ->get();

        $comments = $article->comments()->approved()->latest()->get();
        $categories = Category::all();

        return view('articles.show', compact(
            'article',
            'relatedArticles',
            'comments',
            'categories'
        ));
    }

    /**
     * Display news articles under a specific category.
     */
    public function showCategory(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = Article::with(['category', 'journalistProfile.user'])
            ->where('status', 'published')
            ->where('category_id', $category->id)
            ->forLocale()
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = Category::all();

        return view('categories.show', compact('category', 'articles', 'categories'));
    }
}
