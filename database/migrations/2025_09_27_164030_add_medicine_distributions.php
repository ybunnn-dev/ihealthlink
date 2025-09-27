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
        Schema::create('medicine_distributions', function (Blueprint $table) {
            $table->id();

            // Medicine being distributed
            $table->unsignedBigInteger('medicine_id');

            // User who distributed it
            $table->unsignedBigInteger('distributed_by');

            // Quantity distributed
            $table->integer('quantity');

            $table->timestamps();

            // Foreign keys
            $table->foreign('medicine_id')
                  ->references('id')->on('medicines')
                  ->onDelete('cascade');

            $table->foreign('distributed_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_distributions');
    }
};
