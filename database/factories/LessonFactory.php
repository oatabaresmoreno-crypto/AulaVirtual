<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id'        => Course::factory(),
            'title'            => $this->faker->sentence(4),
            'content'          => $this->faker->paragraphs(3, true),
            'order'            => $this->faker->numberBetween(1, 20),
            'duration_minutes' => $this->faker->randomElement([15, 30, 45, 60, 90]),
            'active'           => true,
        ];
    }
}