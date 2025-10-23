@extends('layouts.app')

@section('title', 'Mock OAuth Test - FreelanceHub')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h4><i class="fas fa-flask me-2"></i>Mock OAuth Testing</h4>
                <small>Test OAuth flows without real credentials</small>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    This page is only available in <strong>testing</strong> or <strong>local</strong> environments.
                    Choose a provider and user variant to simulate OAuth login.
                </p>

                <div class="row g-3">
                    <!-- Google OAuth Mock -->
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fab fa-google text-danger me-2"></i>Google Mock</h6>
                            </div>
                            <div class="card-body">
                                <p class="small text-muted mb-3">New user (john.google@example.com)</p>
                                <a href="{{ route('mock-oauth.redirect', ['provider' => 'google', 'variant' => 'default']) }}"
                                   class="btn btn-outline-danger btn-sm w-100 mb-2">
                                    <i class="fas fa-sign-in-alt me-1"></i>New User
                                </a>

                                <p class="small text-muted mb-3">Existing user (test@example.com)</p>
                                <a href="{{ route('mock-oauth.redirect', ['provider' => 'google', 'variant' => 'existing']) }}"
                                   class="btn btn-outline-danger btn-sm w-100">
                                    <i class="fas fa-sign-in-alt me-1"></i>Existing User
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- GitHub OAuth Mock -->
                    <div class="col-md-6">
                        <div class="card border-dark">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fab fa-github text-dark me-2"></i>GitHub Mock</h6>
                            </div>
                            <div class="card-body">
                                <p class="small text-muted mb-3">New user (jane.github@example.com)</p>
                                <a href="{{ route('mock-oauth.redirect', ['provider' => 'github', 'variant' => 'default']) }}"
                                   class="btn btn-outline-dark btn-sm w-100 mb-2">
                                    <i class="fas fa-sign-in-alt me-1"></i>New User
                                </a>

                                <p class="small text-muted mb-3">Existing user (test@example.com)</p>
                                <a href="{{ route('mock-oauth.redirect', ['provider' => 'github', 'variant' => 'existing']) }}"
                                   class="btn btn-outline-dark btn-sm w-100">
                                    <i class="fas fa-sign-in-alt me-1"></i>Existing User
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="alert alert-info mb-0">
                    <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>How to Use</h6>
                    <ul class="mb-0 small">
                        <li><strong>New User:</strong> Creates a new user with unique email (jane.github@example.com, john.google@example.com)</li>
                        <li><strong>Existing User:</strong> Uses test@example.com (useful for testing provider linking)</li>
                        <li>Each button simulates a real OAuth flow with mock user data</li>
                        <li>Users are stored in the database with provider details</li>
                    </ul>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
