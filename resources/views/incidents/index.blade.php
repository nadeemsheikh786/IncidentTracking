@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
  <h3 class="m-0">Incidents</h3>
  <a href="{{ route('incidents.create') }}" class="btn btn-primary">
    Report Incident
  </a>
</div>

<div class="card p-3 mb-3 filter-bar">
  <form method="GET" class="row g-2 align-items-end">
    <div class="col-12 col-md-3">
      <label class="form-label mb-1">Search</label>
      <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Title or description">
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label mb-1">Severity</label>
      <select name="severity" class="form-select">
        <option value="">All severities</option>
        @foreach($severities as $s)
          <option value="{{ $s }}" @selected(request('severity')===$s)>{{ ucfirst($s) }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label mb-1">Status</label>
      <select name="status" class="form-select">
        <option value="">All status</option>
        @foreach($statuses as $s)
          <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-12 col-md-3">
      <label class="form-label mb-1">Sort</label>
      <div class="d-flex gap-2">
        <select name="sort" class="form-select">
          <option value="created_at" @selected($sort==='created_at')>Newest</option>
          <option value="title" @selected($sort==='title')>Title</option>
          <option value="severity" @selected($sort==='severity')>Severity</option>
          <option value="status" @selected($sort==='status')>Status</option>
        </select>
        <select name="dir" class="form-select" style="max-width:120px">
          <option value="desc" @selected($dir==='desc')>Desc</option>
          <option value="asc" @selected($dir==='asc')>Asc</option>
        </select>
      </div>
    </div>

    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
      <a href="{{ route('incidents.index') }}" class="btn btn-outline-secondary">Reset</a>
      <button class="btn btn-primary">Apply</button>
    </div>
  </form>
</div>

@if($incidents->count() === 0)
  <div class="card p-5 text-center">
    <div class="h5 mb-2">No incidents found</div>
    <div class="text-muted mb-3">Try adjusting your filters or search query.</div>
    <a href="{{ route('incidents.create') }}" class="btn btn-primary">Report Incident</a>
  </div>
@else
  <div class="card p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light position-sticky top-0" style="z-index:1">
          <tr>
            <th style="min-width:260px">Title</th>
            <th>Severity</th>
            <th>Status</th>
            <th>Reporter</th>
            <th>Assignee</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>
          @foreach($incidents as $i)
            <tr onclick="location.href='{{ route('incidents.show',$i) }}'" style="cursor:pointer">
              <td class="fw-medium text-truncate" style="max-width:380px">{{ $i->title }}</td>
              <td>
                <span class="badge badge-sev-{{ $i->severity->value ?? $i->severity }}">
                  {{ ucfirst(is_string($i->severity) ? $i->severity : $i->severity->value) }}
                </span>
              </td>
              <td>
                @php $st = is_string($i->status) ? $i->status : $i->status->value; @endphp
                <span class="badge text-bg-secondary">{{ ucfirst(str_replace('_',' ',$st)) }}</span>
              </td>
              <td>{{ $i->user->name }}</td>
              <td>{{ $i->assignee?->name ?? '-' }}</td>
              <td>{{ $i->created_at->diffForHumans() }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="p-3">
      {{-- Bootstrap 5 pagination, keeps current filters --}}
      {!! $incidents->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') !!}
    </div>
  </div>
@endif
@endsection
