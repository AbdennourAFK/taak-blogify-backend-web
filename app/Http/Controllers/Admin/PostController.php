<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Generate slug from title
        $validated['slug'] = Post::generateSlug($validated['title']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $validated['image'] = basename($imagePath);
        }

        // Set user_id to current authenticated user
        $validated['user_id'] = $request->user()->id;

        Post::create($validated);

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        $post->load('user');
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        // Generate new slug if title changed
        if ($post->title !== $validated['title']) {
            $validated['slug'] = Post::generateSlug($validated['title']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete('posts/' . $post->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('posts', 'public');
            $validated['image'] = basename($imagePath);
        } else {
            // Remove image from validated data if not uploaded
            unset($validated['image']);
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        // Delete image if exists
        if ($post->image) {
            Storage::disk('public')->delete('posts/' . $post->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post deleted successfully.');
    }
}
