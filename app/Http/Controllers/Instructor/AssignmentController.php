<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Lesson;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Lista todas las asignaciones del instructor autenticado.
     */
    public function index()
    {
        $assignments = Assignment::whereHas('lesson.course', function ($query) {
            $query->where('instructor_id', auth()->id());
        })->with('lesson.course')->latest()->get();

        return view('instructor.assignments.index', compact('assignments'));
    }

    /**
     * Muestra el formulario para crear una nueva asignación.
     */
    public function create()
    {
        $lessons = Lesson::whereHas('course', function ($query) {
            $query->where('instructor_id', auth()->id());
        })->with('course')->get();

        return view('instructor.assignments.create', compact('lessons'));
    }

    /**
     * Guarda la nueva asignación en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id'   => 'required|exists:lessons,id',
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date|after:today',
            'max_score'   => 'required|integer|min:1|max:1000',
            'active'      => 'boolean',
        ]);

        Assignment::create($validated);

        return redirect()->route('instructor.assignments.index')
                         ->with('success', 'Asignación creada correctamente.');
    }

    /**
     * Muestra el detalle de una asignación.
     */
    public function show(string $id)
    {
        $assignment = Assignment::with('lesson.course')->findOrFail($id);

        return view('instructor.assignments.show', compact('assignment'));
    }

    /**
     * Muestra el formulario para editar una asignación.
     */
    public function edit(string $id)
    {
        $assignment = Assignment::findOrFail($id);

        $lessons = Lesson::whereHas('course', function ($query) {
            $query->where('instructor_id', auth()->id());
        })->with('course')->get();

        return view('instructor.assignments.edit', compact('assignment', 'lessons'));
    }

    /**
     * Actualiza la asignación en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $assignment = Assignment::findOrFail($id);

        $validated = $request->validate([
            'lesson_id'   => 'required|exists:lessons,id',
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date|after:today',
            'max_score'   => 'required|integer|min:1|max:1000',
            'active'      => 'boolean',
        ]);

        $assignment->update($validated);

        return redirect()->route('instructor.assignments.index')
                         ->with('success', 'Asignación actualizada correctamente.');
    }

    /**
     * Elimina la asignación de la base de datos.
     */
    public function destroy(string $id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();

        return redirect()->route('instructor.assignments.index')
                         ->with('success', 'Asignación eliminada correctamente.');
    }
}