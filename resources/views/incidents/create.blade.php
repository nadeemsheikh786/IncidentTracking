@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 mx-auto">
    <div class="card p-4 md:p-5 shadow-sm">
      <h4 class="mb-3">Report a new incident</h4>
      <form method="POST" action="{{ route('incidents.store') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input name="title" class="form-control form-control-lg" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" rows="6" class="form-control form-control-lg" required>{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Severity</label>
          <select name="severity" class="form-select form-select-lg" required>
            @foreach($severities as $s)
              <option value="{{ $s }}" @selected(old('severity')===$s)>{{ ucfirst($s) }}</option>
            @endforeach
          </select>
        </div>
        <div class="d-grid">
          <button class="btn btn-primary btn-lg">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
