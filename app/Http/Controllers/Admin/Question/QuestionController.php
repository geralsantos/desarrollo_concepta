<?php

namespace App\Http\Controllers\Admin\Question;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question;
use App\ResponseTemplate;
use App\CorrectResponse;
use App\Keyword;
use App\Category;
use App\ThemeGroup;
use App\ThemeSubGroup;
use App\QuestionSubject;
use App\Complexity;
use App\Type;
use App\Exercise;
use App\SimulatorExam;
use App\Exam;
use App\Activity;
use App\CourseExam;
use App\ProductType;
use App\SubmittedForm;
use App\Answer;
use App\MultimediaType;
use Storage;

class QuestionController extends Controller
{
    

    // public function edit($id)
    // {
        
    //     return view('admin.crear_preguntas_asignar', $question);

    // }



    public function showCreate()

    {
        //$question = Question::find($id);
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
            'multimedia_types' => MultimediaType::all(),
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

        return view('admin.crear_preguntas_asignar', $data);
       // return redirect()->route('admin.questions.create', $question->id);
    }

    public function create(Request $request)
    {
        $data          = $request->all();
        $keyword_names = explode(',', $data['keywords']);
        $keyword_ids   = [];
        $question      = Question::create([
            'text' => $data['text'],
            'type_id' => $data['type_id'],
            'complexity_id' => $data['complexity_id'],
            'subject_id' => $data['subject_id'],
            'attachment_type_id' => $data['select_video_imagen'],
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

                switch ($request->get('select_video_imagen')) {
                    case MULTIMEDIA_TYPE_IMAGE:
                        $upload_path = $request->hasFile('uploaded_image_one') ? $request->file('uploaded_image_one')->store(config('constants.upload_paths.questions.attachments'), 'public') : null;
                        $question->attachment = $upload_path ? Storage::url($upload_path) : null;
                        break;
                    
                    case MULTIMEDIA_TYPE_VIDEO_EMBED:
                        $question->attachment = $request->get('link_video_one');
                        break;        
                }
                    $question->save();

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

                switch ($request->get('select_video_imagen')) {
                    case MULTIMEDIA_TYPE_IMAGE:
                        $upload_path = $request->hasFile('uploaded_image_two') ? $request->file('uploaded_image_two')->store(config('constants.upload_paths.questions.attachments'), 'public') : null;
                        $question->attachment = $upload_path ? Storage::url($upload_path) : null;
                        break;
                    
                    case MULTIMEDIA_TYPE_VIDEO_EMBED: 
                        $question->attachment = $request->get('link_video_two');
                        break;
                    
                    
                }
                    $question->save();


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
                switch ($request->get('select_video_imagen')) {
                    case MULTIMEDIA_TYPE_IMAGE: 
                        $upload_path = $request->hasFile('uploaded_image_three') ? $request->file('uploaded_image_three')->store(config('constants.upload_paths.questions.attachments'), 'public') : null;
                        $question->attachment = $upload_path ? Storage::url($upload_path) : null;
                        break;
                    
                    case MULTIMEDIA_TYPE_VIDEO_EMBED: 
                        $question->attachment = $request->get('link_video_three');
                        break;
                    
                }
                    $question->save();

                break;
            }
            case TYPE_FILE_RESPONSE: {
                switch ($request->get('select_video_imagen')) {
                    case MULTIMEDIA_TYPE_IMAGE: 
                        $upload_path = $request->hasFile('uploaded_image_four') ? $request->file('uploaded_image_four')->store(config('constants.upload_paths.questions.attachments'), 'public') : null;
                        $question->attachment = $upload_path ? Storage::url($upload_path) : null;
                        break;
                    
                    case MULTIMEDIA_TYPE_VIDEO_EMBED: 
                        $question->attachment = $request->get('link_video_four');
                        break;
                    
                    
                }
                    $question->save();

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
                $route = 'admin.themes.edit';
                $id = $entity->theme->id;
                $target = '#ejercicios-tab';
                break;
            }
            case ENTITY_COURSE_EXAM: {
                $entity = CourseExam::find($data['entity_id']);
                $route = 'admin.courses.edit';
                $id = $entity->course->id;
                $target = '#examenes-tab';
                break;
            }
            case ENTITY_ACTIVITY: {
                $entity = Activity::find($data['entity_id']);
                $route = 'admin.courses.edit';
                $id = $entity->course->id;
                $target = '#actividades-tab';
                break;
            }
            case ENTITY_SIMULATOR_EXAM: {
                $entity = SimulatorExam::find($data['entity_id']);
                $route = 'admin.simulators.edit';
                $id = $entity->simulator->id;
                $target = '#examenes-tab';
                break;
            }
            case ENTITY_EXAM: {
                $entity = Exam::find($data['entity_id']);
                $route = 'admin.exams.edit';
                $id = $entity->id;
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
        if(!request('type_id')) {
            $query = $query->where('type_id', '=', '1')
                            ->orWhere('type_id', '=', '2');
        }else{
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
                $route = 'admin.themes.edit';
                $id = $entity->theme->id;
                $target = '#ejercicios-tab';
                break;
            }
            case ENTITY_COURSE_EXAM: {
                $entity = CourseExam::find($data['entity_id']);
                $route = 'admin.courses.edit';
                $id = $entity->course->id;
                $target = '#examenes-tab';
                break;
            }
            case ENTITY_ACTIVITY: {
                $entity = Activity::find($data['entity_id']);
                $route = 'admin.courses.edit';
                $id = $entity->course->id;
                $target = '#actividades-tab';
                break;
            }
            case ENTITY_SIMULATOR_EXAM: {
                $entity = SimulatorExam::find($data['entity_id']);
                $route = 'admin.simulators.edit';
                $id = $entity->simulator->id;
                $target = '#examenes-tab';
                break;
            }
            case ENTITY_EXAM: {
                $entity = Exam::find($data['entity_id']);
                $route = 'admin.exams.edit';
                $id = $entity->id;
                break;
            }
        }

        $entity->questions()->detach($data['question_id']);

        return redirect()->route($route, $id)->with(['target' => $target]);
    }

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
            case ENTITY_EXAM: {
                $entity = Exam::find($data['entity_id']);
                break;
            }
        }

        $data['entity']    = $entity;
        $data['questions'] = $entity->questions()->withPivot('score')->get();

        if ($form) {
            return view('admin.formulario_correccion', $data);
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

        $form->save();

        foreach ($answers as $answer_id => $value) {
            $tmp = Answer::find($answer_id);
            $tmp->final_score = $value['score'];
            $tmp->observation = isset($value['obs']) ? $value['obs'] : null;
            $tmp->save();
        }

        switch (request('entity_name')) {
            case ENTITY_EXAM: {
                $entity = Exam::find(request('entity_id'));
                $route  = 'admin.exams.index';
                $id     = null;
                $target = null;
                break;
            }
        }

        return redirect()->route($route, $id)->with('target', $target);
    }
    public function delete($id)
    {
        $question = Question::find($id);
        $question->delete();

        return response()->json(['success'=>$id]);
    }
}
