<?php

use App\Http\Controllers\GoGetLead\IntegrationController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\OneClickVid\RequestController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OneClickVid\ContactController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    dd($request->user());

});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('getUserTokenProducts',[IntegrationController::class,'UserTokenProducts']);
    Route::get('getProductsDetails/{id}',[IntegrationController::class,'ProductDetails']);
    Route::post('addGoGetLeadOrders',[IntegrationController::class,'CreateOrders']);
});


Route::get('checkToken',[IntegrationController::class,'checkToken']);
Route::get('getCreativesNotification/{id}/{message}/{route}', [RequestController::class, 'getCreativesNotification']);
Route::get('getContactNotification/{id}/{message}/{route}', [ContactController::class, 'createContactNotification']);
Route::get('token_update/{id}/{id_integration}/{token}',[UserController::class, 'user_token']);


