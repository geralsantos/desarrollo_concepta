<?php

namespace App\Http\Requests\Admin\Course;

use Illuminate\Foundation\Http\FormRequest;
use App\Course;
use App\GradeCourse;

class CourseEditRequest extends FormRequest
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
        $course = Course::find($this->route('id'));
        $company = auth()->guard('company')->user();
        $rules = [
            'code' => ['unique:products,code,' . $course->product->id],
        ];

        if ($company) {
            $rules['students'] = ['array', 'max:' . $company->business->products()->withPivot('max_students')->find($course->product_id)->pivot->max_students];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'students.max' => 'El máximo número de alumnos debe ser :max'
        ];
    }
}
