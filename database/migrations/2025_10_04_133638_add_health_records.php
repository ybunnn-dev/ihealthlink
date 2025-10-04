<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('basic_health_records', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('resident_id'); // Reference to the resident
            $table->decimal('weight', 5, 2)->nullable(); // KG
            $table->decimal('height', 5, 2)->nullable(); // CM
            $table->enum('status', ['alive', 'deceased'])->default('alive');
            $table->text('health_records')->nullable();
            $table->decimal('waist_circumference', 5, 2)->nullable(); // CM
            $table->unsignedSmallInteger('systolic_pressure')->nullable();
            $table->unsignedSmallInteger('diastolic_pressure')->nullable();

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('resident_id')
                  ->references('id')
                  ->on('residents')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('basic_health_records');
    }
};
