<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::all();

        return view('courses.index', compact('courses'));
    }
}
