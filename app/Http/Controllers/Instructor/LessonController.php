<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Course;
use App\Models\Lesson;

class LessonController extends Controller
{
    /**
     * Lista todas las lecciones del instructor autenticado.
     */
    public function index()
    {
        $lessons = Lesson::whereHas('course', function ($query) {
            $query->where('instructor_id', auth()->id());
        })->with('course')->orderBy('order')->get();

        return view('instructor.lessons.index', compact('lessons'));
    }

    /**
     * Muestra el formulario para crear una nueva lección.
     */
    public function create()
    {
        $courses = Course::where('instructor_id', auth()->id())->get();

        return view('instructor.lessons.create', compact('courses'));
    }

    /**
     * Guarda la nueva lección en la base de datos.
     */
    public function store(StoreLessonRequest $request)
    {
        $validated = $request->validated();

        Lesson::create($validated);

        return redirect()->route('instructor.lessons.index')
                         ->with('success', 'Lección creada correctamente.');
    }

    /**
     * Muestra el detalle de una lección.
     */
    public function show(string $id)
    {
        $lesson = Lesson::whereHas('course', function ($query) {
            $query->where('instructor_id', auth()->id());
        })->with('course', 'assignments')->findOrFail($id);

        return view('instructor.lessons.show', compact('lesson'));
    }

    /**
     * Muestra el formulario para editar una lección.
     */
    public function edit(string $id)
    {
        $lesson = Lesson::whereHas('course', function ($query) {
            $query->where('instructor_id', auth()->id());
        })->findOrFail($id);

        $courses = Course::where('instructor_id', auth()->id())->get();

        return view('instructor.lessons.edit', compact('lesson', 'courses'));
    }

    /**
     * Actualiza la lección en la base de datos.
     */
    public function update(UpdateLessonRequest $request, string $id)
    {
        $lesson = Lesson::whereHas('course', function ($query) {
            $query->where('instructor_id', auth()->id());
        })->findOrFail($id);

        $validated = $request->validated();

        $lesson->update($validated);

        return redirect()->route('instructor.lessons.index')
                         ->with('success', 'Lección actualizada correctamente.');
    }

    /**
     * Elimina la lección de la base de datos.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::whereHas('course', function ($query) {
            $query->where('instructor_id', auth()->id());
        })->findOrFail($id);

        $lesson->delete();

        return redirect()->route('instructor.lessons.index')
                         ->with('success', 'Lección eliminada correctamente.');
    }
}