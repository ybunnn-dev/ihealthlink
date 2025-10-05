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
        Schema::create('death_records', function (Blueprint $table) {
            $table->id();

            // Link to consultation (optional, if the death occurred during a consultation)
            $table->unsignedBigInteger('consultation_id')->nullable();
            $table->foreign('consultation_id')
                  ->references('id')
                  ->on('consultations')
                  ->onDelete('set null');

            $table->date('date_of_death');
            $table->text('cause_of_death');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('death_records');
    }
};
