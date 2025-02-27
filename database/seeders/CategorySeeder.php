<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Pod',
            'slug'=>'dell'
        ]);
        Category::create([
            'name' => 'Disposable',
            'slug'=>'dell'
        ]);
        Category::create([
            'name' => 'Saltnic',
            'slug'=>'dell'
        ]);
        Category::create([
            'name' => 'Freebase',
            'slug'=>'dell'
        ]);
        Category::create([
            'name' => 'Mods',
            'slug'=>'dell'
        ]);
    }
}
