@extends('layouts.app')

@section('title', 'Login - FreelanceHub')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h4><i class="fas fa-sign-in-alt me-2"></i>Login</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <small>
                            <a href="{{ route('password.request') }}" class="text-muted">Forgot your password?</a>
                        </small>
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center mb-3">
                    <p class="small">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                </div>

                <div class="text-center mb-4">
                    <h6 class="text-muted mb-3">Or sign in with</h6>
                    <div class="btn-group-vertical w-100" role="group">
                        <a href="{{ route('oauth.redirect', 'google') }}" class="btn btn-outline-danger">
                            <i class="fab fa-google me-2"></i>Sign in with Google
                        </a>
                        <a href="{{ route('oauth.redirect', 'github') }}" class="btn btn-outline-dark mt-2">
                            <i class="fab fa-github me-2"></i>Sign in with GitHub
                        </a>
                    </div>
                </div>

                <hr class="my-4">

                <div class="text-center">
                    <h6 class="text-muted">Quick Testing Login</h6>
                    <p class="small text-muted">For testing the Job CRUD functionality</p>
                    <a href="{{ route('quick-login') }}" class="btn btn-success">
                        <i class="fas fa-user me-2"></i>Login as Test User
                    </a>
                    <div class="mt-2">
                        <small class="text-muted">
                            Email: test@example.com | Password: password
                        </small>
                    </div>

                    @if(app()->environment(['testing', 'local']))
                        <hr class="my-3">
                        <p class="small text-info mb-2"><i class="fas fa-flask me-1"></i>Testing Mode</p>
                        <a href="{{ route('mock-oauth.page') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-flask me-1"></i>Mock OAuth Test
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection