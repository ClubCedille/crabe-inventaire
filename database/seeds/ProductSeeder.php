<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        DB::table('products')->insert([
            'code' => uniqid("CODE"),
            'name' => "abonnement 20$",
            'description' => $faker->paragraph(2),
            'price' => 20, 
            'category_id' => factory(Category::class)->create()->id,
            'quantity' => 100000000,
        ]);

        DB::table('products')->insert([
            'code' => uniqid("CODE"),
            'name' => "abonnement 60$",
            'description' => $faker->paragraph(2),
            'price' => 60, 
            'category_id' => factory(Category::class)->create()->id,
            'quantity' => 100000000,
        ]);

        factory(App\Product::class, 200)->create()->each(function ($product) {
            $product->save();
        });
    }
}
