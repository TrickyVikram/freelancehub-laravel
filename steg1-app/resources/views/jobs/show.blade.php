@extends('layouts.app')

@section('title', $job->title . ' - FreelanceHub')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $job->title }}</h4>
                <span class="badge bg-primary fs-6">{{ ucfirst($job->job_type) }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-1">Company</h6>
                        <p><i class="fas fa-building me-2"></i>{{ $job->company }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-1">Location</h6>
                        <p><i class="fas fa-map-marker-alt me-2"></i>{{ $job->location }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    @if($job->salary)
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Salary/Rate</h6>
                            <p><i class="fas fa-dollar-sign me-2"></i>{{ $job->salary }}</p>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <h6 class="text-muted mb-1">Experience Level</h6>
                        <p><i class="fas fa-chart-line me-2"></i>{{ ucfirst($job->experience_level) }} Level</p>
                    </div>
                </div>

                @if($job->application_deadline)
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Application Deadline</h6>
                        <p>
                            <i class="fas fa-calendar me-2"></i>
                            {{ $job->application_deadline->format('M d, Y') }}
                            @if($job->application_deadline->isPast())
                                <span class="badge bg-danger ms-2">Expired</span>
                            @elseif($job->application_deadline->diffInDays() <= 3)
                                <span class="badge bg-warning ms-2">Ending Soon</span>
                            @endif
                        </p>
                    </div>
                @endif

                <div class="mb-4">
                    <h6 class="text-muted mb-2">Job Description</h6>
                    <div class="job-description">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                @if($job->skills && count($job->skills) > 0)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Required Skills</h6>
                        <div>
                            @foreach($job->skills as $skill)
                                <span class="badge bg-secondary me-2 mb-2">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($job->requirements)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Requirements</h6>
                        <div>{!! nl2br(e($job->requirements)) !!}</div>
                    </div>
                @endif

                @if($job->benefits)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Benefits</h6>
                        <div>{!! nl2br(e($job->benefits)) !!}</div>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>Posted {{ $job->created_at->diffForHumans() }}
                    </small>
                    <div>
                        <a href="{{ route('jobs.edit', $job) }}" class="btn btn-outline-primary btn-sm me-2">
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

    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header">
                <h5><i class="fas fa-paper-plane me-2"></i>Apply for this Job</h5>
            </div>
            <div class="card-body text-center">
                <p class="text-muted">Ready to apply?</p>
                <button class="btn btn-primary" onclick="alert('Application functionality will be implemented later')">
                    <i class="fas fa-paper-plane me-2"></i>Apply Now
                </button>
                <hr>
                <p class="text-muted small">Job Management (Testing Mode)</p>
                <a href="{{ route('jobs.edit', $job) }}" class="btn btn-outline-primary btn-sm me-2">
                    <i class="fas fa-edit me-1"></i>Edit Job
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

        <div class="card shadow mt-4">
            <div class="card-header">
                <h6><i class="fas fa-info-circle me-2"></i>Job Summary</h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <small class="text-muted d-block">Type</small>
                        <strong>{{ ucfirst($job->job_type) }}</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Level</small>
                        <strong>{{ ucfirst($job->experience_level) }}</strong>
                    </div>
                    @if($job->salary)
                        <div class="col-12 mt-2">
                            <small class="text-muted d-block">Salary</small>
                            <strong>{{ $job->salary }}</strong>
                        </div>
                    @endif
                    <div class="col-12 mt-2">
                        <small class="text-muted d-block">Posted</small>
                        <strong>{{ $job->created_at->format('M d, Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Jobs
    </a>
</div>
@endsection