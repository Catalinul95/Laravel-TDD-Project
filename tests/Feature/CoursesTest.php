<?php

namespace Tests\Feature;

use App\Category;
use App\Course;
use App\User;
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
        unset($course['user_id']);

        $response = $this->actingAs($user)->post('/courses', $course);

        $response->assertStatus(200);

        $this->assertEquals($course['name'], (Course::first())->name);
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
}
