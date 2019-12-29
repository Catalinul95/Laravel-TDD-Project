<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseRegistration;
use Illuminate\Http\Request;

class CourseRegistrationsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index($courseId)
    {
        $course = auth()->user()->courses()->where('id', $courseId)->first();

        if (!$course) {
            abort(404);
        }

        $registrations = $course->registrations;

        return view('teacher.registrations.index', compact('registrations'));
    }

    public function store(Request $request, $courseId)
    {
    	$course = Course::findOrFail($courseId);

    	if ($course->user_id == auth()->user()->id) {
    		return back()->with('error', 'You can not register to your own course.');
    	}

    	if ($course->expiry_date->isPast()) {
    		return back()->with('error', 'This course has expired.');
    	}

    	$existingRegReq = CourseRegistration::where('user_id', auth()->user()->id)
    						->where('course_id', $course->id)->first();

		if ($existingRegReq) {
			return back()->with('error', 'You have already sent one request to register to this course.');
		}

		$courseRegistrationRequests = CourseRegistration::where('course_id', $course->id)->get();

		if ($courseRegistrationRequests->count() == $course->seats) {
			return back()->with('error', 'There are no more seats available.');
		}

    	CourseRegistration::create([
    		'user_id' => auth()->user()->id,
    		'course_id' => $course->id,
    	]);

    	return back()->with('message', 'Your registration request has been sent.');
    }
}
