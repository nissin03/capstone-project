<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocialAuthController;

Route::get('/', function () {
    return Inertia::render('Home');
});


// Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('google-auth-callback');
// Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('google-auth');

Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('admin/category', [CategoryController::class, 'index'])->name('admin.category');
Route::get('admin/product', [ProductController::class, 'index'])->name('admin.product');
