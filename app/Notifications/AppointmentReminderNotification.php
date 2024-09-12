<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentReminderNotification extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        // Use database or custom push notification channel
        return ['database']; // or specify a custom push notification channel
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Reminder: You have an appointment scheduled on ' . $this->appointment->date . ' at ' . $this->appointment->time,
            'appointment_id' => $this->appointment->AppointmentID,
        ];
    }
}
