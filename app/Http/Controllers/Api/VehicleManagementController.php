<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class VehicleManagementController extends Controller
{
    // Display a listing of the vehicles
    public function index()
    {
        $vehicleNumbers = Vehicle::where('user_id', Auth::id())
                                 ->where('status', 'approved')
                                 ->pluck('vehicle_number');
        return response()->json($vehicleNumbers);
    }
    



// Store a newly created vehicle in storage
    public function store(Request $request)
{
    \Log::info('Attempting to create a new vehicle with number: ' . $request->vehicle_number);

    $request->validate([
        'vehicle_number' => 'required|unique:vehicles',
        'model' => 'required',
        'year' => 'required|integer',
        'vehicle_book_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'vehicle_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);


    $vehicleBookImagePath = null;
    if ($request->hasFile('vehicle_book_image')) {
        $vehicleBookImageFile = $request->file('vehicle_book_image');

        \Log::info('Uploaded vehicle book image details:', [
            'original_name' => $vehicleBookImageFile->getClientOriginalName(),
            'mime_type' => $vehicleBookImageFile->getMimeType(),
            'size' => $vehicleBookImageFile->getSize(),
            'temporary_path' => $vehicleBookImageFile->getPathname(),
        ]);

        $vehicleBookImagePath = $vehicleBookImageFile->store('vehicle_books', 'public');
    }

    $vehicleImagePath = null;
    if ($request->hasFile('vehicle_image')) {
        $vehicleImageFile = $request->file('vehicle_image');

        \Log::info('Uploaded vehicle image details:', [
            'original_name' => $vehicleImageFile->getClientOriginalName(),
            'mime_type' => $vehicleImageFile->getMimeType(),
            'size' => $vehicleImageFile->getSize(),
            'temporary_path' => $vehicleImageFile->getPathname(),
        ]);

        $vehicleImagePath = $vehicleImageFile->store('vehicle_images', 'public');
    }

   
    $vehicle = Vehicle::create([
        'vehicle_number' => $request->vehicle_number,
        'model' => $request->model,
        'year' => $request->year,
        'user_id' => Auth::id(),
        'vehicle_book_image' => $vehicleBookImagePath,  
        'vehicle_image' => $vehicleImagePath,           
        'status' => 'pending',
    ]);

    \Log::info('Vehicle created successfully', ['vehicle' => $vehicle]);

    return response()->json($vehicle, 200);
}






    // Display the specified vehicle
    public function show(Vehicle $vehicle)
    {
        if ($vehicle->user != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($vehicle);
    }

    // Update the specified vehicle in storage
    public function update(Request $request, Vehicle $vehicle)
    {
        if ($vehicle->user != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'vehicle_number' => 'required|unique:vehicles,vehicle_number,' . $vehicle->id,
            'model' => 'required',
            'year' => 'required|integer',
        ]);

        $vehicle->update($request->all());

        return response()->json($vehicle);
    }

    // Remove the specified vehicle from storage
    public function destroy($vehicle_number)
    {
        $vehicle = Vehicle::where('vehicle_number', $vehicle_number)->first();
        \Log::info('Attempting to delete vehicle with number: ' . $vehicle_number); 
    
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }
    
        // Directly delete the vehicle without checking user ID
        $vehicle->delete();
    
        return response()->json(['message' => 'Vehicle deleted successfully.']);
    }
}
