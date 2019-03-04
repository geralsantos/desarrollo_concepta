<?php

namespace App\Http\Controllers\Admin\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exam;
use App\ExamCategory;
use App\Product;
use App\Business;
use App\Student;
use Illuminate\Support\Facades\DB;
class ExamController extends Controller
{
    public function index()
    {
        $result = new Exam;

        if(request()->has('category')) {
            $result = $result->where('category_id', request('category'));
        }

        $data = [
            'exams' => $result->get(),
            'categories' => ExamCategory::all(),
        ];

        return view('admin.evaluaciones_admin', $data);
    }

    public function create()
    {
        $product = Product::create(['code' => '']);

        $exam = Exam::create([
            'title' => '',
            'name' => '',
            'duration' => 0,
            'description' => '',
            'product_id' => $product->id,
            'category_id' => request('category_id'),
        ]);

        return redirect()->route('admin.exams.edit', $exam->id);
    }

    public function showEdit($id)
    {
        $exam = Exam::find($id);
      /*  $result = new Exam;

        if(request()->has('category')) {
            $result = $result->where('category_id', request('category'));
        }

        $grade_course_exam = DB::table('submitted_forms')->select(DB::raw('CONCAT(student_id,"-",entity_id) as stu_enti'))->where('evaluated','=',1)->where('entity_id', $exam->id)->pluck('stu_enti')->toArray();*/
        $data = [
            'exam' => $exam,
            'students' => Student::all(),
            'businesses' => Business::all()
        ];
        //print_r($exam->id);
        return view('admin.crear_evaluacion', $data);
        //return redirect()->route('admin.questions.create', ['entity_name' => ENTITY_SIMULATOR_EXAM, 'entity_id' => $id]);

    }

    public function edit($id, Request $request)
    {
        $exam = Exam::find($id);

        if ($request->ajax()) {
            $product              = $exam->product;
            $exam->title          = $request->has('title') ? $request->get('title') : $exam->title;
            $exam->name          = $request->has('title') ? $request->get('title') : $exam->title;
            $exam->duration       = $request->has('duration') ? (float) $request->get('duration') : $exam->duration;
            $exam->description    = $request->has('description') ? $request->get('description') : $exam->description;
            $product->code        = $request->has('code') ? $request->get('code') : $product->code;

            if ($request->has('students')) {
                $students = $request->get('students');
                $formatted = [];

                foreach ($students as $value) {
                    $formatted[$value] = ['progress' => 0];
                }

                $product->students()->sync($formatted);
            }

            $exam->save();
            $product->save();

            return response()->json(['success' => 'Updated'], 200);
        } else {

        }
    }

    public function delete(Request $request)
    {
        $exam = Exam::find($request->get('id'));
        $exam->delete();

        return response()->json(['success'=>$request->get('id')]);
    }

}
