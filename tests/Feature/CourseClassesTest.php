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

    /** @test */
    public function user_can_view_the_course_class_create_page()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        
        $response = $this->actingAs($user)->get('/courses/classes/create/' . $course->id);
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_create_a_class_to_a_course()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();

        $class = factory(CourseClass::class)->make(['course_id' => $course->id])->toArray();

        $response = $this->actingAs($user)->post('/courses/classes/' . $course->id, $class);

        $response->assertStatus(200);
        $this->assertDatabaseHas('course_classes', [
            'course_id' => $class['course_id'],
            'description' => $class['description'],
        ]);
    }

    /** @test */
    public function only_an_autenticated_user_can_create_a_class_to_a_course()
    {
        $response = $this->post('/courses/classes/23');

        $response->assertStatus(302);
    }

    /** @test */
    public function user_can_create_a_class_to_a_valid_course()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();

        $class = factory(CourseClass::class)->make(['course_id' => $course->id])->toArray();

        $response = $this->actingAs($user)->post('/courses/classes/2323');

        $response->assertStatus(404);
    }

    /** @test */
    public function a_title_is_required()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();

        $class = factory(CourseClass::class)->make(['course_id' => $course->id])->toArray();
        unset($class['title']);

        $response = $this->actingAs($user)->post('/courses/classes/' . $course->id, $class);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function an_user_can_view_the_course_class_page_for_editing()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();

        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);  

        $response = $this->actingAs($user)->get('/courses/' . $course->id . '/classes/' . $class->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function an_user_can_view_the_valid_course_class_page_for_editing()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();

        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);  

        $response = $this->actingAs($user)->get('/courses/23/classes/' . $class->id);

        $response->assertStatus(404);
    }

    /** @test */
    public function an_user_can_view_the_course_valid_class_page_for_editing()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();

        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);  

        $response = $this->actingAs($user)->get('/courses/' . $course->id . '/classes/23');

        $response->assertStatus(404);
    }
}
