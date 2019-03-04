<?php

namespace App\Http\Controllers\Admin\Exam\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ExamCategory;

class CategoryController extends Controller
{
    public function create()
    {
        $category = ExamCategory::create([
            'name' => request('nombre_tema'),
        ]);

        return response()->json($category, 200);
    }

    public function delete(Request $request)
    {
        $category = ExamCategory::find($request->get('id'));
        $category->delete();

        return response()->json(['success'=>$request->get('id')]);
    }
}
