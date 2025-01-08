@extends('layouts.app')

@section('content')
<div class="dashboard">
    <!-- Welcome Section - Keeping the blue gradient -->
    <div class="welcome-section mb-4">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">Welcome, {{ Auth::user()->name }}</h2>
                        <p class="mb-0 opacity-75">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                    <div class="text-end">
                        <p class="mb-0" id="currentTime"></p>
                        <p class="mb-0">{{ now()->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About System Section -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4 custom-text">Research Grant Management System</h3>
                    
                    <div class="mb-4 custom-light p-4 rounded">
                        <h5 class="custom-text"><i class="bi bi-info-circle me-2"></i>About the System</h5>
                        <p class="mb-0">The Research Grant Management System is designed to help academicians and administrators efficiently manage research grants and their associated milestones. This platform streamlines the process of tracking research progress and managing grant-related activities.</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="custom-text mb-3"><i class="bi bi-star me-2"></i>Key Features</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 custom-light rounded feature-card">
                                    <i class="bi bi-journal-text custom-text me-2"></i>
                                    Research Grant Management
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 custom-light rounded feature-card">
                                    <i class="bi bi-flag custom-text me-2"></i>
                                    Milestone Tracking
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 custom-light rounded feature-card">
                                    <i class="bi bi-people custom-text me-2"></i>
                                    Team Collaboration
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 custom-light rounded feature-card">
                                    <i class="bi bi-graph-up custom-text me-2"></i>
                                    Progress Monitoring
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="custom-light p-4 rounded">
                        <h5 class="custom-text mb-3"><i class="bi bi-play-circle me-2"></i>Getting Started</h5>
                        <p>Use the navigation menu to access different sections of the system. You can:</p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="bi bi-check2-circle custom-text me-2"></i>
                                        View and manage research grants
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-check2-circle custom-text me-2"></i>
                                        Track project milestones
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="bi bi-check2-circle custom-text me-2"></i>
                                        Collaborate with team members
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-check2-circle custom-text me-2"></i>
                                        Generate progress reports
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('currentTime').textContent = timeString;
    }

    updateTime();
    setInterval(updateTime, 1000);
</script>
@endpush

<style>
    .card {
        border: none;
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }

    .custom-light {
        background-color: #fff3e0 !important;
    }

    .custom-text {
        color: #ed6c02 !important;
    }

    .bg-primary {
        background: linear-gradient(135deg, #1976d2, #1565c0) !important;
    }

    .feature-card {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .feature-card:hover {
        background-color: #fff;
        border-color: #ed6c02;
        box-shadow: 0 4px 12px rgba(237, 108, 2, 0.1);
    }
</style>
@endsection 