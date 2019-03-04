<?php

namespace App\Http\Controllers\Teacher\Course\Activity;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activity;

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

        return redirect()->route('teacher.courses.activities.edit', $activity->id);
    }

    public function edit($id)
    {
        return redirect()->route('teacher.questions.create', ['entity_name' => ENTITY_ACTIVITY, 'entity_id' => $id]);
    }

    public function delete($id)
    {
        $activity = Activity::find($id);
        $course_id = $activity->course_id;
        $activity->delete();

        return redirect()->route('teacher.courses.edit', $course_id)->with('target', '#actividades-tab');
    }
}
