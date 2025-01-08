<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iRMC Research Grant Management System</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        /* Custom Styles */
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background: #2c3e50;
            transition: all 0.3s;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1.25rem;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.1);
        }

        .sidebar .nav-link.active {
            background: #3498db;
            color: #fff;
        }

        .content-wrapper {
            min-height: 100vh;
            background: #f8f9fa;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            transition: all 0.2s;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }

        .status-badge {
            padding: 0.35em 0.65em;
            border-radius: 0.25rem;
        }

        .status-not_started { background-color: #6c757d; color: white; }
        .status-in_progress { background-color: #ffc107; color: black; }
        .status-completed { background-color: #198754; color: white; }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1050;
        }

        /* Custom Button Styles */
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        /* Table Styles */
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }

        /* Form Styles */
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- User Profile Section -->
            <div class="p-3 border-bottom border-secondary">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-light rounded-circle p-2 d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px;">
                            <i class="bi bi-person text-dark"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="text-white">{{ Auth::user()->name }}</div>
                        <small class="text-light opacity-75">
                            {{ ucfirst(Auth::user()->role) }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="nav flex-column mt-2">
                <a href="{{ route('dashboard') }}" 
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door me-2"></i> Dashboard
                </a>
                
                <a href="{{ route('research-grants.index') }}" 
                   class="nav-link {{ request()->routeIs('research-grants.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text me-2"></i> Research Grants
                </a>

                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('academicians.index') }}" 
                       class="nav-link {{ request()->routeIs('academicians.*') ? 'active' : '' }}">
                        <i class="bi bi-people me-2"></i> Academicians
                    </a>
                    <a href="{{ route('milestones.index') }}" 
                       class="nav-link {{ request()->routeIs('milestones.*') ? 'active' : '' }}">
                        <i class="bi bi-flag me-2"></i> Milestones
                    </a>
                @endif
            </nav>

            <!-- Logout Button -->
            <div class="mt-auto p-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content-wrapper flex-grow-1 p-4">
            @if(session('success'))
                <div class="toast-container">
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-success text-white">
                            <strong class="me-auto">Success</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="toast-container">
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-danger text-white">
                            <strong class="me-auto">Error</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-hide toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            var toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    var bsToast = new bootstrap.Toast(toast);
                    bsToast.hide();
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>
</html> 