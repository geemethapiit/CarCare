<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all users from the 'users' table
        $users = User::all();

        // Pass the users data to the view
        return view('users.index', compact('users'));
    }
}