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
        Schema::create('ncd_risk_factors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');

            // Booleans
            $table->boolean('tobacco_use')->nullable();
            $table->boolean('alcohol_intake')->nullable();
            $table->boolean('caffeine_intake')->nullable();
            $table->boolean('high_fat_high_salt_food_intake')->nullable();
            $table->boolean('street_foods_intake')->nullable();
            $table->boolean('high_sugar_foods_intake')->nullable();

            // Strings
            $table->string('number_of_drinks_last_year')->nullable();

            // Numbers
            $table->float('hours_of_activity_weekly')->nullable();
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->float('waist_circumference')->nullable();
            $table->integer('systolic_pressure')->nullable();
            $table->integer('diastolic_pressure')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ncd_risk_factors');
    }
};
