<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'instructor_id' => User::factory(),
            'title'         => $title,
            'slug'          => Str::slug($title),
            'description'   => $this->faker->paragraph(),
            'cover_image'   => null,
            'level'         => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'active'        => true,
        ];
    }
}