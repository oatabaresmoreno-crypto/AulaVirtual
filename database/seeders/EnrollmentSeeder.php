<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $courses  = Course::all();

        // Inscribir cada estudiante en 3 cursos aleatorios
        $students->each(function ($student) use ($courses) {
            $courses->random(3)->each(function ($course) use ($student) {

                // Evitar inscripciones duplicadas
                $exists = Enrollment::where('course_id', $course->id)
                                    ->where('student_id', $student->id)
                                    ->exists();

                if (!$exists) {
                    Enrollment::factory()->create([
                        'course_id'  => $course->id,
                        'student_id' => $student->id,
                    ]);
                }
            });
        });
    }
}