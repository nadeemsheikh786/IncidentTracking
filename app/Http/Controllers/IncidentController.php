<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\IncidentActivity;
use App\Enums\IncidentSeverity;
use App\Enums\IncidentStatus;
use App\Http\Requests\Incident\StoreIncidentRequest;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Incident::with(['user','assignee'])
            ->when(!$request->user()->isAdmin() && !$request->user()->isResponder(), fn($q) => $q->where('user_id', $request->user()->id))
            ->when($request->filled('severity'), fn($q) => $q->where('severity', $request->input('severity')))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('q'), function($q) use($request){
                $term = $request->input('q');
                $q->where(function($qq) use($term){
                    $qq->where('title','like', "%".$term."%")
                       ->orWhere('description','like', "%".$term."%");
                });
            });

        // simple sortable by column & direction
        $sort = in_array($request->input('sort'), ['created_at','severity','status','title']) ? $request->input('sort') : 'created_at';
        $dir  = $request->input('dir') === 'asc' ? 'asc' : 'desc';

        $incidents = $query->orderBy($sort, $dir)->paginate(5)->withQueryString();

        return view('incidents.index', [
            'incidents' => $incidents,
            'severities' => IncidentSeverity::values(),
            'statuses' => IncidentStatus::values(),
            'sort' => $sort, 'dir' => $dir,
        ]);
    }

    public function create()
    {
        return view('incidents.create', ['severities' => IncidentSeverity::values()]);
    }

    public function store(StoreIncidentRequest $request)
    {
        $incident = Incident::create([
            'user_id' => $request->user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'severity' => $request->input('severity'),
            'status' => \App\Enums\IncidentStatus::OPEN,
        ]);

        IncidentActivity::create([
            'incident_id' => $incident->id,
            'user_id' => $request->user()->id,
            'type' => 'created',
            'data' => ['severity' => $incident->severity->value]
        ]);

        // notify admins of new incident (queued notifications)
        $admins = \App\Models\User::where('role', \App\Enums\UserRole::ADMIN)->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\IncidentCreated($incident));

        return redirect()->route('incidents.show', $incident)->with('success','Incident reported.');
    }

    public function show(Incident $incident)
    {
        $this->authorize('view', $incident);

        $incident->load(['user','assignee','comments.user','activities.user']);
        return view('incidents.show', compact('incident'));
    }
}
