{{-- resources/views/instructor/assignments/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Asignación')

@section('content')

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Editar Asignación</h1>
        <a href="{{ route('instructor.assignments.index') }}"
           class="text-sm text-gray-500 hover:text-indigo-600">
            ← Volver a mis asignaciones
        </a>
    </div>

    {{-- Formulario --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-2xl">

        <form method="POST" action="{{ route('instructor.assignments.update', $assignment) }}">
            @csrf
            @method('PUT')

            {{-- Lección --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Lección</label>
                <select name="lesson_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500
                               @error('lesson_id') border-red-400 @enderror">
                    <option value="">Selecciona una lección</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}"
                            {{ old('lesson_id', $assignment->lesson_id) == $lesson->id ? 'selected' : '' }}>
                            {{ $lesson->course->title }} — {{ $lesson->title }}
                        </option>
                    @endforeach
                </select>
                @error('lesson_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Título --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" name="title" value="{{ old('title', $assignment->title) }}"
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
                                 @error('description') border-red-400 @enderror">{{ old('description', $assignment->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Fecha de entrega y Puntaje máximo --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de entrega</label>
                    <input type="date" name="due_date"
                           value="{{ old('due_date', $assignment->due_date?->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  @error('due_date') border-red-400 @enderror">
                    @error('due_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Puntaje máximo</label>
                    <input type="number" name="max_score" value="{{ old('max_score', $assignment->max_score) }}" min="1" max="1000"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  @error('max_score') border-red-400 @enderror">
                    @error('max_score')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Activo --}}
            <div class="mb-6">
                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input type="checkbox" name="active" value="1"
                           {{ old('active', $assignment->active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    Asignación activa
                </label>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                    Guardar cambios
                </button>
                <a href="{{ route('instructor.assignments.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

@endsection