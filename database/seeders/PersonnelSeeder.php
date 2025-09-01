<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class PersonnelSeeder extends Seeder
{
    public function run(): void
    {
        // Get Midwife role
        $midwifeRole = Role::where('name', 'Midwife')->first();

        // Get Midwife user
        $midwifeUser = User::where('email', 'midwife@example.com')->first();

        // Barangay Tagas (id = 1)
        $barangayId = 1;

        if ($midwifeRole && $midwifeUser) {
            DB::table('personnel')->updateOrInsert(
                [
                    'user_id' => $midwifeUser->id,
                    'role_id' => $midwifeRole->id,
                    'brgy_id' => $barangayId,
                ],
                [
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
