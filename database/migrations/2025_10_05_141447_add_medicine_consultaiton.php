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
        Schema::table('medicine_distributions', function (Blueprint $table) {
            // Add consultation_id column
            $table->unsignedBigInteger('consultation_id')->after('id');

            // Add foreign key constraint
            $table->foreign('consultation_id')
                  ->references('id')
                  ->on('consultations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicine_distributions', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['consultation_id']);
            
            // Drop the column
            $table->dropColumn('consultation_id');
        });
    }
};
