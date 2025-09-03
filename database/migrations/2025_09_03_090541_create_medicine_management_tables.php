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
        // Create medicines table
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->string('medicine_name');
            $table->string('generic_name')->nullable();
            $table->string('category');
            $table->string('form'); // tablet, capsule, syrup, injection, etc.
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Create medicine inventories table
        Schema::create('medicine_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->string('batch_num');
            $table->integer('stock')->default(0);
            $table->date('date_received');
            $table->integer('quantity_received');
            $table->date('expiry_date');
            $table->timestamps();
            
            // Index for better query performance
            $table->index(['medicine_id', 'batch_num']);
            $table->index('expiry_date');
        });

        // Create medicine distributions table
        Schema::create('medicine_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('medicine_inventories')->onDelete('cascade');
            $table->foreignId('distributed_by')->constrained('users')->onDelete('cascade');
            $table->integer('amount');
            $table->timestamp('distributed_at');
            
            // Index for better query performance
            $table->index(['batch_id', 'distributed_at']);
            $table->index('distributed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_distributions');
        Schema::dropIfExists('medicine_inventories');
        Schema::dropIfExists('medicines');
    }
};