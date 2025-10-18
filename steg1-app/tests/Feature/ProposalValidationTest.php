<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Job;

class ProposalValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_proposal_requires_cover_letter()
    {
        $job = Job::factory()->create();

        $response = $this->post(route('proposals.store'), [
            'job_id' => $job->id,
            // missing cover_letter
            'budget_amount' => '50.00',
        ]);

        $response->assertSessionHasErrors('cover_letter');
        $this->assertDatabaseMissing('proposals', [
            'job_id' => $job->id,
            'budget_amount' => '50.00',
        ]);
    }
}
