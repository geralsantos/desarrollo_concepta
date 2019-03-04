<?php

namespace App\Http\Controllers\Student\Question;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exercise;
use App\CourseExam;
use App\Activity;
use App\SimulatorExam;
use App\Exam;
use App\SubmittedForm;
use App\Answer;
use App\GradeCourseExercise;
use App\GradeCourseTheme;
use App\GradeCourseSession;
use App\GradeCourse;
use App\GradeCourseExam;
use App\Question;
use App\Session;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\Student\Question\SubmitFormRequest;
use Storage;

class QuestionController extends Controller
{
    public function showForm(SubmitFormRequest $request)
    {
        $data = request()->all();

        switch ($data['entity_name']) {
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

        return view('alumnos.formulario', $data);
    }

    public function submitForm(SubmitFormRequest $request)
    {
        $data = request()->all();
       $form = SubmittedForm::create([
            'entity_name' => $data['entity_name'],
            'entity_id' => $data['entity_id'],
            'student_id' => auth()->guard('web')->user()->id,
        ]);
        $ids_questions = [];
        foreach ($data['questions'] as $question_id => $value) {
            $is_file = false;
            $name = '';
            $ids_questions[] = $question_id;
            if (is_array($value['response'])) {
                foreach ($value['response'] as $check_value) {
                    Answer::create([
                        'question_id' => $question_id,
                        'name' => $name,
                        'value' => $check_value,
                        'is_file' => $is_file,
                        'form_id' => $form->id,
                    ]);
                }
            } else {
                if (isset($value['file'])) {
                    $file = $value['file'];
                    $is_file = true;
                    $upload_path = $file->store(config('constants.upload_paths.answers.files'), 'public');
                    $name = $upload_path ? Storage::url($upload_path) : '';
                }

                Answer::create([
                    'question_id' => $question_id,
                    'name' => $name,
                    'value' => $value['response'],
                    'is_file' => $is_file,
                    'form_id' => $form->id,
                ]);
            }
        }
        if ($data['entity_name'] == ENTITY_SIMULATOR_EXAM) {
          $this->automaticReview($data['entity_name'], $data['entity_id'], auth()->guard('web')->user()->id);
        }else if ($data['entity_name'] == ENTITY_EXERCISE) {
            $this->automaticReview_($data['entity_name'], $data['entity_id'], auth()->guard('web')->user()->id);
            $this->updateGradeCourseTheme(auth()->guard('web')->user()->id, $data['entity_id']);
        }else if($data['entity_name'] == ENTITY_COURSE_EXAM || $data['entity_name'] == ENTITY_EXAM){
          //registrar examen
          $arr = Question::whereIn('id',$ids_questions)->where('type_id',3)->pluck('id')->toArray();
          if (count($arr)<=0) {
            $this->automaticReview($data['entity_name'], $data['entity_id'], auth()->guard('web')->user()->id);
          }
        }
        //return redirect()->route('user.courses.index');
        //return $this->backReview();
    }
    public function updateGradeCourseTheme($student_id, $entity_id)
    {
      $grade_course_exercise = GradeCourseExercise::where('student_id', $student_id)->where('status','!=','Finalizado')->whereNotNull('status')
                           ->get()->count();
                           echo '$grade_course_exercise: '.$grade_course_exercise;
      //si no hay un ejercicio por hacer se hace la nota del tema
      if ($grade_course_exercise<=0) {
         $themeavg = DB::table('grade_course_exercises')->select(DB::raw('AVG(grade) as avg'))
         ->where('student_id','=', auth()->guard('web')->user()->id)
         ->whereNotNull('status')
         ->first()->avg;

        $theme_id = Exercise::find($entity_id)->theme_id;

        $updateGradeCourseTheme=GradeCourseTheme::firstOrCreate(['student_id'=>$student_id,
        'theme_id'=>$theme_id]);
        $updateGradeCourseTheme->status='Finalizado';
        $updateGradeCourseTheme->grade=$themeavg;
        $updateGradeCourseTheme->save();
        echo '$updateGradeCourseTheme: '.($updateGradeCourseTheme?"true":"false");

        if ($updateGradeCourseTheme) {
          $grade_course_theme = GradeCourseTheme::where('student_id', $student_id)->where('status','!=','Finalizado')->whereNotNull('status')
                               ->get()->count();
                               echo 'GradeCourseTheme: '.($grade_course_theme);

          if ($grade_course_theme<=0) {
            $themeavg = DB::table('grade_course_themes')->select(DB::raw('AVG(grade) as avg'))
            ->where('student_id','=', $student_id)
            ->whereNotNull('status')
            ->first()->avg;
            $session_id = Exercise::find($entity_id)->theme->session_id;

             $updateGradeCourseSession=GradeCourseSession::firstOrCreate(['student_id'=>$student_id,
             'session_id'=>$session_id]);
             $updateGradeCourseSession->status='Finalizado';
             $updateGradeCourseSession->grade=$themeavg;
             $updateGradeCourseSession->save();
             echo '$updateGradeCourseSession: '.($updateGradeCourseSession?"true":"false");

             if ($updateGradeCourseSession) {
               $session_id = Exercise::find($entity_id)->theme->session_id;
               $course_id = Session::find($session_id)->course_id;

               $updateGradeCourseSession=GradeCourseSession::where('student_id',$student_id)
               ->get();
               $avg=0;$count=0;
               echo '$updateGradeCourseSession: '.($updateGradeCourseSession);

               foreach ($updateGradeCourseSession as $key => $value) {
                 $avg+= $value["grade"];
                 $count++;
               }
               $avg = $avg!=0? ($avg/$count):0;
               $updateGradeCourse=GradeCourse::firstOrCreate(['student_id'=>$student_id,
               'course_id'=>$course_id]);
               echo '$updateGradeCourse: '.($updateGradeCourse?"true":"false");

               $updateGradeCourse->grade_sessions = $avg;
               $updateGradeCourse->grade = $this->grade_course_total($updateGradeCourse);
               $updateGradeCourse->save();
             }
         }else{
           $session_id = Exercise::find($entity_id)->theme->session_id;
            $updateGradeCourseSession=GradeCourseSession::firstOrCreate(['student_id'=>$student_id,
            'session_id'=>$session_id]);
            $updateGradeCourseSession->status='En Proceso';
            $updateGradeCourseSession->save();

         }
        }
      }else{
        $theme_id = Exercise::find($entity_id)->theme_id;
        $updateGradeCourseTheme=GradeCourseTheme::firstOrCreate(['student_id'=>$student_id,
        'theme_id'=>$theme_id]);
        $updateGradeCourseTheme->status='En Proceso';
        $updateGradeCourseTheme->save();
        if ($updateGradeCourseTheme) {
          $session_id = Exercise::find($entity_id)->theme->session_id;
           $updateGradeCourseSession=GradeCourseSession::firstOrCreate(['student_id'=>$student_id,
           'session_id'=>$session_id]);
           $updateGradeCourseSession->status='En Proceso';
           $updateGradeCourseSession->save();
        }
      }
    }
    public function grade_course_total($grade_course)
    {
      return (empty($grade_course->weight_sessions)?:($grade_course->weight_sessions/100) * $grade_course->grade_sessions) + (empty($grade_course->weight_exams)?:($grade_course->weight_exams/100) * $grade_course->grade_exams) + (empty($grade_course->weight_activities)?:($grade_course->weight_activities/100) * $grade_course->grade_activities);
    }
    public function resultReview()
    {
        $form = SubmittedForm::where('entity_name', request('entity_name'))
                             ->where('entity_id', request('entity_id'))
                             ->where('student_id', auth()->guard('web')->user()->id)
                             ->first();

        $data = [
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
            return view('alumnos.resultado_evaluacion', $data);
        } else {
            return redirect()->back();
        }
    }

    public function backReview()
    {
        switch (request('entity_name')) {
            case ENTITY_EXERCISE: {
                $entity = Exercise::find(request('entity_id'));
                $route = 'user.courses.theme-detail';
                $id = $entity->theme->id;
                $target = '#nav-ejercicios-tab';
                break;
            }
            case ENTITY_COURSE_EXAM: {
                $entity = CourseExam::find(request('entity_id'));
                $route = 'user.courses.detail';
                $id = $entity->course->id;
                $target = '#nav-examen-tab';
                break;
            }
            case ENTITY_ACTIVITY: {
                $entity = Activity::find(request('entity_id'));
                $route = 'user.courses.detail';
                $id = $entity->course->id;
                $target = '#nav-actividad-tab';
                break;
            }
            case ENTITY_SIMULATOR_EXAM: {
                $entity = SimulatorExam::find(request('entity_id'));
                $route = 'user.simulators.index';
                $id = null;
                $target = '#nav-contact-8';
                break;
            }
            case ENTITY_EXAM: {
                $entity = Exam::find(request('entity_id'));
                $route = 'user.exams.index';
                $id = null;
                $target = null;
                break;
            }
        }

        return redirect()->route($route, $id)->with('target', $target);
    }
    public function automaticReview_($entity_name, $entity_id, $student_id)
    {
        $form = SubmittedForm::where('entity_name', $entity_name)
                             ->where('entity_id', $entity_id)
                             ->where('student_id', $student_id)
                             ->first();
        $entity = null;
        $grade_course_exercise = GradeCourseExercise::firstOrCreate(['student_id' => $student_id,
                             'exercise_id'=> $entity_id]);
        switch (request('entity_name')) {
            case ENTITY_EXERCISE: {
                $entity = Exercise::find($entity_id);
                break;
            }
        }

        $questions = $entity->questions()->withPivot('score')->get();
        $answers = [];

        foreach ($form->answers->groupBy('question_id') as $answer){
            if ($answer->first()->question->type_id == TYPE_SINGLE_RESPONSE) {
                $answers[$answer->first()->id]['score'] = $answer->first()->value == $answer->first()->question->correct_responses()->first()->value ?
                                                 $questions->where('id', $answer->first()->question->id)->first()->pivot->score :
                                                 0;
            } elseif ($answer->first()->question->type_id == TYPE_MULTIPLE_RESPONSE) {
                $answers[$answer->first()->id]['score'] = !array_diff($answer->pluck('value')->toArray(),$answer->first()->question->correct_responses->pluck('value')->toArray()) && count($answer->pluck('value')->toArray()) == count($answer->first()->question->correct_responses->pluck('value')->toArray()) ?
                                                 $questions->where('id', $answer->first()->question->id)->first()->pivot->score :
                                                 0;
            }
        }

        $form->evaluated = true;
        $form->save();
        foreach ($answers as $answer_id => $value) {
            $tmp = Answer::find($answer_id);
            $tmp->final_score = $value['score'];
            $tmp->save();
            $grade_course_exercise->grade = $value['score'];
            $grade_course_exercise->status = "Finalizado";
            $grade_course_exercise->save();

        }
    }
    public function automaticReview($entity_name, $entity_id, $student_id)
    {
        $form = SubmittedForm::where('entity_name', $entity_name)
                             ->where('entity_id', $entity_id)
                             ->where('student_id', $student_id)
                             ->first();
        $entity = null;

        switch (request('entity_name')) {
            case ENTITY_SIMULATOR_EXAM:
                $entity = SimulatorExam::find($entity_id);
                break;
            case ENTITY_COURSE_EXAM:
                $entity = CourseExam::find($entity_id);
                $grade_course_exams = GradeCourseExam::firstOrCreate(['student_id'=> $student_id,
                'course_exam_id'=> $entity->id]);
                break;
            case ENTITY_EXAM:
                $entity = Exam::find($entity_id);
                break;
        }

        $questions = $entity->questions()->withPivot('score')->get();
        $answers = [];

        foreach ($form->answers->groupBy('question_id') as $answer){
            if ($answer->first()->question->type_id == TYPE_SINGLE_RESPONSE) {
                $answers[$answer->first()->id]['score'] = $answer->first()->value == $answer->first()->question->correct_responses()->first()->value ?
                                                 $questions->where('id', $answer->first()->question->id)->first()->pivot->score :
                                                 0;
            } elseif ($answer->first()->question->type_id == TYPE_MULTIPLE_RESPONSE) {
                $answers[$answer->first()->id]['score'] = !array_diff($answer->pluck('value')->toArray(),$answer->first()->question->correct_responses->pluck('value')->toArray()) && count($answer->pluck('value')->toArray()) == count($answer->first()->question->correct_responses->pluck('value')->toArray()) ?
                                                 $questions->where('id', $answer->first()->question->id)->first()->pivot->score :
                                                 0;
            }
        }

        $form->evaluated = true;

        $form->save();

        foreach ($answers as $answer_id => $value) {
            $tmp = Answer::find($answer_id);
            $tmp->final_score = $value['score'];
            $tmp->save();
            switch (request('entity_name')) {
                case ENTITY_COURSE_EXAM:
                $grade_course_exams->grade = $value['score'];
                $grade_course_exams->status = "Finalizado";
                $grade_course_exams->save();
                    break;
            }
        }
        switch (request('entity_name')) {
            case ENTITY_COURSE_EXAM:
            $grade_course_exam = GradeCourseExam::where('student_id', $student_id)->where('status','!=','Finalizado')->whereNotNull('status')
                                 ->get()->count();
            if ($grade_course_exam<=0) {
              $examavg = DB::table('grade_course_exams')->select(DB::raw('AVG(grade) as avg'))
              ->where('student_id','=', auth()->guard('web')->user()->id)
              ->whereNotNull('status')
              ->first()->avg;
              $grade_course = GradeCourse::firstOrCreate(['student_id'=> $student_id,
              'course_id'=> $entity->course_id]);
              $grade_course->grade_exams = $examavg;
              $grade_course->grade = $this->grade_course_total($grade_course);
              $grade_course->save();
            }
                break;
        }
        return redirect()->route('user.questions.back-review', ['entity_name' => $entity_name, 'entity_id' => $entity_id]);
    }
}
