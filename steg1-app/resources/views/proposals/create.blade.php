@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Submit Proposal</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('proposals.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="job_id" value="{{ $job_id ?? old('job_id') }}">

        <div class="mb-3">
            <label for="cover_letter" class="form-label">Cover Letter</label>
            <textarea name="cover_letter" id="cover_letter" class="form-control" required>{{ old('cover_letter') }}</textarea>
            @error('cover_letter')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="budget_amount" class="form-label">Budget</label>
            <input type="number" step="0.01" name="budget_amount" id="budget_amount" class="form-control" value="{{ old('budget_amount') }}">
        </div>

        <div class="mb-3">
            <label for="budget_currency" class="form-label">Currency</label>
            <input name="budget_currency" id="budget_currency" class="form-control" value="{{ old('budget_currency', 'USD') }}">
        </div>

        <div class="mb-3">
            <label for="attachments" class="form-label">Attachments</label>
            <input type="file" name="attachments[]" id="attachments" multiple class="form-control">
            @error('attachments.*')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary">Submit Proposal</button>
    </form>
</div>
@endsection
