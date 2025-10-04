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
        Schema::create('maternity_screenings', function (Blueprint $table) {
            $table->id();

            // Link to maternal record
            $table->unsignedBigInteger('maternal_record_id');
            $table->foreign('maternal_record_id')
                  ->references('id')
                  ->on('basic_maternal_records') // still using your current table name
                  ->onDelete('cascade');

            // Syphilis Screening
            $table->date('syphilis_screening_date')->nullable();
            $table->enum('syphilis_screening_result', ['positive', 'negative'])->nullable();

            // Hepatitis B Screening
            $table->date('hepatitis_b_screening_date')->nullable();
            $table->enum('hepatitis_b_screening_result', ['positive', 'negative'])->nullable();

            // HIV Screening
            $table->date('hiv_screening_date')->nullable();
            $table->enum('hiv_screening_result', ['positive', 'negative'])->nullable();

            // Gestational Diabetes
            $table->date('gestational_diabetes_screening_date')->nullable();
            $table->enum('gestational_diabetes_result', ['positive', 'negative'])->nullable();

            // CBC / Hgb & Hct Count
            $table->date('cbc_screening_date')->nullable();
            $table->enum('cbc_result', ['with anemia', 'without anemia'])->nullable();
            $table->enum('given_iron', ['yes', 'no'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maternity_screenings');
    }
};
