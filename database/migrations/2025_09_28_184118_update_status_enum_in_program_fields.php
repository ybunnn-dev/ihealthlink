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
        Schema::table('program_fields', function (Blueprint $table) {
            // Change status column to ENUM with default 'active'
            $table->enum('status', ['active', 'inactive'])
                  ->default('active')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_fields', function (Blueprint $table) {
            // Rollback to tinyint(1) if needed
            $table->tinyInteger('status')
                  ->default(1)
                  ->change();
        });
    }
};
