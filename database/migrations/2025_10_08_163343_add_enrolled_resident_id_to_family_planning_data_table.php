<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('family_planning_data', function (Blueprint $table) {
            $table->unsignedBigInteger('enrolled_resident_id')->nullable()->after('id');
            $table->foreign('enrolled_resident_id')
                  ->references('id')
                  ->on('enrolled_residents')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('family_planning_data', function (Blueprint $table) {
            $table->dropForeign(['enrolled_resident_id']);
            $table->dropColumn('enrolled_resident_id');
        });
    }
};
