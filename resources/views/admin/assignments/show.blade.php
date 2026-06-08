{{-- resources/views/admin/assignments/show.blade.php --}}
@extends('layouts.app')

@section('title', $assignment->title)

@section('content')

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $assignment->title }}</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.assignments.edit', $assignment) }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                Editar asignación
            </a>
            <a href="{{ route('admin.assignments.index') }}"
               class="text-sm text-gray-500 hover:text-indigo-600">
                ← Volver a asignaciones
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Columna izquierda - Descripción --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Descripción --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Descripción</h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ $assignment->description ?? 'Esta asignación no tiene descripción.' }}
                </p>
            </div>

        </div>

        {{-- Columna derecha - Detalles --}}
        <div class="space-y-6">

            {{-- Detalles --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detalles</h2>
                <ul class="space-y-3 text-sm">
                    <li class="flex justify-between">
                        <span class="text-gray-500">Lección</span>
                        <a href="{{ route('admin.lessons.show', $assignment->lesson) }}"
                           class="font-medium text-indigo-600 hover:underline">
                            {{ $assignment->lesson->title }}
                        </a>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Curso</span>
                        <a href="{{ route('admin.courses.show', $assignment->lesson->course) }}"
                           class="font-medium text-indigo-600 hover:underline">
                            {{ $assignment->lesson->course->title }}
                        </a>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Instructor</span>
                        <span class="font-medium text-gray-900">{{ $assignment->lesson->course->instructor->name }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Fecha de entrega</span>
                        <span class="font-medium text-gray-900">
                            {{ $assignment->due_date ? $assignment->due_date->format('d/m/Y') : '—' }}
                        </span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Puntaje máximo</span>
                        <span class="font-medium text-gray-900">{{ $assignment->max_score }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Estado</span>
                        @if($assignment->active)
                            <span class="bg-green-50 text-green-700 text-xs px-2 py-1 rounded-full">Activa</span>
                        @else
                            <span class="bg-red-50 text-red-600 text-xs px-2 py-1 rounded-full">Inactiva</span>
                        @endif
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Creada</span>
                        <span class="font-medium text-gray-900">{{ $assignment->created_at->format('d/m/Y') }}</span>
                    </li>
                </ul>
            </div>

            {{-- Zona de peligro --}}
            <div class="bg-white rounded-xl border border-red-100 p-6">
                <h2 class="text-lg font-semibold text-red-600 mb-2">Zona de peligro</h2>
                <p class="text-xs text-gray-500 mb-4">
                    Esta acción no se puede deshacer.
                </p>
                <form method="POST" action="{{ route('admin.assignments.destroy', $assignment) }}"
                      onsubmit="return confirm('¿Estás seguro de eliminar esta asignación?')">
                    @csrf
                    @method('DELETE')
                    <button class="w-full bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 text-sm">
                        Eliminar asignación
                    </button>
                </form>
            </div>

        </div>
    </div>

@endsection