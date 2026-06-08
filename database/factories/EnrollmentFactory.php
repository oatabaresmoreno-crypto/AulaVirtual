<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id'    => Course::factory(),
            'student_id'   => User::factory(),
            'status'       => $this->faker->randomElement(['active', 'completed', 'cancelled']),
            'enrolled_at'  => $this->faker->dateTimeBetween('-6 months', 'now'),
            'completed_at' => null,
        ];
    }
}