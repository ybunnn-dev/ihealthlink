<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserManual;
use App\Models\Module;
use App\Models\User;

class UserManualsTableSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // make sure at least 1 user exists
        if (!$user) {
            $this->command->warn('No users found, skipping UserManuals seeding.');
            return;
        }

        $manuals = [
            [
                'module'   => 'Medicine',
                'question' => 'How do I add a new medicine record?',
                'category' => 'Usage',
                'content'  => 'Go to the medicine module, click on "Add New", and fill out the required fields.',
            ],
            [
                'module'   => 'Resident',
                'question' => 'How do I register a new resident?',
                'category' => 'Registration',
                'content'  => 'Navigate to the resident module and click "Add Resident". Enter their details and save.',
            ],
            [
                'module'   => 'Household',
                'question' => 'How do I create a household?',
                'category' => 'Management',
                'content'  => 'In the household module, click "Create Household" and link it to a resident as the head.',
            ],
            [
                'module'   => 'Family',
                'question' => 'How do I view family members?',
                'category' => 'Information',
                'content'  => 'Open the family module and select a family to view all linked members.',
            ],
        ];

        foreach ($manuals as $manual) {
            $module = Module::where('module_name', $manual['module'])->first();
            if ($module) {
                UserManual::firstOrCreate([
                    'added_by'  => $user->id,
                    'module_id' => $module->id,
                    'question'  => $manual['question'],
                    'category'  => $manual['category'],
                    'content'   => $manual['content'],
                ]);
            }
        }
    }
}
