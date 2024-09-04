<?php

namespace Database\Seeders;

use App\Models\VehiclesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'category_id' => 1,
                'plate_number' => 'B 1234 ABC',
                'price' => 200000,
            ],
            [
                'category_id' => 1,
                'plate_number' => 'B 1234 ABD',
                'price' => 200000,
            ],
            [
                'category_id' => 1,
                'plate_number' => 'B 1234 ABE',
                'price' => 200000,
            ],
            [
                'category_id' => 2,
                'plate_number' => 'B 1235 ABC',
                'price' => 250000,
            ],
            [
                'category_id' => 2,
                'plate_number' => 'B 1235 ABD',
                'price' => 250000,
            ],
            [
                'category_id' => 2,
                'plate_number' => 'B 1235 ABE',
                'price' => 250000,
            ],
            [
                'category_id' => 3,
                'plate_number' => 'B 1236 ABC',
                'price' => 300000,
            ],
            [
                'category_id' => 3,
                'plate_number' => 'B 1236 ABD',
                'price' => 300000,
            ],
            [
                'category_id' => 3,
                'plate_number' => 'B 1236 ABE',
                'price' => 300000,
            ],
            [
                'category_id' => 4,
                'plate_number' => 'B 1237 ABC',
                'price' => 50000,
            ],
            [
                'category_id' => 4,
                'plate_number' => 'B 1237 ABD',
                'price' => 50000,
            ],
            [
                'category_id' => 4,
                'plate_number' => 'B 1237 ABE',
                'price' => 50000,
            ],
            [
                'category_id' => 5,
                'plate_number' => 'B 1238 ABC',
                'price' => 75000,
            ],
            [
                'category_id' => 5,
                'plate_number' => 'B 1238 ABD',
                'price' => 75000,
            ],
            [
                'category_id' => 5,
                'plate_number' => 'B 1238 ABE',
                'price' => 75000,
            ],
        ];

        foreach ($vehicles as $vehicle) {
            VehiclesModel::create($vehicle);
        }
    }
}
