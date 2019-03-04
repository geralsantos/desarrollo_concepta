<?php

namespace App\Http\Controllers\Admin\Theme;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Theme;
use App\ThemeMultimedia;
use App\ThemeAttachment;
use App\Exercise;
use App\Course;
use App\GradeCourseExercise;
use App\GradeCourseTheme;
use App\MultimediaType;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Theme\AddThemeMultimediaRequest;
use App\Http\Requests\Admin\Theme\AddThemeAttachmentRequest;

class ThemeController extends Controller
{
    public function create()
    {
        $theme = Theme::create([
            'name' => '',
            'duration' => 0,
            'session_id' => request('session_id'),
            'description' => '',
        ]);
        $course = $theme->session->course;
        foreach($course->product->students as $student){
          $gradeCourseTheme = GradeCourseTheme::firstOrCreate([
              'student_id' => $student->id,
              'theme_id' => $theme->id,
          ]);
        }
        return redirect()->route('admin.themes.edit', $theme->id);
    }

    public function delete($id)
    {
        if (Theme::destroy($id)) {
            return response()->json(['success' => 'Deleted'], 200);
        } else {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    public function edit($id)
    {
        $data = [
            'theme' => Theme::find($id),
            'target' => session('target'),
            'multimedia_types' => MultimediaType::all(),
        ];

        return view('admin.crear_tema_admin', $data);
    }

    public function postEdit($id, Request $request)
    {
        if ($request->ajax()) {
            $theme = Theme::find($id);

            $theme->name = $request->get('name');
            $theme->description = $request->get('description') ? $request->get('description') : '';
            $theme->save();

            return response()->json(['success' => 'updated'], 200);
        }
    }

    public function addMultimedia($id, AddThemeMultimediaRequest $request)
    {
        $data = $request->all(); //pide toda la data que esta en el formulario

        switch ($data['type']) {
            case MULTIMEDIA_TYPE_IMAGE: {
                $upload_path = isset($data['uploaded_file']) ? $data['uploaded_file']->store(config('constants.upload_paths.themes.multimedia'), 'public') : null;
                $name        = request('name_image');

                if ($upload_path) {
                    ThemeMultimedia::create([
                        'name'               => $name,
                        'url'                => Storage::url($upload_path),
                        'theme_id'           => $id,
                        'multimedia_type_id' => request('type'),
                    ]);
                }

                break;
            }

            case MULTIMEDIA_TYPE_VIDEO_EMBED: {
                $upload_path = request('uploaded_file');
                $name        = request('name_video');

                if ($upload_path) {
                    ThemeMultimedia::create([
                        'name'               => $name,
                        'url'                => url($upload_path),
                        'theme_id'           => $id,
                        'multimedia_type_id' => request('type'),
                    ]);
                }

                break;
            }
        }

        return redirect()->back()->with(['target' => '#clase-tab']);
    }

    public function deleteMultimedia($id, $multimedia_id)
    {
        $multimedia = ThemeMultimedia::find($multimedia_id);
        $multimedia_url = $multimedia->url;

        if ($multimedia->delete()) {
            Storage::delete($multimedia_url);
        }

        return redirect()->back()->with(['target' => '#clase-tab']);
    }

    public function addAttachment($id, AddThemeAttachmentRequest $request)
    {
        $data = $request->all();
        $upload_path = isset($data['uploaded_material']) ? $data['uploaded_material']->store(config('constants.upload_paths.themes.attachments'), 'public') : null;

        if ($upload_path) {
            ThemeAttachment::create([
                'name' => $data['title_material'],
                'url' => Storage::url($upload_path),
                'theme_id' =>$id,
            ]);
        }

        return redirect()->back()->with(['target' => '#materiales-tab']);
    }

    public function deleteAttachment($id, $attachment_id)
    {
        $attachment = ThemeAttachment::find($attachment_id);
        $attachment_url = $attachment->url;

        if ($attachment->delete()) {
            Storage::delete($attachment_url);
        }

        return redirect()->back()->with(['target' => '#materiales-tab']);
    }

    public function addExercise($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $exercise = Exercise::create([
            'name' => $request->get('title'),
            'theme_id' => $id,
        ]);

        $course = $exercise->theme->session->course;

        foreach($course->product->students as $student){

            $gradeCourseExercises = GradeCourseExercise::firstOrCreate([
                'student_id' => $student->id,
                'exercise_id' => $exercise->id,
            ]);

        }

        return redirect()->route('admin.themes.edit-exercise', [$id, $exercise->id]);
    }

    public function editExercise($id, $exercise_id)
    {
        return redirect()->route('admin.questions.create', ['entity_name' => ENTITY_EXERCISE, 'entity_id' => $exercise_id]);
    }

    public function deleteExercise($id, $exercise_id)
    {
        $success = Exercise::destroy($exercise_id);

        $gradeCourseExercises = GradeCourseExercise::where('exercise_id', '=', $exercise_id)->get();

        foreach($gradeCourseExercises as $gradeCourseExercise){
            $gradeCourseExercise->delete();
        }

        return redirect()->back()->with(['target' => '#ejercicios-tab']);
    }

    public function studentView($id)
    {
        /*$theme = Theme::find($id);
        $data  = [
            'specific_theme' => $theme,
            'theme_groups' => Theme::with('session')->get()->where('session.course_id','=',$theme->session->course->id)->groupBy('session_id'),
            'course' => $theme->session->course,
        ];

        return view('admin.tema_vista_alumno', $data);*/
        $theme = Theme::find($id);
        $data = [
            'specific_theme' => $theme,
            'theme_groups' => Theme::with('session')->get()->where('session.course_id','=',$theme->session->course->id)->groupBy('session_id'),
            'course' => $theme->session->course,
        ];
        return view('admin.tema_vista_alumno', $data);
    }
}
