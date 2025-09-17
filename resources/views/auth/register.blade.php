@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-4 md:p-5 shadow-sm">
      <h4 class="mb-3">Register</h4>
      <form method="POST" action="{{ url('/register') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input name="name" type="text" class="form-control form-control-lg" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input name="email" type="email" class="form-control form-control-lg" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input name="password" type="password" class="form-control form-control-lg" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Confirm Password</label>
          <input name="password_confirmation" type="password" class="form-control form-control-lg" required>
        </div>
        <button class="btn btn-primary btn-lg w-100">Create account</button>
      </form>
    </div>
  </div>
</div>
@endsection
