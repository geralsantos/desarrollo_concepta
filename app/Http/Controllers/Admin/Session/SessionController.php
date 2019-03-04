<?php

namespace App\Http\Controllers\Admin\Session;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Session;
use App\SessionType;
use App\Exercise;
use App\Theme;
use App\ThemeAttachment;
use App\ThemeMultimedia;
use App\GradeCourseSession;

class SessionController extends Controller
{
    public function edit($id)
    {
        $data = [
            'session' => Session::find($id),
            'session_types' => SessionType::all(),
            'themeEjercicios' => Exercise::all(),
            'themeClases' => ThemeMultimedia::all(),
            'themeMaterial' => ThemeAttachment::all(),
            'tema' => Theme::all(),
        ];

        return view('admin.crear_sesion_admin', $data);
    }

    public function delete($id)
    {
        if (Session::destroy($id)) {
            return response()->json(['success' => 'Deleted'], 200);
        } else {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    public function create()
    {
        $session = Session::create([
            'name' => 'Sesion Ejemplo',
            'number' => 1,
            'course_id' => request('course_id'),
        ]);
        $course = $session->course;
        foreach($course->product->students as $student){
          $gradeCourseTheme = GradeCourseSession::firstOrCreate([
              'student_id' => $student->id,
              'session_id' => $session->id,
          ]);
        }
        return redirect()->route('admin.sessions.edit', $session->id);
    }

    public function postEdit($id, Request $request)
    {
        $session = Session::find($id);

        if ($request->ajax()) {
            $session->name  = $request->has('name') ? $request->get('name') : $session->name;
            $session->session_type_id = $request->has('type') ? $request->get('type') : $session->session_type_id;

            $session->save();

            return response()->json(['success' => 'Updated'], 200);
        } else {

        }
    }
}
