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
    use RefreshDatabase;

    /** @test */
    public function user_can_view_all_registrations_of_a_course()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create(['user_id' => $user->id]);
        $courseRegistrations = factory(CourseRegistration::class, 4)->create(['course_id' => $course->id]);

        $response = $this->actingAs($user)->get('/courses/registrations/' . $course->id);

        $response->assertStatus(200)
            ->assertSee($courseRegistrations[0]->user->name)
            ->assertSee($courseRegistrations[0]->course->name);
    }

    /** @test */
    public function user_can_view_all_registrations_of_a_valid_course()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/courses/registrations/' . 3);

        $response->assertStatus(404);
    }

    /** @test */
    public function a_user_can_update_the_status_of_a_registration_request()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create(['user_id' => $user->id]);
        $courseRegistration = factory(CourseRegistration::class)->create(['course_id' => $course->id]);

        $response = $this->actingAs($user)->patch('/courses/registrations/update/' . $courseRegistration->id, ['status' => 'approved']);

        $response->assertStatus(302);
        $this->assertEquals('approved', CourseRegistration::find($courseRegistration->id)->status);
    }

    /** @test */
    public function a_user_can_update_the_status_of_a_registration_request_of_a_valid_course()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create(['user_id' => $user->id]);
        $courseRegistration = factory(CourseRegistration::class)->create(['course_id' => $course->id]);

        $response = $this->actingAs($user)->patch('/courses/registrations/update/123', ['status' => 'approved']);

        $response->assertStatus(404);
    }

    /** @test */
    public function a_user_can_update_the_status_of_a_registration_request_only_for_his_courses()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $course = factory(Course::class)->create(['user_id' => $user->id]);
        $courseRegistration = factory(CourseRegistration::class)->create(['course_id' => $course->id]);

        $response = $this->actingAs($user2)->patch('/courses/registrations/update/' . $courseRegistration->id, ['status' => 'approved']);

        $response->assertStatus(302);
    }

    /** @test */
    public function course_registration_valid_status_update()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create(['user_id' => $user->id]);
        $courseRegistration = factory(CourseRegistration::class)->create(['course_id' => $course->id]);

        $response = $this->actingAs($user)->patch('/courses/registrations/update/' . $courseRegistration->id, ['status' => 'lalala']);

        $response->assertStatus(400);
    }
}
