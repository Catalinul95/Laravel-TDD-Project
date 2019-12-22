<?php

namespace Tests\Unit;

use App\Category;
use App\Course;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
	use RefreshDatabase;
	

    /** @test */
    public function a_category_has_many_courses()
    {
        $category = factory(Category::class)->create();
        $courses = factory(Course::class, 10)->create(['category_id' => $category->id]);

        $this->assertInstanceOf('App\Course', $category->courses->first());
    }
}
