<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\Assignment;
use App\Models\Lesson;

class AssignmentController extends Controller
{
    /**
     * Lista todas las asignaciones del instructor autenticado.
     */
    public function index()
    {
        $this->authorize('viewAny', Assignment::class);

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
        $this->authorize('create', Assignment::class);

        $lessons = Lesson::whereHas('course', function ($query) {
            $query->where('instructor_id', auth()->id());
        })->with('course')->get();

        return view('instructor.assignments.create', compact('lessons'));
    }

    /**
     * Guarda la nueva asignación en la base de datos.
     */
    public function store(StoreAssignmentRequest $request)
    {
        $this->authorize('create', Assignment::class);

        $validated = $request->validated();

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

        $this->authorize('view', $assignment);

        return view('instructor.assignments.show', compact('assignment'));
    }

    /**
     * Muestra el formulario para editar una asignación.
     */
    public function edit(string $id)
    {
        $assignment = Assignment::findOrFail($id);

        $this->authorize('update', $assignment);

        $lessons = Lesson::whereHas('course', function ($query) {
            $query->where('instructor_id', auth()->id());
        })->with('course')->get();

        return view('instructor.assignments.edit', compact('assignment', 'lessons'));
    }

    /**
     * Actualiza la asignación en la base de datos.
     */
    public function update(UpdateAssignmentRequest $request, string $id)
    {
        $assignment = Assignment::findOrFail($id);

        $this->authorize('update', $assignment);

        $validated = $request->validated();

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

        $this->authorize('delete', $assignment);

        $assignment->delete();

        return redirect()->route('instructor.assignments.index')
                         ->with('success', 'Asignación eliminada correctamente.');
    }
}