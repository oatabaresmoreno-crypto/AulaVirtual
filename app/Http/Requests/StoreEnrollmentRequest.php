<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'course_id' => 'required|exists:courses,id',
    ];
}

    public function messages(): array
    {
        return [
            'course_id.required'  => 'El curso es obligatorio.',
            'course_id.exists'    => 'El curso seleccionado no existe.',
            'student_id.required' => 'El estudiante es obligatorio.',
            'student_id.exists'   => 'El estudiante seleccionado no existe.',
            'status.required'     => 'El estado es obligatorio.',
            'status.in'           => 'El estado debe ser activo, completado o cancelado.',
        ];
    }
}