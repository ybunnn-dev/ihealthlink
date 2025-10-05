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
        Schema::table('basic_health_records', function (Blueprint $table) {
            $table->boolean('is_pregnant')->default(false)->after('diastolic_pressure');
            $table->boolean('is_lactating')->default(false)->after('is_pregnant');
            $table->integer('weight_grams')->nullable()->after('height')->comment('For infants or under 1 year old');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_health_records', function (Blueprint $table) {
            $table->dropColumn(['is_pregnant', 'is_lactating', 'weight_grams']);
        });
    }
};
