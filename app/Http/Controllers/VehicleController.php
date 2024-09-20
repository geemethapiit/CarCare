<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // Index method to display all vehicles
    public function index()
    {
        $vehicles = Vehicle::with('user')->get();
        return view('vehicles.index', compact('vehicles'));
    }

    // Approve method to change the vehicle's status to 'approved'
    public function approve($id)
    {
        // Find the vehicle by its ID
        $vehicle = Vehicle::findOrFail($id);

        // Update the vehicle's status to 'approved'
        $vehicle->status = 'approved';
        $vehicle->save();

        // Redirect back to the vehicles page with a success message
        return redirect()->route('vehicles.index')->with('success', 'Vehicle approved successfully.');
    }
}
