<?php

namespace App\Http\Requests\Admin\Simulator;

use Illuminate\Foundation\Http\FormRequest;

class AddSimulatorAttachmentRequest extends FormRequest
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
            'nombre_material' => ['required'],
            'file_material' => ['required', 'file'],
        ];
    }
}
