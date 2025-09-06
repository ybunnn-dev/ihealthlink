<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BHW;
use Illuminate\Support\Facades\Hash;

class BHWSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example BHW users
        $users = [
            [
                'firstName'     => 'Maria',
                'lastName'      => 'Santos',
                'middleName'    => 'Reyes',
                'suffix'        => null,
                'birthdate'     => '1990-05-12',
                'contact_no'    => '09171234567',
                'email'         => 'bhw1@example.com',
                'password'      => Hash::make('password'),
                'role_id'       => 3,
                'sex'           => 'Female',
                'civil_status'  => 'Single',
                'religion'      => 'Catholic',
                'status'        => 'active',
            ],
            [
                'firstName'     => 'Jose',
                'lastName'      => 'Cruz',
                'middleName'    => 'Dela',
                'suffix'        => 'Jr.',
                'birthdate'     => '1985-10-22',
                'contact_no'    => '09181234567',
                'email'         => 'bhw2@example.com',
                'password'      => Hash::make('password'),
                'role_id'       => 3,
                'sex'           => 'Male',
                'civil_status'  => 'Married',
                'religion'      => 'Christian',
                'status'        => 'active',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            // Create personnel record as BHW
            BHW::firstOrCreate([
                'user_id'  => $user->id,
                'role_id'  => 3,
                'brgy_id'  => 1, // adjust barangay ID as needed
                'status'   => 'active',
                'added_by' => 1, // e.g. Admin user ID
            ]);
        }
    }
}
