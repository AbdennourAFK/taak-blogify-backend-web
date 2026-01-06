<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->validated()['content'],
        ]);

        return redirect()->back()->with('status', 'Comment added successfully.');
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $user = auth()->user();

        // Only allow deletion if user is the comment owner or admin
        if ($comment->user_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return redirect()->back()->with('status', 'Comment deleted successfully.');
    }
}
