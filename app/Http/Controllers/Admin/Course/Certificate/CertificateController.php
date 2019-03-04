<?php

namespace App\Http\Controllers\Admin\Course\Certificate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Certificate;
use Storage;

class CertificateController extends Controller{
    
    public function create()
    {
        $data = request()->all();
        $upload_path = isset($data['uploaded_certificado']) ? $data['uploaded_certificado']->store(config('constants.upload_paths.courses.certificates'), 'public') : null;
        // $student = Student::find($student_id);
        $certificate = Certificate::create([
            'name'       => $data['name'],
            'attachment' => Storage::url($upload_path),
            'student_id' => $data['student_id'],
            'course_id'  => $data['course_id'],
        ]);

        return redirect()->route('admin.courses.edit', $data['course_id'])->with('target', '#certificados-tab');
    }

    public function delete($id)
    {
        $certificate = Certificate::find($id);
        $attachment_url = $certificate->attachment;

        if ($certificate->delete()) {
            Storage::delete($attachment_url);
        }

        return redirect()->route('admin.courses.edit', request('course_id'))->with('target', '#certificados-tab');
    }


    public function view(){


        // $students = Student::all();

        // foreach ($students as $student){
        //     if ($student_id = $student->id) {
        //         $student_name = $student->name
        //     }
        // }
        

        //'hola' => $data['Diego'],
            // 'student_name' => $student_name,
            // 'student_name' => DB::table('students')->select('name')->where('student_id','=',$request->id)->first(),
        
        // return view('admin.crear_curso_admin')->with('hola',$data);
        //return view('admin.crear_curso_admin')->with('hola', $hola);

        return view('admin.crear_curso_admin', ['hola' => 'Diego']); 
        //return view('admin.crear_curso_admin',$data);
    }
}
