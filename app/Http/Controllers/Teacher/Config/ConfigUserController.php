<?php

namespace App\Http\Controllers\Teacher\Config;
//App\Http\Controllers\Admin\Config\ConfigUserController does not exist
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use App\Teacher;
use Illuminate\Support\Facades\Auth;
class ConfigUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data = Teacher::find($id);
        $data->photo = empty($data->photo) ? '/images/default/user.png' : $data->photo;
        return view('docentes.configuser',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $data = request()->all();

        if(!empty($data["txtpassword"])){
            $contra = bcrypt($data["txtpassword"]);
        }else{
            $contra = $data["txtpasswordActual"];
        }

        $user = Teacher::find(Auth::user()->id);
        $user->username = $data['txtusername'];
        //$user->password = $request->get('txtpassword');
        $user->password = $contra;
        $user->name = $data['txtnombres'];
        $user->last_name = $data['txtapellidos'];
        $user->dni = $data['txtdni'];
        $user->description = $data["txtdescription"];
        $user->company = $data['txtcompany'];
        $user->email = $data['txtemail'];
        $user->phone = $data['txtphone'];
        $user->personal_email = $data['txtpersonalemail'];

        if(isset($_FILES["image"]["tmp_name"]) && !empty($_FILES["image"]["tmp_name"])){
            $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.students.photos'), 'public') : null;
            $user->photo = $upload_path ? Storage::url($upload_path) : null;
        }else{
            $user->photo = $data["imagenActual"];
        }
        $user->save();

        return redirect()->back();
    }

}
