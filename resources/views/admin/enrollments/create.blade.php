{{-- resources/views/admin/enrollments/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Crear Inscripción')

@section('content')

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Crear Inscripción</h1>
        <a href="{{ route('admin.enrollments.index') }}"
           class="text-sm text-gray-500 hover:text-indigo-600">
            ← Volver a inscripciones
        </a>
    </div>

    {{-- Formulario --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">

        <form method="POST" action="{{ route('admin.enrollments.store') }}">
            @csrf

            {{-- Estudiante --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Estudiante</label>
                <select name="student_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               @error('student_id') border-red-400 @enderror">
                    <option value="">Selecciona un estudiante</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}"
                            {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} — {{ $student->email }}
                        </option>
                    @endforeach
                </select>
                @error('student_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Curso --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Curso</label>
                <select name="course_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               @error('course_id') border-red-400 @enderror">
                    <option value="">Selecciona un curso</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}"
                            {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }} — {{ $course->instructor->name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Estado --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               @error('status') border-red-400 @enderror">
                    <option value="active"     {{ old('status', 'active') === 'active'    ? 'selected' : '' }}>Activo</option>
                    <option value="completed"  {{ old('status') === 'completed'           ? 'selected' : '' }}>Completado</option>
                    <option value="cancelled"  {{ old('status') === 'cancelled'           ? 'selected' : '' }}>Cancelado</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                    Crear Inscripción
                </button>
                <a href="{{ route('admin.enrollments.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

@endsection