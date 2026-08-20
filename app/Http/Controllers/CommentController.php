<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'author_name' => ['required_without:user_id', 'nullable', 'string', 'max:255'],
            'author_email' => ['nullable', 'email', 'max:255'],
            'comment' => ['required', 'string', 'max:2000'],
        ]);

        $comment = new Comment();
        $comment->article_id = $article->id;

        if (Auth::check()) {
            $comment->user_id = Auth::id();
            $comment->author_name = Auth::user()->name;
            $comment->author_email = Auth::user()->email;
        } else {
            $comment->author_name = !empty($validated['author_name']) ? $validated['author_name'] : __('Guest Reader');
            $comment->author_email = $validated['author_email'] ?? null;
        }

        $comment->comment = $validated['comment'];
        $comment->status = 'approved';
        $comment->save();

        return back()->with('success', __('Thank you! Your comment has been posted successfully.'));
    }
}
