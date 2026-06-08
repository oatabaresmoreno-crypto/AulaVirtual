<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\Assignment;
use App\Models\Lesson;

class AssignmentController extends Controller
{
    /**
     * Lista todas las asignaciones de todos los cursos.
     */
    public function index()
    {
        $this->authorize('viewAny', Assignment::class);

        $assignments = Assignment::with('lesson.course.instructor')
                                 ->latest()
                                 ->get();

        return view('admin.assignments.index', compact('assignments'));
    }

    /**
     * Muestra el formulario para crear una nueva asignación.
     */
    public function create()
    {
        $this->authorize('create', Assignment::class);

        $lessons = Lesson::with('course')->get();

        return view('admin.assignments.create', compact('lessons'));
    }

    /**
     * Guarda la nueva asignación en la base de datos.
     */
    public function store(StoreAssignmentRequest $request)
    {
        $this->authorize('create', Assignment::class);

        $validated = $request->validated();

        Assignment::create($validated);

        return redirect()->route('admin.assignments.index')
                         ->with('success', 'Asignación creada correctamente.');
    }

    /**
     * Muestra el detalle de una asignación.
     */
    public function show(string $id)
    {
        $assignment = Assignment::with('lesson.course.instructor')
                                ->findOrFail($id);

        $this->authorize('view', $assignment);

        return view('admin.assignments.show', compact('assignment'));
    }

    /**
     * Muestra el formulario para editar una asignación.
     */
    public function edit(string $id)
    {
        $assignment = Assignment::findOrFail($id);

        $this->authorize('update', $assignment);

        $lessons = Lesson::with('course')->get();

        return view('admin.assignments.edit', compact('assignment', 'lessons'));
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

        return redirect()->route('admin.assignments.index')
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

        return redirect()->route('admin.assignments.index')
                         ->with('success', 'Asignación eliminada correctamente.');
    }
}