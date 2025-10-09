<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Family Residence History
        Schema::create('family_residence_histories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('family_id');
            $table->unsignedBigInteger('purok_id')->nullable();
            $table->string('status')->nullable();

            $table->timestamps();

            $table->foreign('family_id')
                ->references('id')
                ->on('families')
                ->onDelete('cascade');

            $table->foreign('purok_id')
                ->references('id')
                ->on('puroks')
                ->onDelete('set null');
        });

        // Household Residence History
        Schema::create('household_residence_histories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('household_id');
            $table->unsignedBigInteger('purok_id')->nullable();
            $table->string('status')->nullable();

            $table->timestamps();

            $table->foreign('household_id')
                ->references('id')
                ->on('households')
                ->onDelete('cascade');

            $table->foreign('purok_id')
                ->references('id')
                ->on('puroks')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('household_residence_histories');
        Schema::dropIfExists('family_residence_histories');
    }
};
