<?php

namespace App\Http\Requests\Student\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use DB;

class SubmitFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $count = DB::table('submitted_forms')
                   ->where('entity_name', $this->get('entity_name'))
                   ->where('entity_id', $this->get('entity_id'))
                   ->where('student_id', auth()->guard('web')->user()->id)
                   ->count();

        return !$count;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
