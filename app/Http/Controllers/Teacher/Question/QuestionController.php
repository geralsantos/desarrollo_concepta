<?php

namespace App\Http\Controllers\Teacher\Question;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductType;
use App\Category;
use App\ThemeGroup;
use App\ThemeSubGroup;
use App\QuestionSubject;
use App\Complexity;
use App\Type;
use App\SubmittedForm;
use App\Exercise;
use App\CourseExam;
use App\GradeCourseExam;
use App\GradeCourse;
use App\GradeCourseActivity;
use App\Activity;
use App\SimulatorExam;
use App\Exam;
use App\Answer;
use App\Question;
use App\Keyword;
use App\ResponseTemplate;
use App\CorrectResponse;
use Storage;
use Illuminate\Support\Facades\DB;
class QuestionController extends Controller
{
    public function showReview()
    {
        $form = SubmittedForm::where('entity_name', request('entity_name'))
                             ->where('entity_id', request('entity_id'))
                             ->where('student_id', request('student_id'))
                             ->first();

        $data = [
            'products'     => ProductType::all(),
            'categories'   => Category::all(),
            'groups'       => ThemeGroup::all(),
            'sub_groups'   => ThemeSubGroup::all(),
            'subjects'     => QuestionSubject::all(),
            'complexities' => Complexity::all(),
            'types'        => Type::all(),
            'entity_name'  => request('entity_name'),
            'entity_id'    => request('entity_id'),
            'form'         => $form,
        ];

        switch (request('entity_name')) {
            case ENTITY_EXERCISE: {
                $entity = Exercise::find($data['entity_id']);
                break;
            }
            case ENTITY_COURSE_EXAM: {
                $entity = CourseExam::find($data['entity_id']);
                break;
            }
            case ENTITY_ACTIVITY: {
                $entity = Activity::find($data['entity_id']);
                break;
            }
            case ENTITY_SIMULATOR_EXAM: {
                $entity = SimulatorExam::find($data['entity_id']);
                break;
            }
            case ENTITY_EXAM: {
                $entity = Exam::find($data['entity_id']);
                break;
            }
        }

        $data['entity']    = $entity;
        $data['questions'] = $entity->questions()->withPivot('score')->get();

        if ($form) {
            return view('docentes.formulario_correccion', $data);
        } else {
            return redirect()->back()->with('target', '#ejercicios-tab');
        }
    }

