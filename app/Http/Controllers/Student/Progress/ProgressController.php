<?php

namespace App\Http\Controllers\Student\Progress;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgressController extends Controller
{
    public function index()
    {
        $user = auth()->guard('web')->user();

        $data = [
            'courses' => $user->courses,
            'exams' => $user->exams,
            'simulators' => $user->simulators,
            'user' => $user,
        ];

        return view('alumnos.desempenio', $data);
    }
}
