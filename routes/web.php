<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FundingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
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
    Route::post('marketplace/request', [MarketplaceController::class, 'request'])->name('marketplace.request')->middleware('permission:affiliate send product request');
    Route::get('products', [MarketplaceController::class, 'products'])->name('marketplace.products');
    Route::get('products/request/{notification}/{slug}', [MarketplaceController::class, 'product_read_notification'])->name('marketplace.products.read_notification');
    Route::put('products/update_link', [MarketplaceController::class, 'update_link'])->name('products.update_link')->middleware('permission:affiliate set product link');

    Route::prefix('orders')->middleware('permission:affiliate import order')->group(function () {
      Route::get('index', [OrderController::class, 'orders'])->name('orders.index');
      Route::post('orders/import', [OrderController::class, 'import'])->name('orders.import');
      Route::get('history', [OrderController::class, 'history'])->name('orders.history');
      Route::get('history/datas', [OrderController::class, 'uploaded'])->name('order.history.datas');
    });


    // User profile
    Route::prefix('user')->as('user.')->group(function () {
        Route::get('profile', [HomeController::class, 'profile'])->name('profile');
        Route::get('plans', [WebController::class, 'plans'])->name('plans');
        Route::get('create-ticket', [WebController::class, 'createTicket'])->name('create.ticket')->middleware('permission:affiliate send ticket');
        Route::post('store-ticket', [WebController::class, 'storeTicket'])->name('store.ticket')->middleware('permission:affiliate send ticket');
    });
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('help-us', [WebController::class, 'help'])->name('help');

    Route::get('analytics', [ReportController::class, 'analytics'])->name('analytics')->middleware('permission:affiliate show analytics');
    Route::get('performance/{start}/{end}', [ReportController::class, 'performance'])->name('performance')->middleware('permission:affiliate show analytics');
    Route::get('reports', [ReportController::class, 'reports'])->name('reports')->middleware('permission:affiliate show reports');
    Route::get('products/{start}/{end}', [ReportController::class, 'products'])->name('reports.products')->middleware('permission:affiliate show reports');

    Route::prefix('billing')->middleware('permission:affiliate manage billing settings')->group(function () {
      Route::get('index', [PaymentMethodController::class, 'index'])->name('billing.index');
      Route::put('update', [PaymentMethodController::class, 'update'])->name('billing.update');
    });

    Route::prefix('invoices')->middleware('permission:affiliate show invoices')->group(function() {
      Route::get('index', [InvoiceController::class, 'index'])->name('invoices.index');
      Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('invoice.show');
      Route::get('/{notification}/{invoice}', [InvoiceController::class, 'invoice_notification'])->name('invoice.notification.show');
      Route::get('pdf/download/{invoice}', [InvoiceController::class, 'download'])->name('invoice.download');
    });

    Route::prefix('services')->group( function() {
      Route::get('index', [ServiceController::class, 'index'])->name('services.index');
    });

    Route::get('/fundings', [FundingController::class, 'index'])->name('fundings.index')->middleware('role:Investor');

    Route::prefix('user')->middleware('role:Investor')->group( function() {
      Route::get('company', [UserController::class, 'company'])->name('users.company');
      Route::put('/company/update', [UserController::class, 'update_company'])->name('users.company.update');
      Route::resource('/members', MemberController::class);
    });

    Route::prefix('messages')->middleware('role:Investor')->group(function() {
      Route::get('/index', [MessageController::class, 'index'])->name('messages.index');
      Route::get('messages/all/all', [MessageController::class, 'all'])->name('messages.all');
      Route::get('/show/{message}', [MessageController::class, 'show'])->name('messages.show');
    });

});

