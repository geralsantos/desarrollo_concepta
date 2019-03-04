<?php

namespace App\Http\Controllers\Teacher\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use App\Subscription;
use Carbon\Carbon;
use App\Assistance;
use App\Student;
use App\MultimediaType;
use App\Teacher;
use App\Product;
use App\GradeCourseExam;
use App\GradeCourseActivity;
use App\SubmittedForm;

use App\Http\Requests\Admin\Course\CourseEditRequest;
use Storage;
use Illuminate\Support\Facades\DB;
class CourseController extends Controller
{
    public function index()
    {
        $data = [
            'courses' => auth()->guard('teacher')->user()->courses,
        ];

        return view('docentes.cursos_docentes', $data);
    }

    public function detail($id)
    {
        $data = [
            'course' => Course::find($id),
        ];

        return view('docentes.curso_ejemplo', $data);
    }

    public function saveAssistances()
    {
        $students = request('alumnos');
        $session_id = request('session_id');

        foreach ($students as $id => $value) {
            $assistance = Assistance::where('session_id', $session_id)
                                      ->where('student_id', $id)
                                      ->first();
            if ($assistance) {
                $assistance->value = $value;
            } else {
                $assistance = new Assistance;
                $assistance->session_id = $session_id;
                $assistance->student_id = $id;
                $assistance->date = Carbon::now()->toDateTimeString();
                $assistance->value = $value;
            }

            $assistance->save();
        }

        return redirect()->back();
    }

    public function edit($id)
    {
        $course = Course::find($id);

        $exams_ids = [];
        foreach ($course->exams as $key => $exam) {
          $exams_ids[]=$exam->id;
        }

        $grade_course_exam = DB::table('submitted_forms')->select(DB::raw('CONCAT(student_id,"-",entity_id) as stu_enti'))->where('evaluated','=',1)->whereIn('entity_id', $exams_ids)->pluck('stu_enti')->toArray();

        $ids = [];
        foreach ($course->activities as $key => $activity) {
          $ids[]=$activity->id;
        }
        $grade_course_activity = DB::table('submitted_forms')->select(DB::raw('CONCAT(student_id,"-",entity_id) as stu_enti'))->where('evaluated','=',1)->whereIn('entity_id', $ids)->pluck('stu_enti')->toArray();

        $data   = [
            'students'         => Student::all(),
            'teachers'         => Teacher::all(),
            'course'           => $course,
            'certificates'     => $course->certificates,
            'target'           => session('target') ? session('target') : urldecode(request('target')),
            'activities'       => $course->activities,
            'exams'            => $course->exams,
            'multimedia_types' => MultimediaType::all(),
            'grade_course_exam' => $grade_course_exam,
            'grade_course_activity' => $grade_course_activity,
        ];
        return view('docentes.editar_curso', $data);
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
                    $formatted[$value] = ['progress' => 0];
                }

                $product->students()->sync($formatted);
            }

            $course->save();
            $product->save();

            return response()->json(['success' => 'Updated'], 200);
        } else {
            $course->intro_type_id = $request->get('type');
            switch ($request->get('type')) {
                case MULTIMEDIA_TYPE_IMAGE: {
                    $upload_path = $request->hasFile('uploaded_file') ? $request->file('uploaded_file')->store(config('constants.upload_paths.courses.intro'), 'public') : null;
                    $course->video_intro = Storage::url($upload_path);
                    $course->title_intro = $request->get('title_imagen');
                    break;
                }
                case MULTIMEDIA_TYPE_VIDEO_EMBED: {
                    $course->video_intro = $request->get('link_video');
                    $course->title_intro = $request->get('title_video');
                    break;
                }
            }

            $course->save();

            return redirect()->back();
        }
    }
}
