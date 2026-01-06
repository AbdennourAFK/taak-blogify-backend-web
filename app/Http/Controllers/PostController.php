<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of published posts.
     * This route is accessible to both guests and authenticated users.
     */
    public function index(): View
    {
        // Fetch published posts - no auth check needed, this is a public route
        $posts = Post::with('user')
            ->withCount('likes')
            ->published()
            ->latest('published_at')
            ->paginate(12);

        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified post.
     * This route is accessible to both guests and authenticated users.
     */
    public function show(Post $post): View
    {
        // Ensure the post is published
        if (!$post->isPublished()) {
            abort(404);
        }

        // Load relationships
        $post->load(['user', 'comments.user']);
        
        // Use withCount for likes count
        try {
            $post->loadCount('likes');
        } catch (\Exception $e) {
            // If likes table doesn't exist, set count to 0
            $post->setAttribute('likes_count', 0);
        }
        
        // Load likes relationship for checking if user liked it (only load current user's like)
        if (auth()->check()) {
            try {
                $post->load(['likes' => function ($query) {
                    $query->where('user_id', auth()->id());
                }]);
            } catch (\Exception $e) {
                // If likes table doesn't exist, continue without loading
            }
        }

        return view('posts.show', compact('post'));
    }
}
