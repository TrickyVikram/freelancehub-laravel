<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'company' => fake()->company(),
            'location' => fake()->city() . ', ' . fake()->stateAbbr(),
            'salary' => fake()->optional()->randomElement([
                '$50,000 - $70,000/year',
                '$25 - $40/hour',
                '$80,000 - $120,000/year',
                '$30 - $50/hour',
                'Competitive salary',
            ]),
            'job_type' => fake()->randomElement(['full-time', 'part-time', 'contract', 'freelance', 'internship']),
            'experience_level' => fake()->randomElement(['entry', 'mid', 'senior', 'executive']),
            'skills' => fake()->randomElements([
                'JavaScript', 'PHP', 'Python', 'React', 'Vue.js', 'Laravel', 'Node.js',
                'MySQL', 'PostgreSQL', 'MongoDB', 'Docker', 'AWS', 'Git', 'REST APIs',
                'HTML/CSS', 'Bootstrap', 'Tailwind CSS', 'jQuery', 'TypeScript',
            ], fake()->numberBetween(2, 6)),
            'requirements' => fake()->optional()->paragraphs(2, true),
            'benefits' => fake()->optional()->paragraphs(2, true),
            'application_deadline' => fake()->optional()->dateTimeBetween('now', '+3 months'),
            'is_active' => fake()->boolean(85), // 85% chance of being active
            'user_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the job is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the job is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the job is remote.
     */
    public function remote(): static
    {
        return $this->state(fn (array $attributes) => [
            'location' => 'Remote',
        ]);
    }
}