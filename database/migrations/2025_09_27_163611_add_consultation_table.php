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

            // The date of the consultation (scheduled or walk-in)
            $table->dateTime('consultation_date')->nullable();

            // Status: pending, completed, etc.
            $table->enum('status', ['pending', 'completed'])->default('pending');

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
