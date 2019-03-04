<?php

namespace App\Http\Requests\Admin\Theme;

use Illuminate\Foundation\Http\FormRequest;

class AddThemeMultimediaRequest extends FormRequest
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
            'uploaded_file' => ['required'], //te dice que este campo es obligatorio
        ];
    }
}
