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
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    $parent_id = null;

    $category = App\Category::query()->orderByRaw('RAND()')->first();

    if ($category) {
        $parent_id = $category->id;
    }

    return [
        'name' => $faker->words(3, true),
        'description' => $faker->paragraph,
        'parent_id' => $parent_id
    ];
});
