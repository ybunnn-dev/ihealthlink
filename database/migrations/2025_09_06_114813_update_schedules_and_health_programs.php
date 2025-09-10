<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update schedules table
        Schema::table('schedules', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->after('venue');
        });

        // Update health_programs table
        Schema::table('health_programs', function (Blueprint $table) {
            $table->string('name')->after('id'); // if you didn’t add it before
            $table->enum('status', ['active', 'inactive'])->default('active')->after('name');
        });
    }

    public function down(): void
    {
        // Rollback schedules table
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Rollback health_programs table
        Schema::table('health_programs', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('status');
        });
    }
};
