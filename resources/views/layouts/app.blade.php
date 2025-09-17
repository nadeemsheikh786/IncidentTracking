<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Incidents') }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { background:#f6f7fb; }
    .navbar { background:#0b5ed7; }
    .navbar .navbar-brand, .navbar-nav .nav-link, .navbar-text { color:#fff !important; }
    .card { border:none; box-shadow:0 10px 20px rgba(0,0,0,.05); border-radius:1rem; }
    .badge-sev-low{background:#6c757d}
    .badge-sev-medium{background:#0d6efd}
    .badge-sev-high{background:#fd7e14}
    .badge-sev-critical{background:#dc3545}

    /* UI polish */
    .filter-bar .form-select, .filter-bar .form-control { min-height: 42px; }
    .filter-bar .btn { min-height: 42px; }
    .table-hover tbody tr:hover { background: #f0f5ff; }
    .btn-primary { background:#0b5ed7; border-color:#0b5ed7; }
    .btn-outline-primary { border-color:#0b5ed7; color:#0b5ed7; }
    .btn-outline-primary:hover { background:#0b5ed7; color:#fff; }
    .badge { border-radius:.5rem; }
	
	.filter-bar .form-select, .filter-bar .form-control { min-height: 42px; }
.filter-bar .btn { min-height: 42px; }
.table-hover tbody tr:hover { background: #f0f5ff; }

  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('incidents.index') }}">Incident Tracker</a>
    <div class="ms-auto d-flex align-items-center gap-3">
      @auth
        <div class="dropdown">
          <button class="btn btn-light btn-sm relative" data-bs-toggle="dropdown" aria-expanded="false">
            Notifications
            <span class="badge bg-danger align-middle">{{ auth()->user()->unreadNotifications()->count() }}</span>
          </button>
          <ul id="notifDropdown" class="dropdown-menu dropdown-menu-end p-2" style="min-width: 320px;">
            @forelse(auth()->user()->unreadNotifications()->take(8)->get() as $n)
            <li class="p-2 rounded hover:bg-gray-50">
              <div class="text-sm fw-medium">{{ Str::headline(str_replace('_',' ', $n->data['type'] ?? 'notification')) }}</div>
              <div class="text-muted small">{{ $n->created_at->diffForHumans() }}</div>
              <div class="small text-truncate">{{ $n->data['title'] ?? '' }}</div>
            </li>
            @empty
            <li class="p-3 text-muted small">No new notifications.</li>
            @endforelse
          </ul>
        </div>
        <span class="navbar-text me-3">Hi, {{ auth()->user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
          @csrf
          <button class="btn btn-light btn-sm">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn btn-light btn-sm me-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>
      @endauth
    </div>
  </div>
</nav>

<div class="container mb-5 px-3 md:px-0">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  {{ $slot ?? '' }}
  @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $.ajaxSetup({
    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')}
  });
</script>
@stack('scripts')
</body>
</html>
