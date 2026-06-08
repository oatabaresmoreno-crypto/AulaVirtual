<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 3 cursos por cada instructor existente
        User::where('role', 'instructor')->each(function ($instructor) {
            Course::factory(3)->create([
                'instructor_id' => $instructor->id,
            ]);
        });
    }
}