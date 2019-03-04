<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;
    protected $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'last_name', 'company', 'company_id', 'personal_email', 'job_title', 'area', 'dni', 'photo', 'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $appends = [
        'full_name',
    ];

    public function subscriptions()
    {
        return $this->belongsToMany(Product::class, 'subscriptions', 'student_id', 'product_id');
    }

    public function getCoursesAttribute()
    {
        return $this->subscriptions()->with('course')->withPivot('progress', 'attempts')->whereHas('course')->get();
    }

    public function getExamsAttribute()
    {
        return $this->subscriptions()->with('exam')->withPivot('progress', 'attempts')->whereHas('exam')->get();
    }

    public function getSimulatorsAttribute()
    {
        return $this->subscriptions()->with('simulator')->withPivot('progress', 'attempts')->whereHas('simulator')->get();
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'student_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'answers', 'student_id', 'question_id');
    }

    public function correct_answers($theme_id)
    {
        return $this->answers()->whereHas('question', function($query) use ($theme_id){
                $query->whereHas('themes', function($query_2) use ($theme_id){
                    $query_2->where('id', $theme_id);
                });
            })->get()->filter(function($value, $key){
            if ($value->question->type_id == 1) {
                return $value->question->correct_responses->first()->value == $value->value;
            } elseif($value->question->type_id == 2) {
                return $value->question->correct_responses->contains('value', $value->value);
            } else {
                return false;
            }
        });
    }

    public function incorrect_answers($theme_id)
    {
        return $this->answers()->whereHas('question', function($query) use ($theme_id){
                $query->whereHas('themes', function($query_2) use ($theme_id){
                    $query_2->where('id', $theme_id);
                });
            })->get()->filter(function($value, $key){
            if($value->question->type_id == 2) {
                return !$value->question->correct_responses->contains('value', $value->value);
            } else {
                return false;
            }
        });
    }

    public function score($theme_id)
    {

        $theme = Theme::find($theme_id);

        if ($count = $theme->questions()->count()) {
            $positive_score = $this->correct_answers($theme_id)->sum('question.score');
            $negative_score = $this->incorrect_answers($theme_id)->sum('question.score');
            $parcial_score = (int) (MAX_SCORE / $count);

            return (int)(($positive_score - $negative_score) / $parcial_score) * $parcial_score;
        } else {
            return 0.0;
        }
    }

    public function assistances()
    {
        return $this->hasMany(Assistance::class, 'student_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function annotations()
    {
        return $this->hasMany(Annotation::class, 'student_id');
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

    public function average_session_score($session_id)
    {
        $themes = Session::find($session_id)->themes;
        $total = 0.0;
        $count = $themes->count();

        if ($count) {
            foreach ($themes as $theme) {
                $total += $this->score($theme->id);
            }
            return $total / ((float) $count);
        } else {
            return 0.0;
        }
    }

    public function average_course_score($course_id)
    {
        $sessions = Course::find($course_id)->sessions;
        $total = 0.0;
        $count = $sessions->count();

        if ($count) {
            foreach ($sessions as $session) {
                $total += $this->average_session_score($session->id);
            }
            return $total / ((float) $count);
        } else {
            return 0.0;
        }
    }

    public function correct_exam_answers($exam_id)
    {
        return $this->answers()->whereHas('question', function($query) use ($exam_id){
                $query->whereHas('exams', function($query_2) use ($exam_id){
                    $query_2->where('id', $exam_id);
                });
            })->get()->filter(function($value, $key){
            if ($value->question->type_id == 1) {
                return $value->question->correct_responses->first()->value == $value->value;
            } elseif($value->question->type_id == 2) {
                return $value->question->correct_responses->contains('value', $value->value);
            } else {
                return false;
            }
        });
    }

    public function incorrect_exam_answers($exam_id)
    {
        return $this->answers()->whereHas('question', function($query) use ($exam_id){
                $query->whereHas('exams', function($query_2) use ($exam_id){
                    $query_2->where('id', $exam_id);
                });
            })->get()->filter(function($value, $key){
            if($value->question->type_id == 2) {
                return !$value->question->correct_responses->contains('value', $value->value);
            } else {
                return false;
            }
        });
    }

    public function exam_score($exam_id)
    {
        $theme = Exam::find($exam_id);

        if ($count = $theme->questions()->count()) {
            $positive_score = $this->correct_exam_answers($exam_id)->sum('question.score');
            $negative_score = $this->incorrect_exam_answers($exam_id)->sum('question.score');
            $parcial_score = (int) (MAX_SCORE / $count);

            return (int)(($positive_score - $negative_score) / $parcial_score) * $parcial_score;
        } else {
            return 0.0;
        }
    }

    public function correct_simulator_exam_answers($simulator_exam_id)
    {
        return $this->answers()->whereHas('question', function($query) use ($simulator_exam_id){
                $query->whereHas('simulator_exams', function($query_2) use ($simulator_exam_id){
                    $query_2->where('id', $simulator_exam_id);
                });
            })->get()->filter(function($value, $key){
            if ($value->question->type_id == 1) {
                return $value->question->correct_responses->first()->value == $value->value;
            } elseif($value->question->type_id == 2) {
                return $value->question->correct_responses->contains('value', $value->value);
            } else {
                return false;
            }
        });
    }

    public function incorrect_simulator_exam_answers($simulator_exam_id)
    {
        return $this->answers()->whereHas('question', function($query) use ($simulator_exam_id){
                $query->whereHas('simulator_exams', function($query_2) use ($simulator_exam_id){
                    $query_2->where('id', $simulator_exam_id);
                });
            })->get()->filter(function($value, $key){
            if($value->question->type_id == 2) {
                return !$value->question->correct_responses->contains('value', $value->value);
            } else {
                return false;
            }
        });
    }

    public function simulator_exam_score($simulator_exam_id)
    {
        $theme = SimulatorExam::find($simulator_exam_id);

        if ($count = $theme->questions()->count()) {
            $positive_score = $this->correct_exam_answers($simulator_exam_id)->sum('question.score');
            $negative_score = $this->incorrect_exam_answers($simulator_exam_id)->sum('question.score');
            $parcial_score = (int) (MAX_SCORE / $count);

            return (int)(($positive_score - $negative_score) / $parcial_score) * $parcial_score;
        } else {
            return 0.0;
        }
    }

    public function average_simulator_score($simulator_id)
    {
        $simulator_exams = Simulator::find($simulator_id)->exams;
        $total = 0.0;
        $count = $simulator_exams->count();

        if ($count) {
            foreach ($simulator_exams as $exam) {
                $total += $this->simulator_exam_score($exam->id);
            }
            return $total / ((float) $count);
        } else {
            return 0.0;
        }
    }

    public function correct_activity_answers($activity_id)
    {
        return $this->answers()->whereHas('question', function($query) use ($activity_id){
                $query->whereHas('activities', function($query_2) use ($activity_id){
                    $query_2->where('id', $activity_id);
                });
            })->get()->filter(function($value, $key){
            if ($value->question->type_id == 1) {
                return $value->question->correct_responses->first()->value == $value->value;
            } elseif($value->question->type_id == 2) {
                return $value->question->correct_responses->contains('value', $value->value);
            } else {
                return false;
            }
        });
    }

    public function incorrect_activity_answers($activity_id)
    {
        return $this->answers()->whereHas('question', function($query) use ($activity_id){
                $query->whereHas('activities', function($query_2) use ($activity_id){
                    $query_2->where('id', $activity_id);
                });
            })->get()->filter(function($value, $key){
            if($value->question->type_id == 2) {
                return !$value->question->correct_responses->contains('value', $value->value);
            } else {
                return false;
            }
        });
    }

    public function activity_score($activity_id)
    {
        $activity = Activity::find($activity_id);

        if ($count = $activity->questions()->count()) {
            $positive_score = $this->correct_activity_answers($activity_id)->sum('question.score');
            $negative_score = $this->incorrect_activity_answers($activity_id)->sum('question.score');
            $parcial_score = (int) (MAX_SCORE / $count);

            return (int)(($positive_score - $negative_score) / $parcial_score) * $parcial_score;
        } else {
            return 0.0;
        }
    }

    public function assistance_by_session($session_id)
    {
        return $this->assistances()->where('session_id', $session_id)->first();
    }

    public function assistances_by_course($course_id)
    {
        return $this->assistances()->whereHas('session', function($query) use ($course_id){
            $query->where('course_id', $course_id);
        })->get();
    }

    public function assistances_percentage($course_id)
    {
        $assists_count = $this->assistances_by_course($course_id)->count();
        $total_count = Course::find($course_id)->sessions()->count();

        return (float) $assists_count / $total_count * 100.0;
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'student_id');
    }

    public function forms()
    {
        return $this->hasMany(SubmittedForm::class, 'student_id');
    }

    public function cursos()
    {
        return $this->belongsToMany(Courses::class, 'id');
    }

    public function cada_curso(){
        return $this->hasMany(GradeCourse::class);
    }



}
