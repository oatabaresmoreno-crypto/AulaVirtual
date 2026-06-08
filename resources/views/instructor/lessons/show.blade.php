{{-- resources/views/instructor/lessons/show.blade.php --}}
@extends('layouts.app')

@section('title', $lesson->title)

@section('content')

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $lesson->title }}</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('instructor.lessons.edit', $lesson) }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                Editar lección
            </a>
            <a href="{{ route('instructor.lessons.index') }}"
               class="text-sm text-gray-500 hover:text-indigo-600">
                ← Volver a mis lecciones
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Columna izquierda - Contenido --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Contenido de la lección --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Contenido</h2>
                <div class="text-sm text-gray-600 leading-relaxed">
                    {{ $lesson->content ?? 'Esta lección no tiene contenido aún.' }}
                </div>
            </div>

            {{-- Asignaciones --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Asignaciones</h2>
                    <a href="{{ route('instructor.assignments.create') }}"
                       class="text-sm text-indigo-600 hover:underline">
                        + Agregar asignación
                    </a>
                </div>

                @if($lesson->assignments->isEmpty())
                    <p class="text-sm text-gray-400">Esta lección aún no tiene asignaciones.</p>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($lesson->assignments as $assignment)
                            <li class="py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $assignment->title }}</p>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-xs text-gray-400">
                                            Puntaje máx: {{ $assignment->max_score }}
                                        </span>
                                        @if($assignment->due_date)
                                            <span class="text-xs text-gray-400">
                                                Entrega: {{ $assignment->due_date->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($assignment->active)
                                        <span class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded-full">Activa</span>
                                    @else
                                        <span class="text-xs bg-red-50 text-red-600 px-2 py-1 rounded-full">Inactiva</span>
                                    @endif
                                    <a href="{{ route('instructor.assignments.edit', $assignment) }}"
                                       class="text-xs text-gray-500 hover:text-indigo-600">Editar</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>

        {{-- Columna derecha - Detalles --}}
        <div class="space-y-6">

            {{-- Detalles de la lección --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detalles</h2>
                <ul class="space-y-3 text-sm">
                    <li class="flex justify-between">
                        <span class="text-gray-500">Curso</span>
                        <a href="{{ route('instructor.courses.show', $lesson->course) }}"
                           class="font-medium text-indigo-600 hover:underline">
                            {{ $lesson->course->title }}
                        </a>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Orden</span>
                        <span class="font-medium text-gray-900">{{ $lesson->order }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Duración</span>
                        <span class="font-medium text-gray-900">{{ $lesson->duration_minutes }} min</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Estado</span>
                        @if($lesson->active)
                            <span class="bg-green-50 text-green-700 text-xs px-2 py-1 rounded-full">Activa</span>
                        @else
                            <span class="bg-red-50 text-red-600 text-xs px-2 py-1 rounded-full">Inactiva</span>
                        @endif
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Asignaciones</span>
                        <span class="font-medium text-gray-900">{{ $lesson->assignments->count() }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Creada</span>
                        <span class="font-medium text-gray-900">{{ $lesson->created_at->format('d/m/Y') }}</span>
                    </li>
                </ul>
            </div>

            {{-- Eliminar lección --}}
            <div class="bg-white rounded-xl border border-red-100 p-6">
                <h2 class="text-lg font-semibold text-red-600 mb-2">Zona de peligro</h2>
                <p class="text-xs text-gray-500 mb-4">
                    Al eliminar esta lección se eliminarán también todas sus asignaciones.
                </p>
                <form method="POST" action="{{ route('instructor.lessons.destroy', $lesson) }}"
                      onsubmit="return confirm('¿Estás seguro de eliminar esta lección?')">
                    @csrf
                    @method('DELETE')
                    <button class="w-full bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 text-sm">
                        Eliminar lección
                    </button>
                </form>
            </div>

        </div>
    </div>

@endsection