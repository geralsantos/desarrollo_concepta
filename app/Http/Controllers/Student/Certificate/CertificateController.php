<?php

namespace App\Http\Controllers\Student\Certificate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CertificateController extends Controller
{
    public function index()
    {
        $data = [
            'certificates' => auth()->guard('web')->user()->certificates,
        ];

        return view('alumnos.certificados_alumnos', $data);
    }
}
