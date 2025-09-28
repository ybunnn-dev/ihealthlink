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
        Schema::create('enrolled_residents', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('resident_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('enrolled_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->string('status')->default('active'); // flexible string instead of enum
            $table->timestamps();

            // Foreign keys
            $table->foreign('resident_id')
                ->references('id')->on('residents')
                ->onDelete('cascade');

            $table->foreign('program_id')
                ->references('id')->on('health_programs')
                ->onDelete('cascade');

            $table->foreign('enrolled_by')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('updated_by')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrolled_residents');
    }
};
