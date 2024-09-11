<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;


class BranchController extends Controller
{
    public function index()
    {
        // Fetch all branch names
        $branches = Branch::all(['BranchID', 'name']);

        // Return as JSON
        return response()->json($branches);
    }

    public function show()
    {
        // Fetch branch details
       $branchs = Branch::all(['BranchID', 'name', 'address', 'telephone']);

        // Return as JSON
        return response()->json($branchs);
    }
}
