<?php

namespace App\Http\Controllers\Admin\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Teacher;
use Storage;

class TeacherController extends Controller
{
    public function jsonCreate()
    {
        $data = request()->all();
        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.teachers.photos'), 'public') : null;
        $first_segment = strtoupper($data['nombres_docente'][0]);
        $second_segment = strtolower(strtok($data['apellidos_docente'], ' '));
        $third_segment = Teacher::where('username', $first_segment . $second_segment)->count();

        $contraDefault = (strtolower($data["nombres_docente"])."123.".$first_segment.$second_segment);

        $teacher = Teacher::create([
            'name' => $data['nombres_docente'],
            'last_name' => $data['apellidos_docente'],
            'description' => $data['descripcion_docente'],
            'email' => $data['email_empresarial_docente'],
            'password' => bcrypt($contraDefault),
            'username' => $first_segment . $second_segment . ($third_segment ? $third_segment + 1 : ''),
            'company' => $data['empresa_docente'],
            'personal_email' => $data['email_personal_docente'],
            'dni' => $data['dni_docente'],
            'phone' => $data['telefono_docente'],
            'photo' => $upload_path ? Storage::url($upload_path) : null,
        ]);

        return response()->json($teacher, 200);
    }

    public function create()
    {
        $data = request()->all();
        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.teachers.photos'), 'public') : null;
        $first_segment = strtoupper($data['name'][0]);
        $second_segment = strtolower(strtok($data['last_name'], ' '));
        $third_segment = Teacher::where('username', $first_segment . $second_segment)->count();
        $contraDefault = (strtolower($data["name"])."123.".$first_segment.$second_segment);

        $teacher = Teacher::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'description' => $data['description'],
            'email' => $data['email'],
            'password' => bcrypt($contraDefault),
            'username' => $first_segment . $second_segment . ($third_segment ? $third_segment + 1 : ''),
            'company' => $data['company'],
            'personal_email' => $data['personal_email'],
            'dni' => $data['dni'],
            'phone' => $data['phone'],
            'photo' => $upload_path ? Storage::url($upload_path) : null,
        ]);

        return redirect()->back();
    }
}
