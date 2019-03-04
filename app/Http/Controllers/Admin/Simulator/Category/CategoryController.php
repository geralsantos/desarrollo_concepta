<?php

namespace App\Http\Controllers\Admin\Simulator\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SimulatorCategory;

class CategoryController extends Controller
{
    public function create()
    {
        $category = SimulatorCategory::create([
            'name' => request('nombre_tema'),
        ]);

        return response()->json($category, 200);
    }
}
