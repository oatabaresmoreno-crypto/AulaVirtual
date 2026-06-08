<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lesson_id'   => Lesson::factory(),
            'title'       => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'due_date'    => $this->faker->dateTimeBetween('now', '+30 days'),
            'max_score'   => $this->faker->randomElement([50, 75, 100]),
            'active'      => true,
        ];
    }
}