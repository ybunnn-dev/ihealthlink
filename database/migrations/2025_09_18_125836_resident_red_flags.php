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
        Schema::create('resident_health_signs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');

            $table->boolean('chest_pain')->nullable();
            $table->boolean('difficulty_in_breathing')->nullable();
            $table->boolean('loss_of_consciousness')->nullable();
            $table->boolean('numbness_of_arm')->nullable();
            $table->boolean('act_of_self_harm_or_suicide')->nullable();
            $table->boolean('agitated_or_aggressive_behavior')->nullable();
            $table->boolean('severe_injuries')->nullable();
            $table->boolean('slurred_speech')->nullable();
            $table->boolean('facial_asymmetry')->nullable();
            $table->boolean('chest_retractions')->nullable();
            $table->boolean('seizure_or_convulsion')->nullable();
            $table->boolean('disoriented_as_to_time_place_or_person')->nullable();
            $table->boolean('eye_injury')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resident_health_signs');
    }
};