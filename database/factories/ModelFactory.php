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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique($reset = true)->safeEmail,
        'password' => bcrypt('secret'),
        'first_name' => $faker->firstName, 
        'last_name' => $faker->lastName,
    ];
});

$factory->define(App\Activation::class, function (Faker\Generator $faker) {
    return [
        'completed' => 1,
        'completed_at' => $faker->dateTimeBetween($startDate = '-30 minutes', $endDate = 'now')
    ];
});

$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'slug' => $faker->slug,
        'name' => $faker->firstName,
    ];
});