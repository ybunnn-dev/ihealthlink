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
        Schema::create('households', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('purok_id');
            $table->foreign('purok_id')->references('id')->on('puroks')->cascadeOnDelete();

            // head_id will be nullable for now, FK added later
            $table->unsignedBigInteger('head_id')->nullable()->index();

            $table->boolean('has_toilet')->nullable();
            $table->string('water_source')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('households');
    }
};
