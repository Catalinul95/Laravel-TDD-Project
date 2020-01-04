<?php

namespace Tests\Unit;

use App\Course;
use Tests\TestCase;
use App\CourseClass;
use App\CourseClassUser;
use App\CourseRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseClassTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function a_class_belongs_to_a_course()
    {
        $course = factory(Course::class)->create();
        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);

        $this->assertInstanceOf('App\Course', $class->course);
    }

    /** @test */
    public function scheduled_date_column_is_carbon_instance()
    {
    	$course = factory(Course::class)->create();
        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);

        $this->assertInstanceOf('Carbon\Carbon', $class->scheduled_date);
    }

    /** @test */
    public function a_class_has_many_users()
    {
        $course = factory(Course::class)->create();
        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);
        $users = factory(CourseClassUser::class, 10)->create(['class_id' => $class->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $class->users);
    }

    /** @test */
    public function only_those_registrations_that_are_approved()
    {
        $course = factory(Course::class)->create();
        $registrations = factory(CourseRegistration::class, 3)->create(['course_id' => $course->id, 'status' => 'approved']);
        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);
        $userClass = factory(CourseClassUser::class)->create(['class_id' => $class->id, 'user_id' => $registrations[0]->user_id]);
        $userClass = factory(CourseClassUser::class)->create(['class_id' => $class->id, 'user_id' => $registrations[1]->user_id]);
        $userClass = factory(CourseClassUser::class)->create(['class_id' => $class->id, 'user_id' => $registrations[2]->user_id]);
        $registrations1 = factory(CourseRegistration::class)->create(['course_id' => $course->id, 'status' => 'approved']);
        $registrations2 = factory(CourseRegistration::class)->create(['course_id' => $course->id, 'status' => 'pending']);
        $registrations3 = factory(CourseRegistration::class)->create(['course_id' => $course->id, 'status' => 'pending']);

        $unoccupiedRegistrations = $course->unoccupiedRegistrations($class->id);

        $this->assertDatabaseMissing('course_class_users', [
            'class_id' => $class->id,
            'user_id' => $unoccupiedRegistrations[0]->user_id,
        ]);
        $this->assertCount(1, $unoccupiedRegistrations);
        
    }

    /** @test */
    public function only_those_registrations_that_are_not_part_of_a_class()
    {
        $course = factory(Course::class)->create();
        $registrations = factory(CourseRegistration::class, 3)->create(['course_id' => $course->id, 'status' => 'approved']);
        $class = factory(CourseClass::class)->create(['course_id' => $course->id]);
        $userClass = factory(CourseClassUser::class)->create(['class_id' => $class->id, 'user_id' => $registrations[0]->user_id]);
        $userClass = factory(CourseClassUser::class)->create(['class_id' => $class->id, 'user_id' => $registrations[1]->user_id]);
        $userClass = factory(CourseClassUser::class)->create(['class_id' => $class->id, 'user_id' => $registrations[2]->user_id]);
        $registrations = factory(CourseRegistration::class, 3)->create(['course_id' => $course->id, 'status' => 'approved']);

        $unoccupiedRegistrations = $course->unoccupiedRegistrations($class->id);

        foreach ($unoccupiedRegistrations as $unoccupiedRegistration) {
            $this->assertDatabaseMissing('course_class_users', [
                'class_id' => $class->id,
                'user_id' => $unoccupiedRegistration->user_id,
            ]);
        }
        
    }
}
