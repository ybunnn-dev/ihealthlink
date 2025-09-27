<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('health_programs', function (Blueprint $table) {
            $table->enum('schedule_type', ['daily', 'weekly', 'monthly', 'yearly', 'custom'])
                  ->after('category')
                  ->nullable();

            $table->enum('program_mode', ['fixed', 'continuous'])
                  ->after('schedule_type')
                  ->default('fixed');

            $table->unsignedInteger('total_fields')
                  ->after('program_mode')
                  ->nullable(); // only relevant if program_mode = fixed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('health_programs', function (Blueprint $table) {
            $table->dropColumn(['schedule_type', 'program_mode', 'total_fields']);
        });
    }
};
