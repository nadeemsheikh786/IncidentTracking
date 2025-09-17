<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Incident\UpdateIncidentAdminRequest;
use App\Models\Incident;
use App\Models\IncidentActivity;
use App\Models\User;

class IncidentAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    public function edit(Incident $incident)
    {
        $responders = User::where('role', \App\Enums\UserRole::RESPONDER)->get();
        return view('admin.incidents.edit', compact('incident','responders'));
    }

    public function update(UpdateIncidentAdminRequest $request, Incident $incident)
    {
        $old = ['status' => $incident->status?->value, 'assigned_to' => $incident->assigned_to];
        $incident->update($request->only(['status','assigned_to']));

        if ($old['status'] !== $incident->status->value) {
            IncidentActivity::create([
                'incident_id' => $incident->id,
                'user_id' => $request->user()->id,
                'type' => 'status_changed',
                'data' => ['from' => $old['status'], 'to' => $incident->status->value],
            ]);
        }
        if ($old['assigned_to'] != $incident->assigned_to) {
            IncidentActivity::create([
                'incident_id' => $incident->id,
                'user_id' => $request->user()->id,
                'type' => 'assigned',
                'data' => ['to' => $incident->assigned_to],
            ]);
        }

        // queued notifications
        if ($old['status'] !== $incident->status->value) {
            $incident->user->notify(new \App\Notifications\IncidentStatusChanged($incident, $old['status'], $incident->status->value));
            if ($incident->assignee) {
                $incident->assignee->notify(new \App\Notifications\IncidentStatusChanged($incident, $old['status'], $incident->status->value));
            }
        }
        if ($old['assigned_to'] != $incident->assigned_to && $incident->assignee) {
            // simple assignment notice using same template
            $incident->assignee->notify(new \App\Notifications\IncidentStatusChanged($incident, $incident->status->value, $incident->status->value));
        }

        return redirect()->route('incidents.show', $incident)->with('success', 'Incident updated.');
    }
}
