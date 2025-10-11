<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('child_immunization', function (Blueprint $table) {
            // Add mother_id column (nullable, with foreign key)
            $table->unsignedBigInteger('mother_id')->nullable()->after('enrolled_resident_id');

            $table->foreign('mother_id')
                ->references('id')
                ->on('residents')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('child_immunization', function (Blueprint $table) {
            $table->dropForeign(['mother_id']);
            $table->dropColumn('mother_id');
        });
    }
};
