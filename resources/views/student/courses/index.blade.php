{{-- resources/views/student/courses/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Cursos disponibles')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Cursos disponibles</h1>
        <p class="text-gray-500 mt-1">{{ $courses->count() }} cursos disponibles</p>
    </div>

    {{-- Filtro por nivel --}}
    <div class="flex gap-2 flex-wrap mb-8">
        <a href="{{ route('student.courses.index') }}"
           class="px-4 py-2 rounded-full text-sm border
                  {{ !request('nivel') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-300' }}">
            Todos
        </a>
        @foreach(['beginner' => 'Principiante', 'intermediate' => 'Intermedio', 'advanced' => 'Avanzado'] as $value => $label)
            <a href="{{ route('student.courses.index', ['nivel' => $value]) }}"
               class="px-4 py-2 rounded-full text-sm border
                      {{ request('nivel') === $value ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-300' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Grid de cursos --}}
    @if($courses->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <x-course-card :course="$course" />
            @endforeach
        </div>
    @else
        <div class="text-center py-20 text-gray-400">
            <p class="text-5xl mb-4">🎓</p>
            <p class="text-lg">No hay cursos disponibles.</p>
        </div>
    @endif

@endsection