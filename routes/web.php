<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [LandingController::class, 'index'])->name('home');

// Public posts routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// Public FAQ route
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Public contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication routes (login, register, password reset, etc.)
require __DIR__.'/auth.php';

// Authenticated user routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User profile edit routes (only authenticated user can access their own profile)
    // Must be defined before /profile/{user} to avoid route conflict
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public profile page (must be after /profile/edit to avoid route conflict)
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

// Admin routes (protected with admin middleware)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
    Route::post('users/{user}/promote', [\App\Http\Controllers\Admin\UserController::class, 'promote'])->name('users.promote');
    Route::post('users/{user}/demote', [\App\Http\Controllers\Admin\UserController::class, 'demote'])->name('users.demote');
    
    // FAQ management routes
    Route::resource('faq-categories', \App\Http\Controllers\Admin\FaqCategoryController::class);
    Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);
});
