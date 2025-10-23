@extends('layouts.app')

@section('title', 'Register - FreelanceHub')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h4><i class="fas fa-user-plus me-2"></i>Create Account</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
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
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center mb-3">
                    <p class="small">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                </div>

                <div class="text-center">
                    <h6 class="text-muted mb-3">Or sign up with</h6>
                    <div class="btn-group-vertical w-100" role="group">
                        <a href="{{ route('oauth.redirect', 'google') }}" class="btn btn-outline-danger">
                            <i class="fab fa-google me-2"></i>Sign up with Google
                        </a>
                        <a href="{{ route('oauth.redirect', 'github') }}" class="btn btn-outline-dark mt-2">
                            <i class="fab fa-github me-2"></i>Sign up with GitHub
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
