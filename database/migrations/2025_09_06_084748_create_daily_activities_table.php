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
        Schema::create('daily_activities', function (Blueprint $table) {
            $table->id();

            // Day of the week (Monday to Sunday only)
            $table->enum('day', [
                'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
            ]);

            // Foreign keys
            $table->unsignedBigInteger('brgy_id');
            $table->unsignedBigInteger('icon_id');
            $table->unsignedBigInteger('updated_by'); // user_id

            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('brgy_id')->references('id')->on('barangays')->onDelete('cascade');
            $table->foreign('icon_id')->references('id')->on('activity_icons')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activities');
    }
};
