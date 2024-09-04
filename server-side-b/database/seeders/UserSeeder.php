<?php

namespace Database\Seeders;

use App\Models\UsersModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UsersModel::create([
            'name' => 'Maulana',
            'email' => 'maulana@gmail.com',
            'password' => '123456',
            'phone' => '08123456789',
            'role' => 'admin',
        ]);
    }
}
