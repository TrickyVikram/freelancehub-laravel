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
        body {
            background-color: #f8f9fa;
        }
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .navbar-brand {
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            color: white !important;
        }
        .navbar-nav .nav-item {
            display: flex;
            align-items: center;
        }
        .text-warning {
            color: #ffc107 !important;
        }
        .dropdown-menu {
            min-width: 200px;
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
                <ul class="navbar-nav ms-auto">
                    @guest
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
                    @else
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
                    @endguest
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