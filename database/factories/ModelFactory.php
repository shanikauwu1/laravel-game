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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\GameData::class, function (Faker\Generator $faker) {
    return [ //"game_name", "game_type"
        'game_name' => $faker->name,
        'game_type' => "1",
    ];
});

$factory->define(App\Models\GameDataGrid::class, function (Faker\Generator $faker) use ($factory) {
    return [
        'game_id' => $factory->create(App\Models\GameData::class)->id,
        'grid' => json_encode([[0,1,1,0,0,0,0,1],[0,1,1,0,0,0,0,1]]),
    ];
});
