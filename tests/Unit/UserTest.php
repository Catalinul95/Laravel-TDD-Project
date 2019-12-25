<?php

namespace Tests\Unit;

use App\User;
use App\Course;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function a_user_has_many_courses()
    {
        $user = factory(User::class)->create();
        $courses = factory(Course::class, 10)->create(['user_id' => $user->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->courses);
    }
}
