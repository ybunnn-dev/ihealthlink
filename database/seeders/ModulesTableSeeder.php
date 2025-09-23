<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModulesTableSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            ['module_name' => 'Medicine'],
            ['module_name' => 'Resident'],
            ['module_name' => 'Household'],
            ['module_name' => 'Family'],
        ];

        foreach ($modules as $module) {
            Module::firstOrCreate($module);
        }
    }
}
