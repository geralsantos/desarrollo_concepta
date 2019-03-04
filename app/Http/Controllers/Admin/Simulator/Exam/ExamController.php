<?php

namespace App\Http\Controllers\Admin\Simulator\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\SimulatorExam;

class ExamController extends Controller
{
    public function create()
    {
        $exam = SimulatorExam::create([
            'name' => request('nombre_examen'),
            'simulator_id' => request('simulator_id'),
            'category_id' => request('category_id'),
        ]);

        //return redirect()->route('admin.questions.create', ['entity_name' => ENTITY_SIMULATOR_EXAM, 'entity_id' => $exam->id]);
        return response()->json($exam, 200);
    }

    public function showEdit($id)
    {
        return redirect()->route('admin.questions.create', ['entity_name' => ENTITY_SIMULATOR_EXAM, 'entity_id' => $id]);
    }

    public function delete($id)
    {
        $success = SimulatorExam::destroy($id);

        return redirect()->back()->with(['target' => '#examenes-tab']);
    }
}
