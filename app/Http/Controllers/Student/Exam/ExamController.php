<?php

namespace App\Http\Controllers\Student\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public function index()
    {
        $data = [
            'exams' => auth()->guard('web')->user()->exams,
        ];

        return view('alumnos.evaluaciones_alumnos', $data);
    }
}
