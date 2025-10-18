@php
    use Illuminate\Support\Str;
@endphp

@if(isset($job))
    <div class="card shadow mt-4">
        <div class="card-header">
            <h6><i class="fas fa-comments me-2"></i>Proposals</h6>
        </div>
        <div class="card-body">
            @php $proposals = is_iterable($job->proposals) ? $job->proposals : [] @endphp

            @if(count($proposals) === 0)
                <p class="text-muted">No proposals submitted yet.</p>
            @else
                <ul class="list-group mb-3">
                    @foreach($proposals as $proposal)
                        <li class="list-group-item">
                            <strong>{{ $proposal->user->name ?? 'User #' . $proposal->user_id }}</strong>
                            <div class="small text-muted">Submitted {{ $proposal->created_at->diffForHumans() }}</div>
                            <div class="mt-2">{{ \Illuminate\Support\Str::limit($proposal->cover_letter, 200) }}</div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <a href="{{ route('proposals.create', ['job_id' => $job->id]) }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Write a Proposal
            </a>
        </div>
    </div>
@endif
