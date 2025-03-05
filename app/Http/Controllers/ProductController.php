<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        return view('add_product');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'required|string',
            'images' => 'required',
            'variant.*' => 'required|string',
            'quantity.*' => 'required|integer|min:1',
            'price.*' => 'required|numeric|min:0',
        ]);

        if (!session()->has('customer_id')) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Store the product
        $product = Product::create([
            'customer_id' => session('customer_id'),
            'product_name' => $request->product_name,
            'description' => $request->description,
            'tags' => implode(',', explode(',', $request->tags)),
        ]);

        // Store images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        // Store variants
        foreach ($request->variant as $index => $variant) {
            ProductVariant::create([
                'product_id' => $product->id,
                'variant' => $variant,
                'quantity' => $request->quantity[$index],
                'price' => $request->price[$index],
            ]);
        }

        return redirect()->back()->with('success', 'Product added successfully');
    }

    public function index()
    {
        if (!session()->has('customer_id')) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $customer_id = session('customer_id');

        // Load products with related variants and images
        $products = Product::with(['variants', 'images'])
            ->where('customer_id', $customer_id)
            ->get();

        return view('Show_product', compact('products'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (session()->has('role') && session('role') === 'admin') {
            ProductImage::where('product_id', $id)->delete();
            ProductVariant::where('product_id', $id)->delete();
            $product->delete();
            return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully by admin.');
        }

        if (session()->has('customer_id') && session('customer_id') == $product->customer_id) {
            ProductImage::where('product_id', $id)->delete();
            ProductVariant::where('product_id', $id)->delete();
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        }

        return redirect()->route('products.index')->with('error', 'Unauthorized action.');
    }
}