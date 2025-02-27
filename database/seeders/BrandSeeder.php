<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create([
            'name' => 'Oxva',
            'slug'=>'dell'
        ]);
        Brand::create([
            'name' => 'XVape',
            'slug'=>'dell'
        ]);
        Brand::create([
            'name' => 'Nerdz',
            'slug'=>'dell'
        ]);
        Brand::create([
            'name' => 'MilkO',
            'slug'=>'dell'
        ]);
        Brand::create([
            'name' => 'Flava',
            'slug'=>'dell'
        ]);
    }
}
