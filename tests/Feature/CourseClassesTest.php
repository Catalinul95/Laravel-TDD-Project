<?php

namespace Tests\Feature;


use App\User;
use App\Course;
use App\CourseClass;
use App\CourseRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseClassesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_the_classes_of_a_course()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create(['user_id' => $user->id]);
        $registrations = factory(CourseRegistration::class, 10)->create([
            'course_id' => $course->id,
            'status' => 'approved'
        ]);
        $classes = factory(CourseClass::class)->create(['course_id' => $course->id]);

        $response = $this->actingAs($user)->get('/courses/classes/' . $course->id);

        $response->assertStatus(200);
        $response->assertSee($registrations[0]->title);
    }

    /** @test */
    public function only_authenticated_users_can_view_the_classes_of_a_course()
    {
        $response = $this->get('/courses/classes/23');  
        
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    public function user_can_view_the_classes_of_a_valid_course()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create(['user_id' => $user->id]);
        $registrations = factory(CourseRegistration::class, 10)->create([
            'course_id' => $course->id,
            'status' => 'approved'
        ]);
        $classes = factory(CourseClass::class)->create(['course_id' => $course->id]);

        $response = $this->actingAs($user)->get('/courses/classes/2323');

        $response->assertStatus(404);
    }

    /** @test */
    public function user_can_view_only_the_classes_of_his_course()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $registrations = factory(CourseRegistration::class, 10)->create([
            'course_id' => $course->id,
            'status' => 'approved'
        ]);
        $classes = factory(CourseClass::class)->create(['course_id' => $course->id]);

        $response = $this->actingAs($user)->get('/courses/classes/' . $course->id);

        $response->assertStatus(403);
    }
}
