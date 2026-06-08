<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Lista todos los cursos del instructor autenticado.
     */
    public function index()
    {
        $this->authorize('viewAny', Course::class);

        $courses = Course::where('instructor_id', auth()->id())
                         ->withCount('lessons', 'enrollments')
                         ->latest()
                         ->get();

        return view('instructor.courses.index', compact('courses'));
    }

    /**
     * Muestra el formulario para crear un nuevo curso.
     */
    public function create()
    {
        $this->authorize('create', Course::class);

        return view('instructor.courses.create');
    }

    /**
     * Guarda el nuevo curso en la base de datos.
     */
    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);

        $validated = $request->validated();

        $validated['instructor_id'] = auth()->id();
        $validated['slug']          = Str::slug($validated['title']);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('courses', 'public');
        }

        Course::create($validated);

        return redirect()->route('instructor.courses.index')
                         ->with('success', 'Curso creado correctamente.');
    }

    /**
     * Muestra el detalle de un curso.
     */
    public function show(string $id)
    {
        $course = Course::where('instructor_id', auth()->id())
                        ->with('lessons', 'enrollments.student')
                        ->findOrFail($id);

        $this->authorize('view', $course);

        return view('instructor.courses.show', compact('course'));
    }

    /**
     * Muestra el formulario para editar un curso.
     */
    public function edit(string $id)
    {
        $course = Course::where('instructor_id', auth()->id())
                        ->findOrFail($id);

        $this->authorize('update', $course);

        return view('instructor.courses.edit', compact('course'));
    }

    /**
     * Actualiza el curso en la base de datos.
     */
    public function update(UpdateCourseRequest $request, string $id)
    {
        $course = Course::where('instructor_id', auth()->id())
                        ->findOrFail($id);

        $this->authorize('update', $course);

        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('courses', 'public');
        }

        $course->update($validated);

        return redirect()->route('instructor.courses.index')
                         ->with('success', 'Curso actualizado correctamente.');
    }

    /**
     * Elimina el curso de la base de datos.
     */
    public function destroy(string $id)
    {
        $course = Course::where('instructor_id', auth()->id())
                        ->findOrFail($id);

        $this->authorize('delete', $course);

        $course->delete();

        return redirect()->route('instructor.courses.index')
                         ->with('success', 'Curso eliminado correctamente.');
    }
}