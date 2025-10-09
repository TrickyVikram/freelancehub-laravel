<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class JobController extends Controller
{
    /**
     * Display a listing of the jobs.
     */
    public function index()
    {
        $jobs = Job::with('user')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new job.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created job in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,freelance,internship',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'skills' => 'nullable|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'application_deadline' => 'nullable|date|after:today',
        ]);

        // Convert skills string to array
        if ($validated['skills']) {
            $validated['skills'] = array_map('trim', explode(',', $validated['skills']));
        }

        // Add default user_id for testing (no auth required)
        $validated['user_id'] = 1; // Default test user

        Job::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Job posted successfully!');
    }

    /**
     * Display the specified job.
     */
    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(Job $job)
    {
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified job in storage.
     */
    public function update(Request $request, Job $job)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
            'job_type' => 'required|in:full-time,part-time,contract,freelance,internship',
            'experience_level' => 'required|in:entry,mid,senior,executive',
            'skills' => 'nullable|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'application_deadline' => 'nullable|date|after:today',
            'is_active' => 'boolean',
        ]);

        // Convert skills string to array
        if ($validated['skills']) {
            $validated['skills'] = array_map('trim', explode(',', $validated['skills']));
        }

        $job->update($validated);

        return redirect()->route('jobs.show', $job)->with('success', 'Job updated successfully!');
    }

    /**
     * Remove the specified job from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully!');
    }

    /**
     * Display all jobs for management (testing mode - no auth).
     */
    public function myJobs()
    {
        $jobs = Job::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('jobs.my-jobs', compact('jobs'));
    }
}