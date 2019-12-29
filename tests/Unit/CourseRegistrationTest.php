<?php

namespace Tests\Unit;

use App\CourseRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseRegistrationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_course_registration_belongs_to_an_user()
    {
        $courseRegistration = factory(CourseRegistration::class)->create();

        $this->assertInstanceOf('App\User', $courseRegistration->user);
    }
    /** @test */
    public function a_course_registration_belongs_to_a_course()
    {
        $courseRegistration = factory(CourseRegistration::class)->create();

        $this->assertInstanceOf('App\Course', $courseRegistration->course);
    }

}
