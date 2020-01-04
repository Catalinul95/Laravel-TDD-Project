<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseClass;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseClassRequest;

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

    public function create($courseId)
    {
    	return view('teacher.classes.create', compact('courseId'));
    }

    public function store(StoreCourseClassRequest $request, $courseId)
    {
    	$course = Course::findOrFail($courseId);

    	Courseclass::create([
    		'course_id' => $course->id,
    		'title' => $request->title,
    		'description' => $request->description,
    		'start_time' => $request->start_time,
    		'end_time' => $request->end_time,
    		'scheduled_date' => $request->scheduled_date,
    	]);
    }

    public function show($courseId, $classId)
    {
    	$course = Course::findOrFail($courseId);
    	$class = $course->classes()->where('id', $classId)->firstOrFail();
    	$registrations = $course->registrations;

    	return view('teacher.classes.show', compact('course', 'class', 'registrations'));
    }
}
