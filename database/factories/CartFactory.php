<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Cart;
use Faker\Generator as Faker;
use App\User;
$factory->define(Cart::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id
    ];
});
