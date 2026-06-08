<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Lista todas las inscripciones de todos los estudiantes.
     */
    public function index()
    {
        $enrollments = Enrollment::with('course', 'student')
                                 ->latest()
                                 ->get();

        return view('admin.enrollments.index', compact('enrollments'));
    }

    /**
     * Muestra el formulario para crear una nueva inscripción.
     */
    public function create()
    {
        $courses  = Course::where('active', true)->get();
        $students = User::where('role', 'student')->get();

        return view('admin.enrollments.create', compact('courses', 'students'));
    }

    /**
     * Guarda la nueva inscripción en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'student_id' => 'required|exists:users,id',
            'status'     => 'required|in:active,completed,cancelled',
        ]);

        // Evita inscripciones duplicadas
        $exists = Enrollment::where('course_id', $validated['course_id'])
                            ->where('student_id', $validated['student_id'])
                            ->exists();

        if ($exists) {
            return back()->withErrors(['student_id' => 'Este estudiante ya está inscrito en el curso.']);
        }

        $validated['enrolled_at'] = now();

        Enrollment::create($validated);

        return redirect()->route('admin.enrollments.index')
                         ->with('success', 'Inscripción creada correctamente.');
    }

    /**
     * Muestra el detalle de una inscripción.
     */
    public function show(string $id)
    {
        $enrollment = Enrollment::with('course', 'student')
                                ->findOrFail($id);

        return view('admin.enrollments.show', compact('enrollment'));
    }

    /**
     * Muestra el formulario para editar una inscripción.
     */
    public function edit(string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $courses    = Course::where('active', true)->get();
        $students   = User::where('role', 'student')->get();

        return view('admin.enrollments.edit', compact('enrollment', 'courses', 'students'));
    }

    /**
     * Actualiza la inscripción en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $enrollment = Enrollment::findOrFail($id);

        $validated = $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'student_id'  => 'required|exists:users,id',
            'status'      => 'required|in:active,completed,cancelled',
            'completed_at'=> 'nullable|date',
        ]);

        // Si el status cambia a completado, registrar la fecha
        if ($validated['status'] === 'completed' && !$enrollment->completed_at) {
            $validated['completed_at'] = now();
        }

        $enrollment->update($validated);

        return redirect()->route('admin.enrollments.index')
                         ->with('success', 'Inscripción actualizada correctamente.');
    }

    /**
     * Elimina la inscripción de la base de datos.
     */
    public function destroy(string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('admin.enrollments.index')
                         ->with('success', 'Inscripción eliminada correctamente.');
    }
}