{{-- resources/views/student/enrollments/show.blade.php --}}
@extends('layouts.app')

@section('title', $enrollment->course->title)

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $enrollment->course->title }}</h1>
        <a href="{{ route('student.enrollments.index') }}"
           class="text-sm text-gray-500 hover:text-indigo-600">
            ← Volver a mis inscripciones
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Columna izquierda - Lecciones y asignaciones --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Lecciones --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Lecciones del curso</h2>

                @if($enrollment->course->lessons->isEmpty())
                    <p class="text-sm text-gray-400">Este curso aún no tiene lecciones.</p>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($enrollment->course->lessons->sortBy('order') as $lesson)
                            <li class="py-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs text-gray-400 w-5 text-center">
                                            {{ $lesson->order }}
                                        </span>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $lesson->title }}</p>
                                            <p class="text-xs text-gray-400">{{ $lesson->duration_minutes }} min</p>
                                        </div>
                                    </div>
                                    @if($lesson->active)
                                        <span class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded-full">Disponible</span>
                                    @else
                                        <span class="text-xs bg-red-50 text-red-600 px-2 py-1 rounded-full">No disponible</span>
                                    @endif
                                </div>

                                {{-- Asignaciones de la lección --}}
                                @if($lesson->assignments->isNotEmpty())
                                    <div class="ml-8 mt-2 space-y-2">
                                        @foreach($lesson->assignments as $assignment)
                                            @if($assignment->active)
                                                <div class="bg-gray-50 rounded-lg px-3 py-2 flex items-center justify-between">
                                                    <div>
                                                        <p class="text-xs font-medium text-gray-700">📝 {{ $assignment->title }}</p>
                                                        @if($assignment->due_date)
                                                            <p class="text-xs text-gray-400 mt-0.5">
                                                                Entrega: {{ $assignment->due_date->format('d/m/Y') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <span class="text-xs text-gray-500">
                                                        Máx: {{ $assignment->max_score }} pts
                                                    </span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif

                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>

        {{-- Columna derecha - Detalles de la inscripción --}}
        <div class="space-y-6">

            {{-- Detalles --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Mi inscripción</h2>
                <ul class="space-y-3 text-sm">
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
                        <span class="text-gray-500">Instructor</span>
                        <span class="font-medium text-gray-900">{{ $enrollment->course->instructor->name }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Nivel</span>
                        <span class="font-medium text-gray-900">{{ ucfirst($enrollment->course->level) }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Inscrito el</span>
                        <span class="font-medium text-gray-900">{{ $enrollment->enrolled_at->format('d/m/Y') }}</span>
                    </li>
                    @if($enrollment->completed_at)
                        <li class="flex justify-between">
                            <span class="text-gray-500">Completado el</span>
                            <span class="font-medium text-gray-900">{{ $enrollment->completed_at->format('d/m/Y') }}</span>
                        </li>
                    @endif
                    <li class="flex justify-between">
                        <span class="text-gray-500">Lecciones</span>
                        <span class="font-medium text-gray-900">{{ $enrollment->course->lessons->count() }}</span>
                    </li>
                </ul>
            </div>

            {{-- Cancelar inscripción --}}
            @if($enrollment->status === 'active')
                <div class="bg-white rounded-xl border border-red-100 p-6">
                    <h2 class="text-lg font-semibold text-red-600 mb-2">Cancelar inscripción</h2>
                    <p class="text-xs text-gray-500 mb-4">
                        Si cancelas tu inscripción perderás el acceso al curso.
                    </p>
                    <form method="POST" action="{{ route('student.enrollments.destroy', $enrollment) }}"
                          onsubmit="return confirm('¿Estás seguro de cancelar tu inscripción?')">
                        @csrf
                        @method('DELETE')
                        <button class="w-full bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 text-sm">
                            Cancelar inscripción
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>

@endsection