<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of published posts.
     */
    public function index(): View
    {
        $posts = Post::with('user')
            ->published()
            ->latest('published_at')
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post): View
    {
        // Ensure the post is published
        if (!$post->isPublished()) {
            abort(404);
        }

        $post->load('user');

        return view('posts.show', compact('post'));
    }
}
