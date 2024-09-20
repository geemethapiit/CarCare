<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\ServiceRecord; // Ensure you have a ServiceRecord model

class ServiceRecordController extends Controller
{
    // Show the form to create a new service record
    public function create()
    {
        $adminUsers = AdminUser::all(); // Fetch all admin users
        $vehicles = Vehicle::all();
        return view('service_records_create', compact('adminUsers')); // Pass the list to your view
    }

    // Handle the form submission to store a new service record
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'vehicle_number' => 'required|exists:vehicles,vehicle_number',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'supervisor' => 'required|exists:admin_users,name',
            'current_mileage' => 'required|integer|min:0',

            // Oil and Lubrication Services
            'engine_oil' => 'nullable|string',
            'engine_oil_change_mileage' => 'nullable|integer|min:0',
            'clutch_oil' => 'nullable|string',
            'clutch_oil_change_mileage' => 'nullable|integer|min:0',
            'brake_oil' => 'nullable|string',
            'brake_oil_change_mileage' => 'nullable|integer|min:0',
            'coolant' => 'nullable|string',
            'coolant_change_mileage' => 'nullable|integer|min:0',
            'oil_filter' => 'nullable|string',
            'oil_filter_change_mileage' => 'nullable|integer|min:0',
            'power_steering_fluid' => 'nullable|string',
            'power_steering_fluid_mileage' => 'nullable|integer|min:0',
            'air_filter' => 'nullable|string',
            'air_filter_change_mileage' => 'nullable|integer|min:0',
            'fuel_filter' => 'nullable|string',
            'fuel_filter_change_mileage' => 'nullable|integer|min:0',
            'ac_filter' => 'nullable|string',
            'ac_filter_change_mileage' => 'nullable|integer|min:0',
            'gear_oil' => 'nullable|string',
            'gear_oil_change_mileage' => 'nullable|integer|min:0',
            'chassis_lubrication' => 'nullable|string',
            'chassis_lubrication_change_mileage' => 'nullable|integer|min:0',
            'differential_oil' => 'nullable|string',
            'differential_oil_change_mileage' => 'nullable|integer|min:0',

            // Tire and Wheel Services
            'tire_rotation' => 'nullable|string',
            'tire_rotation_change_mileage' => 'nullable|integer|min:0',
            'wheel_alignment' => 'nullable|string',
            'wheel_alignment_mileage' => 'nullable|integer|min:0',
            'tire_balancing' => 'nullable|string',
            'tire_balancing_change_mileage' => 'nullable|integer|min:0',
            'flat_tire_repair' => 'nullable|string',
            'tire_replacement' => 'nullable|string',
            'tire_replacement_mileage' => 'nullable|integer|min:0',
            'wheel_rim_inspection' => 'nullable|string',
            'tpms' => 'nullable|string',

            // Battery and Electrical Services
            'battery_replacement' => 'nullable|string',
            'battery_terminal_cleaning' => 'nullable|string',
            'alternator_testing' => 'nullable|string',
            'starter_motor_testing' => 'nullable|string',
            'electrical_wiring_inspection' => 'nullable|string',
            'headlight_taillight_replacement' => 'nullable|string',
            'fuse_relay_replacement' => 'nullable|string',

            // Cleaning and Detailing Services
            'exterior_car_wash' => 'nullable|string',
            'interior_vacuuming' => 'nullable|string',
            'engine_bay_cleaning' => 'nullable|string',
            'waxing_polishing' => 'nullable|string',
            'interior_detailing' => 'nullable|string',
            'window_cleaning_tinting' => 'nullable|string',
            'odor_removal_air_purification' => 'nullable|string',
            'washing_solvent_refill' => 'nullable|string',
            'wiper_blade_replacement' => 'nullable|string',

            // Mechanical Repair Services
            'brake_system_repair' => 'nullable|string',
            'brake_system_repair_mileage' => 'nullable|integer|min:0',
            'suspension_repair' => 'nullable|string',
            'suspension_repair_mileage' => 'nullable|integer|min:0',
            'exhaust_system_repair' => 'nullable|string',
            'cooling_system_repair' => 'nullable|string',
            'cooling_system_repair_mileage' => 'nullable|integer|min:0',
            'transmission_repair' => 'nullable|string',
            'transmission_repair_mileage' => 'nullable|integer|min:0',
            'steering_system_repair' => 'nullable|string',
            'steering_system_repair_mileage' => 'nullable|integer|min:0',
            'engine_repair' => 'nullable|string',
            'radiator_cap_replacement' => 'nullable|string',
            'radiator_hoses_replacement' => 'nullable|string',
            'radiator_hoses_replacement_mileage' => 'nullable|integer|min:0',
        ]);

        // Create a new service record with the validated data
        ServiceRecord::create($validatedData);

        return redirect()->route('service_records.create')->with('success', 'Service record added successfully.');

    }



}