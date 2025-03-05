<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\CustomerProduct;

class AuthController extends Controller
{
    //  Login session
    public function showLoginForm()
    {
        if (Auth::check() && session('role') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::check() && session('role') === 'user') {
            return redirect()->route('customer_products.create');
        }

        if (Session::has('customer_logged_in')) {
            return redirect()->route('products.index');
        }

        return view('auth.login');
    }

    // Handle Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check Users table if it is admin or user
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($user->password === $request->password) {
                Auth::login($user);
                session(['role' => $user->role]);

                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard')->with('success', 'Admin Login successful!');
                } else {
                    return redirect()->route('customer_products.create')->with('success', 'User Login successful!');
                }
            } else {
                return back()->with('error', 'Incorrect password. Please try again.');
            }
        }

        // Check CustomerProduct table
        $customer = CustomerProduct::where('email', $request->email)->first();

        if ($customer) {
            if ($customer->password !== $request->password) {
                return back()->with('error', 'Incorrect password. Please try again.');
            }

            if ($customer->status !== 'approved') {
                return back()->with('error', 'Your account is pending approval. Please wait for admin approval.');
            }

            // customer session
            Session::put('customer_id', $customer->id);
            Session::put('customer_logged_in', true);

            return redirect()->route('products.index')->with('success', 'Customer Login successful!');
        }

        return back()->with('error', 'Invalid login . Please check your email and try again.');
    }

    //  registration session
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            if (session('role') === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'You are already logged in.');
            } elseif (session('role') === 'user') {
                return redirect()->route('customer_products.create')->with('error', 'You are already logged in.');
            }
        }

        if (Session::has('customer_logged_in')) {
            return redirect()->route('products.index')->with('error', 'You are already logged in.');
        }

        return view('auth.register');
    }

    // Handle User Registration
    public function register(Request $request)
    {
        $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15|min:10',
            'gender' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
        }

        // Create user
        User::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'photo' => $photoPath,
            'password' => $request->password,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    // Logout for all users
    public function logout(Request $request)
    {
        Auth::logout();
        Session::forget(['customer_id', 'customer_logged_in', 'role']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
