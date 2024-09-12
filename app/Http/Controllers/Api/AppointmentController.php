<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\AppointmentSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Create appointment
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validateappointment = Validator::make($request->all(), [
                'date' => 'required|date',
                'time' => 'required|string',
                'ServiceTypeId' => 'required|exists:service,ServiceTypeId',
                'BranchID' => 'required|exists:branches,BranchID',
                'vehicle_number' => 'required|exists:vehicles,vehicle_number',
            ]);

            if ($validateappointment->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateappointment->errors()
                ], 401);
            }

            // Fetch the maximum allowed appointments from the settings
            $maxAppointments = AppointmentSetting::first()->max_appointments ?? 4;

            // Check if the time slot is already booked
            $existingAppointments = Appointment::where('date', $request->date)
                ->where('time', $request->time)
                ->count();

            if ($existingAppointments >= $maxAppointments) {
                return response()->json([
                    'status' => false,
                    'message' => 'The time slot is already fully booked. Please choose a different time.'
                ], 409);
            }

            $appointment = Appointment::create([
                'date' => $request->date,
                'time' => $request->time,
                'status' => 'pending',
                'ServiceTypeId' => $request->ServiceTypeId,
                'BranchID' => $request->BranchID,
                'vehicle_number' => $request->vehicle_number,
                'user_id' => Auth::id(),
            ]);

            // Generate a token for the user who made the appointment
            $user = User::find(Auth::id());

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $token = $user->createToken('API TOKEN')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Appointment Created Successfully',
                'appointment' => $appointment,
                'token' => $token
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    //API for the customer to view their upcoming appointments
    /**
     * Get upcoming appointments for the logged-in user
     * @param Request $request
     * @return JsonResponse
     */
    public function getUpcomingAppointments()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $appointments = Appointment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();


            $appointments = $appointments->map(function ($appointment) {
                return [
                    'id' => $appointment->AppointmentID,
                    'vehicle_no' => $appointment->vehicle_number,
                    'date' => $appointment->date,
                    'time' => $appointment->time,
                    'status' => $appointment->status,
                    'service_type' => $appointment->serviceType->ServiceTypeName ?? 'N/A',
                    'branch' => $appointment->branch->name ?? 'N/A',
                ];
            });

            return response()->json([
                'status' => true,
                'appointments' => $appointments
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    //get history appointment booking.
    /*public function getAppointmentHistory()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $appointments = Appointment::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled', 'not show up'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();


            // Transform appointments data
            $appointmentData = $appointments->map(function ($appointment) {
                return [
                    'id' => $appointment->AppointmentID,
                    'vehicle_no' => $appointment->vehicle_number,
                    'date' => $appointment->date,
                    'time' => $appointment->time,
                    'status' => $appointment->status,
                    'service_type' => $appointment->serviceType->ServiceTypeName ?? 'N/A',
                    'branch' => $appointment->branch->name ?? 'N/A',
                ];
            });


            return response()->json([
                'status' => true,
                'appointments' => $appointments
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }*/

    public function getAppointmentHistory()
{
    try {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $appointments = Appointment::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled', 'not show up'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        // Transform appointments data
        $appointmentData = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->AppointmentID,
                'vehicle_no' => $appointment->vehicle_number,
                'date' => $appointment->date,
                'time' => $appointment->time,
                'status' => $appointment->status,
                'service_type' => $appointment->serviceType->ServiceTypeName ?? 'N/A',
                'branch' => $appointment->branch->name ?? 'N/A',
            ];
        });

        return response()->json([
            'status' => true,
            'appointments' => $appointmentData // Return the transformed data
        ], 200);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}


    public function availableTimeSlots(Request $request)
    {
        // Validate the request parameters
        try{
            $request->validate([
            'date' => 'required|date',
            'BranchID' => 'required|exists:branches,BranchID'
        ]);



        $date = $request->date;
        $branchID = $request->BranchID;

        // Define possible time slots in 30-minute intervals
        $start = '08:00';
        $end = '18:00';
        $interval = new \DateInterval('PT30M'); // 30-minute intervals
        $period = new \DatePeriod(new \DateTime($start), $interval, new \DateTime($end));

        $timeSlots = [];
        foreach ($period as $dt) {
            $timeSlots[] = $dt->format('H:i');
        }

        // Array to store available time slots
        $availableSlots = [];

        foreach ($timeSlots as $slot) {
            // Count the number of appointments for the given date, time slot, and branch
            $count = Appointment::where('date', $date)
                ->where('time', $slot)
                ->where('BranchID', $branchID)
                ->count();

            // Check if there are less than 4 appointments for this slot at the given branch
            if ($count < 4) {
                $availableSlots[] = $slot;
            }
        }

        return response()->json([
            'status' => true,
            'available_slots' => $availableSlots
        ]);
    }   catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 400);
    }

    }


    // delete appointment
    public function cancelAppointment($appointmentid)
    {
        \Log::info('Attempting to delete vehicle with number: ' . $appointmentid);
        $appointment = Appointment::where('AppointmentID', $appointmentid)->first();

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        // Directly delete the vehicle without checking user ID
        $appointment->update([
            'status' => 'cancelled'
        ]);

        return response()->json(['message' => 'Appointment status updated to cancelled.']);
    }


}
