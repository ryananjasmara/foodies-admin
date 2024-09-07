<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products', compact('products'));
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'qty' => 'required|integer',
                'price' => 'required|integer',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');

            Product::create([
                'name' => $request->name,
                'type' => $request->type,
                'qty' => $request->qty,
                'price' => $request->price,
                'image' => $imagePath,
            ]);

            return redirect()->route('products.list')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error creating the product. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'qty' => 'required|integer',
                'price' => 'required|integer',
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $product->name = $request->name;
            $product->type = $request->type;
            $product->qty = $request->qty;
            $product->price = $request->price;

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                $imagePath = $request->file('image')->store('images', 'public');
                $product->image = $imagePath;
            }

            $product->save();

            return redirect()->route('products.list')->with('success', 'Product updated successfully.');
        } catch (ModelNotFoundException $e) {
            Log::error('Product not found: ' . $e->getMessage());
            return redirect()->route('products.list')->with('error', 'Product not found.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->route('products.list')->with('error', 'There was an error when updating the product. Please try again.');
        }
    }

    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()->route('products.list')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting product: ' . $e->getMessage());
            return redirect()->route('products.list')->with('error', 'There was an error deleting the product. Please try again.');
        }
    }

    public function apiGetAll(Request $request)
    {
        try {
            $keyword = $request->input('keyword');

            if ($keyword) {
                $products = Product::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%'])->orderBy('id', 'asc')->get();
            } else {
                $products = Product::orderBy('id', 'asc')->get();
            }

            return response()->json(['data' => $products]);
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return response()->json(['error' => 'There was an error fetching the products. Please try again.'], 500);
        }
    }
}