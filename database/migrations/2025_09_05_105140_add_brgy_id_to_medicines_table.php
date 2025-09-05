<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            // Step 1: add brgy_id as nullable if it doesn't exist
            if (!Schema::hasColumn('medicines', 'brgy_id')) {
                $table->unsignedBigInteger('brgy_id')->nullable()->after('id');
            }
        });

        // Step 2: fill existing medicines with a default barangay (e.g., ID = 1)
        // You can adjust the ID according to your database
        DB::table('medicines')->whereNull('brgy_id')->update(['brgy_id' => 1]);

        Schema::table('medicines', function (Blueprint $table) {
            // Step 3: make brgy_id NOT NULL and add foreign key
            $table->unsignedBigInteger('brgy_id')->nullable(false)->change();
            $table->foreign('brgy_id')
                ->references('id')
                ->on('barangays')
                ->onDelete('cascade');

            // Step 4: add composite unique constraint (name + brgy_id)
            $table->unique(['medicine_name', 'brgy_id']);
        });
    }

    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropForeign(['brgy_id']);
            $table->dropUnique(['medicine_name', 'brgy_id']);
            $table->dropColumn('brgy_id');
        });
    }
};
