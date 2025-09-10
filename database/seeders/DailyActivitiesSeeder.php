<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DailyActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Barangay IDs from your JSON export
        $barangays = [1, 2, 3, 4];

        foreach ($barangays as $brgyId) {
            foreach ($days as $day) {
                DB::table('daily_activities')->insert([
                    'day' => $day,
                    'brgy_id' => $brgyId,
                    'icon_id' => 1, // the first activity_icon
                    'updated_by' => 1, // assuming user_id=1 is admin
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
