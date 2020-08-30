<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Carbon\Carbon;

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
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'codeUniversel' => $faker->randomLetter . $faker->randomLetter . $faker->numberBetween(10000, 99999),
        'chipNumber' => $faker->isbn10,
        'email' => $faker->unique()->safeEmail,
        'remember_token' => Str::random(10),
        'email_verified_at' => carbon::now(),
        'membershipExpirationDate' => carbon::now()->addMonthsNoOverflow(6),
        'password' => bcrypt('secret'),
    ];
});
