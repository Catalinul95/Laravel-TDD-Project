<?php

namespace Tests\Unit;

use App\Course;
use Tests\TestCase;

class CourseTest extends TestCase
{
    /** @test */
    public function expiry_date_is_carbon_instance()
    {
        $course = factory(Course::class)->create();

        $this->assertInstanceOf('Carbon\Carbon', $course->expiry_date);
    }
}