    public function review()
    {
        $form = SubmittedForm::where('entity_name', request('entity_name'))
                             ->where('entity_id', request('entity_id'))
                             ->where('student_id', request('student_id'))
                             ->first();

        $answers = request('answer');

        $form->evaluated = true;
        switch (request('entity_name')) {
            case ENTITY_COURSE_EXAM:
                $entity = CourseExam::find(request('entity_id'));
                $grade_course_exams = GradeCourseExam::where('student_id', request('student_id'))
                ->where('course_exam_id', $entity->id)
                                     ->first();
                break;
            case ENTITY_ACTIVITY:
                $entity = Activity::find(request('entity_id'));
                $grade_course_activity = GradeCourseActivity::where('student_id', request('student_id'))
                ->where('activity_id', $entity->id)
                                     ->first();
                break;
        }
        $form->save();
        foreach ($answers as $answer_id => $value) {
            $tmp = Answer::find($answer_id);
            $tmp->final_score = $value['score'];
            $tmp->observation = isset($value['obs']) ? $value['obs'] : null;
            $tmp->save();
        }

        switch (request('entity_name')) {
            case ENTITY_EXERCISE: {
                $entity = Exercise::find(request('entity_id'));
                $route  = 'teacher.themes.edit';
                $id     = $entity->theme->id;
                $target = '#ejercicios-tab';
                break;
            }
            case ENTITY_COURSE_EXAM: {
                $entity = CourseExam::find(request('entity_id'));
                $grade_course_exams->grade = $value['score'];
                $grade_course_exams->status = "Finalizado";
                $grade_course_exams->save();
                $route  = 'teacher.courses.edit';
                $id     = $entity->course->id;
                $grade_course_exam = GradeCourseExam::where('student_id',request('student_id'))->where('status','!=','Finalizado')->whereNotNull('status')
                                     ->get()->count();
                if ($grade_course_exam<=0) {
                  $examavg = DB::table('grade_course_exams')->select(DB::raw('AVG(grade) as avg'))
                  ->where('student_id','=', request('student_id'))
                  ->whereNotNull('status')
                  ->first()->avg;
                  $grade_course = GradeCourse::where('student_id', request('student_id'))
                  ->where('course_id', $entity->course_id)->firstOrFail();
                  $grade_course->grade_exams = $examavg;
                  $grade_course->grade = $this->grade_course_total($grade_course);
                  $grade_course->save();
                }
                $target = '#nav-examen-tab';
                break;
            }
            case ENTITY_ACTIVITY: {
                $entity = Activity::find(request('entity_id'));
                $grade_course_activity->grade = $value['score'];
                $grade_course_activity->status = "Finalizado";
                $grade_course_activity->save();
                $route  = 'teacher.courses.edit';
                $id     = $entity->course->id;
                $grade_course_activity = GradeCourseActivity::where('student_id',request('student_id'))->where('status','!=','Finalizado')->whereNotNull('status')
                                     ->get()->count();
                if ($grade_course_activity<=0) {
                  $examavg = DB::table('grade_course_activities')->select(DB::raw('AVG(grade) as avg'))
                  ->where('student_id','=', request('student_id'))
                  ->whereNotNull('status')
                  ->first()->avg;
                  $grade_course = GradeCourse::where('student_id', request('student_id'))
                  ->where('course_id', $entity->course_id)->firstOrFail();
                  $grade_course->grade_activities = $examavg;
                  $grade_course->grade = $this->grade_course_total($grade_course);
                  $grade_course->save();
                }

                $target = '#nav-actividad-tab';
                break;
            }
            case ENTITY_SIMULATOR_EXAM: {
                $entity = SimulatorExam::find(request('entity_id'));
                break;
            }
            case ENTITY_EXAM: {
                $entity = Exam::find(request('entity_id'));
                break;
            }
        }

        return redirect()->route($route, $id)->with('target', $target);
    }
    public function grade_course_total($grade_course)
    {
      return (empty($grade_course->weight_sessions)?:($grade_course->weight_sessions/100) * $grade_course->grade_sessions) + (empty($grade_course->weight_exams)?:($grade_course->weight_exams/100) * $grade_course->grade_exams) + (empty($grade_course->weight_activities)?:($grade_course->weight_activities/100) * $grade_course->grade_activities);
    }
    public function showCreate()
    {
        $data = [
            'products'     => ProductType::all(),
            'categories'   => Category::all(),
            'groups'       => ThemeGroup::all(),
            'sub_groups'   => ThemeSubGroup::all(),
            'subjects'     => QuestionSubject::all(),
            'complexities' => Complexity::all(),
            'types'        => Type::all(),
            'entity_name'  => request('entity_name'),
            'entity_id'    => request('entity_id'),
        ];

        switch (request('entity_name')) {
            case ENTITY_EXERCISE: {
                $data['entity'] = Exercise::find($data['entity_id']);
                break;
            }
            case ENTITY_COURSE_EXAM: {
                $data['entity'] = CourseExam::find($data['entity_id']);
                break;
            }
            case ENTITY_ACTIVITY: {
                $data['entity'] = Activity::find($data['entity_id']);
                break;
            }
            case ENTITY_SIMULATOR_EXAM: {
                $data['entity'] = SimulatorExam::find($data['entity_id']);
                break;
            }
            case ENTITY_EXAM: {
                $data['entity'] = Exam::find($data['entity_id']);
                break;
            }
        }

        return view('docentes.crear_preguntas_asignar', $data);
    }

