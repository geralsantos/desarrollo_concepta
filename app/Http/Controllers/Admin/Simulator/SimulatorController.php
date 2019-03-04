<?php

namespace App\Http\Controllers\Admin\Simulator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Simulator;
use App\Product;
use App\Business;
use App\Student;
use App\SimulatorAttachment;
use App\SimulatorCategory;
use App\Http\Requests\Admin\Simulator\AddSimulatorAttachmentRequest;
use Storage;

class SimulatorController extends Controller
{
    public function index()
    {
        $data = [
            'simulators' => Simulator::all(),
        ];

        return view('admin.simuladores_admin', $data);
    }

    public function create()
    {
        $product = Product::create([
            'code' => '',
        ]);

        $simulator = Simulator::create([
            'name' => '',
            'duration' => 0,
            'description' => '',
            'title' => '',
            'product_id' => $product->id,
        ]);

        return redirect()->route('admin.simulators.edit', $simulator->id);
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

        return view('admin.crear_simulador_admin', $data);
    }

    public function postEdit($id, Request $request)
    {
        $simulator = Simulator::find($id);

        if ($request->ajax()) {
            $product                 = $simulator->product;
            $simulator->name         = $request->has('name') ? $request->get('name') : $simulator->name;
            $simulator->description  = $request->has('description') ? $request->get('description') : $simulator->description;
            $product->code           = $request->has('code') ? $request->get('code') : $product->code;

            if ($request->has('students')) {
                $students = $request->get('students');
                $formatted = [];

                foreach ($students as $value) {
                    $formatted[$value] = ['progress' => 0];
                }

                $product->students()->sync($formatted);
            }

            $simulator->save();
            $product->save();

            return response()->json(['success' => 'Updated'], 200);
        }
    }

    public function addAttachment($id, AddSimulatorAttachmentRequest $request)
    {
        $data = $request->all();
        $upload_path = isset($data['file_material']) ? $data['file_material']->store(config('constants.upload_paths.simulators.attachments'), 'public') : null;
        $attachment = null;

        if ($upload_path) {
            $attachment = SimulatorAttachment::create([
                'name' => $data['nombre_material'],
                'url' => Storage::url($upload_path),
                'simulator_id' =>$id,
            ]);
        }

        return response()->json($attachment, 200);
    }

    public function deleteAttachment($id, $attachment_id)
    {
        $attachment = SimulatorAttachment::find($attachment_id);
        $attachment_url = $attachment->url;

        if ($attachment->delete()) {
            Storage::delete($attachment_url);
        }

        return redirect()->back()->with(['target' => '#materiales-tab']);
    }

    public function delete(Request $request){

        $simulator = Simulator::find($request->get('id'));
        $simulator->delete();

        return response()->json(['success'=>$request->get('id')]);
    }

}