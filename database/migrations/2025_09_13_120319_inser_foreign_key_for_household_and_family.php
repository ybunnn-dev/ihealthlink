<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add FK to households.head_id
        Schema::table('households', function (Blueprint $table) {
            $table->foreign('head_id')->references('id')->on('residents')->nullOnDelete();
        });

        // Add FK to families.head_id
        Schema::table('families', function (Blueprint $table) {
            $table->foreign('head_id')->references('id')->on('residents')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('households', function (Blueprint $table) {
            $table->dropForeign(['head_id']);
        });

        Schema::table('families', function (Blueprint $table) {
            $table->dropForeign(['head_id']);
        });
    }
};
