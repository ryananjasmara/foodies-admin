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
    Route::get('/admins', [AdminController::class, 'index'])->name('admins.list')->middleware('check.permission:view_admins');
    Route::post('/admins', [AdminController::class, 'create'])->name('admins.create')->middleware('check.permission:create_admins');
    Route::put('/admins/{id}', [AdminController::class, 'update'])->name('admins.update')->middleware('check.permission:edit_admins');
    Route::delete('/admins/{id}', [AdminController::class, 'delete'])->name('admins.delete')->middleware('check.permission:delete_admins');

    // product routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.list')->middleware('check.permission:view_products');
    Route::post('/products', [ProductController::class, 'create'])->name('products.create')->middleware('check.permission:create_products');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update')->middleware('check.permission:edit_products');
    Route::delete('/products/{id}', [ProductController::class, 'delete'])->name('products.delete')->middleware('check.permission:delete_products');

    // user routes
    Route::get('/users', [UserController::class, 'index'])->name('users.list')->middleware('check.permission:view_users');
    Route::post('/users', [UserController::class, 'create'])->name('users.create')->middleware('check.permission:create_users');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('check.permission:edit_users');
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.delete')->middleware('check.permission:delete_users');

    // order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.list')->middleware('check.permission:view_orders');
    Route::post('/orders', [OrderController::class, 'create'])->name('orders.create')->middleware('check.permission:create_orders');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update')->middleware('check.permission:edit_orders');
    Route::delete('/orders/{id}', [OrderController::class, 'delete'])->name('orders.delete')->middleware('check.permission:delete_orders');
    Route::get('/orders/export', [OrderController::class, 'export'])->name('orders.export')->middleware('check.permission:export_orders');

    // role routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.list')->middleware('check.permission:view_roles');
    Route::post('/roles', [RoleController::class, 'create'])->name('roles.create')->middleware('check.permission:create_roles');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update')->middleware('check.permission:edit_roles');
    Route::delete('/roles/{id}', [RoleController::class, 'delete'])->name('roles.delete')->middleware('check.permission:delete_roles');
    Route::get('roles/{id}/permissions', [RoleController::class, 'getPermissions'])->name('roles.permissions')->middleware('check.permission:edit_roles');
});