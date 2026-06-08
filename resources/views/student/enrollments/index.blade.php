{{-- resources/views/student/enrollments/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mis Inscripciones')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Mis Inscripciones</h1>
        <p class="text-gray-500 mt-1">Cursos en los que estás inscrito</p>
    </div>

    @if($enrollments->isEmpty())
        <div class="text-center py-20 text-gray-400">
            <p class="text-5xl mb-4">📚</p>
            <p class="text-lg">Aún no estás inscrito en ningún curso.</p>
            <a href="{{ route('student.courses.index') }}"
               class="text-indigo-600 hover:underline text-sm mt-2 inline-block">
                Ver cursos disponibles
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($enrollments as $enrollment)
                <div class="bg-white rounded-xl border border-gray-200 hover:shadow-md transition-all duration-200">

                    {{-- Imagen del curso --}}
                    @if($enrollment->course->cover_image)
                        <img src="{{ asset('storage/' . $enrollment->course->cover_image) }}"
                             alt="{{ $enrollment->course->title }}"
                             class="w-full h-36 object-cover rounded-t-xl">
                    @else
                        <div class="w-full h-36 bg-indigo-50 rounded-t-xl flex items-center justify-center text-5xl">
                            🎓
                        </div>
                    @endif

                    {{-- Info --}}
                    <div class="p-4">
                        <p class="text-xs text-indigo-500 font-medium">{{ ucfirst($enrollment->course->level) }}</p>
                        <h3 class="font-semibold text-gray-900 mt-1">{{ $enrollment->course->title }}</h3>
                        <p class="text-xs text-gray-400 mt-1">{{ $enrollment->course->instructor->name }}</p>

                        <div class="flex items-center justify-between mt-4">
                            <span class="text-xs
                                {{ $enrollment->status === 'active'    ? 'bg-blue-50 text-blue-700'  : '' }}
                                {{ $enrollment->status === 'completed' ? 'bg-green-50 text-green-700' : '' }}
                                {{ $enrollment->status === 'cancelled' ? 'bg-red-50 text-red-600'   : '' }}
                                px-2 py-1 rounded-full">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                            <a href="{{ route('student.enrollments.show', $enrollment) }}"
                               class="text-sm text-indigo-600 hover:underline">
                                Ver curso →
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

@endsection