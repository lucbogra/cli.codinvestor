<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OneClickVid\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FundingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OneClickVid\PackController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\RegisterStepsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OneClickVid\RequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use App\Http\Middleware\DomainCheckMiddleware;
use App\Models\Integration;
use App\Http\Middleware\RegisterSteps;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\Routing\RequestContext;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
  })->name('index');

  Route::get('email/change', function() {
    return Inertia::render('Auth/EditEmail');
  } )->middleware('auth')->name('user.get_email');
  Route::put('email/change', [RegisterStepsController::class, 'change_email'])->middleware('auth')->name('user.change_email');

  // Route::get('/register/steps/second_step', function() {
  //   return Inertia::render('Auth/SecondStepRegister');
  // })->middleware('auth:sanctum', 'verified')->name('user.register.second_step');

  Route::put('/register/steps/second_step', [RegisterStepsController::class, 'second_step'])->middleware('auth')->name('user.register.store_second_step');

  // Route::get('/register/steps/third_step', function() {
  //   return Inertia::render('Auth/ThirdStepRegister');
  // })->middleware('auth:sanctum', 'verified')->name('user.register.third_step');

  Route::get('/register/steps', function(Request $request) {
    $step = $request->user() ? $request->user()->step : null;
    if($request->user()?->stepStatus == true){
      return redirect(RouteServiceProvider::HOME);
    }
    if($step !== null && $step ==  2)
      {
        return Inertia::render('Auth/SecondStepRegister');
      }elseif($step !== null && $step == 3)
      {
        return Inertia::render('Auth/ThirdStepRegister');
      }elseif($step !== null && $step == 4)
      {
        return Inertia::render('Auth/FourthStepRegister');
      }elseif($step !== null && $step ==  5)
      {
        return Inertia::render('Auth/FirfthStepRegister');
      }
    else return redirect(RouteServiceProvider::HOME);
  })->middleware('auth:sanctum', 'verified')->name('user.register.steps');

  Route::put('register/steps/third_step', [RegisterStepsController::class, 'third_step'])->middleware('auth')->name('user.register.store_third_step');
  Route::post('register/steps/fourth_step', [RegisterStepsController::class, 'fourth_step'])->middleware('auth')->name('user.register.store_fourth_step');

  Route::middleware([
      'auth:sanctum',
      config('jetstream.auth_session'),
      'verified',
      'register_steps',
  ])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/top/{time}', [DashboardController::class, 'top'])->name('dashboard.top')->middleware('auth');
    Route::get('/dashboard/performance', [DashboardController::class, 'performance'])->name('dashboard.performance')->middleware('auth');
    Route::get('/dashboard/month_reports', [DashboardController::class, 'month_reports'])->name('dashboard.month_reports');
  });
