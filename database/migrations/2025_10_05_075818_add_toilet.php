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
        Schema::table('households', function (Blueprint $table) {
            // Drop the old column
            if (Schema::hasColumn('households', 'has_toilet')) {
                $table->dropColumn('has_toilet');
            }

            // Add new sanitary_toilet column
            $table->enum('sanitary_toilet', [
                'with_sanitary_toilet',
                'with_unsanitary_toilet',
                'without_toilet'
            ])->default('without_toilet')->after('waste_disposal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('households', function (Blueprint $table) {
            // Drop the new column
            $table->dropColumn('sanitary_toilet');

            // Re-add old column
            $table->boolean('has_toilet')->default(false)->after('waste_disposal');
        });
    }
};
