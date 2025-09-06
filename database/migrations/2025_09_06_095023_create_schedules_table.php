<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schedules table
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brgy_id');
            $table->unsignedBigInteger('health_program_id');
            $table->unsignedBigInteger('added_by'); // user_id
            $table->date('date');
            $table->time('time');
            $table->string('activity');
            $table->string('venue');
            $table->timestamps();

            $table->foreign('brgy_id')->references('id')->on('barangays')->onDelete('cascade');
            $table->foreign('health_program_id')->references('id')->on('health_programs')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
        });

        // Pivot table: schedule_assignments
        Schema::create('schedule_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('personnel_id'); // BHW id
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('personnel_id')->references('id')->on('personnel')->onDelete('cascade');

            $table->unique(['schedule_id', 'personnel_id']); // prevent duplicate assignments
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_assignments');
        Schema::dropIfExists('schedules');
    }
};
