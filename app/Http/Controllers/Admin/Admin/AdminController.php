<?php

namespace App\Http\Controllers\Admin\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use App\Admin;

class AdminController extends Controller
{
    public function create()
    {
        $data = request()->all();
        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.admins.photos'), 'public') : null;
        
        $first_segment = strtoupper($data['name'][0]);
        $second_segment = strtolower(strtok($data['last_name'], ' '));
        $third_segment = Admin::where('username', $first_segment . $second_segment)->count();
        
        $contraDefault = (strtolower($data["name"])."123.".$first_segment.$second_segment);

        if(isset($_POST["role_id"]) and !empty($_POST["role_id"])){
            $roleId = $data["role_id"];
        }else{
            $roleId = '2';
        }

        $admins = Admin::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($contraDefault),
            'username' => $first_segment . $second_segment . ($third_segment ? $third_segment + 1 : ''),
            'personal_email' => $data['personal_email'],
            'dni' => $data['dni'],
            'role_id' => $roleId,
            'phone' => $data['phone'],
            'photo' => $upload_path ? Storage::url($upload_path) : null,
        ]);

        return redirect()->back();
    }
}
