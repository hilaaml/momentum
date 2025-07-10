<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'dev@mail.com'],
            [
                'name' => 'dev',
                'email' => 'dev@mail.com',
                'password' => Hash::make('dev'),
                'email_verified_at' => now(),
            ]
        );
    }
}
