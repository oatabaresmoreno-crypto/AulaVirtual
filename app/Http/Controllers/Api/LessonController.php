<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Lista todas las lecciones.
     */
    public function index()
    {
        $lessons = Lesson::with('course:id,title,instructor_id')
                         ->where('active', true)
                         ->orderBy('order')
                         ->get();

        return response()->json($lessons);
    }

    /**
     * Crea una nueva lección.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'        => 'required|exists:courses,id',
            'title'            => 'required|string|max:200',
            'content'          => 'nullable|string',
            'order'            => 'required|integer|min:0',
            'duration_minutes' => 'required|integer|min:0',
            'active'           => 'boolean',
        ]);

        $lesson = Lesson::create($validated);

        return response()->json($lesson, 201);
    }

    /**
     * Muestra el detalle de una lección.
     */
    public function show(string $id)
    {
        $lesson = Lesson::with('course:id,title', 'assignments')
                        ->findOrFail($id);

        return response()->json($lesson);
    }

    /**
     * Actualiza una lección.
     */
    public function update(Request $request, string $id)
    {
        $lesson = Lesson::findOrFail($id);

        $validated = $request->validate([
            'course_id'        => 'required|exists:courses,id',
            'title'            => 'required|string|max:200',
            'content'          => 'nullable|string',
            'order'            => 'required|integer|min:0',
            'duration_minutes' => 'required|integer|min:0',
            'active'           => 'boolean',
        ]);

        $lesson->update($validated);

        return response()->json($lesson);
    }

    /**
     * Elimina una lección.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return response()->json([
            'message' => 'Lección eliminada correctamente.',
        ]);
    }
}