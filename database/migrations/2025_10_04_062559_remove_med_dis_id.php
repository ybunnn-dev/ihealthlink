<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    { 
        Schema::table('consultations', function (Blueprint $table) {
            // Add new enrolled_resident_id column
            $table->unsignedBigInteger('enrolled_resident_id')->nullable()->after('resident_id');

            // Add FK to enrolled_residents
            $table->foreign('enrolled_resident_id')
                  ->references('id')
                  ->on('enrolled_residents')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Drop the new column
            $table->dropForeign(['enrolled_resident_id']);
            $table->dropColumn('enrolled_resident_id');
        });
    }
};
