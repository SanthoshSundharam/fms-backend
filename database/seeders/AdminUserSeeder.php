<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // or mobile_number
            [
                'name' => 'Super Admin',
                'mobile_number' => '9999999999',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}
