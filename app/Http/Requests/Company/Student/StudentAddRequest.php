<?php

namespace App\Http\Requests\Company\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email_empresarial_alumno' => ['required', 'unique:students,email'],
            'email_personal_alumno' => ['required', 'unique:students,personal_email'],
            'dni_alumno' => ['required', 'unique:students,dni'],
            'nombres_alumno' => ['required'],
            'apellidos_alumno' => ['required'],
        ];
    }
}
