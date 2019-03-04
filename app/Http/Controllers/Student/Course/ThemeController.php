<?php

namespace App\Http\Controllers\Student\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Theme;
use App\Course;

class ThemeController extends Controller
{
    public function showDetail($id)
    {
        $theme = Theme::find($id);
        $data = [
            'specific_theme' => $theme,
            'theme_groups' => Theme::with('session')->get()->where('session.course_id','=',$theme->session->course->id)->groupBy('session_id'),
            'course' => $theme->session->course,
            'target' => session('target') ? session('target') : urldecode(request('target')),
        ];
        $theme->status = $theme->status == 'Por Comenzar' ? 'En Proceso' : $theme->status;
        $theme->save();
        return view('alumnos.sesion_ejemplo', $data);
    }
}
