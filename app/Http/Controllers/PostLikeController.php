<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class PostLikeController extends Controller
{
    /**
     * Toggle like/unlike for a post.
     */
    public function toggle(Post $post): RedirectResponse
    {
        $user = auth()->user();

        if ($post->isLikedBy($user)) {
            $post->likes()->detach($user->id);
            $message = 'Post unliked.';
        } else {
            $post->likes()->attach($user->id);
            $message = 'Post liked!';
        }

        return redirect()->back()->with('status', $message);
    }
}
