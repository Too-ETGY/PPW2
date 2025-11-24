<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $application;

    public function __construct($application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['database']; // stored in notifications table
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Status lamaran Anda untuk {$this->application->job->title} telah diperbarui menjadi {$this->application->status}.",
            'application_id' => $this->application->id,
            'status' => $this->application->status,
        ];
    }
}
