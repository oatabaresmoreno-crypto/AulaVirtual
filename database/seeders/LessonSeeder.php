<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 5 lecciones por cada curso existente
        Course::all()->each(function ($course) {
            Lesson::factory(5)->create([
                'course_id' => $course->id,
            ]);
        });
    }
}