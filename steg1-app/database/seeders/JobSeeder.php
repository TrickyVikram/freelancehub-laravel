<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some test users first if they don't exist
        if (User::count() === 0) {
            User::factory(5)->create();
        }

        // Create jobs for existing users
        $users = User::all();
        
        foreach ($users as $user) {
            // Each user creates 2-5 jobs
            Job::factory()
                ->count(fake()->numberBetween(2, 5))
                ->for($user)
                ->create();
        }

        // Create some specific example jobs
        $exampleUser = $users->first();

        Job::factory()->create([
            'title' => 'Senior Laravel Developer',
            'description' => 'We are looking for an experienced Laravel developer to join our growing team. You will be responsible for developing and maintaining web applications using the Laravel framework.',
            'company' => 'TechStart Inc.',
            'location' => 'New York, NY',
            'salary' => '$80,000 - $120,000/year',
            'job_type' => 'full-time',
            'experience_level' => 'senior',
            'skills' => ['Laravel', 'PHP', 'MySQL', 'JavaScript', 'Vue.js', 'Git'],
            'requirements' => "• 5+ years of PHP development experience\n• 3+ years of Laravel framework experience\n• Strong knowledge of MySQL and database design\n• Experience with front-end technologies (HTML, CSS, JavaScript)\n• Familiarity with version control systems (Git)",
            'benefits' => "• Competitive salary\n• Health insurance\n• 401k matching\n• Flexible work hours\n• Remote work options\n• Professional development budget",
            'application_deadline' => now()->addMonths(2),
            'user_id' => $exampleUser->id,
        ]);

        Job::factory()->create([
            'title' => 'Frontend React Developer (Remote)',
            'description' => 'Join our remote team as a Frontend Developer specializing in React. You will work on exciting projects for various clients and have the opportunity to grow your skills.',
            'company' => 'Remote Solutions LLC',
            'location' => 'Remote',
            'salary' => '$30 - $45/hour',
            'job_type' => 'freelance',
            'experience_level' => 'mid',
            'skills' => ['React', 'JavaScript', 'TypeScript', 'HTML/CSS', 'REST APIs'],
            'requirements' => "• 2+ years of React development experience\n• Proficiency in JavaScript and TypeScript\n• Experience with REST API integration\n• Strong CSS skills and responsive design\n• Excellent communication skills for remote work",
            'benefits' => "• Flexible schedule\n• Work from anywhere\n• Competitive hourly rate\n• Opportunity to work with diverse clients",
            'application_deadline' => now()->addMonth(),
            'user_id' => $exampleUser->id,
        ]);
    }
}