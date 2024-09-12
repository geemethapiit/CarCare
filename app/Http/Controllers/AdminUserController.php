<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    // Handle the registration request
    public function registerAdmin(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new admin user in the admin_users table
        AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encrypt the password using bcrypt
        ]);

        // Redirect to the admin login page with a success message
        return redirect()->route('login')->with('success', 'Admin registration successful. Please log in.');
    }


    public function logout(Request $request)
    {
        // Invalidate the session
        Auth::logout();

        // Clear the session data
        $request->session()->invalidate();

        // Regenerate the session to avoid session fixation attacks
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect()->route('login');
    }
}
