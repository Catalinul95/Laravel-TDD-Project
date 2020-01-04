<?php

namespace Tests\Unit;

use App\Course;
use App\CourseClass;
use App\CourseClassUser;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseClassUserTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function belongs_to_a_user()
    {
        $course = factory(Course::class)->create();
        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);
        $classUsers = factory(CourseClassUser::class)->create(['class_id' => $class->id]);

        $this->assertInstanceOf('App\User', $classUsers->user);
    }
}
