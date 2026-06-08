{{-- resources/views/instructor/courses/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mis Cursos')

@section('content')

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Mis Cursos</h1>
        <a href="{{ route('instructor.courses.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
            + Nuevo Curso
        </a>
    </div>

    {{-- Tabla de cursos --}}
    @if($courses->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <div class="text-5xl mb-4">🎓</div>
            <p class="text-lg">Aún no tienes cursos creados.</p>
            <a href="{{ route('instructor.courses.create') }}"
               class="text-indigo-600 hover:underline text-sm mt-2 inline-block">
                Crea tu primer curso
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Curso</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Nivel</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Lecciones</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Estudiantes</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Estado</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($courses as $course)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($course->cover_image)
                                        <img src="{{ asset('storage/' . $course->cover_image) }}"
                                             alt="{{ $course->title }}"
                                             class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-xl">
                                            🎓
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $course->title }}</p>
                                        <p class="text-xs text-gray-400">{{ $course->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ ucfirst($course->level) }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $course->lessons_count }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $course->enrollments_count }}
                            </td>
                            <td class="px-6 py-4">
                                @if($course->active)
                                    <span class="bg-green-50 text-green-700 text-xs px-2 py-1 rounded-full">
                                        Activo
                                    </span>
                                @else
                                    <span class="bg-red-50 text-red-600 text-xs px-2 py-1 rounded-full">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('instructor.courses.show', $course) }}"
                                       class="text-gray-500 hover:text-indigo-600">Ver</a>
                                    <a href="{{ route('instructor.courses.edit', $course) }}"
                                       class="text-gray-500 hover:text-indigo-600">Editar</a>
                                    <form method="POST" action="{{ route('instructor.courses.destroy', $course) }}"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este curso?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-gray-500 hover:text-red-500">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection