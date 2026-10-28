<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin Account
        User::firstOrCreate(
            ['email' => 'admin@strikestore.id'],
            [
                'name' => 'Admin StrikeStore',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'role' => 'admin',
                'address' => 'Jl. Samudra Strike No. 88, Marina',
                'city' => 'Jakarta Utara',
                'province' => 'DKI Jakarta',
                'postal_code' => '14430',
            ]
        );

        // 2. Demo Customer Account (Bintang)
        User::firstOrCreate(
            ['email' => 'bintang@strikestore.id'],
            [
                'name' => 'Bintang Dzul Fadhlil Azim',
                'password' => Hash::make('password'),
                'phone' => '081298765432',
                'role' => 'customer',
                'address' => 'Jl. Angler Sejahtera No. 12',
                'city' => 'Padang',
                'province' => 'Sumatera Barat',
                'postal_code' => '25171',
            ]
        );
    }
}
