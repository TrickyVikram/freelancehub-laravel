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
                </form>

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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection