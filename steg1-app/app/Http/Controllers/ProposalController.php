<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function create(Request $request)
    {
        $jobId = $request->query('job_id');
        return view('proposals.create', ['job_id' => $jobId]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cover_letter' => 'required|string',
            'budget_amount' => 'nullable|numeric|min:0',
            'budget_currency' => 'nullable|string|max:10',
            'job_id' => 'nullable|exists:job_postings,id',
            'attachments.*' => 'file|max:5120',
        ]);

        $attachments = null;
        if ($request->hasFile('attachments')) {
            $saved = [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('proposals', 'public');
                $saved[] = $path;
            }
            $attachments = $saved;
        }

        $proposal = Proposal::create([
            'user_id' => Auth::id(),
            'job_id' => $data['job_id'] ?? null,
            'cover_letter' => $data['cover_letter'],
            'budget_amount' => $data['budget_amount'] ?? null,
            'budget_currency' => $data['budget_currency'] ?? 'USD',
            'attachments' => $attachments,
        ]);

        return redirect()->route('jobs.show', [$proposal->job_id])->with('status', 'Proposal submitted successfully.');
    }
}
