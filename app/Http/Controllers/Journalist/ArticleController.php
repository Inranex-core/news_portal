<?php

namespace App\Http\Controllers\Journalist;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Journalist articles
     */
    public function index()
    {
        $journalist = Auth::user()->journalistProfile;

        if (!$journalist) {
            abort(403, 'Journalist profile not found.');
        }

        $articles = Article::with([
            'category',
        ])
            ->where('journalist_profile_id', $journalist->id)
            ->latest()
            ->get();

        return view(
            'journalist.articles.index',
            compact('articles')
        );
    }


    /**
     * Create article
     */
    public function create()
    {
        $journalist = Auth::user()->journalistProfile;

        if (!$journalist) {
            abort(403, 'Journalist profile not found.');
        }

        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view(
            'journalist.articles.create',
            compact('categories')
        );
    }


    /**
     * Store article
     */
    public function store(Request $request)
    {
        $journalist = Auth::user()->journalistProfile;

        if (!$journalist) {
            abort(403, 'Journalist profile not found.');
        }


        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_bn' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'excerpt_bn' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'content_bn' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'action' => ['required', 'in:draft,submit'],
        ]);

        $article = new Article();
        $article->journalist_profile_id = $journalist->id;
        $article->category_id = $validated['category_id'];
        $article->title = $validated['title'];
        $article->title_bn = !empty($validated['title_bn']) ? $validated['title_bn'] : $validated['title'];
        $article->slug = Str::slug($validated['title']) . '-' . time();
        $article->excerpt = $validated['excerpt'] ?? null;
        $article->excerpt_bn = !empty($validated['excerpt_bn']) ? $validated['excerpt_bn'] : ($validated['excerpt'] ?? null);
        $article->content = $validated['content'];
        $article->content_bn = !empty($validated['content_bn']) ? $validated['content_bn'] : $validated['content'];

        if ($request->hasFile('image')) {
            $article->image = $request
                ->file('image')
                ->store('articles', 'public');
        }

        if ($validated['action'] === 'submit') {
            $article->status = 'published';
            $article->published_at = now();
        } else {
            $article->status = 'draft';
        }


        /*
        |--------------------------------------------------------------------------
        | Rejection Reason
        |--------------------------------------------------------------------------
        */

        $article->rejection_reason = null;


        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        $article->save();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        if ($article->status === 'pending') {

            return redirect()
                ->route('journalist.articles.index')
                ->with(
                    'success',
                    'News submitted for admin review.'
                );
        }


        return redirect()
            ->route('journalist.articles.index')
            ->with(
                'success',
                'News saved as draft successfully.'
            );
    }


    public function submit(Article $article)
{
    abort_unless($article->journalist_profile_id === auth()->user()->journalistProfile->id, 403);

    if ($article->status !== 'draft' && $article->status !== 'rejected') {
        return back()->with('error', 'This article cannot be submitted.');
    }

    $article->update([
        'status' => 'pending',
        'rejection_reason' => null,
    ]);

    return redirect()
        ->route('journalist.articles.index')
        ->with('success', 'News submitted for admin review.');
}

    /**
     * Edit article
     */
    public function edit(Article $article)
    {
        $journalist = Auth::user()->journalistProfile;

        if (!$journalist) {
            abort(403, 'Journalist profile not found.');
        }


        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $article->journalist_profile_id === $journalist->id,
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();


        return view(
            'journalist.articles.edit',
            compact(
                'article',
                'categories'
            )
        );
    }


    /**
     * Update article
     */
    public function update(
        Request $request,
        Article $article
    ) {

        $journalist = Auth::user()->journalistProfile;

        if (!$journalist) {
            abort(403, 'Journalist profile not found.');
        }


        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $article->journalist_profile_id === $journalist->id,
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_bn' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'excerpt_bn' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'content_bn' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'action' => ['required', 'in:draft,submit'],
        ]);

        $article->title = $validated['title'];
        $article->title_bn = !empty($validated['title_bn']) ? $validated['title_bn'] : $validated['title'];
        $article->category_id = $validated['category_id'];
        $article->excerpt = $validated['excerpt'] ?? null;
        $article->excerpt_bn = !empty($validated['excerpt_bn']) ? $validated['excerpt_bn'] : ($validated['excerpt'] ?? null);
        $article->content = $validated['content'];
        $article->content_bn = !empty($validated['content_bn']) ? $validated['content_bn'] : $validated['content'];

        $article->slug = Str::slug($validated['title']) . '-' . $article->id;

        if ($request->hasFile('image')) {
            if ($article->image && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }
            $article->image = $request->file('image')->store('articles', 'public');
        }

        if ($validated['action'] === 'submit') {
            $article->status = 'published';
            $article->published_at = $article->published_at ?? now();
            $article->rejection_reason = null;
        } else {
            $article->status = 'draft';
        }


        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        $article->save();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        if ($article->status === 'pending') {

            return redirect()
                ->route('journalist.articles.index')
                ->with(
                    'success',
                    'News updated and submitted again for admin review.'
                );
        }


        return redirect()
            ->route('journalist.articles.index')
            ->with(
                'success',
                'News updated and saved as draft.'
            );
    }


    /**
     * Delete article
     */
    public function destroy(Article $article)
    {
        $journalist = Auth::user()->journalistProfile;

        if (!$journalist) {
            abort(403, 'Journalist profile not found.');
        }


        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $article->journalist_profile_id === $journalist->id,
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */

        if (
            $article->image &&
            Storage::disk('public')->exists(
                $article->image
            )
        ) {

            Storage::disk('public')->delete(
                $article->image
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Article
        |--------------------------------------------------------------------------
        */

        $article->delete();


        return redirect()
            ->route('journalist.articles.index')
            ->with(
                'success',
                'News deleted successfully.'
            );
    }
}