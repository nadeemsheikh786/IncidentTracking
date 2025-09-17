@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 mx-auto">
    <div class="card p-4 md:p-5 shadow-sm">
      <h4 class="mb-3">Manage Incident</h4>
      <form method="POST" action="{{ route('admin.incidents.update', $incident) }}">
        @csrf @method('PUT')
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select form-select-lg">
            @foreach(\App\Enums\IncidentStatus::values() as $st)
              <option value="{{ $st }}" @selected($incident->status->value===$st)>{{ ucfirst(str_replace('_',' ',$st)) }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Assign to Responder</label>
          <select name="assigned_to" class="form-select form-select-lg">
            <option value="">Unassigned</option>
            @foreach($responders as $u)
              <option value="{{ $u->id }}" @selected($incident->assigned_to===$u->id)>{{ $u->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="d-grid">
          <button class="btn btn-primary btn-lg">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
