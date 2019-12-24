<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});


$factory->define(\App\Category::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->name,
        'slug' => Str::slug($name),
    ];
});


$factory->define(\App\Course::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return (factory(User::class)->create())->id;
        },
        'category_id' => function () {
            return (factory(\App\Category::class)->create())->id;
        },
        'name' => $name = $faker->name,
        'slug' => Str::slug($name),
        'short_description' => $faker->paragraph,
        'description' => $faker->text,
        'seats' => random_int(3, 20),
        'expiry_date' => $faker->dateTimeBetween('+0 days', '+5 months'),
    ];
});



$factory->define(\App\CourseRegistration::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return (factory(User::class)->create())->id;
        },
        'course_id' => function () {
            return (factory(\App\Course::class)->create())->id;
        },
    ];
});

