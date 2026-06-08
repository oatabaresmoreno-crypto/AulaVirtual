{{-- resources/views/instructor/assignments/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mis Asignaciones')

@section('content')

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Mis Asignaciones</h1>
        <a href="{{ route('instructor.assignments.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
            + Nueva Asignación
        </a>
    </div>

    {{-- Tabla de asignaciones --}}
    @if($assignments->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <div class="text-5xl mb-4">📝</div>
            <p class="text-lg">Aún no tienes asignaciones creadas.</p>
            <a href="{{ route('instructor.assignments.create') }}"
               class="text-indigo-600 hover:underline text-sm mt-2 inline-block">
                Crea tu primera asignación
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Asignación</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Lección</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Curso</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Entrega</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Puntaje máx</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Estado</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($assignments as $assignment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $assignment->title }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $assignment->lesson->title }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $assignment->lesson->course->title }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $assignment->due_date ? $assignment->due_date->format('d/m/Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $assignment->max_score }}
                            </td>
                            <td class="px-6 py-4">
                                @if($assignment->active)
                                    <span class="bg-green-50 text-green-700 text-xs px-2 py-1 rounded-full">
                                        Activa
                                    </span>
                                @else
                                    <span class="bg-red-50 text-red-600 text-xs px-2 py-1 rounded-full">
                                        Inactiva
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('instructor.assignments.show', $assignment) }}"
                                       class="text-gray-500 hover:text-indigo-600">Ver</a>
                                    <a href="{{ route('instructor.assignments.edit', $assignment) }}"
                                       class="text-gray-500 hover:text-indigo-600">Editar</a>
                                    <form method="POST" action="{{ route('instructor.assignments.destroy', $assignment) }}"
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta asignación?')">
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