<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Course;
use App\Models\Lesson;

class LessonController extends Controller
{
    /**
     * Lista todas las lecciones de todos los cursos.
     */
    public function index()
    {
        $lessons = Lesson::with('course.instructor')
                         ->orderBy('course_id')
                         ->orderBy('order')
                         ->get();

        return view('admin.lessons.index', compact('lessons'));
    }

    /**
     * Muestra el formulario para crear una nueva lección.
     */
    public function create()
    {
        $courses = Course::with('instructor')->get();

        return view('admin.lessons.create', compact('courses'));
    }

    /**
     * Guarda la nueva lección en la base de datos.
     */
    public function store(StoreLessonRequest $request)
    {
        $validated = $request->validated();

        Lesson::create($validated);

        return redirect()->route('admin.lessons.index')
                         ->with('success', 'Lección creada correctamente.');
    }

    /**
     * Muestra el detalle de una lección.
     */
    public function show(string $id)
    {
        $lesson = Lesson::with('course.instructor', 'assignments')
                        ->findOrFail($id);

        return view('admin.lessons.show', compact('lesson'));
    }

    /**
     * Muestra el formulario para editar una lección.
     */
    public function edit(string $id)
    {
        $lesson  = Lesson::findOrFail($id);
        $courses = Course::with('instructor')->get();

        return view('admin.lessons.edit', compact('lesson', 'courses'));
    }

    /**
     * Actualiza la lección en la base de datos.
     */
    public function update(UpdateLessonRequest $request, string $id)
    {
        $lesson = Lesson::findOrFail($id);

        $validated = $request->validated();

        $lesson->update($validated);

        return redirect()->route('admin.lessons.index')
                         ->with('success', 'Lección actualizada correctamente.');
    }

    /**
     * Elimina la lección de la base de datos.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return redirect()->route('admin.lessons.index')
                         ->with('success', 'Lección eliminada correctamente.');
    }
}