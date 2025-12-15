<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index(): View
    {
        $latestPosts = Post::with('user')
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('landing', compact('latestPosts'));
    }
}

