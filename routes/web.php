<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // admin routes
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.list');
    Route::post('/admins', [AdminController::class, 'create'])->name('admins.create');
    Route::put('/admins/{id}', [AdminController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{id}', [AdminController::class, 'delete'])->name('admins.delete');

    // product routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.list');
    Route::post('/products', [ProductController::class, 'create'])->name('products.create');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'delete'])->name('products.delete');

    // user routes
    Route::get('/users', [UserController::class, 'index'])->name('users.list');
    Route::post('/users', [UserController::class, 'create'])->name('users.create');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.delete');

    // order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.list');
    Route::post('/orders', [OrderController::class, 'create'])->name('orders.create');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{id}', [OrderController::class, 'delete'])->name('orders.delete');
    Route::get('/orders/export', [OrderController::class, 'export'])->name('orders.export');

    // role routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.list');
    Route::post('/roles', [RoleController::class, 'create'])->name('roles.create');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RoleController::class, 'delete'])->name('roles.delete');
    Route::get('roles/{id}/permissions', [RoleController::class, 'getPermissions'])->name('roles.permissions');
});

