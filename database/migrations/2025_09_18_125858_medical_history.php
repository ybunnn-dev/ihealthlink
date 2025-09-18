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
        Schema::create('resident_family_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');

            $table->boolean('hypertension')->nullable();
            $table->boolean('heart_diseases')->nullable();
            $table->boolean('copd')->nullable(); // Chronic Obstructive Pulmonary Disease
            $table->boolean('tuberculosis_last_five_years')->nullable();
            $table->boolean('stroke')->nullable();
            $table->boolean('diabetes_mellitus')->nullable();
            $table->boolean('cancer')->nullable();
            $table->boolean('asthma')->nullable();
            $table->boolean('kidney_disorders')->nullable();
            $table->boolean('premature_coronary_or_vascular_disease')->nullable();
            $table->boolean('mental_neurological_substance_abuse_disorders')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resident_family_histories');
    }
};