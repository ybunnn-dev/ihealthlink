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
        Schema::create('resident_medical_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');

            $table->boolean('hypertension')->nullable();
            $table->boolean('heart_diseases')->nullable();
            $table->boolean('copd')->nullable(); // Chronic Obstructive Pulmonary Disease
            $table->boolean('surgical_history')->nullable();
            $table->boolean('allergies')->nullable();
            $table->boolean('diabetes')->nullable();
            $table->boolean('cancer')->nullable();
            $table->boolean('asthma')->nullable();
            $table->boolean('kidney_disorders')->nullable();
            $table->boolean('vision_problems')->nullable();
            $table->boolean('thyroid_disorders')->nullable();
            $table->boolean('mental_neuro_substance_disorders')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resident_medical_history');
    }
};
