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
        // Add "title" column to program_fields
        Schema::table('program_fields', function (Blueprint $table) {
            $table->string('title')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_fields', function (Blueprint $table) {
            $table->dropColumn('title');
        });

        Schema::table('consultations', function (Blueprint $table) {
            $table->dropForeign(['med_dis_id']);
            $table->unsignedBigInteger('med_dis_id')->nullable()->change();
        });
    }
};
