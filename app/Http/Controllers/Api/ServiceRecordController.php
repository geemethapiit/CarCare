<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;

class ServiceRecordController extends Controller
{
    /**
     * Get the service records by vehicle number.
     */
    public function getServiceRecords($vehicle_no)
    {
        \Log::info('Fetching service records $vehicle_no');
        // Fetch the service records for the given vehicle number
        $serviceRecords = ServiceRecord::where('vehicle_number', $vehicle_no)
            ->select([
                'serviceRecId',
                'vehicle_number',
                'date',
                'time',
                'supervisor',
                'current_mileage',
            ])
            ->get();

        if ($serviceRecords->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No service records found for the given vehicle number',
            ], 404);
        }

        // Return the service records in JSON format
        return response()->json([
            'status' => 'success',
            'data' => $serviceRecords,
        ]);
        \Log::info('Service records fetched successfully');
        \Log::info($serviceRecords);
    }

    // Fetch lube service records
    public function getLubeServiceRecords($vehicle_no, $service_type)
    {
        // Ensure service_type is 'lube'
        if ($service_type !== 'lube') {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid service type',
            ], 400);
        }

        // Fetch the service records for the given vehicle number
        $serviceRecords = ServiceRecord::where('vehicle_number', $vehicle_no)
            ->select([
                'serviceRecId',
                'vehicle_number',
                'date',
                'time',
                'supervisor',
                'current_mileage',
                'engine_oil',
                'clutch_oil',
                'brake_oil',
                'coolant',
                'oil_filter',
                'power_steering_fluid',
                'air_filter',
                'fuel_filter',
                'ac_filter',
                'gear_oil',
                'chassis_lubrication',
                'differential_oil',
            ])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $serviceRecords,
        ]);
    }

    // Fetch tire service records
    public function getTireServiceRecords($vehicle_no, $service_type)
    {
        // Ensure service_type is 'tyre'
        if ($service_type !== 'tyre') {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid service type',
            ], 400);
        }

        // Fetch the service records for the given vehicle number
        $serviceRecords = ServiceRecord::where('vehicle_number', $vehicle_no)
            ->select([
                'serviceRecId',
                'vehicle_number',
                'date',
                'time',
                'supervisor',
                'current_mileage',
                'tire_rotation',
                'wheel_alignment',
                'tire_balancing',
                'flat_tire_repair',
                'tire_replacement',
                'wheel_rim_inspection',
                'tpms',
            ])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $serviceRecords,
        ]);
    }

    // Fetch battery service records
    public function getBatteryServiceRecords($vehicle_no, $service_type)
    {
        // Ensure service_type is 'battery'
        if ($service_type !== 'battery') {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid service type',
            ], 400);
        }

        // Fetch the service records for the given vehicle number
        $serviceRecords = ServiceRecord::where('vehicle_number', $vehicle_no)
            ->select([
                'serviceRecId',
                'vehicle_number',
                'date',
                'time',
                'supervisor',
                'current_mileage',
                'battery_replacement',
                'battery_terminal_cleaning',
                'alternator_testing',
                'starter_motor_testing',
                'electrical_wiring_inspection',
                'headlight_taillight_replacement',
                'fuse_relay_replacement',
            ])
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $serviceRecords,
        ]);
    }
}
