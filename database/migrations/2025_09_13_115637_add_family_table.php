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
        Schema::create('families', function (Blueprint $table) {
            $table->id();

            // Link to household
            $table->unsignedBigInteger('household_id');
            $table->foreign('household_id')->references('id')->on('households')->cascadeOnDelete();

            // Family head (nullable for now)
            $table->unsignedBigInteger('head_id')->nullable()->index();

            $table->boolean('is_indigent')->default(false);
            $table->boolean('is_4ps')->default(false);

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
