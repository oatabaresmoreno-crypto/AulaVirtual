<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Lista todos los cursos activos.
     */
    public function index()
    {
        $courses = Course::with('instructor:id,name,email')
                         ->withCount('lessons', 'enrollments')
                         ->where('active', true)
                         ->latest()
                         ->get();

        return response()->json($courses);
    }

    /**
     * Crea un nuevo curso.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'level'       => 'required|in:beginner,intermediate,advanced',
            'active'      => 'boolean',
        ]);

        $validated['instructor_id'] = auth()->id();
        $validated['slug']          = Str::slug($validated['title']);

        $course = Course::create($validated);

        return response()->json($course, 201);
    }

    /**
     * Muestra el detalle de un curso.
     */
    public function show(string $id)
    {
        $course = Course::with('instructor:id,name,email', 'lessons', 'enrollments')
                        ->findOrFail($id);

        return response()->json($course);
    }

    /**
     * Actualiza un curso.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'level'       => 'required|in:beginner,intermediate,advanced',
            'active'      => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $course->update($validated);

        return response()->json($course);
    }

    /**
     * Elimina un curso.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json([
            'message' => 'Curso eliminado correctamente.',
        ]);
    }
}