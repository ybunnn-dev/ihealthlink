<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Roles
        $roles = [
            ['name' => 'MHO'],
            ['name' => 'Midwife'],
            ['name' => 'BHW'],
            ['name' => 'BHC-Asst'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }

        // Seed Users
        User::create([
            'firstName' => 'Municipal',
            'lastName' => 'Officer',
            'middleName' => null,
            'suffix' => null,
            'email' => 'mho@example.com',
            'password' => Hash::make('mho2003'),
            'role_id' => Role::where('name', 'MHO')->first()->id,
            'status' => 'active'
        ]);

        User::create([
            'firstName' => 'Midwife',
            'lastName' => 'User',
            'middleName' => null,
            'suffix' => null,
            'email' => 'midwife@example.com',
            'password' => Hash::make('midwife2003'),
            'role_id' => Role::where('name', 'Midwife')->first()->id,
            'status' => 'active'
        ]);

        User::create([
            'firstName' => 'Barangay',
            'lastName' => 'Worker',
            'middleName' => null,
            'suffix' => null,
            'email' => 'bhw@example.com',
            'password' => Hash::make('bhw2003'),
            'role_id' => Role::where('name', 'BHW')->first()->id,
            'status' => 'active'
        ]);

        User::create([
            'firstName' => 'Assistant',
            'lastName' => 'BHC',
            'middleName' => null,
            'suffix' => null,
            'email' => 'bhc-asst@example.com',
            'password' => Hash::make('bhcasst2003'),
            'role_id' => Role::where('name', 'BHC-Asst')->first()->id,
            'status' => 'active'
        ]);
    }
}

