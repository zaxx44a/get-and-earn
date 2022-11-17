<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $admin = \App\Models\User::updateOrCreate(
            ['phone' => '+962799637977', 'email' => 'admin@example.com'],
            [
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => 'abcd',
            'phone' => '+962799637977',
            'avatar' => '1668588593.jpg',
            'credit' => 0,
            'referral_id' => null
        ]);
        $admin->assignRole('admin');

        $user = \App\Models\User::updateOrCreate(
            ['phone' => '+96226236564', 'email' => 'user@example.com'],
            [
            'name' => 'Test User',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => 'defg',
            'phone' => '+96226236564',
            'avatar' => '1668588593.jpg',
            'credit' => 0,
            'referral_id' => null
        ]);
        $user->assignRole('user');

    }
}
