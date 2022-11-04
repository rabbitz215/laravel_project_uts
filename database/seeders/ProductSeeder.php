<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();
        $faker = Factory::create("id_ID");
        $categories = Category::get();
        $image = "images/product/200.png";

        for ($i = 0; $i < 100; $i++) {
            Product::create([
                "name" => $faker->sentence(1),
                "description" => $faker->sentence(2),
                "weight" => $faker->randomDigitNot(0),
                "price" => $faker->randomNumber(6, true),
                "category_id" => $categories->random()->id,
                "image" => $image,
                "status" => $faker->randomElement(['active', 'inactive', 'draft'])
            ]);
        }
    }
}
