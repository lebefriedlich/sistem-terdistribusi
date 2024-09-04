<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomHotel extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'category_id' => 1,
                'room_number' => '101',
                'price' => 100000,
            ],
            [
                'category_id' => 1,
                'room_number' => '102',
                'price' => 100000,
            ],
            [
                'category_id' => 1,
                'room_number' => '103',
                'price' => 100000,
            ],
            [
                'category_id' => 1,
                'room_number' => '104',
                'price' => 100000,
            ],
            [
                'category_id' => 1,
                'room_number' => '105',
                'price' => 100000,
            ],
            [
                'category_id' => 1,
                'room_number' => '106',
                'price' => 100000,
            ],
            [
                'category_id' => 1,
                'room_number' => '107',
                'price' => 100000,
            ],
            [
                'category_id' => 1,
                'room_number' => '108',
                'price' => 100000,
            ],
            [
                'category_id' => 1,
                'room_number' => '109',
                'price' => 100000,
            ],
            [
                'category_id' => 1,
                'room_number' => '110',
                'price' => 100000,
            ],
            [
                'category_id' => 2,
                'room_number' => '201',
                'price' => 200000,
            ],
            [
                'category_id' => 2,
                'room_number' => '202',
                'price' => 200000,
            ],
            [
                'category_id' => 2,
                'room_number' => '203',
                'price' => 200000,
            ],
            [
                'category_id' => 2,
                'room_number' => '204',
                'price' => 200000,
            ],
            [
                'category_id' => 2,
                'room_number' => '205',
                'price' => 200000,
            ],
            [
                'category_id' => 2,
                'room_number' => '206',
                'price' => 200000,
            ],
            [
                'category_id' => 2,
                'room_number' => '207',
                'price' => 200000,
            ],
            [
                'category_id' => 2,
                'room_number' => '208',
                'price' => 200000,
            ],
            [
                'category_id' => 2,
                'room_number' => '209',
                'price' => 200000,
            ],
            [
                'category_id' => 2,
                'room_number' => '210',
                'price' => 200000,
            ],
            [
                'category_id' => 3,
                'room_number' => '301',
                'price' => 300000,
            ],
            [
                'category_id' => 3,
                'room_number' => '302',
                'price' => 300000,
            ],
            [
                'category_id' => 3,
                'room_number' => '303',
                'price' => 300000,
            ],
            [
                'category_id' => 3,
                'room_number' => '304',
                'price' => 300000,
            ],
            [
                'category_id' => 3,
                'room_number' => '305',
                'price' => 300000,
            ],
            [
                'category_id' => 3,
                'room_number' => '306',
                'price' => 300000,
            ],
            [
                'category_id' => 3,
                'room_number' => '307',
                'price' => 300000,
            ],
            [
                'category_id' => 3,
                'room_number' => '308',
                'price' => 300000,
            ],
            [
                'category_id' => 3,
                'room_number' => '309',
                'price' => 300000,
            ],
            [
                'category_id' => 3,
                'room_number' => '310',
                'price' => 300000,
            ],
            [
                'category_id' => 4,
                'room_number' => '401',
                'price' => 400000,
            ],
            [
                'category_id' => 4,
                'room_number' => '402',
                'price' => 400000,
            ],
            [
                'category_id' => 4,
                'room_number' => '403',
                'price' => 400000,
            ],
            [
                'category_id' => 4,
                'room_number' => '404',
                'price' => 400000,
            ],
            [
                'category_id' => 4,
                'room_number' => '405',
                'price' => 400000,
            ],
            [
                'category_id' => 4,
                'room_number' => '406',
                'price' => 400000,
            ],
            [
                'category_id' => 4,
                'room_number' => '407',
                'price' => 400000,
            ],
            [
                'category_id' => 4,
                'room_number' => '408',
                'price' => 400000,
            ],
            [
                'category_id' => 4,
                'room_number' => '409',
                'price' => 400000,
            ],
            [
                'category_id' => 4,
                'room_number' => '410',
                'price' => 400000,
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
