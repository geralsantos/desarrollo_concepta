<?php

namespace App\Http\Controllers\Admin\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\CourseEditRequest;
use App\Teacher;
use App\Student;
use App\Course;
use App\Product;
use App\MultimediaType;
use App\Business;
use App\Exercise;
use App\GradeCourse;
use App\GradeCourseExercise;
use App\GradeCourseTheme;
use App\GradeCourseSession;
use App\SubmittedForm;
use App\Theme;

use Storage;

class CourseController extends Controller
{
    public function index()
    {
        $data = [
            'courses' => Course::all(),
        ];

        return view('admin.cursos_admin', $data);
    }

    public function create()
    {
         $product = Product::create([
            'code' => '',
        ]);

        $course = Course::create([
            'name' => '',
            'description' => '.',
            'duration' => 0,
            'title_intro' => '',
            'intro_type_id' => MULTIMEDIA_TYPE_VIDEO_EMBED,
            'product_id' => $product->id,
        ]);

        return redirect()->route('admin.courses.edit', $course->id);
        /*
        $course = json_decode('{"name":"","product":{"code":"","students":[]},"title_intro":"","video_intro":"","description":"","sessions":[],"teacher":{"full_name":"","dni":"","personal_email":""},"teacher_id":"","certificates":[],"activities":[],"exams":[]}');
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
        return view('admin.crear_curso_admin', $data);*/
    }
    public function store(Request $request)
    {
        /*$rules = array(
            //solo caracteres:regex:/^[a-z]+$/i;
            'Categoria'   => 'required|max:25',
            'Descripcion'   => 'required|max:200'
        );
        $validator = Validator::make($request->all(), $rules);

        $product = Product::create([
            'code' => '',
        ]);

        $course = Course::create([
            'name' => '',
            'description' => '.',
            'duration' => 0,
            'title_intro' => '',
            'intro_type_id' => MULTIMEDIA_TYPE_VIDEO_EMBED,
            'product_id' => $product->id,
        ]);

        return redirect()->route('admin.courses.edit', $course->id);*/
    }
    public function edit($id)
    {
        $course = Course::find($id);
        /*foreach ($course->sessions as $key => $session) {
            $arr_session[] = $session["id"];
        }
        $themes = Theme::whereIn('session_id',$arr_session)->get();
        foreach ($themes as $key => $theme) {
            $arr_theme[] = $theme['id'];
        }
        foreach (Exercise::whereIn('theme_id',$arr_theme)->get() as $key => $exercise) {
            $arr_exercise[] = $exercise['id'];
        }
        $acum = [];
        foreach ($course->product->students as $key => $product_student) {
            foreach (SubmittedForm::whereIn('entity_id',$arr_exercise)->where('entity_name',1)->get() as $key => $subForm) {
                if ($subForm['student_id'] == $product_student['student_id'])
                {
                    $acum = $acum + Product;
                    break;
                }
            }
        }

        $xd = SubmittedForm::whereIn('entity_id',$arr_exercise)->where('entity_name',1)->get();
        */
        /*

        $total = 0;
        $notasXexercises = GradeCourseExercise::all();
        $todosExercises = Exercise::all();

        foreach ($notasXexercises as $notasXexercise) {
            foreach ($todosExercises as $todosExercise) {
                if($notasXexercise->exercise_id == $todosExercise->id){
                    $total = $notasXexercise->grade + $total;
                }
            }
        }

        */

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
            'gradeCourse' => GradeCourse::where('course_id', '=', $id)->first(),
            'gradeXcadaSesion' => GradeCourseExercise::all(),
            'ejercicios' => Exercise::all(),
        ];


        return view('admin.crear_curso_admin', $data);
    }

    public function postEdit($id, CourseEditRequest $request)
    {
        $course = Course::find($id);
        //$cantidadMax = Business::find($id);
        $businesses_product = Business::all();
        // $weight_grade_courses = GradeCourse::find('course_id', '=', 4);

        //$pesos = GradeCourse::find(49);
        $pesos = GradeCourse::where('course_id', '=', $id)->get();

        if ($request->ajax()) {
            $product       = $course->product;
            $course->name  = $request->has('name') ? $request->get('name') : $course->name;
            $product->code = $request->has('code') ? $request->get('code') : $product->code;
            $course->description = $request->has('description') ? $request->get('description') : $course->description;
            $course->teacher_id = $request->has('teacher') ? $request->get('teacher') : $course->teacher_id;


            if ($request->has('students')) {
                $students = $request->get('students');
                $formatted = [];
                $sessions = $course->sessions;$ids_session=[];
                foreach ($sessions as $key => $value) {
                  $ids_session[]=$value['id'];
                }
                foreach ($students as $value) {
                    $formatted[$value] = ['progress' => 0];

                    $gradeCourse = GradeCourse::firstOrCreate([
                        'student_id' => $value,
                        'course_id' => $course->id,

                    ]);
                    $themes = Theme::whereIn('session_id',$ids_session)->get();
                    $themes_id = [];
                    foreach($themes as $theme){
                        $gradeCourseTheme = GradeCourseTheme::firstOrCreate([
                            'student_id' => $value,
                            'theme_id' => $theme->id,
                        ]);
                        $themes_id[] = $theme->id;
                    }
                    foreach($sessions as $key => $session){
                        $gradeCourseTheme = GradeCourseSession::firstOrCreate([
                            'student_id' => $value,
                            'session_id' => $session->id,
                        ]);
                    }
                    $exercises = Exercise::whereIn('theme_id',$themes_id)->get();
                    foreach($exercises as $exercise){
                        $gradeCourseTheme = GradeCourseExercise::firstOrCreate([
                            'student_id' => $value,
                            'exercise_id' => $exercise->id,
                        ]);
                    }
                    $gradeCourse->weight_sessions = $request->get('weight_sessions');
                    $gradeCourse->weight_exams = $request->get('weight_exams');
                    $gradeCourse->weight_activities = $request->get('weight_activities');
                    $gradeCourse -> save();

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
    public function delete(Request $request)
    {
        $course = Course::find($request->get('id'));
        /*$gradeCourses = GradeCourse::where('course_id', '=', $request->get('id'))->get();

        foreach($gradeCourses as $gradeCourse){
            $gradeCourse->delete();
        }*/

        $course->delete();

        return response()->json(['success'=>$request->get('id')]);
    }

}
