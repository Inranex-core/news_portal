<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Show all articles.
     */
    public function index()
    {
        $articles = Article::with([
            'category',
            'journalist.user',
        ])
            ->latest()
            ->get();

        return view(
            'admin.articles.index',
            compact('articles')
        );
    }


    /**
     * Show pending articles.
     */
    public function pending()
    {
        $articles = Article::with([
            'category',
            'journalist.user',
        ])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view(
            'admin.articles.pending',
            compact('articles')
        );
    }


    /**
     * Show single article.
     */
    public function show(Article $article)
    {
        $article->load([
            'category',
            'journalist.user',
        ]);

        return view(
            'admin.articles.show',
            compact('article')
        );
    }


    /**
     * Approve article.
     */
    public function approve(Article $article)
    {
        if ($article->status !== 'pending') {

            return back()->with(
                'error',
                'Only pending news can be approved.'
            );
        }

        $article->update([
            'status' => 'published',
            'published_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()
            ->route('admin.articles.pending')
            ->with(
                'success',
                'News published successfully.'
            );
    }


    /**
     * Reject article.
     */
    public function reject(
        Request $request,
        Article $article
    ) {

        if ($article->status !== 'pending') {

            return back()->with(
                'error',
                'Only pending news can be rejected.'
            );
        }


        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
        ]);


        $article->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);


        return redirect()
            ->route('admin.articles.pending')
            ->with(
                'success',
                'News rejected successfully. The journalist can now edit and resubmit it.'
            );
    }
}