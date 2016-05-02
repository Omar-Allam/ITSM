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
    $email = $faker->safeEmail;
    list($login) = explode('@', $email);

    $locations = \App\Location::query()->pluck('id')->toArray();
    $business_units = \App\BusinessUnit::query()->pluck('id')->toArray();

    return [
        'name' => $faker->name,
        'email' => $email,
        'login' => $login,
        'location_id' => $faker->randomElement($locations),
        'business_unit_id' => $faker->randomElement($business_units),
        'password' => bcrypt('kifah1234'),
        'vip' => $faker->boolean(10),
        'is_ad' => false,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->words(3, true),
        'description' => $faker->paragraph,
    ];
});
