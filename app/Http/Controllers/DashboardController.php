<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $adminsCount = Admin::count();
        $productsCount = Product::count();
        $ordersCount = Order::count();

        return view('dashboard', compact('usersCount', 'adminsCount', 'productsCount', 'ordersCount'));
    }
}