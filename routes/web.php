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

Route::get('/courses/registrations/{course}', 'CourseRegistrationsController@index')->name('course-registrations.index');
Route::post('/courses/registrations/{course}', 'CourseRegistrationsController@store')->name('course-registrations.store');
Route::patch('/courses/registrations/update/{courseRegistrationId}', 'CourseRegistrationsController@update')->name('course-registrations.update');
Route::delete('/courses/registrations/delete/{courseRegistrationId}', 'CourseRegistrationsController@delete')->name('course-registrations.delete');
Route::get('/courses/create', 'CoursesController@create')->name('courses.create');
Route::get('/courses', 'CoursesController@index')->name('courses.index');
Route::post('/courses', 'CoursesController@store')->name('courses.store');
Route::get('/courses/{course}', 'CoursesController@show')->name('courses.show');
Route::get('/categories/courses/{category}', 'CategoriesCoursesController@index')->name('categories-courses.index');
Route::get('/teacher-courses', 'TeacherCoursesController@index')->name('teacher-courses.index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
