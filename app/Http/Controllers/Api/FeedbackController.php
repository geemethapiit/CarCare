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
                'AppointmentID' => 'required|exists:appointments,AppointmentID',
                'ServiceTypeId' => 'required|exists:service,ServiceTypeId',
                'BranchID' => 'required|exists:branches,BranchID',
                'rating' => 'required|integer|between:1,5',
                'feedback' => 'nullable|string',  // Change 'description' to 'feedback' to match the migration
            ]);

            // Create the feedback record
            $feedback = Feedback::create([
                'AppointmentID' => $validatedData['AppointmentID'],
                'ServiceTypeId' => $validatedData['ServiceTypeId'],
                'BranchID' => $validatedData['BranchID'],
                'rating' => $validatedData['rating'],
                'feedback' => $validatedData['feedback'],  // Change 'description' to 'feedback'
                'user_id' => Auth::id(), // Assuming user authentication is being used
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
