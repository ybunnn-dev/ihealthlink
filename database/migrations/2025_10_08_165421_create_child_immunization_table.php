<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_immunization', function (Blueprint $table) {
            $table->id();

            // Foreign key to enrolled residents
            $table->unsignedBigInteger('enrolled_resident_id');
            $table->foreign('enrolled_resident_id')
                  ->references('id')
                  ->on('enrolled_residents')
                  ->onDelete('cascade');

            // Basic newborn data
            $table->decimal('birth_weight', 5, 2)->nullable(); // kg, can hold values like 3.45
            $table->date('initiated_breast_feed')->nullable();

            // Exclusive breastfeeding tracking (1–4 months)
            $table->boolean('is_exclusive_breastfeed_1')->nullable();
            $table->boolean('is_exclusive_breastfeed_2')->nullable();
            $table->boolean('is_exclusive_breastfeed_3')->nullable();
            $table->boolean('is_exclusive_breastfeed_4')->nullable();

            $table->date('exclusive_breastfeed_date_1')->nullable();
            $table->date('exclusive_breastfeed_date_2')->nullable();
            $table->date('exclusive_breastfeed_date_3')->nullable();
            $table->date('exclusive_breastfeed_date_4')->nullable();

            // After 6 months
            $table->boolean('is_exclusive_breastfeed_6mos')->nullable();
            $table->date('stopped_exclusive_breastfeed_date')->nullable();

            // Complementary feeding
            $table->boolean('complementary_feeding')->nullable();
            $table->enum('complementary_feeding_status', ['Continuous Breastfeed', 'No Breastfeed'])->nullable();

            // Immunization dates
            $table->date('fic_date')->nullable(); // Fully Immunized Child
            $table->date('cic_date')->nullable(); // Completely Immunized Child

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_immunization');
    }
};
