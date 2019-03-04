<?php

namespace App\Http\Controllers\Company\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Teacher;
use App\Course;
use App\Exam;
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

class ExamController extends Controller
{
    public function index()
    {
        $company = auth()->guard('company')->user();
        $data = [
            'company' => $company,
            'exams' => $company->business->exams,
            'business' => Business::find($company->business->id),
        ];

        return view('coordinador_empresa.evaluaciones_coordinador_empresa', $data);
    }

    public function detail($id)
    {
        $company = auth()->guard('company')->user();
        $company_students_ids = $company->students->pluck('id')->toArray();

        $data = [
            'exam' => $company->business->exams->find($id)->instance,
            'students' => $company->business->exams->find($id)->students()->whereIn('students.id', $company_students_ids)->get(),
        ];

        return view('coordinador_empresa.evaluacion_ejemplo', $data);
    }

    public function edit($id)
    {
        $exam = Exam::find($id);

        $data   = [
            'students'         => Student::all(),
            'teachers'         => Teacher::all(),
            'exam'           => $exam,
            'certificates'     => $exam->certificates,
            'target'           => session('target') ? session('target') : urldecode(request('target')),
            'activities'       => $exam->activities,
            'exams'            => $exam->exams,
            'multimedia_types' => MultimediaType::all(),
            'businesses'       => Business::all(),
        ];

        return view('coordinador_empresa.curso_ejemplo', $data);

    }

    public function postEdit($id, CourseEditRequest $request)
    {

        $course = Course::find($id);

        if ($request->ajax()) {
            $product       = $exam->product;
            $exam->name  = $request->has('name') ? $request->get('name') : $exam->name;
            $product->code = $request->has('code') ? $request->get('code') : $product->code;
            $exam->description = $request->has('description') ? $request->get('description') : $exam->description;
            $exam->teacher_id = $request->has('teacher') ? $request->get('teacher') : $exam->teacher_id;

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

            $exam->save();
            $product->save();

            return response()->json(['success' => 'Updated'], 200);
        } else {
            return redirect()->back();
        }
    }
}
