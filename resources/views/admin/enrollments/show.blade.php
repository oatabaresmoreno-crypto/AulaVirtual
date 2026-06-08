{{-- resources/views/admin/enrollments/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detalle de Inscripción')

@section('content')

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Detalle de Inscripción</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.enrollments.edit', $enrollment) }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                Editar inscripción
            </a>
            <a href="{{ route('admin.enrollments.index') }}"
               class="text-sm text-gray-500 hover:text-indigo-600">
                ← Volver a inscripciones
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Columna izquierda - Lecciones --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Lecciones del curso --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Lecciones del curso</h2>

                @if($enrollment->course->lessons->isEmpty())
                    <p class="text-sm text-gray-400">Este curso aún no tiene lecciones.</p>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($enrollment->course->lessons->sortBy('order') as $lesson)
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
                                    <a href="{{ route('admin.lessons.show', $lesson) }}"
                                       class="text-xs text-gray-500 hover:text-indigo-600">Ver</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>

        {{-- Columna derecha - Detalles --}}
        <div class="space-y-6">

            {{-- Detalles de la inscripción --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detalles</h2>
                <ul class="space-y-3 text-sm">
                    <li class="flex justify-between">
                        <span class="text-gray-500">Estudiante</span>
                        <span class="font-medium text-gray-900">{{ $enrollment->student->name }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Email</span>
                        <span class="font-medium text-gray-900">{{ $enrollment->student->email }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Curso</span>
                        <a href="{{ route('admin.courses.show', $enrollment->course) }}"
                           class="font-medium text-indigo-600 hover:underline">
                            {{ $enrollment->course->title }}
                        </a>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Instructor</span>
                        <span class="font-medium text-gray-900">{{ $enrollment->course->instructor->name }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Estado</span>
                        <span class="text-xs
                            {{ $enrollment->status === 'active'    ? 'bg-blue-50 text-blue-700'   : '' }}
                            {{ $enrollment->status === 'completed' ? 'bg-green-50 text-green-700' : '' }}
                            {{ $enrollment->status === 'cancelled' ? 'bg-red-50 text-red-600'     : '' }}
                            px-2 py-1 rounded-full">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Inscrito el</span>
                        <span class="font-medium text-gray-900">{{ $enrollment->enrolled_at->format('d/m/Y') }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Completado el</span>
                        <span class="font-medium text-gray-900">
                            {{ $enrollment->completed_at ? $enrollment->completed_at->format('d/m/Y') : '—' }}
                        </span>
                    </li>
                </ul>
            </div>

            {{-- Zona de peligro --}}
            <div class="bg-white rounded-xl border border-red-100 p-6">
                <h2 class="text-lg font-semibold text-red-600 mb-2">Zona de peligro</h2>
                <p class="text-xs text-gray-500 mb-4">
                    Esta acción no se puede deshacer.
                </p>
                <form method="POST" action="{{ route('admin.enrollments.destroy', $enrollment) }}"
                      onsubmit="return confirm('¿Estás seguro de eliminar esta inscripción?')">
                    @csrf
                    @method('DELETE')
                    <button class="w-full bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 text-sm">
                        Eliminar inscripción
                    </button>
                </form>
            </div>

        </div>
    </div>

@endsection