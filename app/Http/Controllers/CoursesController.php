<?php

namespace App\Http\Controllers;

use App\Course;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreCourseRequest;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store']);
    }

    public function index()
    {
        $courses = Course::all();

        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('courses.create', compact('categories'));
    }

    public function store(StoreCourseRequest $request)
    {
        Course::create([
            'category_id' => $request->category_id,
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'seats' => $request->seats,
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect('/courses/create')->with('message', 'Your course has been created.');
    }
}
