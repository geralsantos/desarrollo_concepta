<?php

namespace App\Http\Controllers\Company\Simulator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Business;
use App\Simulator;

class SimulatorController extends Controller
{
    public function index()
    {
        $company = auth()->guard('company')->user();
        $data = [
            'company' => $company,
            'simulators' => $company->business->simulators,
            'business' => Business::find($company->business->id),
        ];

        return view('coordinador_empresa.simuladores_coordinador_empresa', $data);
    }

    public function detail($id)
    {
        $company = auth()->guard('company')->user();
        $company_students_ids = $company->students->pluck('id')->toArray();
        $simulator = $company->business->simulators->find($id)->instance;

        $data = [
            'simulator' => $simulator,
            'added_students' => $company->business->simulators->find($id)->students()->whereIn('students.id', $company_students_ids)->get(),
            'students' => $company->students,
        ];

        return view('coordinador_empresa.simulador_ejemplo', $data);
    }

    public function edit($id)
    {

        $simulator = Simulator::find($id);

        $data = [
            'simulator' => $simulator,
            'target' => session('target'),
            'students' => Student::all(),
            'exam_groups' => $simulator->exams->groupBy('category_id'),
            'categories' => SimulatorCategory::all(),
            'businesses' => Business::all(),
        ];

        return view('coordinador_empresa.simulador_ejemplo', $data);

    }

    public function postEdit($id, Request $request)
    {
        $simulator = Simulator::find($id);

        if ($request->ajax()) {
            $product                 = $simulator->product;
            /*$simulator->name         = $request->has('name') ? $request->get('name') : $simulator->name;
            $simulator->description  = $request->has('description') ? $request->get('description') : $simulator->description;
            $product->code           = $request->has('code') ? $request->get('code') : $product->code;*/

            if ($request->has('students')) {
                $students = $request->get('students');
                $formatted = [];

                foreach ($students as $value) {
                    $formatted[$value] = ['progress' => 0];
                }

                if (empty($formatted)) {
                    $product->students()->detach();
                } else {
                    $product->students()->sync($formatted);
                }
            }

            //$simulator->save();
            $product->save();

            return response()->json(['success' => 'Updated'], 200);
        }
    }
}
