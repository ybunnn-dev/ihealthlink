<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create user with role MHO (assumed role_id = 1)
        User::factory()->create([
            'name' => 'Municipal Health Officer',
            'email' => 'mho@example.com',
            'password' => Hash::make('mho2003'),
            'role_id' => 1
        ]);

        // Create user with role Midwife (assumed role_id = 2)
        User::factory()->create([
            'name' => 'Midwife User',
            'email' => 'midwife@example.com',
            'password' => Hash::make('midwife2003'),
            'role_id' => 2
        ]);
    }
}

