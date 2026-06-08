<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Lista todos los cursos de todos los instructores.
     */
    public function index()
    {
        $this->authorize('viewAny', Course::class);

        $courses = Course::with('instructor')
                         ->withCount('lessons', 'enrollments')
                         ->latest()
                         ->get();

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Muestra el formulario para crear un nuevo curso.
     */
    public function create()
    {
        $this->authorize('create', Course::class);

        $instructors = User::where('role', 'instructor')->get();

        return view('admin.courses.create', compact('instructors'));
    }

    /**
     * Guarda el nuevo curso en la base de datos.
     */
    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);

        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('courses', 'public');
        }

        Course::create($validated);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Curso creado correctamente.');
    }

    /**
     * Muestra el detalle de un curso.
     */
    public function show(string $id)
    {
        $course = Course::with('instructor', 'lessons', 'enrollments.student')
                        ->findOrFail($id);

        $this->authorize('view', $course);

        return view('admin.courses.show', compact('course'));
    }

    /**
     * Muestra el formulario para editar un curso.
     */
    public function edit(string $id)
    {
        $course = Course::findOrFail($id);

        $this->authorize('update', $course);

        $instructors = User::where('role', 'instructor')->get();

        return view('admin.courses.edit', compact('course', 'instructors'));
    }

    /**
     * Actualiza el curso en la base de datos.
     */
    public function update(UpdateCourseRequest $request, string $id)
    {
        $course = Course::findOrFail($id);

        $this->authorize('update', $course);

        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('courses', 'public');
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Curso actualizado correctamente.');
    }

    /**
     * Elimina el curso de la base de datos.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);

        $this->authorize('delete', $course);

        $course->delete();

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Curso eliminado correctamente.');
    }
}