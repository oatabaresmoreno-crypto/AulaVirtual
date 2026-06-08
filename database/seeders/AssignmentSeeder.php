<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 2 asignaciones por cada lección existente
        Lesson::all()->each(function ($lesson) {
            Assignment::factory(2)->create([
                'lesson_id' => $lesson->id,
            ]);
        });
    }
}