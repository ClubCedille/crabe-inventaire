<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Product;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'code' => uniqid("CODE"),
        'name' => $faker->word(2),
        'description' => $faker->paragraph(2),
        'price' => $faker->numberBetween(1, 100 ), // Integer cents
        'category_id' => Category::all()->random(1)->first(),
        'quantity' => $faker->numberBetween(0,20),
    ];
});
