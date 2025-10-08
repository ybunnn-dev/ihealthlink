<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add a new string column
        Schema::table('users', function (Blueprint $table) {
            $table->string('birthdate_new', 255)->after('birthdate');
        });

        // Step 2: Copy and convert the date data to string format
        DB::statement("UPDATE users SET birthdate_new = DATE_FORMAT(birthdate, '%Y-%m-%d') WHERE birthdate IS NOT NULL");

        // Step 3: Drop the old date column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birthdate');
        });

        // Step 4: Rename the new column to birthdate
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('birthdate_new', 'birthdate');
        });

        // Step 5: Set NOT NULL constraint using raw SQL (avoids Laravel's change() issues)
        DB::statement("ALTER TABLE users MODIFY birthdate VARCHAR(255) NOT NULL");
    }

    public function down(): void
    {
        // Step 1: Add a new date column
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthdate_new')->nullable()->after('birthdate');
        });

        // Step 2: Convert string back to date
        DB::statement("UPDATE users SET birthdate_new = STR_TO_DATE(birthdate, '%Y-%m-%d') WHERE birthdate IS NOT NULL");

        // Step 3: Drop the string column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birthdate');
        });

        // Step 4: Rename back
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('birthdate_new', 'birthdate');
        });
    }
};