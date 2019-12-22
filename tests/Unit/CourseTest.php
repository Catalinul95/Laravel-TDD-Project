<?php

namespace Tests\Unit;

use App\User;
use App\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function expiry_date_is_carbon_instance()
    {
        $course = factory(Course::class)->create();

        $this->assertInstanceOf('Carbon\Carbon', $course->expiry_date);
    }

    /** @test */
    public function a_course_belongs_to_a_user()
    {
    	$course = factory(Course::class)->create();

    	$this->assertInstanceOf('App\User', $course->user);
    }

    /** @test */
    public function verify_if_user_is_owner_of_course()
    {
    	// check with a user that it's not the owner of the course
    	$course = factory(Course::class)->create();
    	$this->assertFalse($course->ownedBy(3));

    	$user = factory(User::class)->create();
    	$course2 = factory(Course::class)->create(['user_id' => $user->id]);
    	$this->assertTrue($course2->hasOwner($user->id));
    }
}
