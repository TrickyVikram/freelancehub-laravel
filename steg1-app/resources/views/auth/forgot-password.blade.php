@extends('layouts.app')

@section('title', 'Forgot Password - FreelanceHub')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h4><i class="fas fa-key me-2"></i>Forgot Your Password?</h4>
            </div>
            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                    </div>
                @endif

                <p class="text-muted mb-4">No problem. Just let us know your email address and we will send you a password reset link.</p>

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Send Reset Link
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
