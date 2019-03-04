<?php

namespace App\Http\Controllers\Admin\Course\Activity;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activity;
use App\GradeCourseActivity;
use App\Course;

class ActivityController extends Controller
{
    public function create()
    {
        $this->validate(request(), [
            'nombre_actividad' => 'required',
            'course_id' => 'required',
        ]);

        $activity = Activity::create([
            'name' => request('nombre_actividad'),
            'course_id' => request('course_id'),
        ]);
        $data = request()->all();
        $course = Course::find($data['course_id']);
        foreach ($course->product->students as $key => $student) {
          $GradeCourseExam = GradeCourseActivity::create([
              'student_id' => $student->id,
              'activity_id' => $activity->id,
          ]);
        }
        return redirect()->route('admin.courses.activities.edit', $activity->id);
    }

    public function edit($id)
    {
        return redirect()->route('admin.questions.create', ['entity_name' => ENTITY_ACTIVITY, 'entity_id' => $id]);
    }

    public function delete($id)
    {
        $activity = Activity::find($id);
        $course_id = $activity->course_id;
        $activity->delete();

        return redirect()->route('admin.courses.edit', $course_id)->with('target', '#actividades-tab');
    }
}
