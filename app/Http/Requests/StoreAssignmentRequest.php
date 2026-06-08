<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lesson_id'   => 'required|exists:lessons,id',
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date|after:today',
            'max_score'   => 'required|integer|min:1|max:1000',
            'active'      => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'lesson_id.required' => 'La lección es obligatoria.',
            'lesson_id.exists'   => 'La lección seleccionada no existe.',
            'title.required'     => 'El título es obligatorio.',
            'title.max'          => 'El título no puede superar los 200 caracteres.',
            'due_date.date'      => 'La fecha de entrega debe ser una fecha válida.',
            'due_date.after'     => 'La fecha de entrega debe ser posterior a hoy.',
            'max_score.required' => 'El puntaje máximo es obligatorio.',
            'max_score.integer'  => 'El puntaje máximo debe ser un número entero.',
            'max_score.min'      => 'El puntaje máximo debe ser al menos 1.',
            'max_score.max'      => 'El puntaje máximo no puede superar 1000.',
        ];
    }
}