@extends('layouts.app')

@section('title', 'Reset Password - FreelanceHub')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h4><i class="fas fa-key me-2"></i>Reset Your Password</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('password.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">At least 8 characters, with uppercase, lowercase, and numbers.</small>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                               id="password_confirmation" name="password_confirmation" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check-circle me-2"></i>Reset Password
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p class="small">
                        <a href="{{ route('login') }}"><i class="fas fa-arrow-left me-1"></i>Back to Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
