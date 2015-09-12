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

use Illuminate\Support\Facades\Hash;

$factory->define(App\Entity\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => Hash::make('123'),
        'remember_token' => str_random(10),
        'admin' => rand(0,1)
    ];
});

$factory->define(App\Entity\Dream::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->sentence
    ];
});
