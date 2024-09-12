<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Notifications\AppointmentReminderNotification;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send reminders for upcoming appointments';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Define the time range for sending reminders (e.g., 2 hours before the appointment)
        $reminderTime = Carbon::now()->addHours(2);

        // Find appointments that are within the reminder time and haven't been reminded yet
        $appointments = Appointment::where('date', $reminderTime->toDateString())
            ->where('time', $reminderTime->toTimeString())
            ->where('status', '!=', 'reminded') // Ensure to add a `status` column to track reminded status
            ->get();

        foreach ($appointments as $appointment) {
            $appointment->user->notify(new AppointmentReminderNotification($appointment));
            // Update appointment status to reminded
            $appointment->status = 'reminded';
            $appointment->save();
        }

        $this->info('Reminders sent successfully.');
    }
}
