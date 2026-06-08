{{-- resources/views/admin/courses/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Curso')

@section('content')

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Editar Curso</h1>
        <a href="{{ route('admin.courses.index') }}"
           class="text-sm text-gray-500 hover:text-indigo-600">
            ← Volver a cursos
        </a>
    </div>

    {{-- Formulario --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">

        <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Instructor --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Instructor</label>
                <select name="instructor_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               @error('instructor_id') border-red-400 @enderror">
                    <option value="">Selecciona un instructor</option>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->id }}"
                            {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>
                            {{ $instructor->name }}
                        </option>
                    @endforeach
                </select>
                @error('instructor_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Título --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500
                              @error('title') border-red-400 @enderror">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descripción --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                 focus:outline-none focus:ring-2 focus:ring-indigo-500
                                 @error('description') border-red-400 @enderror">{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nivel --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nivel</label>
                <select name="level"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               @error('level') border-red-400 @enderror">
                    <option value="">Selecciona un nivel</option>
                    <option value="beginner"     {{ old('level', $course->level) === 'beginner'     ? 'selected' : '' }}>Principiante</option>
                    <option value="intermediate" {{ old('level', $course->level) === 'intermediate' ? 'selected' : '' }}>Intermedio</option>
                    <option value="advanced"     {{ old('level', $course->level) === 'advanced'     ? 'selected' : '' }}>Avanzado</option>
                </select>
                @error('level')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Imagen de portada --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen de portada</label>

                {{-- Imagen actual --}}
                @if($course->cover_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $course->cover_image) }}"
                             alt="{{ $course->title }}"
                             class="w-32 h-20 object-cover rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-400 mt-1">Imagen actual</p>
                    </div>
                @endif

                <input type="file" name="cover_image" accept="image/*"
                       class="w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                              file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100">
                <p class="text-xs text-gray-400 mt-1">Deja vacío para mantener la imagen actual.</p>
                @error('cover_image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Activo --}}
            <div class="mb-6">
                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input type="checkbox" name="active" value="1"
                           {{ old('active', $course->active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    Curso activo
                </label>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                    Guardar cambios
                </button>
                <a href="{{ route('admin.courses.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

@endsection