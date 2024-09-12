<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

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
    \Log::info('show method called');
    try {
        // Fetch branches with feedbacks' average rating
        $branches = Branch::select('BranchID', 'name', 'address', 'telephone')
            ->with(['feedbacks' => function ($query) {
                $query->select('BranchID', DB::raw('AVG(rating) as average_rating'))
                      ->groupBy('BranchID');
            }])
            ->get();

        // Format the branches with average rating
        $formattedBranches = $branches->map(function ($branch) {
            $averageRating = $branch->feedbacks->isNotEmpty() ? $branch->feedbacks->first()->average_rating : 3; // Default to 3
            $branch->average_rating = $averageRating;
            unset($branch->feedbacks); // Clean up feedbacks relation after use
            return $branch;
        });

        return response()->json($formattedBranches);
    } catch (\Exception $e) {
        // Log the exception for detailed error
        \Log::error('Error fetching branches: ' . $e->getMessage());

        return response()->json(['error' => 'Failed to load branches'], 500);
    }
}

}
