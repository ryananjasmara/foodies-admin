<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['product', 'user'])->get();
        $products = Product::all();
        $users = User::all();

        return view('orders', compact('orders', 'products', 'users'));
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'user_id' => 'required|exists:users,id',
                'qty' => 'required|integer',
                'total' => 'required|numeric',
            ]);

            Order::create($request->all());

            return redirect()->route('orders.list')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error creating the order. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'user_id' => 'required|exists:users,id',
                'qty' => 'required|integer',
                'total' => 'required|numeric',
            ]);

            $order->product_id = $request->product_id;
            $order->user_id = $request->user_id;
            $order->qty = $request->qty;
            $order->total = $request->total;

            $order->save();

            return redirect()->route('orders.list')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error updating the order. Please try again.');
        }
    }

    public function delete($id)
    {
        try {
            $order = Order::findOrFail($id);

            $order->delete();

            return redirect()->route('orders.list')->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error deleting the order. Please try again.');
        }
    }

    public function export()
    {
        try {
            $orders = Order::with(['product', 'user'])->get();

            $csvData = "Order ID;User Name;Product Name;Product Price;Quantity;Total;Order Date\n";

            foreach ($orders as $order) {
                $csvData .= "{$order->id};{$order->user->name};{$order->product->name};{$order->product->price};{$order->qty};{$order->total};{$order->created_at}" . "\n";
            }

            $fileName = "orders_" . date('Ymd_His') . ".csv";

            return Response::make($csvData, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$fileName\"",
            ]);
        } catch (\Exception $e) {
            \Log::error('Error exporting orders to CSV: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error exporting the orders. Please try again.');
        }
    }
}