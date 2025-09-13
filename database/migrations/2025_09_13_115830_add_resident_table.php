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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();

            // Link to family
            $table->unsignedBigInteger('family_id');
            $table->foreign('family_id')->references('id')->on('families')->cascadeOnDelete();

            // Added by (users table)
            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('added_by')->references('id')->on('users')->nullOnDelete();

            // Personal info
            $table->string('firstName', 50);
            $table->string('lastName', 50);
            $table->string('middleName', 50)->nullable();
            $table->string('suffix', 10)->nullable();
            $table->date('birthdate');
            $table->enum('sex', ['male', 'female']);
            $table->string('contact_no', 20)->nullable();
            $table->enum('civil_status', ['single', 'married', 'widowed', 'separated', 'divorced'])->default('single');
            $table->string('family_relationship', 50)->nullable();

            // Health & social attributes
            $table->boolean('is_pwd')->default(false);
            $table->string('pwd_id', 50)->nullable();
            $table->boolean('is_indigenous')->default(false);
            $table->enum('employment_status', ['employed', 'self-employed', 'unemployed', 'student', 'retired', 'not-applicable'])->default('not-applicable');

            // General status
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
