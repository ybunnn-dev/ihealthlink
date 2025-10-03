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
        Schema::create('basic_maternal_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');
            $table->date('last_menstrual_period'); // LMP
            $table->unsignedInteger('gravida'); // total number of pregnancies
            $table->unsignedInteger('para');    // total pregnancies reaching viability
            $table->date('expected_date_of_confinement'); // EDC
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('basic_maternal_records');
    }
};
