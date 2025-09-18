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
        Schema::create('risk_assessment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');

            // Symptoms (Booleans)
            $table->boolean('polyphagia')->nullable();
            $table->boolean('polydipsia')->nullable();
            $table->boolean('polyuria')->nullable();
            $table->boolean('breathlessness')->nullable();
            $table->boolean('chronic_cough')->nullable();
            $table->boolean('sputum_production')->nullable();
            $table->boolean('wheezing')->nullable();

            // Lab results (Numbers)
            $table->float('fbs_result')->nullable();
            $table->float('rbs_result')->nullable();
            $table->float('total_cholesterol')->nullable();
            $table->float('hdl')->nullable();
            $table->float('ldl')->nullable();
            $table->float('vldl')->nullable();
            $table->float('triglyceride')->nullable();
            $table->float('protein')->nullable();
            $table->float('ketones')->nullable();

            // Dates (Strings)
            $table->string('blood_sugar_date_taken')->nullable();
            $table->string('lipid_profile_date_taken')->nullable();
            $table->string('urinalysis_date_taken')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_assessment');
    }
};
