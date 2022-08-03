<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\WebController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('index');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
    Route::get('marketplace/search', [MarketplaceController::class, 'search'])->name('marketplace.search');
    Route::get('marketplace-detail/{slug}', [MarketplaceController::class, 'detail'])->name('marketplace.detail');
    Route::post('marketplace/request', [MarketplaceController::class, 'request'])->name('marketplace.request');
    Route::get('products', [MarketplaceController::class, 'products'])->name('marketplace.products');
    // User profile
    Route::prefix('user')->as('user.')->group(function () {
        Route::get('profile', [HomeController::class, 'profile'])->name('profile');
        Route::get('setting', [WebController::class, 'setting'])->name('setting');
    });
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

