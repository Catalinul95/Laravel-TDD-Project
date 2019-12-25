<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherCoursesController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
    public function index()
    {
    	$courses = auth()->user()->courses;

    	return view('teacher.courses.index', compact('courses'));
    }
}
