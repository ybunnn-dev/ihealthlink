<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, convert existing data to string
        DB::table('ncd_risk_factors')->get()->each(function ($record) {
            DB::table('ncd_risk_factors')
                ->where('id', $record->id)
                ->update([
                    'tobacco_use' => (string) $record->tobacco_use,
                ]);
        });

        // Then change the column type to string
        Schema::table('ncd_risk_factors', function (Blueprint $table) {
            $table->string('tobacco_use')->change();
        });
    }

    public function down(): void
    {
        // Optional: convert back to previous type (assuming integer or enum)
        Schema::table('ncd_risk_factors', function (Blueprint $table) {
            $table->integer('tobacco_use')->change();
        });
    }
};
