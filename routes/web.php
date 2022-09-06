<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ReportController;
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
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/top/{time}', [DashboardController::class, 'top'])->name('dashboard.top')->middleware('auth');
    Route::get('/dashboard/performance', [DashboardController::class, 'performance'])->name('dashboard.performance')->middleware('auth');
    Route::get('/dashboard/month_reports', [DashboardController::class, 'month_reports'])->name('dashboard.month_reports');
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
    Route::put('products/update_link', [MarketplaceController::class, 'update_link'])->name('products.update_link');
    Route::get('orders', [OrderController::class, 'orders'])->name('orders.index');
    Route::post('orders/import', [OrderController::class, 'import'])->name('orders.import');

    // User profile
    Route::prefix('user')->as('user.')->group(function () {
        Route::get('profile', [HomeController::class, 'profile'])->name('profile');
        Route::get('plans', [WebController::class, 'plans'])->name('plans');
        Route::get('create-ticket', [WebController::class, 'createTicket'])->name('create.ticket');
        Route::post('store-ticket', [WebController::class, 'storeTicket'])->name('store.ticket');
    });
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('help-us', [WebController::class, 'help'])->name('help');

    Route::get('reports', [ReportController::class, 'reports'])->name('reports');
    Route::get('performance/{start}/{end}', [ReportController::class, 'performance'])->name('performance');
    Route::get('products/{start}/{end}', [ReportController::class, 'products'])->name('reports.products');

    Route::prefix('billing')->group(function () {
      Route::get('index', [PaymentMethodController::class, 'index'])->name('billing.index');
      Route::put('update', [PaymentMethodController::class, 'update'])->name('billing.update');
    });

});

