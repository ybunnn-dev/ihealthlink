<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'resident_health_signs',
            'ncd_risk_factors',
            'resident_family_histories',
            'resident_medical_history',
            'risk_assessment',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->unsignedBigInteger('consultation_id')->nullable()->after('id');
                $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'resident_health_signs',
            'ncd_risk_factors',
            'resident_family_histories',
            'resident_medical_history',
            'risk_assessment',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign([$table->getTable() . '_consultation_id_foreign']);
                $table->dropColumn('consultation_id');
            });
        }
    }
};
