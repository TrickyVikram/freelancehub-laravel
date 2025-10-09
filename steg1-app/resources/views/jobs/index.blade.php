@extends('layouts.app')

@section('title', 'Browse Jobs - FreelanceHub')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-search me-2"></i>Browse Jobs</h1>
    @auth
        <a href="{{ route('jobs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Post New Job
        </a>
    @endauth
</div>

@if($jobs->count() > 0)
    <div class="row">
        @foreach($jobs as $job)
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title">{{ $job->title }}</h5>
                            <span class="badge bg-primary">{{ ucfirst($job->job_type) }}</span>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <i class="fas fa-building me-1"></i>{{ $job->company }}
                        </h6>
                        <p class="card-text">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}
                        </p>
                        <p class="card-text text-truncate">{{ Str::limit($job->description, 120) }}</p>
                        
                        @if($job->skills && count($job->skills) > 0)
                            <div class="mb-2">
                                @foreach(array_slice($job->skills, 0, 3) as $skill)
                                    <span class="badge bg-secondary me-1">{{ $skill }}</span>
                                @endforeach
                                @if(count($job->skills) > 3)
                                    <span class="text-muted small">+{{ count($job->skills) - 3 }} more</span>
                                @endif
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>{{ $job->created_at->diffForHumans() }}
                            </small>
                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary btn-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $jobs->links() }}
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
        <h3>No jobs available</h3>
        <p class="text-muted">Be the first to post a job opportunity!</p>
        @auth
            <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Post Your First Job
            </a>
        @endauth
    </div>
@endif
@endsection