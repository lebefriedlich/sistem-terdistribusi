<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesHotel extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Single Room',
                'image' => 'category/single-room.jpg',
                'description' => 'Kamar yang ideal untuk tamu yang bepergian sendirian.'
            ],
            [
                'name' => 'Twin Room',
                'image' => 'category/twin-room.webp',
                'description' => 'kamar yang bisa menjadi pilihan baik bagi orang yang ingin memiliki kasur terpisah.'
            ],
            [
                'name' => 'Superior Room',
                'image' => 'category/superior-room.jpg',
                'description' => 'Kamar yang lebih luas dan fasilitas yang lebih baik'
            ],
            [
                'name' => 'Deluxe Room',
                'image' => 'category/deluxe-room.jpg',
                'description' => 'Kamar yang lebih mewah, dengan ruang yang lebih luas dan fasilitas yang lebih lengkap'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
