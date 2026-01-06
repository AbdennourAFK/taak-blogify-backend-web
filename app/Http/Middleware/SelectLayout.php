<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SelectLayout
{
    /**
     * Handle an incoming request.
     *
     * This middleware automatically sets the layout view variable
     * based on the authenticated user's role.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only set layout for authenticated users
        if (Auth::check()) {
            $layout = Auth::user()->isAdmin() ? 'layouts.admin' : 'layouts.user';
            
            // Share the layout variable with all views
            view()->share('selectedLayout', $layout);
        }

        return $response;
    }
}

