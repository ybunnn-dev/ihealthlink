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
        Schema::table('basic_maternal_records', function (Blueprint $table) {
            // Drop old FK first
            $table->dropForeign(['resident_id']);
            $table->dropColumn('resident_id');

            // Add new FK
            $table->foreignId('enrolled_resident_id')
                  ->constrained('enrolled_residents')
                  ->onDelete('cascade')
                  ->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_maternal_records', function (Blueprint $table) {
            
            $table->dropForeign(['enrolled_resident_id']);
            $table->dropColumn('enrolled_resident_id');

            // Restore old FK
            $table->foreignId('resident_id')
                  ->constrained('residents')
                  ->onDelete('cascade')
                  ->after('id');
        });
    }
};
