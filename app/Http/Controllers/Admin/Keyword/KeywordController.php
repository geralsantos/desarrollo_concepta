<?php

namespace App\Http\Controllers\Admin\Keyword;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Keyword;

class KeywordController extends Controller
{
    public function jsonAll()
    {
        return response()->json(Keyword::pluck('name'), 200);
    }
}
