<?php

namespace App\Http\Controllers\Company\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Product\AddStudentRequest;
use App\Student;
use App\Subscription;

class ProductController extends Controller
{
    public function addStudent($id, AddStudentRequest $request)
    {
        $data = $request->all();
        $photo_file   = request()->file('photo');
        $photo_path   = isset($photo_file) ? $photo_file->store(config('constants.upload_paths.students.photos'), 'public') : null;
        $first_segment = $data['name'][0];
        $second_segment = strtok($data['last_name'], ' ');
        $third_segment = Student::where('username', $first_segment . $second_segment)->count();

        $student_data = [
            'name'           => request('name'),
            'last_name'      => request('last_name'),
            'email'          => request('email'),
            'personal_email' => request('personal_email'),
            'job_title'      => request('job_title'),
            'area'           => request('area'),
            'dni'            => request('dni'),
            'phone'          => request('phone'),
            'company_id'     => auth()->guard('company')->user()->id,
            'username'       => $first_segment . $second_segment . ($third_segment ? $third_segment + 1 : ''),
            'password'       => bcrypt('secret'),
            'photo'          => $photo_path,
        ];

        $student = Student::create($student_data);

        $subscription_data = [
            'progress' => 0.0,
            'product_id' => $id,
            'student_id' => $student->id,
        ];

        Subscription::create($subscription_data);

        return redirect()->back();
    }
}
