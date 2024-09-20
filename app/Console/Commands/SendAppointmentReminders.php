<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Notifications\AppointmentReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    protected $signature = 'reminders:appointments';

    protected $description = 'Send reminders for upcoming appointments a day before and 5 hours before the appointment.';

    public function handle()
    {
        // Get the current time
        $now = Carbon::now();

        // Find appointments happening a day from now
        $dayBefore = $now->copy()->addDay();
        $appointmentsDayBefore = Appointment::whereDate('date', $dayBefore->toDateString())
            ->where('time', '>=', $now->format('H:i:s'))
            ->get();

        // Find appointments happening 5 hours from now
        $fiveHoursBefore = $now->copy()->addHours(5);
        $appointmentsFiveHoursBefore = Appointment::whereDate('date', $fiveHoursBefore->toDateString())
            ->whereTime('time', $fiveHoursBefore->format('H:i:s'))
            ->get();

        // Send notifications for appointments a day before
        foreach ($appointmentsDayBefore as $appointment) {
            $user = $appointment->user; // assuming 'user()' relationship is defined
            $user->notify(new AppointmentReminderNotification($appointment));
        }

        // Send notifications for appointments 5 hours before
        foreach ($appointmentsFiveHoursBefore as $appointment) {
            $user = $appointment->user;
            $user->notify(new AppointmentReminderNotification($appointment));
        }

        $this->info('Appointment reminders sent successfully!');
    }
}
