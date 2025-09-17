<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Incident;
use App\Models\IncidentComment;
use App\Models\IncidentActivity;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Incident $incident)
    {
        $this->authorize('comment', $incident);

        $comment = IncidentComment::create([
            'incident_id' => $incident->id,
            'user_id' => $request->user()->id,
            'comment' => $request->input('comment'),
        ]);

        IncidentActivity::create([
            'incident_id' => $incident->id,
            'user_id' => $request->user()->id,
            'type' => 'commented',
            'data' => ['comment_id' => $comment->id],
        ]);

        // queued notifications to relevant parties
        $notifyUsers = collect();
        $notifyUsers->push($incident->user);
        if ($incident->assignee) { $notifyUsers->push($incident->assignee); }
        $admins = \App\Models\User::where('role', \App\Enums\UserRole::ADMIN)->get();
        $notifyUsers = $notifyUsers->merge($admins)->unique('id')->reject(fn($u) => $u->id === $request->user()->id);
        foreach ($notifyUsers as $u) {
            $u->notify(new \App\Notifications\IncidentCommented($incident, $comment));
        }

        if ($request->ajax()) {
            return response()->json([
                'ok' => true,
                'html' => view('incidents.partials.comment', ['c' => $comment->load('user')])->render()
            ]);
        }

        return back()->with('success','Comment added.');
    }
}
