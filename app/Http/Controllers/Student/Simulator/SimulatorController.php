<?php

namespace App\Http\Controllers\Student\Simulator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SimulatorController extends Controller
{
    public function index()
    {
        $data = [
            'simulators' => auth()->guard('web')->user()->simulators,
        ];

        return view('alumnos.simuladores_alumnos', $data);
    }
}
