<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    /**
     * Lista todos los cursos en los que está inscrito el estudiante.
     */
    public function index()
    {

        $this->authorize('viewAny', Enrollment::class);

        $enrollments = Enrollment::where('student_id', auth()->id())
                                 ->with('course.instructor')
                                 ->latest()
                                 ->get();

        return view('student.enrollments.index', compact('enrollments'));
    }

    /**
     * Muestra el detalle de una inscripción.
     */
    public function show(string $id)
    {
        $enrollment = Enrollment::where('student_id', auth()->id())
                                ->with('course.lessons.assignments')
                                ->findOrFail($id);

        $this->authorize('view', $enrollment);

        return view('student.enrollments.show', compact('enrollment'));
    }

    /**
     * Inscribe al estudiante en un curso.
     */
    public function store(StoreEnrollmentRequest $request)
    {

        $this->authorize('create', Enrollment::class);

        $validated = $request->validated();

        $exists = Enrollment::where('student_id', auth()->id())
                            ->where('course_id', $validated['course_id'])
                            ->exists();

        if ($exists) {
            return back()->with('error', 'Ya estás inscrito en este curso.');
        }

        Enrollment::create([
            'student_id'  => auth()->id(),
            'course_id'   => $validated['course_id'],
            'status'      => 'active',
            'enrolled_at' => now(),
        ]);

        return redirect()->route('student.enrollments.index')
                         ->with('success', 'Te has inscrito al curso correctamente.');
    }

    /**
     * Cancela la inscripción del estudiante.
     */
    public function destroy(string $id)
    {
        $enrollment = Enrollment::where('student_id', auth()->id())
                            ->findOrFail($id);

        $this->authorize('delete', $enrollment);

        $enrollment->update(['status' => 'cancelled']);
        $enrollment->delete();

        return redirect()->route('student.enrollments.index')
                     ->with('success', 'Inscripción cancelada correctamente.');
    }
}