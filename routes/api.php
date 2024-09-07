<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

// users
Route::put('/users/{id}', [UserController::class, 'apiUpdate']);
Route::get('/users/{id}', [UserController::class, 'apiGetDetail']);
Route::post('/users', [UserController::class, 'apiCreate']);

// products
Route::get('/products', [ProductController::class, 'apiGetAll']);

// orders
Route::post('/orders', [OrderController::class, 'apiCreate']);
Route::get('/orders/history/{user_id}', [OrderController::class, 'apiGetOrderHistory']);

// login
Route::post('/login', [UserController::class, 'apiLogin']);