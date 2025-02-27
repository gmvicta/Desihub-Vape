<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'title' => 'Product 1',
            'price' => 500,
            'quantity' => 5,
            'category_id'=> 1,
            'brand_id'=>1,
            'description'=>'Product 1'
        ]);

        Product::create([
            'title' => 'Product 2',
            'price' => 1000,
            'quantity' => 20,
            'category_id'=> 2,
            'brand_id'=>2,
            'description'=>'Product 2'
        ]);

        Product::create([
            'title' => 'Product 3',
            'price' => 1500,
            'quantity' => 3,
            'category_id'=> 3,
            'brand_id'=>3,
            'description'=>'Product 3'
        ]);
    }
}
