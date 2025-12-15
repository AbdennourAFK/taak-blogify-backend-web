<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        // Prevent admin from removing their own admin role
        if ($user->id === auth()->id() && $validated['role'] !== User::ROLE_ADMIN) {
            return redirect()->route('admin.users.edit', $user)
                ->with('error', 'You cannot remove your own admin role.');
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('status', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('status', 'User deleted successfully.');
    }

    /**
     * Promote a user to admin.
     */
    public function promote(User $user): RedirectResponse
    {
        // Prevent self-promotion (though unlikely, but for consistency)
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot promote yourself.');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User is already an admin.');
        }

        $user->update(['role' => User::ROLE_ADMIN]);

        return redirect()->route('admin.users.index')
            ->with('status', 'User promoted to admin successfully.');
    }

    /**
     * Demote an admin to regular user.
     */
    public function demote(User $user): RedirectResponse
    {
        // Prevent self-demotion
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot demote yourself.');
        }

        if (!$user->isAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User is not an admin.');
        }

        $user->update(['role' => User::ROLE_USER]);

        return redirect()->route('admin.users.index')
            ->with('status', 'User demoted to regular user successfully.');
    }
}
