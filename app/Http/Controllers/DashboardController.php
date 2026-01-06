<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Prepare data for the dashboard
        $data = [
            'user' => $user,
        ];

        // Add user-specific data if not admin
        if (!$user->isAdmin()) {
            $data['userPosts'] = $user->posts()->latest()->take(5)->get();
            $data['totalPostsCount'] = $user->posts()->count();
        }

        return view('dashboard', $data);
    }
}

