<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('households', function (Blueprint $table) {
            if (!Schema::hasColumn('households', 'purok_id')) {
                $table->foreignId('purok_id')
                    ->after('id')
                    ->constrained('puroks')
                    ->onDelete('cascade');
            }

            if (!Schema::hasColumn('households', 'head_id')) {
                $table->foreignId('head_id')
                    ->nullable()
                    ->after('purok_id')
                    ->constrained('residents')
                    ->onDelete('set null');
            }

            if (!Schema::hasColumn('households', 'water_source')) {
                $table->string('water_source')->nullable()->after('head_id');
            }

            if (!Schema::hasColumn('households', 'waste_disposal')) {
                $table->string('waste_disposal')->nullable()->after('water_source');
            }

            if (!Schema::hasColumn('households', 'sanitary_toilet')) {
                $table->enum('sanitary_toilet', [
                    'with_sanitary_toilet',
                    'with_unsanitary_toilet',
                    'without_toilet'
                ])->default('without_toilet')->after('waste_disposal');
            }

            if (!Schema::hasColumn('households', 'is_iwas_gutom_enrolled')) {
                $table->boolean('is_iwas_gutom_enrolled')->default(false)->after('sanitary_toilet');
            }

            if (!Schema::hasColumn('households', 'is_indigent')) {
                $table->boolean('is_indigent')->default(false)->after('is_iwas_gutom_enrolled');
            }

            if (!Schema::hasColumn('households', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('is_indigent');
            }
        });
    }

    public function down(): void
    {
        Schema::table('households', function (Blueprint $table) {
            $table->dropForeign(['purok_id']);
            $table->dropForeign(['head_id']);
            $table->dropColumn([
                'purok_id',
                'head_id',
                'water_source',
                'waste_disposal',
                'sanitary_toilet',
                'is_iwas_gutom_enrolled',
                'is_indigent',
                'status'
            ]);
        });
    }
};
