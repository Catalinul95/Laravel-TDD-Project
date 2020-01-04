<?php

namespace Tests\Unit;

use App\Course;
use Tests\TestCase;
use App\CourseClass;
use App\CourseClassUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseClassTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function a_class_belongs_to_a_course()
    {
        $course = factory(Course::class)->create();
        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);

        $this->assertInstanceOf('App\Course', $class->course);
    }

    /** @test */
    public function scheduled_date_column_is_carbon_instance()
    {
    	$course = factory(Course::class)->create();
        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);

        $this->assertInstanceOf('Carbon\Carbon', $class->scheduled_date);
    }

    /** @test */
    public function a_class_has_many_users()
    {
        $course = factory(Course::class)->create();
        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);
        $users = factory(CourseClassUser::class, 10)->create(['class_id' => $class->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $class->users);
    }
}
