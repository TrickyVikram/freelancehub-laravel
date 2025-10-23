<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FreelanceHub')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .navbar {
            z-index: 1000 !important;
            position: static !important;
            width: 100% !important;
            visibility: visible !important;
            opacity: 1 !important;
            display: flex !important;
        }
        .navbar-brand {
            font-weight: bold !important;
            color: white !important;
            font-size: 1.5rem !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        .navbar-nav {
            gap: 0.5rem;
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.95) !important;
            margin: 0 0.25rem !important;
            font-weight: 500 !important;
            display: inline-flex !important;
            align-items: center !important;
            white-space: nowrap;
            font-size: 0.95rem;
            visibility: visible !important;
            opacity: 1 !important;
            height: auto !important;
            overflow: visible !important;
            clip: auto !important;
            position: static !important;
        }
        .navbar-nav .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.25rem;
            transition: all 0.2s ease;
            visibility: visible !important;
            opacity: 1 !important;
        }
        .navbar-nav .nav-item {
            display: flex !important;
            align-items: center !important;
            visibility: visible !important;
            opacity: 1 !important;
            height: auto !important;
        }
        .text-warning {
            color: #ffc107 !important;
        }
        .dropdown-menu {
            min-width: 200px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            visibility: visible !important;
            opacity: 1 !important;
        }
        .navbar-toggler {
            border: 1px solid rgba(255,255,255,0.3) !important;
        }
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(255,255,255,0.25) !important;
            outline: 0;
        }
        .collapse.show {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        .navbar-collapse {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('jobs.index') }}">
                <i class="fas fa-briefcase me-2"></i><strong>FreelanceHub</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left Navigation -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('jobs.index') }}">
                            <i class="fas fa-search me-1"></i>Browse Jobs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('jobs.create') }}">
                            <i class="fas fa-plus me-1"></i>Post Job
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('jobs.my-jobs') }}">
                            <i class="fas fa-list me-1"></i>Jobs Manager
                        </a>
                    </li>
                </ul>

                <!-- Right Navigation -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <!-- User is logged in -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('jobs.my-jobs') }}">
                                    <i class="fas fa-briefcase me-2"></i>My Jobs
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('password.request') }}">
                                    <i class="fas fa-key me-2"></i>Change Password
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- User is not logged in -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('quick-login') }}" title="Quick login for testing">
                                <i class="fas fa-user-check me-1"></i>Test Login
                            </a>
                        </li>
                        @if(app()->environment(['testing', 'local']))
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="{{ route('mock-oauth.page') }}" title="Mock OAuth for testing">
                                    <i class="fas fa-flask me-1"></i>Mock OAuth
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>FreelanceHub</h5>
                    <p>Your gateway to freelance opportunities</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>&copy; {{ date('Y') }} FreelanceHub. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>