// }});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'register_steps',
    ])->group(function () {
  Route::get('marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
  Route::get('marketplace/search', [MarketplaceController::class, 'search'])->name('marketplace.search');
  Route::get('marketplace-detail/{slug}', [MarketplaceController::class, 'detail'])->name('marketplace.detail');
  Route::post('marketplace/request', [MarketplaceController::class, 'request'])->name('marketplace.request')->middleware('permission:affiliate send product request');
  Route::get('products', [MarketplaceController::class, 'products'])->name('marketplace.products');
  Route::get('products/request/{notification}/{slug}', [MarketplaceController::class, 'product_read_notification'])->name('marketplace.products.read_notification');
  Route::put('products/update', [MarketplaceController::class, 'update'])->name('products.update')->middleware('permission:affiliate set product link');
  Route::get('user/products',[MarketplaceController::class,'getuserProduct'])->name('products.user');

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

  Route::get('analytics', [ReportController::class, 'analytics'])->name('analytics')->middleware('permission:affiliate show analytics');
  Route::get('performance/{start}/{end}', [ReportController::class, 'performance'])->name('performance')->middleware('permission:affiliate show analytics');
  Route::get('reports', [ReportController::class, 'reports'])->name('reports')->middleware('permission:affiliate show reports');
  Route::get('products/{start}/{end}', [ReportController::class, 'products'])->name('reports.products')->middleware('permission:affiliate show reports');

  Route::prefix('billing')->middleware('permission:affiliate manage billing settings')->group(function () {
    Route::get('index', [PaymentMethodController::class, 'index'])->name('billing.index');
    Route::put('update', [PaymentMethodController::class, 'update'])->name('billing.update');
  });

  Route::prefix('invoices')->middleware('permission:affiliate show invoices')->group(function () {
    Route::get('index', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/{notification}/{invoice}', [InvoiceController::class, 'invoice_notification'])->name('invoice.notification.show');
    Route::get('pdf/download/{invoice}', [InvoiceController::class, 'download'])->name('invoice.download');
  });

  Route::prefix('integrations')->group(function () {
    Route::get('', [IntegrationController::class, 'index'])->name('integrations.index');
    Route::get('create', [IntegrationController::class, 'create'])->name('integrations.create');
    Route::post('store', [IntegrationController::class, 'store'])->name('integrations.store');
    Route::get('oneclickVid', [IntegrationController::class, 'oneclickvid'])->name('oneclickvid.index');
    Route::get('oneclickVid/{id}', [IntegrationController::class, 'request_show'])->name('oneclickvid.show');
    Route::put('Logout/{integration}',[IntegrationController::class,'logout'])->name('oneclickvid.logout');

  });

  Route::get('/fundings', [FundingController::class, 'index'])->name('fundings.index')->middleware('role:Investor');

  Route::prefix('user')->middleware('role:Investor')->group(function () {
    Route::get('company', [UserController::class, 'company'])->name('users.company');
    Route::post('create_account_oneclickvid', [UserController::class, 'create_oneclickvid'])->name('users.oneclickvid')->middleware(DomainCheckMiddleware::class);
    Route::put('/company/update', [UserController::class, 'update_company'])->name('users.company.update');
    Route::resource('/members', MemberController::class);
  });
    Route::prefix('user')->middleware('role:Investor')->group( function() {
      Route::get('company', [UserController::class, 'company'])->name('users.company');
      Route::put('/company/update', [UserController::class, 'update_company'])->name('users.company.update');
      Route::resource('/members', MemberController::class);
      Route::get('/notifications', [HomeController::class, 'all_notifications'])->name('user.notifications');
      Route::put('/notifications/{id}/close', [HomeController::class, 'close_notification'])->name('user.notifications.close');
      Route::put('/notifications/close', [HomeController::class, 'close_all_notifications'])->name('user.all_notifications.close');
      Route::get('/seller/get_started', [HomeController::class, 'seller'])->name('seller.index');
      Route::put('/seller/get_started', [HomeController::class, 'seller_get_started'])->name('seller.get_started');

    });

  Route::prefix('messages')->middleware('role:Investor')->group(function () {
    Route::get('/index', [MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/all/all', [MessageController::class, 'all'])->name('messages.all');
    Route::get('/show/{message}', [MessageController::class, 'show'])->name('messages.show');
  });

  Route::resource('requests', RequestController::class);
  Route::get('getuserRequests', [RequestController::class, 'userequests'])->name('userequests');
  Route::put('rate/{id}', [RequestController::class, 'rate'])->name('rate.creative');

  //packs
  Route::get('getpacks',[PackController::class,'getpacks'])->name('getpacks');
  Route::post('subscribePack',[PackController::class,'subscribe'])->name('subscribe');

    Route::get('/', [HomeController::class, 'help'])->name('help');
    Route::get('tutos', [HomeController::class, 'tutos'])->name('tutos');
    Route::post('messages',[ContactController::class,'messages'])->name('messages.add');
    Route::get('getMessages',[ContactController::class,'getmessages'])->name('messages.get');
    Route::put('sendMessage/{id}',[ContactController::class,'sendMessage'])->name('messages.send');

});


  Route::get('getCreativesNotification/{id}/{investor_id}/{message}/{route}', [RequestController::class, 'getCreativesNotification']);
