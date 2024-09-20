<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AppointmentReminderNotification extends Notification
{
    use Queueable;

    private $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        // Send via database and broadcast (you can add more channels if needed)
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'appointment_id' => $this->appointment->AppointmentID,
            'message' => 'Your appointment for service ' . $this->appointment->serviceType->name . ' is coming up on ' . $this->appointment->date . ' at ' . $this->appointment->time,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'appointment_id' => $this->appointment->AppointmentID,
            'message' => 'Your appointment for service ' . $this->appointment->serviceType->name . ' is coming up on ' . $this->appointment->date . ' at ' . $this->appointment->time,
        ]);
    }
}
