{{-- resources/views/student/courses/show.blade.php --}}
@extends('layouts.app')

@section('title', $course->title)

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Columna izquierda - Info del curso --}}
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
                    {{ $course->description ?? 'Este curso no tiene descripción.' }}
                </p>
            </div>

            {{-- Lecciones --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Contenido del curso</h2>

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
                                @if($isEnrolled)
                                    <span class="text-xs text-indigo-600">Disponible</span>
                                @else
                                    <span class="text-xs text-gray-400">🔒</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>

        {{-- Columna derecha - Inscripción --}}
        <div class="space-y-6">

            {{-- Card de inscripción --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h1 class="text-xl font-bold text-gray-900 mb-1">{{ $course->title }}</h1>
                <p class="text-sm text-indigo-500 font-medium mb-4">{{ ucfirst($course->level) }}</p>

                <ul class="space-y-2 text-sm mb-6">
                    <li class="flex justify-between">
                        <span class="text-gray-500">Instructor</span>
                        <span class="font-medium text-gray-900">{{ $course->instructor->name }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Lecciones</span>
                        <span class="font-medium text-gray-900">{{ $course->lessons->count() }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Estudiantes</span>
                        <span class="font-medium text-gray-900">{{ $course->enrollments->count() }}</span>
                    </li>
                </ul>

                @if($isEnrolled)
                    <div class="bg-green-50 text-green-700 text-sm text-center px-4 py-3 rounded-lg mb-3">
                        ✓ Ya estás inscrito en este curso
                    </div>
                    <a href="{{ route('student.enrollments.index') }}"
                       class="block text-center text-sm text-indigo-600 hover:underline">
                        Ver mis inscripciones
                    </a>
                @else
                    <form method="POST" action="{{ route('student.enrollments.store') }}">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <button type="submit"
                                class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-medium text-sm">
                            Inscribirme
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>

@endsection