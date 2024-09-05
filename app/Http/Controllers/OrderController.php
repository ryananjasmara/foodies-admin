<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['product', 'user'])->get();
        return view('orders', compact('orders'));
    }

    public function export()
    {
        $orders = Order::with(['product', 'user'])->get();

        $csvData = "Order ID;Product Name;User Name;Quantity;Total;Order Date\n";

        foreach ($orders as $order) {
            $csvData .= "{$order->id};{$order->product->name};{$order->user->name};{$order->qty};{$order->total};{$order->created_at}" . "\n";
        }

        $fileName = "orders_" . date('Ymd_His') . ".csv";

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }
}