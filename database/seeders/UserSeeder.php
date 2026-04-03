<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'hayatulhabirun'],
            [
                'name' => 'Hayatul Habirun',
                'email' => 'hayatulhabirun@gmail.com',
                'password' => Hash::make('12345678'),
                'level' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['username' => 'afberbershop'],
            [
                'name' => 'barbershop',
                'email' => 'poseidon@gmail.com',
                'password' => Hash::make('12345678'),
                'level' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['username' => 'pengunjung'],
            [
                'name' => 'Pengunjung',
                'email' => 'pengunjung@gmail.com',
                'password' => Hash::make('12345678'),
                'level' => 'kasir', // Using kasir as placeholder for visitor if applicable
            ]
        );
    }
}
