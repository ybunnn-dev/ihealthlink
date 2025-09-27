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
        Schema::create('program_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')
                  ->constrained('health_programs')
                  ->onDelete('cascade'); // if program is deleted, fields go too
            $table->unsignedInteger('interval_days'); // number of days between fields
            $table->boolean('status')->default(true); // true = active, false = inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_fields');
    }
};
