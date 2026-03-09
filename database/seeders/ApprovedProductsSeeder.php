<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ApprovedProductsSeeder extends Seeder
{
    public function run()
    {
        Product::insert([
            [
                'seller_id' => 5,           // Use existing verified seller
                'name' => 'Fresh Tomato',
                'category' => 'Vegetable',
                'price' => 499,
                'stock' => 50,
                'is_approved' => 1,
                 'image' => 'placeholder.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 5,
                'name' => 'Red Apple',
                'category' => 'Fruit',
                'price' => 799,
                'stock' => 30,
                'is_approved' => 1,
                 'image' => 'placeholder.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 5,
                'name' => 'Carrot',
                'category' => 'Vegetable',
                'price' => 299,
                'stock' => 100,
                'is_approved' => 1,
                 'image' => 'placeholder.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'seller_id' => 5,
                'name' => 'Banana',
                'category' => 'Fruit',
                'price' => 199,
                'stock' => 200,
                'is_approved' => 1,
                 'image' => 'placeholder.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}