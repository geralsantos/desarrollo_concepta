<?php

namespace App\Http\Controllers\Admin\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Teacher;
use App\Company;
use App\Business;
use App\Admin;
use Storage;
class AccountController extends Controller
{
    public function index()
    {
        $data = [
            'students' => Student::all(),
            'teachers' => Teacher::all(),
            'companies' => Company::all(),
            'businesses' => Business::all(),
            'admins' => Admin::all(),
        ];

        return view('admin.cuentas_admin', $data);
    }

    public function find()
    {
        $account_type = request('type');
        $account_id   = request('id');
        $object = null;

        switch ($account_type) {
            case ACCOUNT_STUDENT: {
                $object = Student::find($account_id);
                break;
            }
            case ACCOUNT_TEACHER: {
                $object = Teacher::find($account_id);
                break;
            }
            case ACCOUNT_COMPANY: {
                $object = Company::find($account_id);
                break;
            }
            case ACCOUNT_ADMIN: {
                $object = Admin::find($account_id);
                break;
            }
            case ACCOUNT_BUSINESS: {
                $object = Business::find($account_id);
                break;
            }
        }

        return response()->json($object, 200);
    }
    public function edit(Request $request)
    {
        $account_type = request('type');
        $account_id   = request('id');
        $object = null;

        switch ($account_type) {
            case ACCOUNT_STUDENT: {
                $object = Student::find($account_id);
                if ($object) {
                    $object->name = $request->get('name');
                    $object->dni = $request->get('dni');
                    $object->last_name = $request->get('last_name');
                    $object->phone = $request->get('phone');
                    $object->company_id = $request->get('company_id');
                    $object->email = $request->get('email');
                    $object->personal_email = $request->get('personal_email');
                    $data = request()->all();

                    if(isset($_FILES["image"]["tmp_name"]) && !empty($_FILES["image"]["tmp_name"])){
                        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.students.photos'), 'public') : null;
                        $object->photo = $upload_path ? Storage::url($upload_path) : null;
                    }else{
                        $object->photo = $data["student_imagen_ahora"];
                    }

                    $object->save();
                }
                break;
            }
            case ACCOUNT_TEACHER: {
                $object = Teacher::find($account_id);
                if ($object) {
                    $object->name = $request->get('name');
                    $object->dni = $request->get('dni');
                    $object->last_name = $request->get('last_name');
                    $object->phone = $request->get('phone');
                    $object->company = $request->get('company');
                    $object->email = $request->get('email');
                    $object->personal_email = $request->get('personal_email');
                    $object->description = $request->get('description');
                    $data = request()->all();

                    if(isset($_FILES["image"]["tmp_name"]) && !empty($_FILES["image"]["tmp_name"])){
                        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.students.photos'), 'public') : null;
                        $object->photo = $upload_path ? Storage::url($upload_path) : null;
                    }else{
                        $object->photo = $data["docente_imagen_ahora"];
                    }
    
                    $object->save();
                }
                break;
            }
            case ACCOUNT_COMPANY: {
                $object = Company::find($account_id);
                if ($object) {
                    $object->name = $request->get('name');
                    $object->dni = $request->get('dni');
                    $object->last_name = $request->get('last_name');
                    $object->contact_phone = $request->get('contact_phone');
                    $object->business_id = $request->get('business_id');
                    $object->email = $request->get('email');
                    $object->personal_email = $request->get('personal_email');
                    $data = request()->all();

                    if(isset($_FILES["image"]["tmp_name"]) && !empty($_FILES["image"]["tmp_name"])){
                        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.students.photos'), 'public') : null;
                    $object->photo = $upload_path ? Storage::url($upload_path) : null;
                    }else{
                        $object->photo = $data["coord_empresa_imagen_ahora"];
                    }
                    
                    $object->save();
                }
                break;
            }
            case ACCOUNT_ADMIN: {
                $object = Admin::find($account_id);
                if ($object) {
                    $object->name = $request->get('name');
                    $object->dni = $request->get('dni');
                    $object->last_name = $request->get('last_name');
                    $object->phone = $request->get('phone');
                    $object->email = $request->get('email');
                    $object->personal_email = $request->get('personal_email');

                    if(isset($_POST["role_id"]) and !empty($_POST["role_id"])){
                        $object->role_id = $request->get('role_id');
                    }else{
                        $object->role_id = '2';
                    }
                    
                    $data = request()->all();

                    if(isset($_FILES["image"]["tmp_name"]) && !empty($_FILES["image"]["tmp_name"])){
                        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.students.photos'), 'public') : null;
                    $object->photo = $upload_path ? Storage::url($upload_path) : null;
                    }else{
                        $object->photo = $data["admin_imagen_ahora"];
                    }

                    $object->save();
                }
                break;
            }
            case ACCOUNT_BUSINESS: {
                $object = Business::find($account_id);
                if ($object) {
                    $object->ruc = $request->get('ruc');
                    $object->phone = $request->get('phone');
                    $object->social_reason = $request->get('social_reason');
                    $object->email = $request->get('email');
                    $object->contact_name = $request->get('contact_name');
                    $object->address = $request->get('address');

                    $object->contact_email = $request->get('contact_email');
                    $data = request()->all();

                    if(isset($_FILES["image"]["tmp_name"]) && !empty($_FILES["image"]["tmp_name"])){

                        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.students.photos'), 'public') : null;
                        $object->logo = $upload_path ? Storage::url($upload_path) : null;

                    }else{

                        $object->logo = $data["empresa_imagen_ahora"];

                    }
    
                    $object->save();

                }
                break;
            }
        }
        $person = $object;
        return redirect()->back();
    }

}
