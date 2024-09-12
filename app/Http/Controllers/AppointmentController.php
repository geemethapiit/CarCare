<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function showCalendar(Request $request)
    {
        // Retrieve the selected date or default to today
        $selectedDate = $request->query('date', Carbon::today()->toDateString());

        // Get appointments for the selected date
        $appointments = Appointment::where('date', $selectedDate)
            ->orderBy('time')
            ->get();

        // Organize appointments by time slot
        $timeSlots = [];
        foreach ($appointments as $appointment) {
            $timeSlot = Carbon::parse($appointment->time)->format('H:i');
            if (!isset($timeSlots[$timeSlot])) {
                $timeSlots[$timeSlot] = [];
            }
            $timeSlots[$timeSlot][] = $appointment;
        }

        // Pass the selected date and time slots to the view
        return view('appointments.by_date', [
            'selectedDate' => $selectedDate,
            'timeSlots' => $timeSlots
        ]);
    }
}

