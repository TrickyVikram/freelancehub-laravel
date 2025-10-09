@extends('layouts.app')

@section('title', 'Post New Job - FreelanceHub')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h4><i class="fas fa-plus me-2"></i>Post New Job</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('jobs.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="title" class="form-label">Job Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="job_type" class="form-label">Job Type *</label>
                            <select class="form-select @error('job_type') is-invalid @enderror" 
                                    id="job_type" name="job_type" required>
                                <option value="">Select Type</option>
                                <option value="full-time" {{ old('job_type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="part-time" {{ old('job_type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="contract" {{ old('job_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="freelance" {{ old('job_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                                <option value="internship" {{ old('job_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                            </select>
                            @error('job_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="company" class="form-label">Company Name *</label>
                            <input type="text" class="form-control @error('company') is-invalid @enderror" 
                                   id="company" name="company" value="{{ old('company') }}" required>
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label">Location *</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}" 
                                   placeholder="e.g., New York, NY or Remote" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="salary" class="form-label">Salary/Rate</label>
                            <input type="text" class="form-control @error('salary') is-invalid @enderror" 
                                   id="salary" name="salary" value="{{ old('salary') }}" 
                                   placeholder="e.g., $50,000/year or $25/hour">
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="experience_level" class="form-label">Experience Level *</label>
                            <select class="form-select @error('experience_level') is-invalid @enderror" 
                                    id="experience_level" name="experience_level" required>
                                <option value="">Select Level</option>
                                <option value="entry" {{ old('experience_level') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                <option value="mid" {{ old('experience_level') == 'mid' ? 'selected' : '' }}>Mid Level</option>
                                <option value="senior" {{ old('experience_level') == 'senior' ? 'selected' : '' }}>Senior Level</option>
                                <option value="executive" {{ old('experience_level') == 'executive' ? 'selected' : '' }}>Executive</option>
                            </select>
                            @error('experience_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Job Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="skills" class="form-label">Required Skills</label>
                        <input type="text" class="form-control @error('skills') is-invalid @enderror" 
                               id="skills" name="skills" value="{{ old('skills') }}" 
                               placeholder="e.g., JavaScript, React, Node.js (comma-separated)">
                        <div class="form-text">Separate multiple skills with commas</div>
                        @error('skills')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="requirements" class="form-label">Requirements</label>
                        <textarea class="form-control @error('requirements') is-invalid @enderror" 
                                  id="requirements" name="requirements" rows="3">{{ old('requirements') }}</textarea>
                        @error('requirements')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="benefits" class="form-label">Benefits</label>
                        <textarea class="form-control @error('benefits') is-invalid @enderror" 
                                  id="benefits" name="benefits" rows="3">{{ old('benefits') }}</textarea>
                        @error('benefits')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="application_deadline" class="form-label">Application Deadline</label>
                        <input type="date" class="form-control @error('application_deadline') is-invalid @enderror" 
                               id="application_deadline" name="application_deadline" value="{{ old('application_deadline') }}">
                        @error('application_deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('jobs.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Post Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection