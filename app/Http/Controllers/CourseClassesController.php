<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class CourseClassesController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index($courseId)
    {
    	$course = Course::findOrFail($courseId);

    	if (!$course->hasOwner(auth()->user()->id)) {
    		abort(403);
    	}

    	$classes = $course->classes;

    	return view('teacher.classes.index', compact('course', 'classes'));
    }
}
