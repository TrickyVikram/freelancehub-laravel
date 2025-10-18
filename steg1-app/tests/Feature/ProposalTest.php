<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Proposal;
use App\Models\Job;

class ProposalTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_submit_proposal()
    {
        // Create a job to attach the proposal to
        $job = Job::factory()->create();

        $response = $this->post(route('proposals.store'), [
            'job_id' => $job->id,
            'cover_letter' => 'I would like this job',
            'budget_amount' => '100.00',
            'budget_currency' => 'USD',
        ]);

        $response->assertRedirect(route('jobs.show', [$job->id]));

        $this->assertDatabaseHas('proposals', [
            'job_id' => $job->id,
            'cover_letter' => 'I would like this job',
        ]);
    }
}
