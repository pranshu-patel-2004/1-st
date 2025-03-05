<?php

namespace App\Http\Controllers;

use App\Models\CustomerProduct;
use App\Models\Product;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerProductController extends Controller
{
    // Admin Dashboard
    public function adminDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $products = Product::all();
            return view('admin_dashboard', compact('products'));
        }

        return redirect()->route('login')->with('error', 'Access denied! You are not an admin.');
    }

    // Admin Customers Page 
    public function adminCustomers()
{
    if (Auth::check() && Auth::user()->role === 'admin') {
        $customerProducts = DB::table('customer_products')
            ->join('users', 'customer_products.user_id', '=', 'users.id') 
            ->join('countries', 'customer_products.country_id', '=', 'countries.id')
            ->join('states', 'customer_products.state_id', '=', 'states.id')
            ->join('cities', 'customer_products.city_id', '=', 'cities.id')
            ->select(
                'customer_products.*',
                'users.f_name as added_by',
                'users.email as added_by_email',  
                'countries.name as country_name',
                'states.name as state_name',
                'cities.name as city_name'
            )
            ->get();

        return view('admin_customers', compact('customerProducts'));
    }

    return redirect()->route('login')->with('error', 'Access denied! You are not an admin.');
}

    // Store Customer Product
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customer_products,email,NULL,id,user_id,' . Auth::id(),
            'phone' => 'required|string|max:15|min:10',
            'address' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'password' => 'required|string|min:6', 
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        $data['created_at'] = now();
        $data['updated_at'] = now();

        CustomerProduct::create($data);

        return redirect()->route('customer_products.create')->with('success', 'Customer product added successfully!');
    }

    // Admin Approve Customer Product
    public function approve($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied!');
        }

        $customerProduct = CustomerProduct::find($id);

        if ($customerProduct && $customerProduct->status === 'pending') {
            $customerProduct->update(['status' => 'approved']);
            return redirect()->route('admin.customers')->with('success', 'Customer product approved successfully!');
        }

        return redirect()->route('admin.dashboard')->with('error', 'This product is already approved or does not exist!');
    }

    // Show Create Form (For Regular Users)
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        // Fetch customer products
        $customerProducts = DB::table('customer_products')
            ->join('countries', 'customer_products.country_id', '=', 'countries.id')
            ->join('states', 'customer_products.state_id', '=', 'states.id')
            ->join('cities', 'customer_products.city_id', '=', 'cities.id')
            ->select(
                'customer_products.*',
                'countries.name as country_name',
                'states.name as state_name',
                'cities.name as city_name'
            )
            ->where('user_id', Auth::id())
            ->get();

        $countries = Country::all();

        return view('customer_products.create', compact('customerProducts', 'countries'));
    }

    // Delete Customer Product
    public function destroy($id)
    {
        $customerProduct = CustomerProduct::find($id);

        if (!$customerProduct) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        if (Auth::user()->role === 'admin' || Auth::id() === $customerProduct->user_id) {
            $customerProduct->delete();
            return redirect()->back()->with('success', 'Customer product deleted successfully.');
        }

        return redirect()->back()->with('error', 'Access denied! You cannot delete this product.');
    }

    
}
