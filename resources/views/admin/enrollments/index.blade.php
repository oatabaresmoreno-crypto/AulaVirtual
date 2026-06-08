{{-- resources/views/admin/enrollments/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Inscripciones')

@section('content')

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Inscripciones</h1>
        <a href="{{ route('admin.enrollments.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
            + Nueva Inscripción
        </a>
    </div>

    {{-- Tabla de inscripciones --}}
    @if($enrollments->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <div class="text-5xl mb-4">📋</div>
            <p class="text-lg">Aún no hay inscripciones registradas.</p>
            <a href="{{ route('admin.enrollments.create') }}"
               class="text-indigo-600 hover:underline text-sm mt-2 inline-block">
                Crear primera inscripción
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Estudiante</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Curso</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Instructor</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Estado</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Inscrito el</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Completado el</th>
                        <th class="text-left px-6 py-3 text-gray-500 font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($enrollments as $enrollment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $enrollment->student->name }}</p>
                                <p class="text-xs text-gray-400">{{ $enrollment->student->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $enrollment->course->title }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $enrollment->course->instructor->name }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs
                                    {{ $enrollment->status === 'active'    ? 'bg-blue-50 text-blue-700'   : '' }}
                                    {{ $enrollment->status === 'completed' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $enrollment->status === 'cancelled' ? 'bg-red-50 text-red-600'     : '' }}
                                    px-2 py-1 rounded-full">
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $enrollment->enrolled_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $enrollment->completed_at ? $enrollment->completed_at->format('d/m/Y') : '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.enrollments.show', $enrollment) }}"
                                       class="text-gray-500 hover:text-indigo-600">Ver</a>
                                    <a href="{{ route('admin.enrollments.edit', $enrollment) }}"
                                       class="text-gray-500 hover:text-indigo-600">Editar</a>
                                    <form method="POST" action="{{ route('admin.enrollments.destroy', $enrollment) }}"
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta inscripción?')">
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