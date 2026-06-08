<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id'        => 'required|exists:courses,id',
            'title'            => 'required|string|max:200',
            'content'          => 'nullable|string',
            'order'            => 'required|integer|min:0',
            'duration_minutes' => 'required|integer|min:0',
            'active'           => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'course_id.required'        => 'El curso es obligatorio.',
            'course_id.exists'          => 'El curso seleccionado no existe.',
            'title.required'            => 'El título es obligatorio.',
            'title.max'                 => 'El título no puede superar los 200 caracteres.',
            'order.required'            => 'El orden es obligatorio.',
            'order.integer'             => 'El orden debe ser un número entero.',
            'order.min'                 => 'El orden no puede ser negativo.',
            'duration_minutes.required' => 'La duración es obligatoria.',
            'duration_minutes.integer'  => 'La duración debe ser un número entero.',
            'duration_minutes.min'      => 'La duración no puede ser negativa.',
        ];
    }
}