<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
	protected $dates = ['scheduled_date'];
	protected $guarded = [];

    public function course()
    {
    	return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
