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
        Schema::create('pregnancy_outcomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('basic_maternal_record_id')
                  ->constrained('basic_maternal_records')
                  ->onDelete('cascade');

            // Pregnancy Outcome
            $table->date('date_terminated')->nullable();
            $table->enum('outcome', ['Full Term', 'Pre-term', 'Fetal Death', 'Abortion/Miscarriage'])->nullable();
            $table->enum('sex', ['Male', 'Female'])->nullable();

            // Type of Delivery
            $table->enum('delivery_type', ['Cesarean Section', 'Vaginal Delivery'])->nullable();

            // Child Info
            $table->decimal('birth_weight', 5, 2)->nullable(); // in KG, up to 999.99

            // Place of Delivery
            $table->enum('delivery_place_type', [
                'BHS', 'RHU', 'MHC', 'Lying-in', 'Hospital', 'Birthing Homes', 'DOH Licensed Ambulance', 'Home', 'Others'
            ])->nullable();
            $table->boolean('is_bemonc_cemonc_capable')->nullable();
            $table->enum('delivery_place_ownership', ['Public', 'Private'])->nullable();

            // Birth Attendant
            $table->enum('birth_attendant', ['Doctor', 'Nurse', 'Midwife', 'Hilot', 'Others'])->nullable();

            $table->text('remarks')->nullable();
            $table->dateTime('delivery_datetime')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregnancy_outcomes');
    }
};
