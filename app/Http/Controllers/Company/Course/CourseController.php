<?php

namespace App\Http\Controllers\Company\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Teacher;
use App\Course;
use App\Certificate;
use App\Subscription;
use App\MultimediaType;
use App\Assistance;
use App\Student;
use App\Exercise;
use App\SubmittedForm;
use App\Business;
use Carbon\Carbon;
use App\Theme;
use App\Http\Requests\Admin\Course\CourseEditRequest;

class CourseController extends Controller
{
    public function index()
    {
        $company = auth()->guard('company')->user();
        $data = [
            'company' => $company,
            'courses' => $company->business->courses,
            'business' => Business::find($company->business->id),
        ];

        return view('coordinador_empresa.cursos_coordinador_empresa', $data);
    }

    public function detail($id)
    {   
        $company = auth()->guard('company')->user();
        //dd($company->id);
        $course = $company->business->courses->where('course.id', $id)->first()->instance;
        $certificados = Student::where('company_id', '=', $id)->get();
        $variosCertificados = Certificate::with('student')->get();
        $allcertificados = Certificate::all();

        $data = [
            'course' => $course,
            'sessions' => $course->sessions,
            'exams' => $course->exams,
            'activities' => $course->activities,
            'students' => $company->students,
            'company' => $company,
            'specific_business' => Business::find($company->business->id),
            'businesses' => Business::all(),
            'added_students' => $company->students()->whereHas('subscriptions', function($query) use ($course){$query->where('product_id', $course->product_id);})->get(),
            'allcertificados' => $certificados,
            'certificados' => $variosCertificados,
            'valorId' => $company->id,
            'todosloscertificados' => $allcertificados,
        ];

        return view('coordinador_empresa.curso_ejemplo', $data);
    }

    public function edit($id)
    {
        $course = Course::find($id);

        $data   = [
            'students'         => Student::all(),
            'teachers'         => Teacher::all(),
            'course'           => $course,
            'certificates'     => $course->certificates,
            'target'           => session('target') ? session('target') : urldecode(request('target')),
            'activities'       => $course->activities,
            'exams'            => $course->exams,
            'multimedia_types' => MultimediaType::all(),
            'businesses'       => Business::all(),
        ];

        return view('coordinador_empresa.curso_ejemplo', $data);

    }

    public function postEdit($id, CourseEditRequest $request)
    {

        $course = Course::find($id);

        if ($request->ajax()) {
            $product       = $course->product;
            $course->name  = $request->has('name') ? $request->get('name') : $course->name;
            $product->code = $request->has('code') ? $request->get('code') : $product->code;
            $course->description = $request->has('description') ? $request->get('description') : $course->description;
            $course->teacher_id = $request->has('teacher') ? $request->get('teacher') : $course->teacher_id;

            if ($request->has('students')) {
                $students = $request->get('students');
                $formatted = [];

                foreach ($students as $value) {
                    if ($value) {
                        $formatted[$value] = ['progress' => 0];
                    }
                }

                if (empty($formatted)) {
                    $product->students()->detach();
                } else {
                    $product->students()->sync($formatted);
                }
            }

            $course->save();
            $product->save();

            return response()->json(['success' => 'Updated'], 200);
        } else {
            return redirect()->back();
        }
    }
}
