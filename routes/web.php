<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocialAuthController;

Route::prefix('auth')->group(function () {
    Route::middleware('guest')
        ->group(function () {
            Route::get('/login', [AuthController::class, 'index'])->name('login.index');
            Route::post('/login', [AuthController::class, 'login'])->name('login');
        });

    Route::middleware('auth')
        ->group(function () {
            Route::get('/set-password', [AuthController::class, 'showSetPasswordForm'])->name('password.set');
            Route::post('/set-password/store', [AuthController::class, 'setPassword'])->name('password.store');
            Route::post('logout', [AuthController::class, 'destroy'])->name('logout');
        });
});


Route::get('/', function () {
    return Inertia::render('Home');
})->name('home.index');
Route::get('/about-us', function () {
    return Inertia::render('About');
});

// Social Auth
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('google.login');

// Admin Routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('category', [CategoryController::class, 'index'])->name('category');
        Route::get('product', [ProductController::class, 'index'])->name('product');
    });
