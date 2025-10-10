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
        Schema::create('philpen_managements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade');
            $table->boolean('is_lifestyle_modification')->nullable();
            $table->boolean('is_anti_hypertensive')->nullable();
            $table->boolean('is_insulin')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('philpen_managements');
    }
};
