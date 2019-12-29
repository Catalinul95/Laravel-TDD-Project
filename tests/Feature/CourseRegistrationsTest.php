<?php

namespace Tests\Feature;

use App\Course;
use App\CourseRegistration;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseRegistrationsTest extends TestCase
{
    /** @test */
    public function user_can_view_all_registrations_of_a_course()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create(['user_id' => $user->id]);
        $courseRegistrations = factory(CourseRegistration::class, 4)->create(['course_id' => $course->id]);

        $response = $this->actingAs($user)->get('/courses/registrations/' . $course->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_all_registrations_of_a_valid_course()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/courses/registrations/' . 3);

        $response->assertStatus(404);
    }
}
