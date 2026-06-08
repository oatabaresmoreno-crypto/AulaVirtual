<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario admin principal
        User::factory()->admin()->create([
            'name'  => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        // Crear 3 instructores
        User::factory(3)->instructor()->create();

        // Crear 10 estudiantes
        User::factory(10)->student()->create();

        // Crear cursos, lecciones, asignaciones e inscripciones
        $this->call([
            CourseSeeder::class,
            LessonSeeder::class,
            AssignmentSeeder::class,
            EnrollmentSeeder::class,
        ]);
    }
}