<?php

namespace App\Notifications;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class IncidentStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Incident $incident, public string $from, public string $to) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'incident_status_changed',
            'incident_id' => $this->incident->id,
            'title' => $this->incident->title,
            'from' => $this->from,
            'to' => $this->to,
        ];
    }
}
