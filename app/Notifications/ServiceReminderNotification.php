<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ServiceReminderNotification extends Notification
{
    use Queueable;

    private $serviceDetails;

    public function __construct($serviceDetails)
    {
        $this->serviceDetails = $serviceDetails;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'service_id' => $this->serviceDetails->id,
            'message' => 'Your vehicle is due for service on ' . $this->serviceDetails->due_date,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'service_id' => $this->serviceDetails->id,
            'message' => 'Your vehicle is due for service on ' . $this->serviceDetails->due_date,
        ]);
    }
}
