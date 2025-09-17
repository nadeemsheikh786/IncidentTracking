@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-8">
    <div class="card p-4 md:p-5 mb-3 shadow-sm">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h4 class="mb-1">{{ $incident->title }}</h4>
          <div class="small text-muted">Reported by {{ $incident->user->name }} • {{ $incident->created_at->toDayDateTimeString() }}</div>
        </div>
        @if(auth()->user()->isAdmin())
          <a class="btn btn-outline-primary" href="{{ route('admin.incidents.edit',$incident) }}">Admin Manage</a>
        @endif
      </div>
      <hr>
      <div class="mb-2">
        <span class="badge badge-sev-{{ $incident->severity->value }}">{{ ucfirst($incident->severity->value) }}</span>
        <span class="badge text-bg-secondary">{{ ucfirst(str_replace('_',' ',$incident->status->value)) }}</span>
        <span class="badge text-bg-light border">Assignee: {{ $incident->assignee?->name ?? 'Unassigned' }}</span>
      </div>
      <div class="mt-3">
        {{ $incident->description }}
      </div>
    </div>

    <div class="card p-4 md:p-5 shadow-sm" id="comments-card">
      <h5 class="mb-3">Comments</h5>
      <div id="comments-list">
        @foreach($incident->comments as $c)
          @include('incidents.partials.comment', ['c' => $c])
        @endforeach
      </div>
      <hr>
      <form id="comment-form" action="{{ route('comments.store',$incident) }}" method="POST">
        @csrf
        <div class="mb-2">
          <textarea name="comment" rows="3" class="form-control form-control-lg" placeholder="Write a comment..."></textarea>
        </div>
        <button class="btn btn-primary btn-lg">Post Comment</button>
      </form>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card p-4 md:p-5 shadow-sm">
      <h5 class="mb-3">Activity</h5>
      <ul class="list-unstyled divide-y">
        @foreach($incident->activities as $a)
          <li class="mb-2">
            <div class="small text-muted">{{ $a->created_at->diffForHumans() }}</div>
            <div class="fw-medium">
              @if($a->type === 'created') Created incident @endif
              @if($a->type === 'status_changed') Status changed {{ $a->data['from'] }} → {{ $a->data['to'] }} @endif
              @if($a->type === 'assigned') Assigned to user #{{ $a->data['to'] }} @endif
              @if($a->type === 'commented') New comment added @endif
              by {{ $a->user->name }}
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $('#comment-form').on('submit', function(e){
    e.preventDefault();
    const $form = $(this);
    $.post($form.attr('action'), $form.serialize())
      .done(function(res){
        if(res.ok){
          $('#comments-list').prepend(res.html);
          $form[0].reset();
        }
      })
      .fail(function(xhr){
        alert('Failed to post comment.');
      });
  });
</script>
@endpush
