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
        Schema::create('consultation_data', function (Blueprint $table) {
            $table->id();

            // Link to consultation
            $table->unsignedBigInteger('consultation_id');
            $table->foreign('consultation_id')
                  ->references('id')
                  ->on('consultations')
                  ->onDelete('cascade');

            // Patient info
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->boolean('is_philhealth')->default(false);

            // Medical info
            $table->text('chief_complaint')->nullable();
            $table->text('treatment')->nullable();

            // Measurements
            $table->integer('birthweight')->nullable()->comment('grams, for under 1 year old');
            $table->float('weight')->nullable()->comment('kg');
            $table->float('height')->nullable()->comment('cm');

            // Vital signs
            $table->integer('bp_systolic')->nullable()->comment('mmHg');
            $table->integer('bp_diastolic')->nullable()->comment('mmHg');
            $table->integer('rr')->nullable()->comment('cpm - respiratory rate');
            $table->float('temperature')->nullable()->comment('Celsius');
            $table->integer('pr')->nullable()->comment('bpm - pulse rate');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_data');
    }
};
