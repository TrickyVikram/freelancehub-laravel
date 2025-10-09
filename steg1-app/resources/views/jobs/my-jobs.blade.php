@extends('layouts.app')

@section('title', 'Job Manager - FreelanceHub')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-briefcase me-2"></i>Job Manager <small class="text-muted">(All Jobs)</small></h1>
    <a href="{{ route('jobs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Post New Job
    </a>
</div>

@if($jobs->count() > 0)
    <div class="row">
        @foreach($jobs as $job)
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm {{ !$job->is_active ? 'border-secondary' : '' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title">{{ $job->title }}</h5>
                            <div>
                                <span class="badge bg-primary">{{ ucfirst($job->job_type) }}</span>
                                @if(!$job->is_active)
                                    <span class="badge bg-secondary ms-1">Inactive</span>
                                @endif
                            </div>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <i class="fas fa-building me-1"></i>{{ $job->company }}
                        </h6>
                        <p class="card-text">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}
                        </p>
                        <p class="card-text text-truncate">{{ Str::limit($job->description, 120) }}</p>
                        
                        @if($job->application_deadline)
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>Deadline: {{ $job->application_deadline->format('M d, Y') }}
                                    @if($job->application_deadline->isPast())
                                        <span class="badge bg-danger ms-1">Expired</span>
                                    @elseif($job->application_deadline->diffInDays() <= 3)
                                        <span class="badge bg-warning ms-1">Ending Soon</span>
                                    @endif
                                </small>
                            </p>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>{{ $job->created_at->diffForHumans() }}
                            </small>
                            <div class="btn-group" role="group">
                                <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                                <a href="{{ route('jobs.edit', $job) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <form action="{{ route('jobs.destroy', $job) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this job?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
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
        <h3>You haven't posted any jobs yet</h3>
        <p class="text-muted">Start posting jobs to find the perfect candidates for your projects!</p>
        <a href="{{ route('jobs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Post Your First Job
        </a>
    </div>
@endif
@endsection