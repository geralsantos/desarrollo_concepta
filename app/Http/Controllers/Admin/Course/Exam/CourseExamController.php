<?php

namespace App\Http\Controllers\Admin\Course\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CourseExam;
use App\GradeCourseExam;
use App\Course;

class CourseExamController extends Controller
{
    public function create()
    {
        $this->validate(request(), [
            'nombre_examen' => 'required',
            'course_id' => 'required',
        ]);

        $exam = CourseExam::create([
            'name' => request('nombre_examen'),
            'course_id' => request('course_id'),
        ]);
        $data = request()->all();
        $course = Course::find($data['course_id']);
        foreach ($course->product->students as $key => $student) {
          $GradeCourseExam = GradeCourseExam::firstOrCreate([
              'student_id' => $student->id,
              'course_exam_id' => $exam->id]);
        }

        return redirect()->route('admin.courses.exams.edit', $exam->id);
    }

    public function edit($id)
    {
        return redirect()->route('admin.questions.create', ['entity_name' => ENTITY_COURSE_EXAM, 'entity_id' => $id]);
    }

    public function delete($id)
    {
        $exam = CourseExam::find($id);
        $course_id = $exam->course_id;
        $exam->delete();

        return redirect()->route('admin.courses.edit', $course_id)->with('target', '#examenes-tab');
    }
}
