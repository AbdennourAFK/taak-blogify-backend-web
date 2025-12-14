<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('status', 'User created successfully.');
    }

    /**
     * Promote a user to admin.
     */
    public function promote(User $user): RedirectResponse
    {
        $user->update(['role' => User::ROLE_ADMIN]);

        return redirect()->route('admin.users.index')
            ->with('status', 'User promoted to admin successfully.');
    }

    /**
     * Demote an admin to regular user.
     */
    public function demote(User $user): RedirectResponse
    {
        $user->update(['role' => User::ROLE_USER]);

        return redirect()->route('admin.users.index')
            ->with('status', 'User demoted to regular user successfully.');
    }
}
