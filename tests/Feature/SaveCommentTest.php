<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can save and unsave a comment', function () {
    $user = User::factory()->create();
    // Create a post manually if factory doesn't exist or just try factory
    // Assuming Post factory exists based on standard Laravel practices in this project
    // But to be safe, let's create it manually if we are unsure, but factory is cleaner.
    // Let's try factory, if it fails we check.
    // Actually, looking at the file list, we didn't check factories.
    // Let's just create raw data to be safe.
    $poster = User::factory()->create();
    $post = Post::create([
        'user_id' => $poster->id,
        'title' => 'Test Post',
        'content' => 'Test Content',
        'slug' => 'test-post', // in case slug is required
        'published_at' => now(),
    ]);

    $comment = Comment::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'content' => 'Test comment',
    ]);

    $this->actingAs($user);

    // Initial state: not saved
    expect($comment->isSavedBy($user))->toBeFalse();

    // Save
    $response = $this->post(route('comments.save', $comment));
    $response->assertRedirect();
    $response->assertSessionHas('status', 'Comment saved successfully.');
    expect($comment->refresh()->isSavedBy($user))->toBeTrue();

    // Unsave
    $response = $this->post(route('comments.save', $comment));
    $response->assertRedirect();
    $response->assertSessionHas('status', 'Comment unsaved successfully.');
    expect($comment->refresh()->isSavedBy($user))->toBeFalse();
});
