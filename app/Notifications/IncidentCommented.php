<?php

namespace App\Notifications;

use App\Models\Incident;
use App\Models\IncidentComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class IncidentCommented extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Incident $incident, public IncidentComment $comment) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'incident_commented',
            'incident_id' => $this->incident->id,
            'title' => $this->incident->title,
            'comment_id' => $this->comment->id,
            'by' => $this->comment->user->name,
        ];
    }
}
