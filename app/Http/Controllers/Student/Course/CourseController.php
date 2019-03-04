<?php

namespace App\Http\Controllers\Student\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use App\Annotation;
use App\Session;
use App\CourseExam;
use App\Product;
use App\GradeCourse;
use App\Student;
use App\Activity;
use App\Assistance;
use App\Certificate;
use App\GradeCourseTheme;
use App\Theme;
class CourseController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $student = auth()->guard('web')->user();
        $response = [];
        foreach ($student->courses as $key => $course)
        {
            $sessions = Session::where('course_id',$course->course->id)->get();
            $acum=0;
            foreach ($sessions as $key => $session) {
                $acum+= ($session['score'] == null || $session['score'] == "" ? 1 : 0);
            }
            $response[$course['course']['id']]['progress'] = $acum!=0 ? (round((($acum / count($sessions)) + 1)* (-100))) : 0;
        }
        $data = [
            'courses' => $student->courses,
            'session' => ($response),
            'sesiones_e' => Session::all(),
            'exam_e' => CourseExam::all(),
            'actividad_e' => Activity::all(),
        ];

        return view('alumnos.cursos_alumnos', $data);
    }



    public function showDetail($id)
    {
        $course = Course::find($id);
        $student = auth()->guard('web')->user();
        $response = [];

            $sessions = Session::where('course_id',$id)->get();
            $exams = CourseExam::where('course_id', $id)->get();
            $activities = Activity::where('course_id', $id)->get();
            $asistencias = Assistance::where('student_id', $student->id)->get();
            $certificados = Certificate::where('course_id', $course->id)
                                        ->where('student_id', $student->id)->get();
            $acum=0;
            foreach ($sessions as $key => $session) {
                $acum+= ($session['score'] == null || $session['score'] == "" ? 1 : 0);
            }
            $response['progress'] = $acum!=0? (round((($acum / count($sessions)) -1)* (-100))):0;

        $arrGCT = [];
        $GradeCourseThemes = Theme::query()
        ->leftjoin('grade_course_themes as gct','gct.theme_id','=','themes.id')
        ->leftjoin('sessions as se','se.id','=','themes.session_id')
        ->where('gct.student_id',$student->id)
        ->get(['themes.id as id','themes.name','gct.status','gct.grade as score','se.id as session_id']);
        foreach ($GradeCourseThemes as $key => $value) {
          $arrGCT[$value['session_id']][] = $value;
        }
        $data = [
            'course' => auth()->guard('web')->user()->courses->where('id', $course->product_id)->first(),
            'target' => session('target') ? session('target') : urldecode(request('target')),
            'students' => Student::all(),
            'student' => $student,
            'session' => $response,
            'allsesiones' => $sessions,
            'allexams' => $exams,
            'allactivities' => $activities,
            'allasistencias' => $asistencias,
            'allcertificados' => $certificados,
            'GradeCourseThemes' => ($arrGCT)
        ];
        return view('alumnos.cursoejemplo', $data);
    }

    public function saveAnnotation()
    {
        $student = auth()->guard('web')->user();
        if ($student->annotations()->where('course_id', request('course'))->count()) {
            $annotation = $student->annotations()->where('course_id', request('course'))->first();
        } else {
            $annotation = new Annotation;
            $annotation->student_id = $student->id;
            $annotation->course_id = request('course');
        }

        $annotation->text = request('text') ? request('text') : ' ';
        $annotation->save();

        return response()->json(['status' => 'ok'], 200);
    }
}
