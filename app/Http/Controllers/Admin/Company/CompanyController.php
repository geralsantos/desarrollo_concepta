<?php

namespace App\Http\Controllers\Admin\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use App\Company;

class CompanyController extends Controller
{
    public function create()
    {
        $data = request()->all();
        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.companies.photos'), 'public') : null;
        $first_segment = strtoupper($data['name'][0]);
        $second_segment = strtolower(strtok($data['last_name'], ' '));
        $third_segment = Company::where('username', $first_segment . $second_segment)->count();

        $contraDefault = (strtolower($data["name"])."123.".$first_segment.$second_segment);

        $teacher = Company::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'business_id' => $data['business_id'],
            'email' => $data['email'],
            'password' => bcrypt($contraDefault),
            'username' => $first_segment . $second_segment . ($third_segment ? $third_segment + 1 : ''),
            'business_id' => $data['business_id'],
            'personal_email' => $data['personal_email'],
            'dni' => $data['dni'],
            'contact_phone' => $data['contact_phone'],
            'contact_name' => '',
            'photo' => $upload_path ? Storage::url($upload_path) : null,
        ]);

        return redirect()->back();
    }
}