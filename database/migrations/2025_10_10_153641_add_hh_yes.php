<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('household_residence_histories', function (Blueprint $table) {
            // Add head_id if missing
            if (!Schema::hasColumn('household_residence_histories', 'head_id')) {
                $table->unsignedBigInteger('head_id')->nullable()->after('household_id');
            }

            // Add water_source if missing
            if (!Schema::hasColumn('household_residence_histories', 'water_source')) {
                $table->string('water_source')->nullable()->after('purok_id');
            }

            // Add waste_disposal if missing
            if (!Schema::hasColumn('household_residence_histories', 'waste_disposal')) {
                $table->string('waste_disposal')->nullable()->after('water_source');
            }

            // Add sanitary_toilet if missing
            if (!Schema::hasColumn('household_residence_histories', 'sanitary_toilet')) {
                $table->enum('sanitary_toilet', [
                    'with_sanitary_toilet',
                    'with_unsanitary_toilet',
                    'without_toilet'
                ])->default('without_toilet')->after('waste_disposal');
            }

            // Add is_iwas_gutom_enrolled if missing
            if (!Schema::hasColumn('household_residence_histories', 'is_iwas_gutom_enrolled')) {
                $table->boolean('is_iwas_gutom_enrolled')->default(false)->after('sanitary_toilet');
            }

            // Add is_indigent if missing
            if (!Schema::hasColumn('household_residence_histories', 'is_indigent')) {
                $table->boolean('is_indigent')->default(false)->after('is_iwas_gutom_enrolled');
            }

            // Add status if missing
            if (!Schema::hasColumn('household_residence_histories', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('is_indigent');
            }
        });
    }

    public function down(): void
    {
        Schema::table('household_residence_histories', function (Blueprint $table) {
            $dropIfExists = [
                'head_id',
                'water_source',
                'waste_disposal',
                'sanitary_toilet',
                'is_iwas_gutom_enrolled',
                'is_indigent',
                'status',
            ];

            foreach ($dropIfExists as $column) {
                if (Schema::hasColumn('household_residence_histories', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
