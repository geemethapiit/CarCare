<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthManagerController extends Controller
{

    public function registerAdmin(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Log::info('Validation passed', $request);

        // Create a new admin user in the admin_users table
        AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encrypt the password using bcrypt
        ]);

        // Redirect to the admin login page with a success message
        return redirect()->route('login')->with('success', 'Admin registration successful. Please log in.');
    }


    public function loginAdmin(Request $request)
    {
        // Validate the login credentials
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the admin
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            // Authentication successful, retrieve the authenticated admin
            $admin = Auth::guard('admin')->user();

            // Retrieve all products
            $products = Product::all();

            // Store the admin's name in the session
            session(['admin_name' => $admin->name]);

            // Pass the admin's name and products data to the view
            return view('adminconsole', [
                'name' => session('admin_name'),
                'products' => $products,
            ]);
        }

        // Authentication failed, return back with error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

    }
}
