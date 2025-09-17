<div class="border rounded p-3 mb-2 bg-white">
  <div class="d-flex justify-content-between">
    <div class="fw-medium text-gray-800">{{ $c->user->name }}</div>
    <div class="text-muted small">{{ $c->created_at->diffForHumans() }}</div>
  </div>
  <div class="mt-2">{{ $c->comment }}</div>
</div>
