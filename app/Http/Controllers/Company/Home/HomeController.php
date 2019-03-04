<?php

namespace App\Http\Controllers\Company\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'company' => auth()->guard('company')->user(),
        ];

        return view('backend.company.home', $data);
    }
}
