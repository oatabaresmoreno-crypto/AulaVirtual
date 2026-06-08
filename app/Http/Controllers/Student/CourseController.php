<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Lista todos los cursos activos disponibles.
     */
    public function index()
    {
        $courses = Course::where('active', true)
                         ->when(request('nivel'), fn($q, $nivel) => $q->where('level', $nivel))
                         ->with('instructor')
                         ->withCount('lessons', 'enrollments')
                         ->latest()
                         ->get();

        return view('student.courses.index', compact('courses'));
    }

    /**
     * Muestra el detalle de un curso.
     */
    public function show(string $id)
    {
        $course = Course::where('active', true)
                        ->with('instructor', 'lessons' , 'enrollments')
                        ->findOrFail($id);

        $isEnrolled = $course->enrollments
                             ->where('student_id', auth()->id())
                             ->isNotEmpty();

        return view('student.courses.show', compact('course', 'isEnrolled'));
    }
}