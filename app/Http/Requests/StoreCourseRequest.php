<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'instructor_id' => 'required|exists:users,id',
            'title'         => 'required|string|max:200',
            'description'   => 'nullable|string',
            'cover_image'   => 'nullable|image|max:2048',
            'level'         => 'required|in:beginner,intermediate,advanced',
            'active'        => 'boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'instructor_id.required' => 'El instructor es obligatorio.',
            'instructor_id.exists'   => 'El instructor seleccionado no existe.',
            'title.required'         => 'El título es obligatorio.',
            'title.max'              => 'El título no puede superar los 200 caracteres.',
            'cover_image.image'      => 'El archivo debe ser una imagen.',
            'cover_image.max'        => 'La imagen no puede superar los 2MB.',
            'level.required'         => 'El nivel es obligatorio.',
            'level.in'               => 'El nivel debe ser principiante, intermedio o avanzado.',
        ];
    }
}