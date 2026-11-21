<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@ecopoint.test'],
            [
                'name' => 'Admin EcoPoint',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'total_points' => 0,
            ]
        );

        // Peserta 1
        User::updateOrCreate(
            ['email' => 'budi@ecopoint.test'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'peserta',
                'total_points' => 50,
            ]
        );

        // Peserta 2
        User::updateOrCreate(
            ['email' => 'siti@ecopoint.test'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('password'),
                'role' => 'peserta',
                'total_points' => 0,
            ]
        );
    }
}
