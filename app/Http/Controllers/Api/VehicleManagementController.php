<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleManagementController extends Controller
{
    // Display a listing of the vehicles
    public function index()
    {
        $vehicles = Vehicle::where('user', Auth::id())->get();
        return response()->json($vehicles);
    }

    // Store a newly created vehicle in storage
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_number' => 'required|unique:vehicles',
            'model' => 'required',
            'year' => 'required|integer',
        ]);

        $vehicle = Vehicle::create([
            'vehicle_number' => $request->vehicle_number,
            'model' => $request->model,
            'year' => $request->year,
            'user' => Auth::id(),  // Set the user to the authenticated user's ID
        ]);

        return response()->json($vehicle, 201); // 201 Created
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
    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->user != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $vehicle->delete();

        return response()->json(['message' => 'Vehicle deleted successfully.']);
    }
}
