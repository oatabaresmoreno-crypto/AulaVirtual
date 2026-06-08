{{-- resources/views/admin/lessons/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Lección')

@section('content')

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Editar Lección</h1>
        <a href="{{ route('admin.lessons.index') }}"
           class="text-sm text-gray-500 hover:text-indigo-600">
            ← Volver a lecciones
        </a>
    </div>

    {{-- Formulario --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">

        <form method="POST" action="{{ route('admin.lessons.update', $lesson) }}">
            @csrf
            @method('PUT')

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
                            {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->title }} — {{ $course->instructor->name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Título --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" name="title" value="{{ old('title', $lesson->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500
                              @error('title') border-red-400 @enderror">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contenido --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                <textarea name="content" rows="6"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                 focus:outline-none focus:ring-2 focus:ring-indigo-500
                                 @error('content') border-red-400 @enderror">{{ old('content', $lesson->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Orden y Duración --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                    <input type="number" name="order" value="{{ old('order', $lesson->order) }}" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  @error('order') border-red-400 @enderror">
                    @error('order')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duración (minutos)</label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $lesson->duration_minutes) }}" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  @error('duration_minutes') border-red-400 @enderror">
                    @error('duration_minutes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Activo --}}
            <div class="mb-6">
                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input type="checkbox" name="active" value="1"
                           {{ old('active', $lesson->active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    Lección activa
                </label>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                    Guardar cambios
                </button>
                <a href="{{ route('admin.lessons.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

@endsection