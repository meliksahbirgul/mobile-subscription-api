<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [LoginController::class,'register']);

Route::group(['middleware' => ['auth:sanctum']], function ($route) {
    $route->post('/subscribe', [SubscriptionController::class,'subscribe']);
    $route->get('/check-subscribe', [SubscriptionController::class,'checkSubscribe']);
});