    public function create(Request $request)
    {
        $data          = $request->all();
        $keyword_names = explode(',', $data['keywords']);
        $keyword_ids   = [];
        $upload_path   = isset($data['uploaded_question']) ? $data['uploaded_question']->store(config('constants.upload_paths.questions.attachments'), 'public') : null;
        $question      = Question::create([
            'text' => $data['text'],
            'type_id' => $data['type_id'],
            'complexity_id' => $data['complexity_id'],
            'subject_id' => $data['subject_id'],
            'attachment' => $upload_path ? Storage::url($upload_path) : null,
        ]);

        foreach ($keyword_names as $keyword_name) {
            $keyword = Keyword::firstOrCreate(['name' => $keyword_name]);
            $keyword_ids[] = $keyword->id;
        }

        $question->keywords()->sync($keyword_ids);

        switch ($data['type_id']) {
            case TYPE_SINGLE_RESPONSE: {
                foreach ($data['opcion'] as  $value) {
                    ResponseTemplate::create([
                        'question_id' => $question->id,
                        'name' => '',
                        'value' => $value,
                        'is_alternative' => true,
                    ]);
                }

                CorrectResponse::create([
                    'question_id' => $question->id,
                    'name' => '',
                    'value' => $data['respuesta'],
                ]);

                break;
            }
            case TYPE_MULTIPLE_RESPONSE: {

                foreach ($data['opcion'] as  $value) {
                    ResponseTemplate::create([
                        'question_id' => $question->id,
                        'name' => '',
                        'value' => $value,
                        'is_alternative' => true,
                    ]);
                }

                foreach ($data['respuesta'] as  $value) {
                    CorrectResponse::create([
                        'question_id' => $question->id,
                        'name' => '',
                        'value' => $value,
                    ]);
                }

                break;
            }
            case TYPE_OPEN_RESPONSE: {

                break;
            }
            case TYPE_FILE_RESPONSE: {

                break;
            }
        }

        return response()->json($question->toArray(), 200);
    }

    public function sync()
    {
        $data = request()->all();
        $entity = null;
        $route = null;
        $target = null;
        $id = null;

        switch ($data['entity_name']) {
            case ENTITY_EXERCISE: {
                $entity = Exercise::find($data['entity_id']);
                $route = 'teacher.themes.edit';
                $id = $entity->theme->id;
                $target = '#ejercicios-tab';
                break;
            }
            case ENTITY_COURSE_EXAM: {
                $entity = CourseExam::find($data['entity_id']);
                $route = 'teacher.courses.edit';
                $id = $entity->course->id;
                $target = '#examenes-tab';
                break;
            }
            case ENTITY_ACTIVITY: {
                $entity = Activity::find($data['entity_id']);
                $route = 'teacher.courses.edit';
                $id = $entity->course->id;
                $target = '#actividades-tab';
                break;
            }
        }

        $entity->duration = request('duration', $entity->duration);
        $entity->save();

        $entity->questions()->sync($data['questions']);

        return redirect()->route($route, $id)->with(['target' => $target]);
    }

    public function filter()
    {
        $query = Question::with('type');

        if(request('category_id')) {
            $query = $query->where('category_id', request('category_id'));
        }
        if(request('subject_id')) {
            $query = $query->where('subject_id', request('subject_id'));
        }
        if(request('complexity_id')) {
            $query = $query->where('complexity_id', request('complexity_id'));
        }
        if(request('type_id')) {
            $query = $query->where('type_id', request('type_id'));
        }

        return response()->json($query->get(), 200);
    }

    public function detach()
    {
        $data = request()->all();
        $entity = null;
        $route = null;
        $target = null;
        $id = null;

        switch ($data['entity_name']) {
            case ENTITY_EXERCISE: {
                $entity = Exercise::find($data['entity_id']);
                $route = 'teacher.themes.edit';
                $id = $entity->theme->id;
                $target = '#ejercicios-tab';
                break;
            }
            case ENTITY_COURSE_EXAM: {
                $entity = CourseExam::find($data['entity_id']);
                $route = 'teacher.courses.edit';
                $id = $entity->course->id;
                $target = '#examenes-tab';
                break;
            }
            case ENTITY_ACTIVITY: {
                $entity = Activity::find($data['entity_id']);
                $route = 'teacher.courses.edit';
                $id = $entity->course->id;
                $target = '#actividades-tab';
                break;
            }
        }

        $entity->questions()->detach($data['question_id']);

        return redirect()->route($route, $id)->with(['target' => $target]);
    }
}
