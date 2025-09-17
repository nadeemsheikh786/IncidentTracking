<?php

namespace App\Notifications;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class IncidentCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Incident $incident) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'incident_created',
            'incident_id' => $this->incident->id,
            'title' => $this->incident->title,
            'severity' => $this->incident->severity->value,
            'reporter' => $this->incident->user->name,
        ];
    }
}
