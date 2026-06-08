<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Lista todos los cursos del instructor autenticado.
     */
    public function index()
    {
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
        return view('instructor.courses.create');
    }

    /**
     * Guarda el nuevo curso en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'level'       => 'required|in:beginner,intermediate,advanced',
            'active'      => 'boolean',
        ]);

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

        return view('instructor.courses.show', compact('course'));
    }

    /**
     * Muestra el formulario para editar un curso.
     */
    public function edit(string $id)
    {
        $course = Course::where('instructor_id', auth()->id())
                        ->findOrFail($id);

        return view('instructor.courses.edit', compact('course'));
    }

    /**
     * Actualiza el curso en la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::where('instructor_id', auth()->id())
                        ->findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'level'       => 'required|in:beginner,intermediate,advanced',
            'active'      => 'boolean',
        ]);

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

        $course->delete();

        return redirect()->route('instructor.courses.index')
                         ->with('success', 'Curso eliminado correctamente.');
    }
}