<?php

namespace App\Http\Controllers\Teacher\Session;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Session;
use App\SessionType;

class SessionController extends Controller
{
    public function edit($id)
    {
        $data = [
            'session' => Session::find($id),
            'session_types' => SessionType::all(),
        ];

        return view('docentes.crear_sesion_docente', $data);
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
            'name' => '',
            'number' => 1,
            'course_id' => request('course_id'),
        ]);

        return redirect()->route('teacher.sessions.edit', $session->id);
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
