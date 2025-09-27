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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            // Resident who is receiving the consultation
            $table->unsignedBigInteger('resident_id');

            // Program (nullable for walk-ins)
            $table->unsignedBigInteger('program_id')->nullable();

            // The date of the consultation (scheduled or walk-in)
            $table->dateTime('consultation_date')->nullable();

            // Status: pending, completed, etc.
            $table->enum('status', ['pending', 'completed'])->default('pending');

            // Medical disposition ID (placeholder, no FK for now)
            $table->unsignedBigInteger('med_dis_id')->nullable();

            // Extra details
            $table->string('consultation_title')->nullable();
            $table->text('remarks')->nullable();

            // Audit
            $table->unsignedBigInteger('updated_by')->nullable(); // FK to users table later

            $table->timestamps();

            // Foreign keys
            $table->foreign('resident_id')
                  ->references('id')->on('residents')
                  ->onDelete('cascade');

            $table->foreign('program_id')
                  ->references('id')->on('health_programs')
                  ->onDelete('set null'); // if program is deleted, keep record but nullify program_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
