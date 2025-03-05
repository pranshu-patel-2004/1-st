<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\ProductController;
use App\Models\State;
use App\Models\City;


Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }
        return view('dashboard');
    })->name('dashboard');

    // Customer Product Routes (Regular Users)
    Route::get('/customer-products/create', [CustomerProductController::class, 'create'])->name('customer_products.create');
    Route::post('/customer-products', [CustomerProductController::class, 'store'])->name('customer_products.store');
    Route::resource('customer_products', CustomerProductController::class);
});





Route::middleware(['auth'])->group(function () {
    // Admin Dashboard (Default: Product List)
    Route::get('/admin/dashboard', [CustomerProductController::class, 'adminDashboard'])->name('admin.dashboard');

    // Admin Customer List
    Route::get('/admin/customers', [CustomerProductController::class, 'adminCustomers'])->name('admin.customers');

    // Approve Customer Products
    Route::patch('/admin/customer-products/{id}/approve', [CustomerProductController::class, 'approve'])->name('customer_products.approve');

    // Delete Product
    Route::delete('/admin/products/{id}', [CustomerProductController::class, 'deleteProduct'])->name('products.delete');
});

Route::get('/states/{country_id}', function ($country_id) {
    return response()->json(State::where('country_id', $country_id)->get());
});

Route::get('/cities/{state_id}', function ($state_id) {
    return response()->json(City::where('state_id', $state_id)->get());
});


Route::get('/add_product', [ProductController::class, 'create'])->name('product.create');
Route::post('/add_product', [ProductController::class, 'store'])->name('product.store');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.delete');


