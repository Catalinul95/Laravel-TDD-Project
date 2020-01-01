<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $dates = ['expiry_date'];
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function hasOwner($id)
    {
    	return $this->user->id == $id;
    }

    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class, 'course_id', 'id');
    }

    public function classes()
    {
        return $this->hasMany(CourseClass::class, 'course_id', 'id');
    }
}
