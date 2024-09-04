<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Haekal',
            'email' => 'haekal@gmail.com',
            'password' => '123456',
            'phone' => '08123456788',
            'role' => 'user',
        ]);
    }
}
