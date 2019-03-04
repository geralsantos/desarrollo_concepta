<?php

namespace App\Http\Controllers\Admin\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use Storage;

class StudentController extends Controller
{
    public function jsonCreate()
    {
        $data = request()->all();
        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.students.photos'), 'public') : null;
        $first_segment = strtoupper($data['nombres_alumno'][0]);
        $second_segment = strtolower(strtok($data['apellidos_alumno'], ' '));
        $third_segment = Student::where('username', $first_segment . $second_segment)->count();

        $contraDefault = (strtolower($data["nombres_alumno"])."123.".$first_segment.$second_segment);

        $student = Student::create([
            'name' => $data['nombres_alumno'],
            'last_name' => $data['apellidos_alumno'],
            'email' => $data['email_empresarial_alumno'],
            'password' => bcrypt($contraDefault),
            'username' => $first_segment . $second_segment . ($third_segment ? $third_segment + 1 : ''),
            'company' => $data['empresa_name'],
            'company_id' => $data['empresa_alumno'],
            'personal_email' => $data['email_personal_alumno'],
            'dni' => $data['dni_alumno'],
            'job_title' => null,
            'area' => null,
            'phone' => $data['telefono_alumno'],
            'photo' => $upload_path ? Storage::url($upload_path) : null,
        ]);

        return response()->json($student, 200);
    }

    public function create()
    {
        $data = request()->all();

        $upload_path = isset($data['image']) ? $data['image']->store(config('constants.upload_paths.students.photos'), 'public') : null;
        $first_segment = strtoupper($data['name'][0]);
        $second_segment = strtolower(strtok($data['last_name'], ' '));
        $third_segment = Student::where('username', $first_segment . $second_segment)->count();

        $contraDefault = (strtolower($data["name"])."123.".$first_segment.$second_segment);

        $student = Student::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($contraDefault),
            'username' => $first_segment . $second_segment . ($third_segment ? $third_segment + 1 : ''),
            'company_id' => $data['company_id'],
            'personal_email' => $data['personal_email'],
            'dni' => $data['dni'],
            'job_title' => null,
            'area' => null,
            'phone' => $data['phone'],
            'photo' => $upload_path ? Storage::url($upload_path) : null,
        ]);

        return redirect()->back();
    }
}
