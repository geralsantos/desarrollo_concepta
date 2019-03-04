<?php

namespace App\Http\Controllers\Company\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Theme;

class ThemeController extends Controller
{
    public function detail($id)
    {
        $theme = Theme::find($id);
        $data = [
            'specific_theme' => $theme,
            'theme_groups' => Theme::with('session')->get()->groupBy('session_id'),
            'course' => $theme->session->course,
        ];

        return view('coordinador_empresa.sesion_ejemplo', $data);
    }
}
