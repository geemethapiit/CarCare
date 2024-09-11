<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\Feedback;  
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{

    public function store(Request $request)
{
    try {
        // Validate the input
        $validatedData = $request->validate([
            'ServiceTypeId' => 'required|exists:service,ServiceTypeId',
            'BranchID' => 'required|exists:branches,BranchID',
            'rating' => 'required|integer|between:1,5',
            'description' => 'nullable|string',
        ]);

        // Create the feedback record
        $feedback = Feedback::create([
            'ServiceTypeId' => $validatedData['ServiceTypeId'],
            'BranchID' => $validatedData['BranchID'],
            'rating' => $validatedData['rating'],
            'description' => $validatedData['description'],
            'user_id' => Auth::id(),
        ]);

        // Return a JSON response with a success message and the created feedback
        return response()->json([
            'message' => 'Feedback submitted successfully.',
            'feedback' => $feedback,
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error submitting feedback.',
            'error' => $e->getMessage(),
        ], 500); // 500 status code indicates a server error
    }
}

}
