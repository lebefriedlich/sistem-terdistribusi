<?php

namespace Database\Seeders;

use App\Models\CategoriesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Toyota Agya',
                'type' => 'car',
                'image' => 'category/car/toyota-agya.jpg',
                'description' => 'Mobil Toyota Agya',
            ],
            [
                'name' => 'Toyota Avanza',
                'type' => 'car',
                'image' => 'category/car/toyota-avanza.webp',
                'description' => 'Mobil Toyota Avanza',
            ],
            [
                'name' => 'Toyota Alphard',
                'type' => 'car',
                'image' => 'category/car/toyota-alphard.webp',
                'description' => 'Mobil Toyota Alphard',
            ],
            [
                'name' => 'Honda Vario',
                'type' => 'motorcycle',
                'image' => 'category/motorcycle/honda-vario.jpg',
                'description' => 'Motor Honda Vario',
            ],
            [
                'name' => 'Vespa Matic',
                'type' => 'motorcycle',
                'image' => 'category/motorcycle/vespa-matic.jpg',
                'description' => 'Motor Vespa Matic',
            ]
        ];

        foreach ($categories as $category) {
            CategoriesModel::create($category);
        }
    }
}
