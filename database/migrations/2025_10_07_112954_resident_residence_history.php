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
        Schema::create('residence_history', function (Blueprint $table) {
            $table->id(); // PK1
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');
            $table->foreignId('brgy_id')->constrained('barangays')->onDelete('cascade');
            $table->enum('status', ['active', 'moved'])->default('moved');
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
