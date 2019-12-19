<?php

namespace Tests\Feature;

use App\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CoursesTest extends TestCase
{
    /** @test */
    public function can_view_all_courses()
    {
        $courses = factory(Course::class, 10)->create();

        $response = $this->get('/courses');

        $response->assertStatus(200)
            ->assertSee($courses[0]->name)
            ->assertSee($courses[0]->short_description);
    }
}
