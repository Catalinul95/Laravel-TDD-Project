<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesCoursesController extends Controller
{
    public function index(Category $category)
    {
        $courses = $category->courses;

        return view('courses.index', compact('courses'));
    }
}
