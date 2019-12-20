<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/courses', 'CoursesController@index')->name('courses.index');
Route::post('/courses', 'CoursesController@store')->name('courses.store');
Route::get('/courses/{course}', 'CoursesController@show')->name('courses.show');
Route::get('/categories/courses/{category}', 'CategoriesCoursesController@index')->name('categories-courses.index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
