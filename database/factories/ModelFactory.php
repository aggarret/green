<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Organization::class, function (Faker\Generator $faker) {
    return [
        'firstName' => $faker->name,
        'email' => $faker->unique()->email,
        'password' => bcrypt("Damn22"),
        'lastName'=> $faker->name,
        'about' => $faker->realText(200, 2),
    ];
});

$factory->define(App\Volunteer::class, function (Faker\Generator $faker) {
    return [
        'firstName' => $faker->name,
        'lastName'=> $faker->name,
        'email' => $faker->unique()->email,
        'password' => bcrypt("Damn22"),
    ];
});

$factory->define(App\CalendarEvent::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'start'=> $faker->dateTime(),
        'end'=> $faker->dateTime(),
        'description' => $faker->realText(200, 2),
        'max_volunteer' =>$faker->randomNumber(2),
    ];
});