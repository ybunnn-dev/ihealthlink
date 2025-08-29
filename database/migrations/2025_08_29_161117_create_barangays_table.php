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
        // Barangays table
        Schema::create('barangays', function (Blueprint $table) {
            $table->id(); // id
            $table->string('name'); // barangay name
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->timestamps(); // created_at, updated_at
        });

        // Puroks table
        Schema::create('puroks', function (Blueprint $table) {
            $table->id(); // id
            $table->foreignId('brgy_id')->constrained('barangays')->onDelete('cascade'); 
            // links to barangays.id, cascade delete if barangay is deleted
            $table->string('name'); // purok name
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puroks');
        Schema::dropIfExists('barangays');
    }
};
