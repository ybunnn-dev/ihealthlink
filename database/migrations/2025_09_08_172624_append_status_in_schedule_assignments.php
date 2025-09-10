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
        Schema::table('schedule_assignments', function (Blueprint $table) {
            // Adding a status column with default value 'active'
            $table->enum('status', ['active', 'inactive'])->default('active')->after('personnel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_assignments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
