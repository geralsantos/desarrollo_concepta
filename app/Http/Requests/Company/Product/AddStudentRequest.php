<?php

namespace App\Http\Requests\Company\Product;

use Illuminate\Foundation\Http\FormRequest;
use App\Business;
use App\Subscription;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AddStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $product_id = $this->route('id');
        $business = Business::find(auth()->guard('company')->user()->business->id);
        $students_subscribed = Subscription::where('product_id', $product_id)->whereIn('student_id', $business->company->students->pluck('id')->toArray())->count();
        $max_students = $business->products()->withPivot('max_students')->get()->find($product_id)->pivot->max_students;

        return $students_subscribed < $max_students;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dni' => 'required|unique:students,dni',
        ];
    }
}
