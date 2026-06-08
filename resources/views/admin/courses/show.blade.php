{{-- resources/views/admin/courses/show.blade.php --}}
@extends('layouts.app')

@section('title', $course->title)

@section('content')

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $course->title }}</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.courses.edit', $course) }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                Editar curso
            </a>
            <a href="{{ route('admin.courses.index') }}"
               class="text-sm text-gray-500 hover:text-indigo-600">
                ← Volver a cursos
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Columna izquierda --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Imagen de portada --}}
            @if($course->cover_image)
                <img src="{{ asset('storage/' . $course->cover_image) }}"
                     alt="{{ $course->title }}"
                     class="w-full h-56 object-cover rounded-xl border border-gray-200">
            @else
                <div class="w-full h-56 bg-indigo-50 rounded-xl flex items-center justify-center text-6xl">
                    🎓
                </div>
            @endif

            {{-- Descripción --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Descripción</h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ $course->description ?? 'Sin descripción.' }}
                </p>
            </div>

            {{-- Lecciones --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Lecciones</h2>
                    <a href="{{ route('admin.lessons.create') }}"
                       class="text-sm text-indigo-600 hover:underline">
                        + Agregar lección
                    </a>
                </div>

                @if($course->lessons->isEmpty())
                    <p class="text-sm text-gray-400">Este curso aún no tiene lecciones.</p>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($course->lessons->sortBy('order') as $lesson)
                            <li class="py-3 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-gray-400 w-5 text-center">
                                        {{ $lesson->order }}
                                    </span>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $lesson->title }}</p>
                                        <p class="text-xs text-gray-400">{{ $lesson->duration_minutes }} min</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($lesson->active)
                                        <span class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded-full">Activa</span>
                                    @else
                                        <span class="text-xs bg-red-50 text-red-600 px-2 py-1 rounded-full">Inactiva</span>
                                    @endif
                                    <a href="{{ route('admin.lessons.edit', $lesson) }}"
                                       class="text-xs text-gray-500 hover:text-indigo-600">Editar</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Estudiantes inscritos --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Estudiantes inscritos</h2>
                    <a href="{{ route('admin.enrollments.create') }}"
                       class="text-sm text-indigo-600 hover:underline">
                        + Inscribir estudiante
                    </a>
                </div>

                @if($course->enrollments->isEmpty())
                    <p class="text-sm text-gray-400">Aún no hay estudiantes inscritos.</p>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($course->enrollments as $enrollment)
                            <li class="py-3 flex items-center justify-between">
                                <span class="text-sm text-gray-700">{{ $enrollment->student->name }}</span>
                                <span class="text-xs
                                    {{ $enrollment->status === 'completed' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $enrollment->status === 'active'    ? 'bg-blue-50 text-blue-700'  : '' }}
                                    {{ $enrollment->status === 'cancelled' ? 'bg-red-50 text-red-600'   : '' }}
                                    px-2 py-1 rounded-full">
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>

        {{-- Columna derecha - Detalles --}}
        <div class="space-y-6">

            {{-- Detalles del curso --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detalles</h2>
                <ul class="space-y-3 text-sm">
                    <li class="flex justify-between">
                        <span class="text-gray-500">Instructor</span>
                        <span class="font-medium text-gray-900">{{ $course->instructor->name }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Nivel</span>
                        <span class="font-medium text-gray-900">{{ ucfirst($course->level) }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Estado</span>
                        @if($course->active)
                            <span class="bg-green-50 text-green-700 text-xs px-2 py-1 rounded-full">Activo</span>
                        @else
                            <span class="bg-red-50 text-red-600 text-xs px-2 py-1 rounded-full">Inactivo</span>
                        @endif
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Lecciones</span>
                        <span class="font-medium text-gray-900">{{ $course->lessons->count() }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Estudiantes</span>
                        <span class="font-medium text-gray-900">{{ $course->enrollments->count() }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Creado</span>
                        <span class="font-medium text-gray-900">{{ $course->created_at->format('d/m/Y') }}</span>
                    </li>
                </ul>
            </div>

            {{-- Zona de peligro --}}
            <div class="bg-white rounded-xl border border-red-100 p-6">
                <h2 class="text-lg font-semibold text-red-600 mb-2">Zona de peligro</h2>
                <p class="text-xs text-gray-500 mb-4">
                    Al eliminar este curso se eliminarán también todas sus lecciones e inscripciones.
                </p>
                <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                      onsubmit="return confirm('¿Estás seguro de eliminar este curso?')">
                    @csrf
                    @method('DELETE')
                    <button class="w-full bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 text-sm">
                        Eliminar curso
                    </button>
                </form>
            </div>

        </div>
    </div>

@endsection