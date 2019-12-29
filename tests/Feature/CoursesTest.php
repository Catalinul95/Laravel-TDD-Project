<?php

namespace Tests\Feature;

use App\Category;
use App\Course;
use App\User;
use App\CourseRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CoursesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_all_courses()
    {
        $courses = factory(Course::class, 10)->create();

        $response = $this->get('/courses');

        $response->assertStatus(200)
            ->assertSee($courses[0]->name)
            ->assertSee($courses[0]->short_description);
    }

    /** @test */
    public function can_view_all_courses_filtered_by_a_valid_catgory()
    {
        $category = factory(Category::class)->create();
        $course = factory(Course::class)->create(['category_id' => $category->id]);

        $response = $this->get('/categories/courses/' . $category->slug);

        $response->assertStatus(200)
            ->assertSee($course->name)
            ->assertSee($course->short_description);
    }

    /** @test */
    public function can_view_a_course()
    {
        $this->withoutExceptionHandling();

        $course = factory(Course::class)->create();

        $response = $this->get('/courses/' . $course->slug);

        $response->assertStatus(200)
            ->assertSee($course->expiry_date->diffForHumans())
            ->assertSee($course->name)
            ->assertSee($course->description);
    }

    /** @test */
    public function user_can_create_course()
    {
        $user = factory(User::class)->create();

        $course = factory(Course::class)->make()->toArray();
        $course['expiry_date'] = date('Y-m-d',strtotime($course['expiry_date']));

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(302)
            ->assertRedirect('/courses/create');

        $this->assertDatabaseHas('courses' , ['name' => Course::where('name', $course['name'])->first()->name]);
    }

    /** @test */
    public function only_authenticated_users_can_view_page_to_create_course()
    {
        $this->get('/courses/create')
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    public function only_authenticated_users_can_create_a_course()
    {
        //$this->withoutExceptionHandling();

        $course = factory(Course::class)->make()->toArray();
        unset($course['user_id']);

        $response = $this->post('/courses', $course);

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    public function category_is_required()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->make()->toArray();
        unset($course['user_id']);
        unset($course['category_id']);

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['category_id']);
    }

    /** @test */
    public function a_name_required()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->make()->toArray();
        unset($course['user_id']);
        unset($course['name']);

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function short_description_required()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->make()->toArray();
        unset($course['user_id']);
        unset($course['short_description']);

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['short_description']);
    }

    /** @test */
    public function description_required()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->make()->toArray();
        unset($course['user_id']);
        unset($course['description']);

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['description']);
    }

    /** @test */
    public function seats_required()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->make()->toArray();
        unset($course['user_id']);
        unset($course['seats']);

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['seats']);
    }

    /** @test */
    public function expiry_date_required()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->make()->toArray();
        unset($course['user_id']);
        unset($course['expiry_date']);

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['expiry_date']);
    }

    /** @test */
    public function a_valid_category_is_required()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->make()->toArray();
        unset($course['user_id']);
        $course['category_id'] = 10000;

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['category_id']);
    }

    /** @test */
    public function seats_is_numeric_value()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->make()->toArray();
        unset($course['user_id']);
        $course['seats'] = 'asdasdasd';

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['seats']);
    }

    /** @test */
    public function seats_is_positive_numeric_value()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->make()->toArray();
        unset($course['user_id']);
        $course['seats'] = -73;

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['seats']);
    }

    /** @test */
    public function expiry_date_is_valid_date()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->make()->toArray();
        unset($course['user_id']);
        $course['expiry_date'] = 'asdasdasd';

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['expiry_date']);
    }

    /** @test */
    public function user_can_send_course_registration_request()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();

        $response = $this->actingAs($user)->post('/courses/registrations/' . $course->id);

        $this->assertDatabaseHas('course_registrations', [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $response->assertStatus(302)
            ->assertSessionHas(['message']);
    }

    /** @test */
    public function only_authenticated_user_can_send_course_registration_requests()
    {
        $response = $this->post('/courses/registrations/3');

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    public function can_send_course_registration_requests_only_to_valid_course()
    {

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();

        $response = $this->actingAs($user)->post('/courses/registrations/32');


        $response->assertStatus(404);
    }

    /** @test */
    public function cant_send_more_than_one_course_registration_request()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $courseRegistrationReq = factory(CourseRegistration::class)->create(['user_id' => $user->id, 'course_id' => $course->id]);

        $response = $this->actingAs($user)->post('/courses/registrations/' . $course->id);

        $response->assertStatus(302)
            ->assertSessionHas(['error' => 'You have already sent one request to register to this course.']);
    }

    /** @test */
    public function cant_send_registration_requests_when_no_more_seats()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create(['seats' => 1]);
        $courseRegistrationReq = factory(CourseRegistration::class)->create(['course_id' => $course->id]);

        $response = $this->actingAs($user)->post('/courses/registrations/' . $course->id);

        $response->assertStatus(302)
            ->assertSessionHas(['error' => 'There are no more seats available.']);
    }

    /** @test */
    public function course_owner_cant_send_registration_request_to_his_own_course()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post('/courses/registrations/' . $course->id);

        $response->assertStatus(302)
            ->assertSessionHas(['error' => 'You can not register to your own course.']);
    }

    /** @test */
    public function cant_send_registration_request_when_course_expired()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $course = factory(Course::class)->create(['expiry_date' => '2018-01-01']);

        $response = $this->actingAs($user)->post('/courses/registrations/' . $course->id);

        $response->assertStatus(302)
            ->assertSessionHas(['error' => 'This course has expired.']);
    }

    /** @test */
    public function teacher_can_view_his_courses()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $courses = factory(Course::class, 10)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/teacher-courses');

        $response->assertStatus(200)
            ->assertSee($user->courses()->first()->id)
            ->assertSee($user->courses()->first()->name);
    }

    /** @test */
    public function an_authenticated_teacher_can_view_his_courses()
    {
        $user = factory(User::class)->create();
        $courses = factory(Course::class, 10)->create(['user_id' => $user->id]);

        $response = $this->get('/teacher-courses');

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
}
